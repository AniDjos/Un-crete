$(document).ready(function() {
    // Gestion de la suppression d'une filière
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Êtes-vous sûr(e) de vouloir supprimer cette filière ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Faire la requête pour supprimer la filière
                $.ajax({
                    url: 'supfiliere.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Suppression réussie !',
                                text: data.message,
                                icon: 'success'
                            }).then(() => {
                                // Recharger la page ou mettre à jour la liste des filières
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Erreur',
                                text: data.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Erreur',
                            text: 'Une erreur s\'est produite lors de la suppression.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });
});
