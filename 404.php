<?php
// 404.php - Trang lỗi "Không tìm thấy"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>404 Page Not Found</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Cabin:400,700');
        @import url('https://fonts.googleapis.com/css?family=Montserrat:900');

        body {
            padding: 0;
            margin: 0;
        }

        #notfound {
            position: relative;
            height: 100vh;
            background: #030005;
        }

        #notfound .notfound {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .notfound {
            max-width: 520px;
            width: 100%;
            text-align: center;
            line-height: 1.4;
        }

        .notfound .notfound-404 {
            position: relative;
            height: 200px;
        }

        .notfound .notfound-404 h1 {
            font-family: 'Montserrat', sans-serif;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 220px;
            font-weight: 900;
            margin: 0;
            background: url('https://colorlib.com/etc/404/colorlib-error-404-10/bg.jpg') no-repeat;
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            text-transform: uppercase;
        }

        .notfound .notfound-404 h3 {
            font-family: 'Cabin', sans-serif;
            position: absolute;
            left: 0;
            right: 0;
            top: 110%;
            font-size: 16px;
            font-weight: 400;
            color: #fff;
            text-transform: uppercase;
            margin: 0;
        }

        .notfound h2 {
            font-family: 'Cabin', sans-serif;
            font-size: 20px;
            font-weight: 400;
            text-transform: uppercase;
            color: #fff;
            margin-top: 0;
        }

    </style>
</head>

<body>

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h3>Oops! Page not found</h3>
                <h1><span>4</span><span>0</span><span>4</span></h1>
            </div>
            <h2>we are sorry, but the page you requested was not found</h2>
        </div>
    </div>

</body>

</html>
