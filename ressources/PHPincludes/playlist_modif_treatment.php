<?php
session_start();
$data = file_get_contents('../json/'.$_SESSION['identifiant'].'.json');
$json_playlists = json_decode($data, true);
$nbr = count($json_playlists);
$nbr_display = $json_playlists['display'];

if(isset($_REQUEST["delete"])){
    unset($json_playlists[$nbr_display]);
    $json_playlists['display'] = "playlist0";
}
else{
    unset($json_playlists[$nbr_display]);
    if(array_key_exists('title', $_REQUEST)){
        $json_playlists[$nbr_display]["name"] = $_REQUEST['title'];
    }
    $musics = 1;
    $scan = scandir('mp3');
    $nbrCases = count($scan);
    for($i=2; $i<$nbrCases; $i++){
        $j = $i-1;
        if(array_key_exists('check'.$j, $_REQUEST)){
            if($_REQUEST['check'.$j]==='on'){
                $json_playlists[$nbr_display]["music".$musics] = $scan[$i];
                $musics++;
            }
        }
    }
}
file_put_contents('../json/'.$_SESSION['identifiant'].'.json', json_encode($json_playlists));
header("Location: ../../index.php");
