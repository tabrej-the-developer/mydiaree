<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Email configuration
$config['protocol']    = 'smtp';
$config['smtp_host'] = 'mail.mydiaree.com';
$config['smtp_port']   = 465;                        // SSL (or 587 for TLS)
$config['smtp_user']   = 'support@mydiaree.com';     // Your full email address
$config['smtp_pass']   = 'MyD1@ree';      // Your email password
$config['smtp_crypto'] = 'ssl';                      // 'tls' for port 587
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";