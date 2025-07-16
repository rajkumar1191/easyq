<?php
// Replace this with your real receiving email address
$receiving_email_address = 'you@example.com';

// Check if form submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Validate required fields
  if (
    isset($_POST['name']) && isset($_POST['email']) &&
    isset($_POST['subject']) && isset($_POST['message'])
  ) {
    $name    = strip_tags(trim($_POST['name']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    // $subject = strip_tags(trim($_POST['subject']));
    $message = strip_tags(trim($_POST['message']));

    // Email content
    $email_content = "From: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($receiving_email_address, $subject, $email_content, $headers)) {
      echo "OK"; // You can return JSON if you're using AJAX
    } else {
      http_response_code(500);
      echo "Failed to send message. Please try again later.";
    }
  } else {
    http_response_code(400);
    echo "Please fill in all required fields.";
  }
} else {
  http_response_code(403);
  echo "Invalid request.";
}
?>
