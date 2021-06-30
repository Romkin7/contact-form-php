<?php

// Only process POST reqeusts.
//An array of HTTP methods that
//we want to allow.
$allowedMethods = array(
    'POST'
);

//The current request type.
$requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);


//If the request method isn't in our
//list of allowed methods.
if (!in_array($requestMethod, $allowedMethods)) {
    //Send a 405 Method Not Allowed header.
    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed", true, 405);
    //Halt the script's execution.
    exit;
}
if ($requestMethod == 'POST') {
    // Get the form fields and remove whitespace.
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);

    // Check that data was sent to the mailer.
    if (empty($name) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Please make sure, that all of the required fields are filled correctly.";
        exit;
    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = "romantuomisto@gmail.com";

    // Set the email subject.
    $subject = "New subscription: $name";

    // Build the email content.
    $email_content = "Name: $name\n";
    $email_content = "Email: $email\n\n";

    // Build the email headers.
    $email_headers = "From: $name <$email>";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Thank you, your email have been sent successfully!";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong, try again later!";
    }
} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "Oops! Something went wrong, try again later!";
}
?>