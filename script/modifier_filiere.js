 // Soumission du formulaire avec confirmation
 document.getElementById('formulaireModifierFiliere').addEventListener('submit', function(event) {
    event.preventDefault();

    // Afficher la confirmation avec SweetAlert2
    Swal.fire({
        title: 'Êtes-vous sûr de vouloir modifier cette filière ?',
        text: 'Cette action est irréversible.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui, modifier',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si confirmé, soumettre le formulaire via AJAX
            var formData = new FormData(document.getElementById('formulaireModifierFiliere'));

            fetch('validermodfil.php', {
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
                        // Redirection ou autre action après succès
                        window.location.href = 'listefil.php';
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
        }
    });
});