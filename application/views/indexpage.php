<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mydiaree</title>            
    
    <!-- META SECTION -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <style>
       body {
            margin: 0;
            padding: 0;
            background: url('<?php echo base_url("api/assets/media/mydiaree(1).png"); ?>') no-repeat top center;
            background-size: cover; /* Ensures full width */
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .login-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            padding: 10px 20px;
            background-color: black;
            color: white;
            text-decoration: none;
            font-size: 28px;
            font-weight: bold;
            border-radius: 5px;
        }

        .login-btn:hover {
            background-color: white;
            color: black;
        }
    </style>
</head>
<body>

    <!-- Login Button -->
    <a href="<?php echo base_url('welcome/account2'); ?>" class="login-btn">Log In</a>

</body>
</html>
