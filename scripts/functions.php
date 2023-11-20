<?php

    function cleanInput($data){
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        $data = strip_tags($data);
        return $data;
    }

    function cleanFormData($data, $cnt = 0, $newData = []) {
        foreach ($data as $key => $value) {
            $newData[$key] = cleanInput($value);
        }
        return $newData;
    }
    
   