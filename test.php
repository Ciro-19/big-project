<?php
// Connexion à la base de données
$host = 'localhost';
$user = '';
$password = '';
$dbname = '';
$conn = mysqli_connect($host, $user, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

// Récupération des données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$sujet = $_POST['sujet'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$message = $_POST['message'];

// Insertion des données dans la base de données
$sql = "INSERT INTO contacts (nom, prenom, email, sujet, telephone, message) VALUES ('$nom', '$prenom', '$email', '$sujet','$telephone', '$message')";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "error";
}

// Récupérer les valeurs du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$sujet = $_POST['sujet'];
$telephone = $_POST['telephone'];
$message = $_POST['message'];

// Adresse e-mail du destinataire
$destinataire = "lpoignard@guardiaschool.fr";

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

mysqli_close($conn);

?>
