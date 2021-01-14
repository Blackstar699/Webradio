<?php
session_start();
$_SESSION['identifiant'];
if  (!isset($_SESSION['identifiant'])){
    header('location: login.php');
}

$page = "<div id=\"upload__text\">Téléchargez une musique depuis votre PC</div><div id=\"upload__form\"><form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\"><label for=\"file\">Choisir une musique</label><input type=\"file\" id=\"file\" name=\"fichier\"><input type=\"submit\" id=\"upload__submit\" value=\"envoyer\" name=\"submit\"></form></div>";
$page_base = $page;
if(isset($_FILES['fichier'])){
    $dossier = 'mp3/';
    $fichier = basename($_FILES['fichier']['name']);
    if(mime_content_type($_FILES['fichier']['tmp_name']) === "audio/mpeg"){
        if(move_uploaded_file($_FILES['fichier']['tmp_name'],$dossier.$fichier)){
            $page = "<div id=\"upload__text\">Votre musique a bien été enregistrée !</div><a href=\"upload.php\"><button id=\"upload__btn-retry\">Télécharger une autre musique</button></a><a href=\"index.php\"><button id=\"upload__btn-menu\">Retour au menu</button></a>";
        }
        else{
            $page = "<div id=\"upload__text\">Votre musique n'a pas pu être téléchargée !</div><a href=\"upload.php\"><button id=\"upload__btn-retry\">Réessayer</button></a><a href=\"index.php\"><button id=\"upload__btn-menu\">Retour au menu</button></a>";
        }
    }
    else{
        $page = "<div id=\"upload__text\">Votre fichier n'est pas de type MP3 !</div><a href=\"upload.php\"><button id=\"upload__btn-retry\">Réessayer</button></a><a href=\"index.php\"><button id=\"upload__btn-menu\">Retour au menu</button></a>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>WebRadio - Music Upload</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="ressources/presentation/logo.png">
    <link rel="stylesheet" href="ressources/stylesheets/upload.css">
</head>

<body>

    <section id="upload">
        <?= $page ?>
    </section>

</body>
</html>
