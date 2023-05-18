<?php
namespace App\Util;


class Util
{
    public static function convertDateToScheduler($date)
    {
        $timestamp = strtotime($date);
        return date('m/d/Y', $timestamp);
    }
}

?>