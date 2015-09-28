<?php

function databaseErrorHandler($message, $info){
    if (!error_reporting()) return;
    echo "SQL Error: $message<br><pre>"; 
    print_r($info);
    echo "</pre>";
    exit();
}


