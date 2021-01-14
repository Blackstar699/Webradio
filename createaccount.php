<?php
include_once 'ressources/PHPincludes/functions.php';
$msg = FALSE;

if (!isset($_POST['mdp']) || !isset($_POST['identifiant']) || !isset($_POST['mdpconfirm'])) {
} else {
    if (usernamecheck($_POST['identifiant'])) {
        $msg = TRUE;
    }
    else {

        $dataacc = fopen('data.csv', 'a');
        fputs($dataacc, "{$_POST['identifiant']}:{$_POST['mdp']}\n");
        fclose($dataacc);
        $json_playlists = [];
        $json_playlists['display'] = "playlist0";
        file_put_contents("ressources/json/{$_POST['identifiant']}.json", json_encode($json_playlists));
        header('location: login.php');
    }
}
?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Création de compte</title>
    <link rel="stylesheet" href="ressources/stylesheets/login.css">
    <link rel="shortcut icon" href="ressources/presentation/logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" charset="UTF-8"></script>
</head>
<body>

<form action="createaccount.php" method="post" class="lgn-form">
    <h1>Créer un compte</h1>

    <?php
    if ($msg) {
        echo '<div id="error2">Cet identifiant est déja utilisé!</div>';
    }
    ?>

    <div class="lgntext">
        <input type="text" id="username" name="identifiant">
        <span data-placeholder="Identifiant"></span>
    </div>

    <div class="lgntext">
        <input type="password" id="password" name="mdp">
        <span data-placeholder="Mot de passe"></span>
    </div>

    <div class="lgntext">
        <input type="password" id="passwordconfirm" name="mdpconfirm">
        <span data-placeholder="Répéter le mot de passe"></span>
    </div>

    <input type="submit" class="lgnbutton" value="Se créer un compte" id="lgnbutton" disabled>

    <script type="text/javascript">
        $(".lgntext input").on("focus", function () {
            $(this).addClass("focus");
        });
        $(".lgntext input").on("blur", function () {
            if ($(this).val() == "")
                $(this).removeClass("focus");
        });
        $(".lgntext input").change(function () {
            if (document.getElementById('username').value !== "" && document.getElementById('password').value === document.getElementById('passwordconfirm').value) {
                document.getElementById('lgnbutton').disabled = false;
            } else {
                document.getElementById('lgnbutton').disabled = true;

            }
        })
    </script>

</form>
</body>
</html>