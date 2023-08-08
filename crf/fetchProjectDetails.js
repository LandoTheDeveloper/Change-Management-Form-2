function fetchProjectDetails(projectName) {
    fetch('getProjectDetails.php?projectName=' + encodeURIComponent(projectName))
        .then(response => response.json())
        .then(projectDetails => {
            document.getElementById('cr-number').value = projectDetails.cr_number;
            document.getElementById('client-email').value = projectDetails.client_email;
        })
        .catch(error => {
            console.error('Error fetching project details:', error);
        });
}
