// ===== JavaScript & DOM (Chapitre 5 du cours) =====

// 1. Afficher un message quand on clique "Ajouter au panier"
function ajouterPanier(nomProduit) {
    // Récupérer l'élément par son id (getElementById - cours chap 5)
    var msg = document.getElementById('msg-panier');

    // Modifier le texte de l'élément (innerText - cours chap 5)
    msg.innerText = '✅ "' + nomProduit + '" ajouté au panier !';

    // Afficher l'élément (style.display - cours chap 5)
    msg.style.display = 'block';

    // Cacher le message après 3 secondes
    setTimeout(function() {
        msg.style.display = 'none';
    }, 3000);
}

// 2. Valider le formulaire côté client avant envoi (DOM)
function validerFormulaire() {
    var email = document.getElementById('email').value;
    var mdp   = document.getElementById('mdp').value;

    if (email == '' || mdp == '') {
        // Modifier le style d'un élément (cours chap 5)
        document.getElementById('msg-validation').innerText = '⚠️ Veuillez remplir tous les champs !';
        document.getElementById('msg-validation').style.display = 'block';
        document.getElementById('msg-validation').style.color = 'red';
        return false; // Empêche l'envoi du formulaire
    }
    return true;
}

// 3. Accepter les cookies (bannière)
function accepterCookies() {
    // Cacher la bannière (style.display - cours chap 5)
    document.getElementById('cookie-banner').style.display = 'none';

    // Envoyer au serveur PHP pour créer le cookie
    window.location.href = '?accepter_cookie=1';
}
