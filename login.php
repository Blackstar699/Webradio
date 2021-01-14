<?php
session_start();
include_once 'ressources/PHPincludes/functions.php';
$msg = FALSE;

if (!isset($_POST['mdp']) || !isset($_POST['identifiant'])) {
}
else {
    if (connectioncheck($_POST['identifiant'], $_POST['mdp']) == TRUE){
        $_SESSION['identifiant'] = $_POST['identifiant'];
        header('location: index.php');

    }
    else {
        $msg = TRUE;

    }
}
?>

<!DOCTYPE html>
<html lang="FR" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue!</title>
    <link rel="stylesheet" href="ressources/stylesheets/login.css">
    <link rel="shortcut icon" href="ressources/presentation/logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js" charset="UTF-8"></script>

</head>
<body>

    <form action="login.php" method="post" class="lgn-form">
        <h1>Se connecter</h1>

        <?php
        if ($msg){
            echo "<div id='error1'>Le mot de passe ou nom d'utilisateur est incorrect </div>";
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

        <input type="submit" class="lgnbutton" value="Se connecter" id="lgnbutton" onclick="trytolog()">

        <script type="text/javascript">
        $(".lgntext input").on("focus",function(){
        $(this).addClass("focus");
        });
        $(".lgntext input").on("blur",function(){
        if($(this).val() == "")
        $(this).removeClass("focus");
        });
        </script>

        <div class="create-account">
            Pas de compte? <a href="createaccount.php">Se cr&eacute;er un compte</a>
        </div>

    </form>


</body>
</html>