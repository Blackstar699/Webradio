<?php
$scan = scandir('mp3');
$nbrCases = count($scan);

if(isset($_REQUEST)){
    for($i=2; $i<$nbrCases; $i++){
        $j = $i-1;
        if(array_key_exists('check'.$j, $_REQUEST)){
            if($_REQUEST['check'.$j]==='on'){
                unlink("mp3/".$scan[$i]);
            }
        }
    }
    header('Location: ../../index.php');
    $_REQUEST = "";
}
