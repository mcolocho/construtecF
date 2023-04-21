<?php
// Uncomment next line if you're not using a dependency loader (such as Composer)
//API KEY Línea de abajo No.4
//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

require("../sendgrid-php/sendgrid-php.php");

use SendGrid\Mail\From;
use SendGrid\Mail\HtmlContent;
use SendGrid\Mail\Mail;
use SendGrid\Mail\PlainTextContent;
use SendGrid\Mail\Subject;
use SendGrid\Mail\To;

// Obtener los datos del formulario
$nombre = $_POST['name'];
$correo = $_POST['email'];
$telefono = $_POST['phone'];
$asunto = $_POST['subject'];
$mensaje = $_POST['message'];

// Configurando los datos del correo electrónico
$from = new From($correo, $nombre);
$subject = new Subject($asunto);
$to = new To("marcoantoniocolocho@gmail.com", "Marco");
$plainTextContent = new PlainTextContent($mensaje, $telefono);
$htmlContent = new HtmlContent("<strong>" . $mensaje . " El teleóno es: " . $telefono . "</strong>");

$email = new Mail(
    $from,
    $to,
    $subject,
    $plainTextContent,
    $htmlContent
);

$sendgrid = new \SendGrid('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');
try {
    $response = $sendgrid->send($email);
    // Verificar si el correo se envió correctamente
    if ($response->statusCode() === 202) {
        // Redireccionar a la página en blanco con un mensaje de éxito
        header("Location: confirmacion.html?envio_exitoso=1");
        exit(); // Salir del script para asegurar la redirección
    } else {
        // Redireccionar a la página en blanco con un mensaje de error
        header("Location: confirmacionFailed.html?envio_exitoso=0");
        echo"<pre>";
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        echo"<pre>";
        exit(); // Salir del script para asegurar la redirección
    }
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}



//Este código es para correo de forma quemada, con vaolores fijos
/*$email = new Mail();
$email->setFrom("mcolochorivera@gmail.com", "Marco Rivera");
$email->setSubject("Esto es una Prueba");
$email->addTo("marcoantoniocolocho@gmail.com", "Antonio Rivera");
$email->addContent("text/plain", "Esto es una prueba con Sendgrig");
$email->addContent(
    "text/html", "<strong>Prueba del correo fue exitosa! </strong>"
);
$sendgrid = new \SendGrid('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');
try {
    $response = $sendgrid->send($email);
    echo"<pre>";
        print $response->statusCode() . "\n";
        print_r($response->headers());
        print $response->body() . "\n";
    echo"<pre>";
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}*/


?>

