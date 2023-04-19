<?php
// Récupérer les valeurs du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$sujet = $_POST['sujet'];
$telephone = $_POST['telephone'];
$message = $_POST['message'];

// Adresse e-mail du destinataire
$destinataire = "itaberkane@guardiaschool.fr";

// Sujet du message
$objet = "Nouveau message de $nom $prenom : $sujet";

// Contenu du message
$contenu = "Nom : $nom\n";
$contenu .= "Prénom : $prenom\n";
$contenu .= "Email : $email\n";
$contenu .= "Téléphone : $telephone\n\n";
$contenu .= "Message :\n$message";

// En-têtes du message
$headers = "From: $nom $prenom <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\"";

// Envoyer le message
if(mail($destinataire, $objet, $contenu, $headers)) {
    // Le message a été envoyé avec succès
    echo "Votre message a bien été envoyé.";
} else {
    // Une erreur s'est produite lors de l'envoi du message
    echo "Une erreur s'est produite lors de l'envoi du message.";
}