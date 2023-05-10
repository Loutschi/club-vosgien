document.getElementById("mon-formulaire").addEventListener("submit", function (event) {
    // Réinitialiser les valeurs du formulaire
    document.getElementById("mon-formulaire").reset();
    // Empêcher la soumission du formulaire
    event.preventDefault();
});
