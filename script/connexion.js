

document.getElementById('formulaireConnexion').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(document.getElementById('formulaireConnexion'));

    fetch('valider_connexion.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: data.message
            }).then(() => {
                window.location.href = data.redirect;
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Une erreur s\'est produite. Veuillez réessayer.'
        });
    });
});
