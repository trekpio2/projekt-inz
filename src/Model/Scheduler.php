<?php
namespace App\Model;

use App\Service\Config;

function convertDate($date) {
    $timestamp = strtotime($date);
    return date('m/d/Y', $timestamp);
}

class Scheduler
{
    public function createTaskFile($scriptFilePath,$ip, $activityName, $executeData)
    {
        $url = $ip;
    
        $file = fopen($scriptFilePath, "w");
        fwrite($file, "var data = '".$executeData."';\n");
        fwrite($file, "fetch('" . $url . "', {\n");
        fwrite($file, "  method: 'POST',\n");
        fwrite($file, "  headers: { 'Content-Type': 'application/json' },\n");
        fwrite($file, "  body: JSON.stringify(data)\n");
        fwrite($file, "})\n");
        fwrite($file, ".then(response => response.text())\n");
        fwrite($file, ".then(data => console.log(data))\n");
        fwrite($file, ".catch(error => console.error('Error:', error));\n");
        fclose($file);
    }

    public function deleteTaskFile($scriptFilePath)
    {
        if (file_exists($scriptFilePath))
        {
            unlink($scriptFilePath);
        }
    }

    public function addTask($taskName, $taskCommand, $startTime, $startDate, $period, $periodNr)
    {
        $startDate = convertDateToScheduler($startDate);
        switch ($period) {
            case 'days':
                exec("schtasks /create /tn \"$taskName\" /tr \"$taskCommand\" /sc daily /mo $periodNr /sd $startDate /st $startTime");
                break;
            case 'weeks':
                exec("schtasks /create /tn \"$taskName\" /tr \"$taskCommand\" /sc weekly /mo $periodNr /sd $startDate /st $startTime");
                break;
            case 'months':
                exec("schtasks /create /tn \"$taskName\" /tr \"$taskCommand\" /sc monthly /mo $periodNr /sd $startDate /st $startTime");
                break;
            default:
                exec("schtasks /create /tn \"$taskName\" /tr \"$taskCommand\" /sc once /sd $startDate /st $startTime");
                break;
        }
        
    }

    public function editTask($taskName, $startTime, $startDate, $period, $periodNr)
    {
        $startDate = convertDateToScheduler($startDate);
        switch ($period) {
            case 'days':
                exec("schtasks /change /tn \"$taskName\" /tr \"$taskCommand\" /sc daily /mo $periodNr /sd $startDate /st $startTime");
                break;
            case 'weeks':
                exec("schtasks /change /tn \"$taskName\" /tr \"$taskCommand\" /sc weekly /mo $periodNr /sd $startDate /st $startTime");
                break;
            case 'months':
                exec("schtasks /change /tn \"$taskName\" /tr \"$taskCommand\" /sc monthly /mo $periodNr /sd $startDate /st $startTime");
                break;
            default:
                exec("schtasks /change /tn \"$taskName\" /tr \"$taskCommand\" /sc once /sd $startDate /st $startTime");
                break;
        }
    }

    public function removeTask($taskName)
    {
        exec("schtasks /delete /tn \"$taskName\" /f");
    }
/*
public function turnOffTask($taskName)
{
    exec("schtasks /change /tn \"$taskName\" /disable");
}

public function turnOnTask($taskName) 
{
    exec("schtasks /change /tn \"$taskName\" /enable");
}
*/
}
