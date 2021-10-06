<? 
if($updateNewUser)
{
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
  $sqlUp= "UPDATE `user` SET `uname`='$userName', `password`='$password', `fullName`='$userFullName', `designation`='$userDesignation', `projectCode`='$projectCode',`permission`='$permission', `datet`='$todat' WHERE `id` = '$uidup'";
        echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>your record updated </font></p>";

//echo $sqlUp;
$sqlQurup=mysqli_query($db, $sqlUp);
}

if($d){
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
  $sqlUp= "DELETE  FROM  `user`  WHERE `id` = '$uid'";
        echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>record deleted </font></p>";
//echo $sqlUp;
$sqlQurup=mysqli_query($db, $sqlUp);
}

?>

<? 
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
$sql="SELECT * From user ORDER by projectcode ASC";
//echo $sql;
$sqlQur=mysqli_query($db, $sql);

?>
<table align="center" border="1" bordercolor="#000000" cellpadding="5" cellspacing="0" style="border-collapse:collapse">
 <TR>
   <Th colspan="5">all user list</Th>
   </TR>
 <TR bgcolor="#CC9933">
   <Td>Name</Td>
   <Td>password</Td>   
   <Td>Full Name</Td>      
   <Td>Designation</Td>      
   <Td>Project Code</Td>      
   
   </TR>
   
<? while($user=mysqli_fetch_array($sqlQur)){?>   
 <TR>
   <Td><a href="./index.php?keyword=edit+user&uid=<? echo $user[id];?>&u=1" ><? echo $user[uname];?></a></Td>
   <Td><? echo $user[password];?></Td>   
   <Td><? echo $user[fullName];?></Td>   
   <Td><? echo $user[designation];?></Td>   
   <Td><? echo $user[projectCode];?>
   <a href="./index.php?keyword=edit+user&uid=<? echo $user[id];?>&d=1"> [ DELETE ] </a>
   </Td>   
   </TR>
<? }?>
</table>

<? 
if($uid && $u){
include("./config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
$sql1="SELECT * From user WHERE id='$uid'";
//echo $sql1;
$sqlQur1=mysqli_query($db, $sql1);
$sqlresult=mysqli_fetch_array($sqlQur1);

?>

<form name="cerateUser" action="./index.php?keyword=edit+user" method="post">
<table align="center" width="50%" border="1" bordercolor="#E4E4E4" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="2" align="center" bgcolor="#EEEEEE"><b> Edit User</b></td>
</tr>	
<tr>
    <td > User Full Name</td> <td><input name="userFullName" type="text" size="50" maxlength="100"  value="<? echo $sqlresult[fullName];?>" ></td>
</tr>	
<tr>
    <td > User Designation</td> 
	<? $de= $sqlresult[designation];?>
	<td><select name="userDesignation">
		<?php
		 $sql="select designation from user group by designation";
		 $q=mysqli_query($db,$sql);
		 while($row=mysqli_fetch_array($q)){
			 echo "<option>$row[designation]</option>";
		 }
		 ?>
<!-- 			<option <? if($de=='Project Manager') echo 'SELECTED';?>>Project Manager</option>
			<option <? if($de=='Project Engineer') echo 'SELECTED';?>>Project Engineer</option>
			<option <? if($de=='Construction Manager') echo 'SELECTED';?>>Construction Manager</option>
			<option <? if($de=='Project Accountant') echo 'SELECTED';?>>Project Accountant</option>										
			<option <? if($de=='Store Manager') echo 'SELECTED';?>>Store Manager</option>										
			<option <? if($de=='Manager Planning & Control') echo 'SELECTED';?>>Manager Planning & Control</option>										
			<option <? if($de=='Site Engineer') echo 'SELECTED';?>>Site Engineer</option>
			<option <? if($de=='Site Cashier') echo 'SELECTED';?>>Site Cashier</option>
			<option <? if($de=='Store Officer') echo 'SELECTED';?>>Store Officer</option>
			<option <? if($de=='Site Equipment Co-ordinator') echo 'SELECTED';?>>Site Equipment Co-ordinator</option>																							
			<option <? if($de=='Accounts Executive (HO)') echo 'SELECTED';?>>Accounts Executive (HO)</option>
			<option <? if($de=='Accounts Manager') echo 'SELECTED';?>>Accounts Manager</option>
			<option <? if($de=='Procurement Manager') echo 'SELECTED';?>>Procurement Manager</option>										
			<option <? if($de=='Procurement Executive') echo 'SELECTED';?>>Procurement Executive</option>										
			<option <? if($de=='Managing Director') echo 'SELECTED';?>>Managing Director</option>
			<option <? if($de=='Human Resource Manager') echo 'SELECTED';?>>Human Resource Manager</option>-->
	</select>
								</td>
</tr>	
<tr>
    <td > Project Code</td>   <td>
	<? $po= $sqlresult[projectCode];?>	
	<select name="projectCode">
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
$sqlp = "SELECT pname, pcode from `project`";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 if($po==$typel[pcode]) echo " SELECTED";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?>
	</select></td>

</tr>	

<tr>
    <td > User Name</td> <td><input name="userName" type="text" maxlength="20" value="<? echo $sqlresult[uname];?>"></td>
</tr>	
<tr>
    <td > Password</td> <td><input name="password" type="password" maxlength="20" value="<? echo $sqlresult[password];?>"></td>
</tr>	
<tr>
    <td > Permission</td> <td><input type="radio" name="permission" value="1"> Edit    <input type="radio" name="permission" value="0">View Only 
      </td>
</tr>	
<tr>
<td colspan="2" align="center"><input type="submit" name="updateNewUser" value="Update New User">
   <input type="hidden" name="uidup" value="<? echo $uid;?>">
</td>
</tr>	

</table>
</form>	
<? }?>