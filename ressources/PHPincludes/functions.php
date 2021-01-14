<?php
function usernamecheck($username){
    $filename = 'data.csv';

    if (($h = fopen($filename, "r")) !== FALSE)
    {
        while (($data = fgetcsv($h, 0, ":" )) !== FALSE)
        {
            if($username == $data[0]){
                fclose($h);
                return TRUE;
            }
        }
    }
    fclose($h);
    return FALSE;
}

function connectioncheck($username, $password){
    $filename = 'data.csv';

    if (($h = fopen($filename, "r")) !== FALSE)
    {
        while (($data = fgetcsv($h, 0, ":" )) !== FALSE)
        {
            if($username == $data[0] && $password == $data[1]){
                fclose($h);
                return TRUE;
            }
        }
    }
    fclose($h);
    return FALSE;
}

