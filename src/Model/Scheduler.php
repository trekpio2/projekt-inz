<?php
namespace App\Model;

use App\Service\Config;

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

    public function addTask($taskName, $taskCommand, $startTime, $period)
    {
        exec("schtasks /create /tn \"$taskName\" /tr \"$taskCommand\" /sc $period /st $startTime");
    }

    public function editTask($taskName, $startTime, $period)
    {
        exec("schtasks /change /tn \"$taskName\" /sc $period /st $startTime");
    }

    public function removeTask($taskName)
    {
        exec("schtasks /delete /tn \"$taskName\" /f");
    }

    public function turnOffTask($taskName)
    {
        exec("schtasks /change /tn \"$taskName\" /disable");
    }
    
    public function turnOnTask($taskName) 
    {
        exec("schtasks /change /tn \"$taskName\" /enable");
    }
}
