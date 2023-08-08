function populateProjectDropdown() {
    const projectDropdown = document.getElementById('project-name-choice');
  
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

        fetchProjectDetails(selectedProjectName);
      });
}


