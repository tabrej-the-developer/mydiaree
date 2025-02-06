<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();  // Load the database connection
        $this->load->dbutil();    // Load the database utility class
    }

    public function database_backup() {
        // Backup database preferences
        $prefs = array(
            'format'      => 'zip',  // Format of the backup file (zip)
            'filename'    => 'database_backup.sql' // SQL file name inside the zip
        );

        // Generate the database backup
        $backup = $this->dbutil->backup($prefs);

        // Define the backup filename with date and time
        $backup_name = 'backup_' . date('Y-m-d_H-i-s') . '.zip';

        // Define the backup storage path (inside the "backups" folder)
        $backup_path = FCPATH . 'backups/' . $backup_name; 

        // Load file helper and write the backup file to the storage
        $this->load->helper('file');
        write_file($backup_path, $backup);

        $this->delete_old_backups();

        // Optional: Download backup file
        // $this->load->helper('download');
        // force_download($backup_name, $backup);

        print_r("Successfully Database Backup created in the Backup Folder");
        exit;
    }


    private function delete_old_backups() {
        // Delete backup files older than 7 days
        $files = glob(FCPATH . 'backups/*.zip');
        foreach ($files as $file) {
            if (filemtime($file) < (time() - 7 * 24 * 60 * 60)) { // Older than 7 days
                unlink($file); // Delete the file
            }
        }
    }


}
