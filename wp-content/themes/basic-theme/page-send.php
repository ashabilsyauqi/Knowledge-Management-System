<?php 

    use PHPMailer\PHPMailer\ PHPMailer;
    use PHPMailer\PHPMailer\ Exception;

    require 'phpmailer/src/exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';


    if(isset($_POST['send'])){
        $mail = new  PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp./gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = 'dukuhzamrud@j7';

        $mail->Password = 'dukuhzamrud@j7';
        $mail->SMTPSecure = 'ssl';
        $mail->Port=465;

        $mail->setForm('ashabilsyauqi@gmaill.com');
        $mail->addAddress($_POST['email']);
        $mail->isHTML(true);

        $main->Subject = $_POST['subject'];
        $main->body = $_POST['message'];

        $mail->send();

        echo
        "
        <script>
            alert(' Sent Success ');
            document.location.href = 'front-page.php'
        </script>
        "
        ;

    }
?>



