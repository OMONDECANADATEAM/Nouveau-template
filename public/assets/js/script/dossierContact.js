  // Attend que le DOM soit prêt
  document.addEventListener('DOMContentLoaded', function () {
    // Récupère la case à cocher et le formulaire
    var checkbox = document.getElementById('consultation_payee');
    var questionnaireForm = document.querySelector('.questionnaire-form');

    // Ajoute un écouteur d'événement pour le changement de la case à cocher
    checkbox.addEventListener('change', function () {
        // Affiche ou masque le deuxième formulaire en fonction de l'état de la case à cocher
        questionnaireForm.style.display = checkbox.checked ? 'block' : 'none';
    });
});
