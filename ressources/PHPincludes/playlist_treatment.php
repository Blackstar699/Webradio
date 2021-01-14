<?php
session_start();
$playlist = $_GET['playlist'];
$data = file_get_contents('../json/'.$_SESSION['identifiant'].'.json');
$json_playlists = json_decode($data, true);

$json_playlists['display'] = $playlist;
file_put_contents('../json/'.$_SESSION['identifiant'].'.json', json_encode($json_playlists));

header('Location: ../../index.php');