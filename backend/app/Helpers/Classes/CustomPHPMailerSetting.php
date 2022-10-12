<?php

namespace App\Helpers\Classes;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class CustomPHPMailerSetting
{
    /**
     * @throws \Exception
     */
    public static function mailServerSetup(): PHPMailer
    {
        require base_path("vendor/autoload.php");
        $phpmailer = new PHPMailer(true);

        // Email server settings
        $phpmailer->SMTPDebug = 0;
        $phpmailer->isSMTP();
        $phpmailer->Host = 'mail.softbdltd.com';             //  smtp host
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = 'miladul@softbdltd.com';   //  sender username
        $phpmailer->Password = 'miladul@321#';       // sender password
        $phpmailer->SMTPSecure = 'tls';                  // encryption - ssl/tls
        $phpmailer->Port = 587;                        // port - 587/465
        $phpmailer->setFrom('miladul@softbdltd.com', 'LRMS');//Mail sender address
        $phpmailer->addReplyTo('miladul@softbdltd.com', 'LRMS'); //reply to
        return $phpmailer;
    }

    public static function customMailSender($phpmailer, $toEmail, $subject, $mailBody, $fileAttachments = null)
    {
        $phpmailer->addAddress($toEmail);
        if (isset($fileAttachments)) {
            for ($i = 0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                $phpmailer->addAttachment($fileAttachments['tmp_name'][$i], $fileAttachments['name'][$i]);
            }
        }
        $phpmailer->isHTML(true);
        $phpmailer->Subject = $subject;
        $phpmailer->Body = !empty($mailBody) ? $mailBody : "Custom Mail body message";
        return $phpmailer->send();
    }
}
