<?
if($createNewUser || $signupedit){
include('./config.inc.php');
include("./session.inc.php");
echo 'Username='.$userName.'PAss='.$password.'cerate='.$createNewUser;
if($userName=="" OR $password=="" AND $createNewUser)
{
	echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>Fillup the form completely UserName and Password</font> </p>";
	echo "<b><font face=Verdana size=1><a href=../index.php?keyword=new+user>Back to signup page</a></font></b><br><br>";
	//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"3; URL=../index.php?keyword=new+user\">";
	exit();
}

if($createNewUser){

$db =mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
	$as="SELECT uname FROM user ";
	$bbv = mysqli_query($db, $as);
	//echo $as;

	while($bbval = mysqli_fetch_array($bbv))
	{
		if($bbval[uname]==$userName)
			{
			echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>Please Change your user name </font></p>";
			echo "<b><font face=Verdana size=1><a href=../index.php?keyword=new+user>Back to signup page</a></font></b><br><br>";
			//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=new+user\">";
			exit();
			}

     }//while ends
}

$sid=uniqid("");

$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
	if($userName && $createNewUser){
	  $sql="INSERT INTO `user` (`id`, `uname`, `password`, `fullName`, `designation`, `projectCode`,`permission`, `datet`) VALUES ('$sid', '$userName','$password', '$userFullName', '$userDesignation','$projectCode', '$permission','$todat')";
	  echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>user added</font></p>";

		}
	$adduserdb = mysqli_query($db, $sql);

echo $sql;

}//signup ends

//echo " <meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../member/redirect.php?usern=$un&password=$password\">";
?>
<form name="cerateUser" action="./index.php?keyword=New+User" method="post">
<style>
div.rounded-box {
    position:relative;
	left:100px;
	top:10px;
    width: 40em;
    height: 22em;	
    background-color: #E8E8E8;
	z-index:2
}

div.top-left-corner, div.bottom-left-corner, div.top-right-corner, div.bottom-right-corner
{position:absolute; width:20px; height:20px; background-color:#FFF; overflow:hidden;}
div.top-left-inside, div.bottom-left-inside, div.top-right-inside, div.bottom-right-inside {position:relative; font-size:150px; font-family:arial; color:#E6E6E6; line-height: 40px;}

div.top-left-corner { top:0px; left:0px; }
div.bottom-left-corner {bottom:0px; left:0px;}
div.top-right-corner {top:0px; right:0px;}
div.bottom-right-corner {bottom: 0px; right:0px;}

div.top-left-inside {left:-8px;}
div.bottom-left-inside {left:-8px; top:-17px;}
div.top-right-inside {left:-25px;}
div.bottom-right-inside {left:-25px; top:-17px;}

div.box-contents {
	position: relative; padding: 8px; color:#000;
}

p.x1
{
position:absolute;
left:210px;
top:180px;
z-index:0
}
p.x2
{
position:absolute;
left:190px;
top:250px;
z-index:1
}

</style>
<p class="x2">
<table align="left" border="2" bordercolor="#6666FF" width="120%" height="150" bgcolor="#9999FF">
 <tr>
  <td></td>
 </tr>
</table>
</p>
<p class="x1">
<table align="center" border="2" bordercolor="#FF6666" width="30" height="500" bgcolor="#FF9999">
 <tr>
  <td></td>
 </tr>
</table>
</p>
<div class="rounded-box"> 
  <div class="top-left-corner">
    <div class="top-left-inside">&bull;</div>
  </div>
  <div class="bottom-left-corner">
    <div class="bottom-left-inside">&bull;</div>
  </div>
  <div class="top-right-corner">
    <div class="top-right-inside">&bull;</div>
  </div>
  <div class="bottom-right-corner">
    <div class="bottom-right-inside">&bull;</div>
  </div>
 <div class="box-contents">

<table align="center"  border="0"  cellpadding="5" cellspacing="0" style="border-collapse:collapse">
<tr>
    <td colspan="2" align="center" bgcolor="#E4E4E4" class="englishheadBlack"> Create New User</td>
</tr>	
<tr>
    <td width="45%" > User Full Name</td> <td width="55%"><input name="userFullName" type="text" size="50" maxlength="100" ></td>
</tr>	
<tr>
    <td > User Designation</td>
	 <td><select name="userDesignation">
		 <?php
		 $sql="select designation from user group by designation";
		 $q=mysqli_query($db,$sql);
		 while($row=mysqli_fetch_array($q)){
			 echo "<option>$row[designation]</option>";
		 }
		 ?>
<!-- 		 
			<option>Project Manager</option>
			<option>Project Accountant</option>										
			<option>Store Manager</option>	
			<option>Store Controller</option>											
			<option>Manager Planning & Control</option>
			<option>Site Engineer</option>			
			<option>Site Cashier</option>																				
			<option>Store Officer</option>
			<option>Task Supervisor</option>			
			<option>Site Equipment Co-ordinator</option>											
			<option>Accounts Executive (HO)</option>
			<option>Accounts Manager</option>
			<option>MIS Manager</option>
			<option>Purchase Manager</option>										
			<option>Price Management Executive</option>										
			<option>Managing Director</option>
			<option>Director</option>
			<option>Human Resource Executive</option>																				
             <option>Human Resource Manager</option>
			 <option>Finance Executive</option>		
			 <option>Quotation Maintenance Officer </option>																						 -->
		</select>
	</td>
</tr>	
<tr>
    <td > Project Code</td>   <td><select name="projectCode">
<?
include("config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS ,$SESS_DBNAME);
$sqlp = "SELECT pname, pcode from `project`";
//echo $sqlp;
$sqlrunp= mysqli_query($db, $sqlp);

 while($typel= mysqli_fetch_array($sqlrunp))
{
 echo "<option value='".$typel[pcode]."'";
 echo ">$typel[pcode]--$typel[pname]</option>  ";
 }
?>
	</select></td>

</tr>	

<tr>
    <td > User Name</td> <td><input name="userName" type="text" maxlength="20"></td>
</tr>	
<tr>
    <td > Password</td> <td><input name="password" type="password" maxlength="20"></td>
</tr>	
<tr>
    <td > Permission</td> <td><input type="radio" name="permission" value="1"> Edit    <input type="radio" name="permission" value="0">View Only 
      </td>
</tr>	
<tr>
<td colspan="2" align="center"><input type="submit" name="createNewUser" value="Create New User"></td>
</tr>	
</table>


</div>
</div>
</form>	