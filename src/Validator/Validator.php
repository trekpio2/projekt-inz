<?php
namespace App\Validator;

class Validator
{
    public function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function isAlpha($data)
    {
        if(!ctype_alpha($data))
        {
            return "Given data must contains only alphabetic characters";
        }
    
        return 1;
    }

    public function isNumeric($data)
    {
        if(!is_numeric($data))
        {
            return "Given data must be numeric only";
        }

        return 1;
    }

    public function validateImg($file)
    {
        if($file['type'] != 'image/png' || $file['type'] != 'image/jpeg')
            return 'Wrong file type';
        $fileSize = filesize($file['tmp_name']);
 
        // 5MB
        if($fileSize > 5242880)
        {
            return 'Image is too large. Max 5MB';
        }

        return 1;
    }
}