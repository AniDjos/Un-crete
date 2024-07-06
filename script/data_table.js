$(document).ready(function() {
    $('#tableEtudiants').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
    });

    // Toggle du formulaire
    $('#afficherFormulaireBtn').on('click', function() {
        $('#formulaire').toggle();
    });
});