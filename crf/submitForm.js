function submitForm() {
    const formData = new FormData(document.getElementById("client-acceptance-form"));

    // Convert the signature image to a Blob
    const signatureData = signaturePad.toDataURL();
    const signatureBlob = dataURItoBlob(signatureData);

    // Add the signature image to the form data
    formData.append("client_signature", signatureBlob, "client_signature.png");

    // Send the form data to the server
    fetch("process_form.php", {
      method: "POST",
      body: formData
    })
    .then(response => {
      if (response.ok) {
        alert("Form submitted successfully!");
        // Handle success or redirect to a success page
      } else {
        alert("Error submitting form. Please try again later.");
        // Handle error or display an error message
      }
    })
    .catch(error => {
      console.error("Error:", error);
      // Handle network errors or other issues
    });
  }