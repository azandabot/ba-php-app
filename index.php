<?php

    require_once 'scripts/dbconfig.php';

    $client = new BakeryDBClient;

    $result = $client->userLogin('azanda', 'azanda123');


    echo 'Login: '.$result;