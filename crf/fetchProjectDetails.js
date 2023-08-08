function fetchProjectDetails(projectName) {
    fetch('getProjectDetails.php?projectName=' + encodeURIComponent(projectName))
        .then(response => {
            // Parse the response body as JSON
            return response.json();
        })
        .then(projectDetails => {
            // Now you can work with the parsed JSON data
            document.getElementById('cr-number').value = projectDetails.cr_num;
            document.getElementById('client-email').value = projectDetails.email;
            document.getElementById('project-name').value = projectName;
        })
        .catch(error => {
            console.error('Error fetching project details:', error);
        });
}
