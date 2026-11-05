<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'authentication.php';

if (empty($_SESSION['admin_id']) || empty($_SESSION['security_key'])) {
    header('Location: index.php');
    exit;
}
if ((int) $_SESSION['user_role'] !== 1 || !empty($_SESSION['temp_password'])) {
    http_response_code(403);
    exit;
}
if (!isset($_POST['add_task_post'])) {
    header('Location: task-info.php');
    exit;
}

if (!$obj_admin->add_new_task($_POST)) {
    $_SESSION['Task_msg'] = 'Could not assign task. Check the task details.';
    header('Location: task-info.php');
    exit;
}

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = getenv('SMTP_HOST') ?: '127.0.0.1';
    $mail->Port = (int) (getenv('SMTP_PORT') ?: 1025);
    $mail->SMTPAutoTLS = false;
    $mail->setFrom('etms@example.test', 'ETMS');
    $mail->addAddress($_POST['to']);
    $mail->Subject = $_POST['task_title'];
    $mail->Body = $_POST['task_description'];
    $mail->send();
} catch (\PHPMailer\PHPMailer\Exception $error) {
    $_SESSION['Task_msg'] = 'Task assigned. Email notification could not be delivered.';
}

header('Location: task-info.php');
exit;
