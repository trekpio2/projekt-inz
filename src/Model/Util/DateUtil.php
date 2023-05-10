<?php
function convertDateToScheduler($date) {
    $timestamp = strtotime($date);
    return date('m/d/Y', $timestamp);
}
?>