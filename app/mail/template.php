<html>
<head>
    <style>
    .banner-color {
        background-color: #eb681f;
    }

    .title-color {
        color: #0066cc;
    }

    .button-color {
        background-color: #0066cc;
    }

    @media screen and (min-width: 500px) {
        .banner-color {
            background-color: #0066cc;
        }

        .title-color {
            color: #eb681f;
        }

        .button-color {
            background-color: #eb681f;
        }
    }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0;">
    <div style="height:100%;background-color:#ececec;padding:0;margin:0 auto;font-weight:200;width:100%!important">
        <table align="center" border="0" cellspacing="0" cellpadding="0"
            style="table-layout:fixed;font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
            <tbody>
                <tr>
                    <td align="center">
                        <center style="width:100%">
                            <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0"
                                style="margin:0 auto;max-width:512px;font-weight:200;width:inherit;font-family:Helvetica,Arial,sans-serif"
                                width="512">
                                <tbody>
                                    <tr>
                                        <td bgcolor="#F3F3F3" width="100%"
                                            style="background-color:#f3f3f3;padding:12px;border-bottom:1px solid #ececec">
                                            <table border="0" cellspacing="0" cellpadding="0"
                                                style="font-weight:200;width:100%!important;font-family:Helvetica,Arial,sans-serif;min-width:100%!important"
                                                width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td align="left" valign="middle" width="50%"><span style="margin:0;color:#4c4c4c;white-space:normal;display:inline-block;text-decoration:none;font-size:12px;line-height:20px"><?php echo isset($site_title) ? $site_title : "All Smart Tools"; ?></span>
                                                        </td>
                                                        <td valign="middle" width="50%" align="right"
                                                            style="padding:0 0 0 10px"><span
                                                                style="margin:0;color:#4c4c4c;white-space:normal;display:inline-block;text-decoration:none;font-size:12px;line-height:20px">Tuesday
                                                                <?php echo date("d M, Y"); ?></span></td>
                                                        <td width="1">&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <table border="0" cellspacing="0" cellpadding="0"
                                                style="font-weight:200;font-family:Helvetica,Arial,sans-serif"
                                                width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td width="100%">
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                style="font-weight:200;font-family:Helvetica,Arial,sans-serif"
                                                                width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" bgcolor="#8BC34A"
                                                                            style="padding:20px 48px;color:#ffffff"
                                                                            class="banner-color">
                                                                            <table border="0" cellspacing="0"
                                                                                cellpadding="0"
                                                                                style="font-weight:200;font-family:Helvetica,Arial,sans-serif"
                                                                                width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" width="100%">
                                                                                            <h1
                                                                                                style="padding:0;margin:0;color:#ffffff;font-weight:500;font-size:20px;line-height:24px">
                                                                                                <?php echo isset($title) ? $title : ""; ?>
                                                                                            </h1>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center"
                                                                            style="padding:20px 0 10px 0">
                                                                            <table border="0" cellspacing="0"
                                                                                cellpadding="0"
                                                                                style="font-weight:200;font-family:Helvetica,Arial,sans-serif"
                                                                                width="100%">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" width="100%"
                                                                                            style="padding: 0 15px;text-align: justify;color: rgb(76, 76, 76);font-size: 12px;line-height: 18px;">
                                                                                            
                                                                                            <h3 style="font-weight: 600; padding: 0px; margin: 0px; font-size: 16px; line-height: 24px; text-align: left;"
                                                                                                class="title-color">Hi<?php echo isset($name) ? " $name," : ""; ?></h3>

                                                                                            <?php if( isset($message) ): ?>
                                                                                            <div style="margin: 20px 0 30px 0;font-size: 15px;text-align: left;">
                                                                                                <?php echo $message; ?>
                                                                                            </div>
                                                                                            <?php endif; ?>


                                                                                            <?php if( isset( $buttons ) && is_array($buttons) ): ?>
                                                                                                <div style="margin: 25px;">
                                                                                                    <?php foreach( $buttons as $button): ?>
                                                                                                    <div style="font-weight: 200; text-align: center; margin-bottom:10px;">
                                                                                                        <a href="<?php echo $button['link']; ?>" style="cursor:pointer;padding:0.6em 1em;border-radius:600px;color:#ffffff;font-size:14px;text-decoration:none;font-weight:bold" class="button-color"><?php echo $button['text']; ?></a>
                                                                                                    </div>
                                                                                                    <?php endforeach; ?>
                                                                                                </div>
                                                                                            <?php endif; ?>

                                                                                            <?php if( isset($after_message) ): ?>
                                                                                            <div style="margin: 20px 0 30px 0;font-size: 15px;text-align: center;">
                                                                                                <?php echo $after_message; ?>
                                                                                            </div>
                                                                                            <?php endif; ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                    </tr>
                                                                    <tr>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left">
                                            <table bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0"
                                                style="padding:0 24px;color:#999999;font-weight:200;font-family:Helvetica,Arial,sans-serif"
                                                width="100%">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" width="100%">
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                style="font-weight:200;font-family:Helvetica,Arial,sans-serif"
                                                                width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="middle" width="100%"
                                                                            style="border-top:1px solid #d9d9d9;padding:12px 0px 20px 0px;text-align:center;color:#4c4c4c;font-weight:200;font-size:12px;line-height:18px">
                                                                            Regards,
                                                                            <br><b><?php echo isset($footer) ? $footer : "All Smart Tool's Team"; ?></b>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="100%">
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                style="font-weight:200;font-family:Helvetica,Arial,sans-serif"
                                                                width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" style="padding:0 0 8px 0"
                                                                            width="100%"></td>
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
                        </center>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>