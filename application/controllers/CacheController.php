<?php
defined('BASEPATH') OR exit('No direct script access allowed');  

class CacheController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load the database library
        $this->load->database();
        // Load the cache driver
        $this->load->driver('cache');
    }

    public function clear_cache() {
        // Clear file cache
        $this->cache->file->clean();

        // Clear database cache
        if ($this->db) {
            $this->db->cache_delete_all(); // Deletes database cache
        }

        // Clear output cache
        $this->output->cache(0); // Turns off caching for output

        echo "Cache cleared successfully!";
    }
}