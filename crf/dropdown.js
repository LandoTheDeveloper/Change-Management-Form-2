function populateProjectDropdown() {
  const projectDropdown = document.getElementById('project-name-choice');
  const selectedProjectInput = document.getElementById('selected-project-name');
  const selectedCRNumberInput = document.getElementById('selected-cr-number');
  const selectedClientEmailInput = document.getElementById('selected-client-email');

  projectDropdown.removeAttribute('disabled');

  fetch('getProjectNames.php')
    .then(response => response.json())
    .then(projectNames => {
      projectNames.forEach(name => {
        const option = document.createElement('option');
        option.value = name;
        option.textContent = name;
        projectDropdown.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching project names:', error);
    });

    projectDropdown.addEventListener('change', function() {
      const selectedProjectName = projectDropdown.value;

      // Update the value of the hidden input field
      selectedProjectInput.value = selectedProjectName;

      // Fetch additional project details if needed
      fetchProjectDetails(selectedProjectName);

    });
}
