<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH  . 'vendor/autoload.php';

use Intervention\Image\ImageManager;

class Image_intervention {
    protected $CI;
    protected $manager;

    public function __construct() {
        $this->CI =& get_instance();
        
        // Create image manager with GD driver
        $this->manager = new ImageManager(['driver' => 'gd']);
    }

    public function compress($source, $destination, $maxWidth = 1024, $quality = 70) {
        try {
            // Use $this->manager instead of Image::make()
            $img = $this->manager->make($source);

            // Resize the image maintaining aspect ratio
            $img->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize(); // Prevent upscaling
            });

            // Save the compressed image
            $img->save($destination, $quality);

            return $destination;
        } catch (Exception $e) {
            log_message('error', 'Image Compression Error: ' . $e->getMessage());
            return false;
        }
    }
}