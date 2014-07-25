<?php
/*
  **************************************************************
  *                        MyShell                             *
  **************************************************************
  $Id: shell.php,v 1.0.5 2001/09/08 09:28:42 digitart Exp $

  An interactive PHP-page that will execute any command entered.
  See the files README and INSTALL or http://www.digitart.net  for
  further information.
  Copyright ©2001 Alejandro Vasquez <admin@digitart.com.mx>
  based on the original program phpShell by Martin Geisler

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You can get a copy of the GNU General Public License from this
  address: http://www.gnu.org/copyleft/gpl.html#SEC1
  You can also write to the Free Software Foundation, Inc., 59 Temple
  Place - Suite 330, Boston, MA  02111-1307, USA.
*/


#$selfSecure Enable auto authenticate feature. This must be 0 in order to
#use .htaccess file to control access to MyShell, otherwise let it as 1
#and set up your user and password using $shellUser and $shellPswd.
#DO NOT TURN THIS OFF UNLESS YOU HAVE AN ALTERNATE METHOD TO PROTECT
#ACCESS TO THE SCRIPT.

$selfSecure = 1;
$shellUser  = "root";
$shellPswd  = "myshell";

#$adminEmail is the email address to send warning notifications in case
#someone tries to access the script and fails to provide correct user and
#password. This only works if you have $selfSecure enabeled.

$adminEmail = "youremail@yourserver.com";

#$fromEmail is the email address warning messages are sended from.
#This is set for default to the server admin, but you can change
#to any address you want i.e.: noreplay@yourdomain.com
#This only works if you have $selfSecure enabeled.

$fromEmail  = $HTTP_SERVER_VARS["SERVER_ADMIN"];

#$dirLimit is the top directory allowed to change to using cd command
#or the form selector. Any attempt to change to a directory up this
#level bounces MyShell to this directory. i.e.: $dirLimit = "/home";
#It is a good practice to set it to $DOCUMENT_ROOT using:
#$dirLimit = $DOCUMENT_ROOT;
#If you want to have access to all server directories leave it blank.
#WARNING: Althought a user won't be able to snoop on directories above
#this level using MyShell, he/she will still be able to excecute
#commands on any directory where Webserver has permisson,
#i.e.: mkdir /tmp/mydir or cat /home/otheruser/.htaccess.

$dirLimit = "";

#$autoErrorTrap Enable automatic error traping if command returns error.
#Bear in mind that MyShell executes the command again in order to
#trap the stderr. This shouldn't be a problem in most cases.
#If you turn it off, you'll have to select to trap stderr or not for
#every command you excecute.

$autoErrorTrap = 1;

#Cosmetic defaults.

$termCols     = 80;            //Default width of the output text area
$termRows     = 20;            //Default heght of the output text area
$bgColor      = "#000000";     //background color
$bgInputColor = "#333333";     //color of the input field
$outColor     = "#00BB00";     //color of the text output from the server
$textColor    = "#009900";     //color of the hard texts of the terminal
$linkColor    = "#00FF00";     //color of the links

/************** No customize needed from this point *************/

$MyShellVersion = "MyShell 1.0.5 build 20010910";
if($selfSecure){
    if (($PHP_AUTH_USER!=$shellUser)||($PHP_AUTH_PW!=$shellPswd)) {
       Header('WWW-Authenticate: Basic realm="MyShell"');
       Header('HTTP/1.0 401 Unauthorized');
       echo "<html>
         <head>
         <title>MyShell error - Access Denied</title>
         </head>
         <h1>Access denied</h1>
         A warning message have been sended to the administrator
         <hr>
         <em>$MyShellVersion</em>";
       if(isset($PHP_AUTH_USER)){
          $warnMsg ="
 This is $MyShellVersion
 installed on: http://".$HTTP_SERVER_VARS["HTTP_HOST"]."$PHP_SELF
 just to let you know that somebody tryed to access
 the script using wrong username or password:
 
 Date: ".date("Y-m-d H:i:s")."
 IP: ".$HTTP_SERVER_VARS["REMOTE_ADDR"]."
 User Agent: ".$HTTP_SERVER_VARS["HTTP_USER_AGENT"]."
 username used: $PHP_AUTH_USER
 password used: $PHP_AUTH_PW
 
 If this is not the first time it happens,
 please consider either to remove MyShell
 from your system or change it's name or
 directory location on your server.
 
 Regards
 The MyShell dev team
       ";
          mail($adminEmail,"MyShell Warning - Unauthorized Access",$warnMsg,
          "From: $fromEmail\nX-Mailer:$MyShellVersion AutoWarn System");
       }
       exit;
    }
}

