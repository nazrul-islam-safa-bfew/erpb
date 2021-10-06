<?
if($saveMessage)
{
$t_req=$REMOTE_ADDR;
$todatTime = date("Y-m-d H:i:s");

include("./config.inc.php");
$db =mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
$sql="INSERT INTO message (id,prID, name,msg,sdate) VALUES ('','$prId', '$loginFullName', '$message','$todatTime')";
//echo $sql;
mysqli_query($db, $sql);

echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php\">";
echo "Please Wait... Your Message has been saved..";
}
?>


<?
if(!$saveMessage)
{?>

<form name="msg" action="./index.php?keyword=message" method="post">
<table align="center" width="400" bgcolor="#EfEfEf" border="1" cellpadding="0" cellspacing="1" style="border-collapse:collapse">
  <tr>
    <td bgcolor="#DDDDDD" align="center"><b>Messaging System</b> </td>
  </tr>
  <tr>
    <td>Put Your Message [not more then 20 words]</td>
  </tr>
  <tr>
    <td><textarea cols="60" rows="5" name="message"></textarea> </td>
  </tr>
  <tr><td align="center"><input type="submit" name="saveMessage" value="SaveMessage">
  <input type="hidden" name="prId" value="<? echo $prId;?>"></td></tr>
</table>
</form>
<? }?>