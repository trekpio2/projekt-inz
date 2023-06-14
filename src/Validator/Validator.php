<?php
namespace App\Validator;

class Validator
{
    public static function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function isAlpha($data)
    {
        if(!ctype_alpha($data)) {
            return 0;
        }
    
        return 1;
    }

    public static function isNumeric($data)
    {
        if(!is_numeric(floatval($data))){
            return 0;
        }

        return 1;
    }

    public static function validateImg($file)
    {
        if($file['type'] != 'image/png' && $file['type'] != 'image/jpeg') {
            return 'Wrong image file type';
        }

        $fileSize = filesize($file['tmp_name']);
 
        // 5MB
        if($fileSize > 5242880) {
            return 'Image is too large. Max 5MB';
        }

        return 1;
    }
}