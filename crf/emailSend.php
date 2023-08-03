<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $projectName = $_POST["project_name"];
    $crNumber = $_POST["cr_number"];
    $crType = $_POST["cr_type"];
    $submitterName = $_POST["submitter_name"];
    $dateSubmitted = $_POST["date_submitted"];
    $clientEmail = $_POST["client_email"];

    // Scope of work data
    $items = $_POST["items"];
    $hours = $_POST["hours"];

    // Client acceptance data
    $acceptance = $_POST["acceptance"];
    $clientName = $_POST["client_name"];
    $signatureData = $_POST["client_signature"];
    $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
    $signatureData = str_replace(' ', '+', $signatureData);
    $signatureImage = base64_decode($signatureData);
    $signatureFilePath = 'client_signature.png';
    file_put_contents($signatureFilePath, $signatureImage);
    $clientApproverTitle = $_POST["client_approver_title"];
    $approvalDate = $_POST["approval_date"];
    $comments = $_POST["comments"];

    // Handle the uploaded Word document
    $wordDocFilePath = '';
    if (isset($_FILES["word_document"])) {
        $file = $_FILES["word_document"];
        $wordDocFilePath = 'change_request.docx';
        move_uploaded_file($file["tmp_name"], $wordDocFilePath);
    }

    $fromEmail = "landoncraft04@gmail.com";
    $recipientEmail = "landoncraft04@gmail.com";

    // Prepare email content
    $subject = "Change Request Form Submission";
    $message = "Project Name: " . $projectName . "\n";
    $message .= "CR#: " . $crNumber . "\n";
    $message .= "Type of CR: " . $crType . "\n";
    $message .= "Submitter Name: " . $submitterName . "\n";
    $message .= "Date Submitted: " . $dateSubmitted . "\n";
    $message .= "Client Email: " . $clientEmail . "\n\n";

    // Append scope of work data
    $message .= "Scope of Work:\n";
    for ($i = 0; $i < count($items); $i++) {
        $message .= "- " . $items[$i] . " (Hours: " . $hours[$i] . ")\n";
    }
    $message .= "\n";

    // Append client acceptance data
    $message .= "Client Acceptance:\n";
    $message .= "Acceptance: " . ($acceptance === "accepted" ? "Yes" : "No") . "\n";
    $message .= "Client Name: " . $clientName . "\n";

    // Attach the signature and Word document to the email
    $attachments = array($signatureFilePath, $wordDocFilePath);
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    $headers = "From: sender@example.com"; // Change this to the sender's email address
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
    $message .= "\n\n";
    foreach ($attachments as $attachment) {
        if (file_exists($attachment)) {
            $file = fopen($attachment, "rb");
            $data = fread($file, filesize($attachment));
            fclose($file);
            $data = chunk_split(base64_encode($data));
            $message .= "--{$mime_boundary}\n" . "Content-Type: application/octet-stream;\n" . " name=\"" . basename($attachment) . "\"\n" . "Content-Disposition: attachment;\n" . " filename=\"" . basename($attachment) . "\"\n" . "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";

    // Send the email
    if (mail($recipientEmail, $subject, $message, $headers)) {
        // Clean up the temporary files
        unlink($signatureFilePath);
        if (!empty($wordDocFilePath)) {
            unlink($wordDocFilePath);
        }

        // Redirect or display a success message to the user
        header("Location: success_page.html");
        exit;
    } else {
        // Handle error if email failed to send
        echo "Error: Failed to send the email.";
    }
}
?>