if(!$oCols)$oCols=$termCols;
if(!$oRows)$oRows=$termRows;
?>
<html>
<head>
<title>MyShell</title>
<style>
body{
	background-color: <?echo $bgColor ?>;
	font-family : sans-serif;
	font-size : 10px;
	scrollbar-face-color: #666666;
	scrollbar-shadow-color:  <?echo $bgColor ?>;
	scrollbar-highlight-color: #999999;
	scrollbar-3dlight-color:  <?echo $bgColor ?>;
	scrollbar-darkshadow-color:  <?echo $bgColor ?>;
	scrollbar-track-color:  <?echo $bgInputColor ?>;
	scrollbar-arrow-color:  <?echo $textColor ?>;
}
input,select,option{
	background-color: <?echo $bgInputColor ?>;
	color : <?echo $outColor ?>;
	border-style : none;
	font-size : 10px;
}
textarea{
	background-color: <?echo $bgColor ?>;
	color : <?echo $outColor ?>;
	border-style : none;
}
</style>
</head>
<body bgcolor=<?echo $bgColor ?> TEXT=<?echo $textColor ?> LINK=<?echo $linkColor ?> VLINK=<?echo $linkColor ?> onload=document.shell.command.select()>
<?php
// First we check if there has been asked for a working directory.
if (isset($work_dir)) {
  //A workdir has been asked for - we chdir to that dir.
  $work_dir = validate_dir($work_dir);
  @chdir($work_dir) or
      ($dirError = "Can't change directory. Permission denied\nSwitching back to $DOCUMENT_ROOT\n");
  $work_dir = exec("pwd");
}
else{
  /* No work_dir - we chdir to $DOCUMENT_ROOT */
  $work_dir = validate_dir($DOCUMENT_ROOT);
  chdir($work_dir);
  $work_dir = exec("pwd");
}

//Handling cd command
$cdPos = strpos($command,"cd ");
if ((string)$cdPos != "") {
    $cdPos=$cdPos+3;
    $path = substr($command,$cdPos);
    if ($path==".."){
         $work_dir=strrev(substr(strstr(strrev($work_dir), "/"), 1));
         if ($work_dir == "") $work_dir = "/";
    }
    elseif (substr($path,0,1)=="/")$work_dir=$path;
    else $work_dir=$work_dir."/".$path;
    $work_dir = validate_dir($work_dir);
    @chdir($work_dir) or ($dirError = "Can't change directory. Directory does not exist or permission denied");
    $work_dir = exec("pwd");
    $commandBk = $command;
    $command = "";
}
?>

