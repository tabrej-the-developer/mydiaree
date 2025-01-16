<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Email configuration
$config['protocol'] = 'smtp';               // Email sending protocol
$config['smtp_host'] = 'smtp.your-email-provider.com';  // SMTP server
$config['smtp_port'] = 587;                 // SMTP port (587 for TLS, 465 for SSL)
$config['smtp_user'] = 'your_email@example.com'; // Your email address
$config['smtp_pass'] = 'your_password';     // Your email password
$config['smtp_crypto'] = 'tls';             // Encryption type: 'tls' or 'ssl'
$config['mailtype'] = 'html';               // Email format (html/text)
$config['charset'] = 'utf-8';               // Character set
$config['wordwrap'] = TRUE;                 // Automatically wraps the email text

// Optional settings
$config['smtp_timeout'] = 30;               // Timeout setting
$config['newline'] = "\r\n";                // Line break for the email body
$config['crlf'] = "\r\n";                   // Carriage return for the email body
