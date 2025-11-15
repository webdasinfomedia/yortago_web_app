<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>

    <style type="text/css">
            * { margin: 0; padding: 0; font-size: 100%; font-family: 'Avenir Next', "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; line-height: 1.65; }

            img { max-width: 100%; margin: 0 auto; display: block; }

            body, .body-wrap { width: 100% !important; height: 100%; background: #f8f8f8; }

            a { color: #03528C; text-decoration: none; }

            /* a:hover { text-decoration: underline; } */

            .text-center { text-align: center; }

            .text-right { text-align: right; }

            .text-left { text-align: left; }

            .button { display: inline-block; color: white; background: #CFDBE3; border: solid #03528C; border-width: 10px 20px 8px; font-weight: bold; border-radius: 4px; }

            .button:hover { text-decoration: none; }

            h1, h2, h3, h4, h5, h6 { margin-bottom: 20px; line-height: 1.25; }

            h1 { font-size: 25px; }

            h2 { font-size: 21px; }

            h3 { font-size: 18px; }

            h4 { font-size: 15px; }

            h5 { font-size: 12px; }

            p, ul, ol { font-size: 13px; font-weight: normal; margin-bottom: 20px; }

            .container { display: block !important; clear: both !important; margin: 0 auto !important; max-width: 580px !important; }

            .container table { width: 100% !important; border-collapse: collapse; }

            .container .masthead { padding: 50px 0; background: #CFDBE3; color: white; }

            .container .masthead h1 { margin: 0 auto !important; max-width: 90%; text-transform: uppercase; }

            .container .content { background: white; padding: 30px 35px; }

            .container .content.footer { background: none; }

            .container .content.footer p { margin-bottom: 0; color: #888; text-align: center; font-size: 14px; }

            .container .content.footer a { color: #888; text-decoration: none; font-weight: bold; }

    </style>
</head>
<body>
<table class="body-wrap">
    <tr>
        <td class="container">

            <!-- Message start -->
            <table>
                <tr>
                    <td align="center" class="masthead">
                        <img src="https://yortago-new.deviotech.com/front/landing/images/logo-inner-pages.png" width="220" height="57" alt="Logo" style="display: block;">
                    </td>
                </tr>
                <tr>
                    <td class="content">
                        <h2>Dear Admin,</h2>
                        <p>We are pleased to inform you that a new user has successfully registered in the system. Please find the details of the new registration below:</p>
                        <br>

                        <table>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <td><strong>Registration Date:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('l, F j, Y g:i A') }}</td>

                            </tr>
                        </table>
                        <br>
                        <p>If you need to review or take any action on this new user, please visit the admin dashboard.</p>
                        
                        <p>Best regards,<br>Yortago Team</p>
                    </td>
                </tr>
            </table>

            <p><em><a href="https://yortago-new.deviotech.com/">– Yortago </a></em></p>

        </td>
    </tr>
    <tr>
        <td class="container">
            <!-- Message start -->
            <table>
                <tr>
                    <td class="content footer" align="center">
                        <p>Sent by <a href="https://yortago-new.deviotech.com/"> Yortago</a></p>
                        <p><a href="https://yortago-new.deviotech.com/"> Yortago</a> | <a href="https://yortago-new.deviotech.com/in/person"> Contact Us</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