<form name="shell" method="post">
Current working directory: <b>
<?
$work_dir_splitted = explode("/", substr($work_dir, 1));
echo "<a href=\"$PHP_SELF?work_dir=" . urlencode($url) . "/&command=" . urlencode($command) . "\">Root</a>/";
if ($work_dir_splitted[0] == "") {
  $work_dir = "/";  /* Root directory. */
}
else{
  for ($i = 0; $i < count($work_dir_splitted); $i++) {
    /*  echo "i = $i";*/
    $url .= "/".$work_dir_splitted[$i];
    echo "<a href=\"$PHP_SELF?work_dir=" . urlencode($url) . "&command=" . urlencode($command) . "\">$work_dir_splitted[$i]</a>/";
  }
}
?>
</b>
<br>
<textarea cols="<? echo $oCols ?>" rows="<? echo $oRows ?>" readonly>
<?
echo $dirError;
if ($command) {
  if ($stderr) {
    system($command . " 1> /tmp/output.txt 2>&1; cat /tmp/output.txt; rm /tmp/output.txt");
  }
  elseif (substr($command,0,3) == "man"){
      exec($command,$man);
      $rows=count($man);
      $codes = ".".chr(8);
      $manual = "";
      for ($i=0;$i<$rows;$i++){
          $manual.=$man[$i]."\n";
      }
      echo ereg_replace($codes,"",$manual);
  }
  else {
    $ok = system($command,$status);
    if($ok==false &&$status && $autoErrorTrap)system($command . " 1> /tmp/output.txt 2>&1; cat /tmp/output.txt; rm /tmp/output.txt");
  }
}
if ($commandBk) $command = $commandBk;
?>
</textarea>
<br>
<br>
Command:
<input type="text" name="command" size="80" <? if ($command && $echoCommand) { echo "value=\"$command\"";} ?> > <input name="submit_btn" type="submit" value="Go!">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?
if ($autoErrorTrap) echo "Auto error traping enabled";
else echo "<input type=\"checkbox\" name=\"stderr\">stderr-traping ";
?>
<br>Working directory:
<select name="work_dir" onChange="this.form.submit()">
<?
/* Now we make a list of the directories. */
$dir_handle = opendir($work_dir);
/* Run through all the files and directories to find the dirs. */
while ($dir = readdir($dir_handle)) {
  if (is_dir($dir)) {
    if ($dir == ".") {
      echo "<option value=\"$work_dir\" selected>Current Directory</option>\n";
    } elseif ($dir == "..") {
      /* We have found the parent dir. We must be carefull if the parent
         directory is the root directory (/). */
      if (strlen($work_dir) == 1) {
        /* work_dir is only 1 charecter - it can only be / */
      } elseif (strrpos($work_dir, "/") == 0) {
        /* The last / in work_dir were the first charecter.
           This means that we have a top-level directory
           eg. /bin or /home etc... */
      echo "<option value=\"/\">Parent Directory</option>\n";
      } else {
      /* We do a little bit of string-manipulation to find the parent
         directory... Trust me - it works :-) */
      echo "<option value=\"". strrev(substr(strstr(strrev($work_dir), "/"), 1)) ."\">Parent Directory</option>\n";
      }
    } else {
      if ($work_dir == "/") {
        echo "<option value=\"$work_dir$dir\">$dir</option>\n";
      } else {
        echo "<option value=\"$work_dir/$dir\">$dir</option>\n";
      }
    }
  }
}
  closedir($dir_handle);
?>
</select>
&nbsp; | &nbsp;<input type="checkbox" name="echoCommand"<?if($echoCommand)echo " checked"?>>Echo commands
&nbsp; | &nbsp;Cols:<input type="text" name="oCols" size=3 value=<?echo $oCols?>>
&nbsp;Rows:<input type="text" name="oRows" size=2 value=<?echo $oRows?>>
&nbsp;| ::::::::::&nbsp;<a href="http://www.digitart.net" target="_blank" style="text-decoration:none"><b>MyShell</b> &copy;2001 Digitart Producciones</a>
</form>
</body>
</html>
<?
function validate_dir($dir){
    GLOBAL $dirLimit;
    if($dirLimit){
        $cdPos = strpos($dir,$dirLimit);
        if ((string)$cdPos == "") {
            $dir = $dirLimit;
            $GLOBALS["dirError"] = "You are not allowed change to directories above $dirLimit\n";
        }
    }
    return $dir;
}
?>
