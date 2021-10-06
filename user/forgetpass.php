<form method="POST" action="../index.php?keyword=Forget Password">
  <div align="center">
    <center>
      <? 
    if($forget)
    {
    echo "<br><br><br>PASSWORD Retrival for <b><font color=#FF0000>".$usern."</b></font><br>";
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
$sql = "select password FROM `user` where `uname` = '$usern' and `emailp`='$sqa'";  
//echo $sql ;
$sqlrun= mysqli_query($db, $sql);
$uval= mysqli_fetch_array($sqlrun);
if(mysql_num_rows($sqlrun)==1)
{
echo " <font size=2>Your Password will Send to your e-mail address </font><br>";

/* mail to */
$email = $uval[emailp];

/* subject */
$subject = "$uval[uname], Welcome to Boshoti.com ";

/* message */
$message = "
<p><font face=Verdana size=1>Welcome $uname .<br>
<br>
<b>LOGIN:<br>
</b><br>
Please go to <a href=http://www.boshoti.com>www.boshoti.com</a>
<br>
1. Type your username as <b>$uname</b> and password as <b>$password</b> that you provided while signup.<br>
2. Choose your login type.<br>
3. Edit your profile.<br>
<br>
Feel free to advise us at <a href=www.boshoti.com>
www.boshoti.com</a> <br>
<br>
Thanks<br>
Mohammad Abu Taleb<br>
<a href=mailto:simul14@yahoo.com>simul14@yahoo.com</a><br>
<a href=http://www.boshoti.com>www.boshoti.com</a><br>
7412224<br>
<br>
";

/* To send HTML mail, you can set the Content-type header. */
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

/* additional headers */
$headers .= "From: Boshoti<webmaster@boshoti.com>\r\n";

$headers .= "Cc: $sqa@boshoti.com\r\n";
$headers .= "Cc: info@boshoti.com\r\n";

/* and now mail it */
mail($email, $subject, $message, $headers);
//End E-mail


$sh=1;
}
else
{
echo "<img src='../image/s_warn.png'>   Your username and e-mail address doesn't match.<br><br>";
}

}
if($sh!=1)
{
?>
 <br><br>
      <table border="0" cellspacing="0" style="border-collapse: collapse" bgcolor="#EEEEEE"width="450">
      <tr><td colspan="3" bgcolor="#FFFFFF">      Forgot your password? Just send us your User Id and email address, our system 
      will email your password rightaway. If you don't know your email address 
      either, please call our customer service for assistance.<br><br></td></tr>
	  <tr>
	     <td bgcolor="#7A6C5C" height="50" colspan="3" background="../image/tbl_th.png"><strong><font color="#FFFFFF">Forget Password?</font></strong></td>
	  </tr>
      <tr>
        <td width="248">
        <p style="margin-left: 5; margin-top: 5"><font color="#080808">Boshoti ID</font></td>
        <td width="198">
        <p style="margin-left: 5; margin-top: 5"><input name="usern" maxlength="20"  ></font></td>
      </tr>
      <tr>
        <td width="248">
        <p style="margin-left: 5; margin-top: 5"><font color="#080808">Contact Person e-mail address</font></td>
        <td width="198">
        <p style="margin-left: 5; margin-top: 5"><input type="text" name="sqa" ></font></td>
	  </tr>
      <tr>
        <td  colspan="2" align="center"><p style="margin-left: 5; margin-top: 10">
		<input type="submit" value="Say Me" name="forget"></font></td>
      </tr>
    </table>
    </center>
  </div>
  <input type="hidden" name="forget" value="1">
</form>
<? }?>