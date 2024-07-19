<?php 
require "../conn.php";
$name = $conn->real_escape_string(gpost('name'));
$email = $conn->real_escape_string(gpost('email'));
$comments = $conn->real_escape_string(gpost('comments'));

if (empty($name) || empty($email) || empty($comments)) {
    echo 'Please fill in all required fields.';
    exit;
}
$msg = '
        <table style="width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-collapse: collapse; font-family: Arial, sans-serif;">
            <tr>
                <td style="background-color: #f7f7f7; padding: 10px 20px; border-bottom: 1px solid #ddd;">
                    <h2 style="margin: 0; font-size: 18px; color: #333;">New Contact Form Submission</h2>
                </td>
            </tr>
            <tr>
                <td style="padding: 20px;">
                    <p style="margin: 0 0 10px; font-size: 14px; color: #555;">
                        <strong>Name:</strong> ' . htmlspecialchars($name) . '
                    </p>
                    <p style="margin: 0 0 10px; font-size: 14px; color: #555;">
                        <strong>Email:</strong> ' . htmlspecialchars($email) . '
                    </p>
                    <p style="margin: 0; font-size: 14px; color: #555;">
                        <strong>Comments:</strong> ' . nl2br(htmlspecialchars($comments)) . '
                    </p>
                </td>
            </tr>
            <tr>
                <td style="background-color: #f7f7f7; padding: 10px 20px; border-top: 1px solid #ddd;">
                    <p style="margin: 0; font-size: 12px; color: #999;">
                        This is an automated message. Please do not reply.
                    </p>
                </td>
            </tr>
        </table>';
require '../lib/PHPMailer-5/PHPMailerAutoload.php';
$mail = new PHPMailer;
if (sendAlert('info@vin-rues-apartments.ng','Contact - US',$msg,$mail)) {
    echo 'success'; die; exit();
}
echo 'Unable to send message';die;
?>