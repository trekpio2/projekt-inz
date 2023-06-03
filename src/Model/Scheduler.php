<?php
namespace App\Model;

use App\Util\Util;

class Scheduler
{
    public function createTaskFile($scriptFilePath,$ip, $activityName, $executeData, $logaData)
    {
        $url = $ip;
    
        $fileContent = <<<EOD
        fetch('$ip', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify($executeData),
        }).then((response) => {
          console.log(response.status);
          console.log(response);
          fetch('/assets/src/js/LogActivityExecution.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(),
          })
          .then((response) => {
            if (response.ok) {
              console.log('Timestamp logged successfully!');
            } else {
              throw new Error('Error logging timestamp');
            }
          })
          .catch((error) => {
            console.error('Error logging timestamp:', error);
          });
        });
        EOD;
        
        $file = fopen($scriptFilePath, 'w');
        fwrite($file, $fileContent);
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
        $startDate = Util::convertDateToScheduler($startDate);
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
        $startDate = Util::convertDateToScheduler($startDate);
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

public function turnOffTask($taskName)
{
    exec("schtasks /change /tn \"$taskName\" /disable");
}


}
