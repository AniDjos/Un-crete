$(document).ready(function() {
    $('#formulaireFiliere').submit(function(event) {
        event.preventDefault();
        
        var formData = $(this).serialize();

        $.ajax({
            url: 'validerfil.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Ajout réussi !',
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
                    text: 'Une erreur s\'est produite lors de l\'ajout de la filière.',
                    icon: 'error'
                });
            }
        });
    });
});
