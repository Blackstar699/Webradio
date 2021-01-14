<?php
session_start();
$_SESSION['identifiant'];
if(!isset($_SESSION['identifiant'])){
    header('location: login.php');
}
require_once "ressources/PHPincludes/webradio.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>WebRadio - Accueil</title>
    <meta charset="utf-8">
    <script type="text/javascript" src="webradio.js"></script>
    <link rel="shortcut icon" href="ressources/presentation/logo.png">
    <link rel="stylesheet" href="ressources/stylesheets/style.css">
    <link rel="stylesheet" href="icones/font/flaticon.css">
</head>

<script type="text/javascript">window.onload=premiere_musique;</script>

<body>

<header>
    <div id="header__username">
        <a href="ressources/PHPincludes/logout.php"><img src="https://img.icons8.com/windows/96/c0c0c0/logout-rounded-left.png" width="30" height="30"></a>
        <img src="https://img.icons8.com/windows/96/c0c0c0/username.png" width="30" height="30">
        <span><?=$_SESSION['identifiant']?></span>
        <div id="php_transferts">
            <div id="musics_table"><?php scan() ?></div>
            <div id="nbr_playlist_display"><?php display_nbr(); ?></div>
        </div>
    </div>
    <div id="header__btn-upload">
        <a href="upload.php"><img src="https://img.icons8.com/windows/96/c0c0c0/add-song.png" width="30" height="30"></a>
    </div>
</header>

<section id="playlists">
    <img src="https://img.icons8.com/windows/96/c0c0c0/playlist.png" width="25" height="25">
    <span id="playlists__playlist">Playlists :</span>
    <div id="playlists__list">
        <a href="ressources/PHPincludes/playlist_treatment.php?playlist=playlist0"><span id="playlist0">Toutes les musiques</span></a>
        <?php display_playlists_title() ?>
    </div>
    <a href="new_playlist.php"><img src="https://img.icons8.com/windows/96/c0c0c0/duplicate.png" width="25" height="25" id="playlists_plus"></a>
    <span id="playlists__create">Cr&eacute;er une playlist</span>
</section>

<section id="display-playlist-title">
    <span id="display-playlist-title__span">
        <!--affichage du titre de la playlist via Javascript-->
    </span>
    <?php modif_button() ?>
</section>
<section id="display">
    <?php display() ?>
</section>

<img src="https://img.icons8.com/windows/512/c0c0c0/music-record.png" alt="" id="cover">

<footer>
    <audio src="" oncanplay="update(this)" ontimeupdate="update(this)" id="lecteur" class="" preload="metadata"></audio>

    <div id="footer__music-infos">
        <span id="footer__music-infos__title"><?= $ThisFileInfo["tags"]["id3v1"]["title"][0] ?></span><br>
        <span id="footer__music-infos__artist"><?= $ThisFileInfo["tags"]["id3v1"]["artist"][0] ?></span>
    </div>

    <div id="footer__btn">
        <table>
            <tr>
                <td><img src="https://img.icons8.com/windows/96/c0c0c0/shuffle.png" id="random" width="25" height="25" class="1" onclick="play_random(this)"></td>
                <td><i class="flaticon-084-backward" id="pre" onclick="defilement_musics_test(-1)"></i></td>
                <td><i class="flaticon-146-play" id="play" onclick="play_pause()"></i></td>
                <td><i class="flaticon-085-forward" id="next" onclick="defilement_musics_test(1)"></i></td>
                <td><img src="https://img.icons8.com/windows/96/c0c0c0/repeat.png" id="loop" class="1" width="25" height="25" onclick="play_loop(this)"></td>
            </tr>
        </table>
    </div>

    <div id="footer__volume">
        <table>
            <tr>
                <td><img src="https://img.icons8.com/windows/96/c0c0c0/medium-volume.png" id="son" width="30" height="30" onclick="btn_volume()"></td>
                <td id="footer__volume__range">
                    <div id="footer__volume__progress-range" onclick="vol2()" onmousedown="vol()">
                        <div id="progressRange"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div id="footer__progress-bar" onclick="progress_bar_clic()" onmousedown="move()">
        <div id="progressBar"></div>
        <span id="progressTime">0:00/0:00</span>
    </div>
</footer>

</body>
</html>