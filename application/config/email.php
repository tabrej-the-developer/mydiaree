<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Email configuration
$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.zoho.com';           // Zoho SMTP server
$config['smtp_port']   = 465;
$config['smtp_user']   = 'support@mydiaree.com';     // Your full email address
// $config['smtp_pass']   = 'MyD1@ree';      // Your email password
// $config['smtp_pass']   = '5SVHz5cLa5hi'; 
$config['smtp_pass']   = 'U5k0s0hFJnPZ'; 
//  U5k0s0hFJnPZ
// Your email password
$config['smtp_crypto'] = 'ssl';
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['wordwrap']    = TRUE;