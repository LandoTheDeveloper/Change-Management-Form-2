function initializeTinyMCE(selector) {
    tinymce.init({
      selector: selector,
      plugins: "link lists",
      toolbar: "undo redo | bold italic underline | bullist numlist | link",
      menubar: false,
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    // Initialize the first textarea
    initializeTinyMCE("#scope-of-work-editor");
  });
