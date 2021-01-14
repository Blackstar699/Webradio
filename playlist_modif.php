<?php
session_start();
$_SESSION['identifiant'];
if  (!isset($_SESSION['identifiant'])){
    header('location: login.php');
}

$data = file_get_contents('ressources/json/'.$_SESSION['identifiant'].'.json');
$json_playlists = json_decode($data, true);
$nbr_display = $json_playlists['display'];
$nbr_musics = count($json_playlists[$nbr_display]);
$playlist_title = $json_playlists[$nbr_display]["name"];

function display_playlist(){
    global $nbr_musics;
    global $json_playlists;
    global $nbr_display;
    require_once('getid3/getid3.php');
    $getid3 = new getID3;
    $scan = scandir('mp3');
    $nbrCases = count($scan);

    for($i=2; $i<$nbrCases; $i++){
        $ThisFileInfo = $getid3->analyze("mp3/".$scan[$i]);
        $j = $i-1;
        $check = "";

        for($k=1; $k<$nbr_musics; $k++){
            if($json_playlists[$nbr_display]["music".$k] === $scan[$i]){
                $check = "checked";
                break;
            }
            else{
                $check = "";
            }
        }

        if(isset($ThisFileInfo['tags']['id3v1'])){
            $tag1 = $ThisFileInfo['tags']['id3v1']['title'][0];
            $tag2 = $ThisFileInfo['tags']['id3v1']['artist'][0];
            $tag3 = $ThisFileInfo['tags']['id3v1']['album'][0];
        }
        elseif(isset($ThisFileInfo['tags']['id3v2'])){
            $tag1 = $ThisFileInfo['tags']['id3v2']['title'][0];
            $tag2 = $ThisFileInfo['tags']['id3v2']['artist'][0];
            $tag3 = $ThisFileInfo['tags']['id3v2']['album'][0];
        }
        else{
            $tag1 = "Unknow";
            $tag2 = "Unknow";
            $tag3 = "Unknow";
        }
        $tag1 = string_conversion($tag1);
        $tag2 = string_conversion($tag2);
        $tag3 = string_conversion($tag3);
        echo "<tr class=\"display__table__line\" id='".$scan[$i]."'>
            <td class='display__table__button'><input type=\"checkbox\" class='add' name=\"check".$j."\" ".$check."></td>
            <td class='display__table__title'>".$tag1."</td>
            <td class='display__table__artist'>".$tag2."</td>
            <td class='display__table__album'>".$tag3."</td>
            <td class='display__table__time'>".formatTime($getid3->info['playtime_seconds'])."</td>
            </tr>";
    }
}

function formatTime($time){
    $hours = floor($time/3600);
    $mins = floor(($time%3600)/60);
    $secs = floor($time%60);
    if ($secs < 10){
        $secs = "0".$secs;
    }
    if($hours){
        if($mins < 10){
            $mins = "0".$mins;
        }
        return $hours.":".$mins.":".$secs; // hh:mm:ss
    }
    else{
        return $mins.":".$secs; // mm:ss
    }
}

function string_conversion($str){
    $dictionnaire = array("й"=>"&eacute;", "к"=>"&ecirc;", "л"=>"&euml;", "щ"=>"&ugrave;", "з"=>"&ccedil;", "а"=>"&agrave;", "п"=>"&iuml;", "и"=>"&egrave;", "о"=>"&icirc;", "&"=>"&amp;", "é"=>"&eacute;", "è"=>"&egrave;", "ç"=>"&ccedil;", "à"=>"&agrave;", "ê"=>"&ecirc;", "û"=>"&ucirc;", "î"=>"&icirc;", "ô"=>"&ocirc;", "ù"=>"&ucirc;", "ä"=>"&auml;", "ü"=>"&uuml;", "ï"=>"&iuml;", "ö"=>"&ouml;", "ë"=>"&euml;");
    return strtr($str, $dictionnaire);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>WebRadio - Playlist Modification</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="ressources/presentation/logo.png">
    <link rel="stylesheet" href="ressources/stylesheets/modifs.css">
</head>


<body>
<header>
    <div class="header__username">
        <a href="ressources/PHPincludes/logout.php"><img src="https://img.icons8.com/windows/96/c0c0c0/logout-rounded-left.png" width="30" height="30"></a>
        <img src="https://img.icons8.com/windows/96/c0c0c0/username.png" width="30" height="30">
        <span><?=$_SESSION['identifiant']?></span>
    </div>
</header>

<section>
    <form action="ressources/PHPincludes/playlist_modif_treatment.php" method="post">
        <div class="title_bar">
            <h1 class="left">Modification de la playlist <?= $playlist_title ?></h1>
            <input type="text" class="left input_txt" maxlength="20" minlength="1" size="20" name="title" value="<?= $playlist_title ?>">
            <input type="checkbox" class="delete left" id="delete" name="delete">
            <input type="submit" class="left" value="Modifier">
        </div>
        <div class="display">
            <table>
                <tr>
                    <th class="display__table__button"></th>
                    <th class="display__table__title">Titre</th>
                    <th class="display__table__artist">Artiste</th>
                    <th class="display__table__album">Album</th>
                    <th class="display__table__time">Dur&eacute;e</th>
                </tr>
                <?php display_playlist(); ?>
            </table>
        </div>
    </form>
</section>

</body>
</html>
