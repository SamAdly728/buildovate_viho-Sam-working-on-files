<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="viho admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, viho admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{!! env('ICON') !!}" type="image/x-icon">
    <link rel="shortcut icon" href="{!! env('ICON') !!}" type="image/x-icon">
    <!-- <title>viho - Premium Admin Template</title> -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style>
        body{
            width: 650px;
            /* font-family: work-Sans, sans-serif; */
            font-family: Helvetica,Arial,'Lucida Grande',sans-serif;
            background-color: #f6f7fb;
            display: block;
        }
        a{
            text-decoration: none;
        }
        span {
            font-size: 14px;
        }
        p {
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 0.7px;
            margin-top: 0;
        }
        .text-center{
            text-align: center
        }
    </style>
</head>
<body style="margin: 30px auto;">
<table style="width: 100%">
    <tbody>
    <tr>
        <td>
            <table style="background-color: #f6f7fb; width: 100%">
                <tbody>
                <tr>
                    <td style="padding: 50px 50px 70px 50px">
                        <table style="width: 650px; margin: 0 auto; margin-bottom: 30px">
                            <tbody>
                            <tr>
                                <td><img src="https://buildovate-development.s3.us-west-1.amazonaws.com/images/general/buildovate_logo_big.png" alt="logo"></td>
                            </tr>
                            </tbody>
                        </table>
                        <table style="width: 650px; margin: 0 auto; background-color: #fff; border-radius: 8px">
                            <tbody>
                            <tr>
                                <td style="padding: 30px">
                                    <a href="{!! env('APP_URL') !!}password-reset?code={!! $CODE !!}&uc={!! $USER_CREDS_ID !!}" target="_blank" style="padding: 10px; background-color: #1E5BB2; color: #ffffff; display: inline-block; border-radius: 4px; margin-bottom: 18px">
                                        Reset Password
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>