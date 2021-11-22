<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $number = trim($_POST["number"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($subject) OR empty($number) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $to = "alemartinezz@protonmail.com";

        // Build the email content.
        $email_content = "Nombre: $name\n";
        $email_content .= "Número: $number\n";
        $email_content .= "e-mail: $email\n\n";
        $email_content .= "Asunto: $subject\n\n";
        $email_content .= "Mensaje:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $email\r\nReply-to: $email";
        $email_subject = "CONTACTO HIPOTECAR";

        // Send the email.
        if (mail ($to, $email_subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            header("Location: http://pocitosbox.uy/mensaje_enviado.html");
        } else {
            // Set a 500 (internal server error) response code.
            header("Location: http://pocitosbox.uy/mensaje_no_enviado.html");
            http_response_code(500);
        }
        die();
    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
            header("Location: http://hipotecar.uy/mensaje_no_enviado.html");
        die();
    }
?>