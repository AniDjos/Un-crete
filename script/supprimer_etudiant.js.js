$(document).ready(function() {
    // Écouter le clic sur les liens de suppression
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();

        // Récupérer l'ID de l'étudiant à supprimer
        var studentId = $(this).data('id');

        // Afficher une boîte de confirmation avec SweetAlert2
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: 'Cette action est irréversible!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Effectuer la suppression via AJAX
                $.ajax({
                    type: 'GET',
                    url: 'supprimer_etudiant.php?id=' + studentId,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Afficher un message de succès
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message
                            }).then(() => {
                                // Recharger la page ou faire d'autres actions nécessaires
                                location.reload();
                            });
                        } else {
                            // Afficher un message d'erreur
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // En cas d'erreur de requête AJAX
                        console.error('AJAX Error:', status, error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur s\'est produite. Veuillez réessayer.'
                        });
                    }
                });
            }
        });
    });
});