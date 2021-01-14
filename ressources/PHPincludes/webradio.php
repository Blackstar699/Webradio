<?php
$data = file_get_contents('ressources/json/'.$_SESSION['identifiant'].'.json');
$json_playlists = json_decode($data, true);
$nbr_display = $json_playlists['display'];
require_once('getid3/getid3.php');
$getid3 = new getID3;
$ThisFileInfo = $getid3->analyze("mp3/mortel_kobalad.mp3");

function display_nbr(){
    global $nbr_display;
    global $json_playlists;
    $scan = count($json_playlists);
    $scan-=1;

    echo "<p id='playlist_num'>".$nbr_display."</p>";
    echo "<p id='playlist_nbr'>".$scan."</p>";
}

function modif_button(){
    global $nbr_display;
    if($nbr_display === "playlist0"){
        echo "<a href='delete_music.php'><img src='https://img.icons8.com/windows/96/c0c0c0/minus-sign.png' width='35' height='35'></a>";
    }
    else{
        echo "<a href='playlist_modif.php'><img src='https://img.icons8.com/windows/512/c0c0c0/edit.png' width='35' height='35'></a>";
    }
}

function scan(){
    global $nbr_display;
    if($nbr_display === "playlist0"){
        scan_all_musics();
    }
    else{
        scan_playlist($nbr_display);
    }
}

function scan_all_musics(){
    $scan = scandir('mp3');
    $nbr = count($scan);

    for($i=2; $i<$nbr; $i++){
        $j = $i-1;
        echo "<p id='music_num".$j."'>".$scan[$i]."</p>";
    }
    $nbr-=2;
    echo "<p id='nbr_musics'>".$nbr."</p>";
}

function scan_playlist($playlist){
    global $json_playlists;
    $scan = $json_playlists[$playlist];
    $nbr = count($scan);

    for($i=1; $i<$nbr; $i++){
        echo "<p id='music_num".$i."'>".$scan["music".$i]."</p>";
    }
    $nbr-=1;
    echo "<p id='nbr_musics'>".$nbr."</p>";
}


function new_playlist(){
    global $json_playlists;
    $nbr = count($json_playlists);
    if(array_key_exists('title', $_REQUEST)){
        $json_playlists["playlist".$nbr]["name"] = $_REQUEST['title'];
    }

    $musics = 1;
    $scan = scandir('mp3');
    $nbrCases = count($scan);

    for($i=2; $i<$nbrCases; $i++){
        $j = $i-1;
        if(array_key_exists('check'.$j, $_REQUEST)){
            if($_REQUEST['check'.$j]==='on'){
                $json_playlists["playlist".$nbr]["music".$musics] = $scan[$i];
                $musics++;
            }
        }
    }
    file_put_contents('ressources/json/'.$_SESSION['identifiant'].'.json', json_encode($json_playlists));
}

if(isset($_REQUEST)){
    new_playlist();
}

function display_playlists_title(){
    global $json_playlists;
    $nbr = count($json_playlists);

    for($i=1; $i<$nbr; $i++){
        echo "<a href='ressources/PHPincludes/playlist_treatment.php?playlist=playlist".$i."'><span id='playlist".$i."'>".$json_playlists["playlist".$i]["name"]."</span></a>";
    }
}


function display(){
    global $nbr_display;
    if($nbr_display === "playlist0"){
        display_first_playlist();
    }
    else{
        display_other_playlist($nbr_display);
    }
}

function display_first_playlist(){
    require_once('getid3/getid3.php');
    $getid3 = new getID3;
    $scan = scandir('mp3');
    $nbr = count($scan);

    echo "<table><tr><th class=\"display__table__title\">Titre</th><th class=\"display__table__artist\">Artiste</th><th class=\"display__table__album\">Album</th><th class=\"display__table__time\">Dur&eacute;e</th></tr>";

    for($i=2; $i<$nbr; $i++){
        $ThisFileInfo = $getid3->analyze("mp3/".$scan[$i]);
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
        echo "<tr class=\"display__table__line\" id='".$scan[$i]."' onclick='music_clic(this)'>
            <td class='display__table__title'>".$tag1."</td>
            <td class='display__table__artist'>".$tag2."</td>
            <td class='display__table__album'>".$tag3."</td>
            <td class='display__table__time'>".formatTime($getid3->info['playtime_seconds'])."</td>
            </tr>";
    }

    echo "</table>";
}

function display_other_playlist($playlist){
    global $json_playlists;
    $nbr = count($json_playlists[$playlist]);
    require_once('getid3/getid3.php');
    $getid3 = new getID3;

    echo "<table><tr><th class=\"display__table__title\">Titre</th><th class=\"display__table__artist\">Artiste</th><th class=\"display__table__album\">Album</th><th class=\"display__table__time\">Dur&eacute;e</th></tr>";

    for($i=1; $i<$nbr; $i++){
        $ThisFileInfo = $getid3->analyze("mp3/".$json_playlists[$playlist]["music".$i]);
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
        echo "<tr class=\"display__table__line\" id='".$json_playlists[$playlist]["music".$i]."' onclick='music_clic(this)'>
            <td class='display__table__title'>".$tag1."</td>
            <td class='display__table__artist'>".$tag2."</td>
            <td class='display__table__album'>".$tag3."</td>
            <td class='display__table__time'>".formatTime($getid3->info['playtime_seconds'])."</td>
            </tr>";
    }

    echo "</table>";
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
