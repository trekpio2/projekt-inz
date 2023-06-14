<?php
$requestData = file_get_contents('php://input');
$data = json_decode($requestData, true);
if ($data && isset($data['userName']) && isset($data['activityName']))
{
    $username = $data['userName'];
    $activityName = $data['activityName'];
    $exectuedData = '';

    foreach ($data['executeData']as $dataOption)
    {
        $exectuedData .= $dataOption . ' ';
    }   
}

date_default_timezone_set('Europe/Warsaw');
$timestamp = date("Y-m-d H:i:s"); // Get the current timestamp

$logFile = '../../../../ExecutedActivities.log';

$logData = $username . ' - ' . $activityName . ' - ' . date('Y-m-d H:i:s') . PHP_EOL; 

$fileHandle = fopen($logFile, 'a');
if ($fileHandle === false)
{

}
else
{
    fwrite($fileHandle, $logData);
    fclose($fileHandle);
}