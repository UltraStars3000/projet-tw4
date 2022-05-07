<?php


use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["mail"]) && isset($_POST["message"])){
    $email = $_POST["mail"];
    $message = $_POST["message"];
    $subject = "support technique";
    $name = $_POST["name"];


    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();

    //smtp settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "mailsysteme487@gmail.com";
    $mail->Password = 'Test8181!';
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";

    //email settings
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress("mailsysteme487@gmail.com");
    $mail->Subject = ("$email ($subject)");
    $mail->Body = $message;

    if($mail->send()){
        $status = "succes";
        $response = "Email envoyé";

    }else{
        $status = "echec";
        $response = "il y a un problème: <br>" . $mail->ErrorInfo;
    }
    header('Location: index.php');
    exit();
}


?>