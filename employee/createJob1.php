<? 
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	

function hrDesignation($p)
{
$sqlff="SELECT itemDes FROM itemlist where itemCode='$p'";
//echo $sqlff;
$sqlf=mysqli_query($db, $sqlff);
     $pn=mysqli_fetch_array($sqlf);
	 $hrDesignation=$pn[itemDes];	 
	 return $hrDesignation;
}


if($_POST['save']=="Save")
{
	
	$n=$_POST['n'];
	for($i=1;$i<=$n;$i++)
	 {
		
		$summary=$_POST['summary'.$i];
		$id=$_POST['id'.$i];
		$dduties=$_POST['dduties'.$i];
		$pduties=$_POST['pduties'.$i];
		$education=$_POST['education'.$i];
		$experience=$_POST['experience'.$i];
		$training=$_POST['training'.$i];
		$skill=$_POST['skill'.$i];
		$ability=$_POST['ability'.$i];
		$administrative=$_POST['administrative'.$i];
		$financial=$_POST['financial'.$i];
		$performance=$_POST['performance'.$i];
		$conditions=$_POST['conditions'.$i];
		
	 	if($_POST['w']==1)
	    {	
		
    	 $q="update jobdetails set summary='$summary' where id='$id'";
		 $r=mysqli_query($db, $q);
	    }
	   if($_POST['w']==2)
	   {	
    	$q="update jobdetails set dduties='$dduties' where id='$id'";
		$r=mysqli_query($db, $q);
	    }
	   if($_POST['w']==3)
	   {	
    	 $q="update jobdetails set pduties='$pduties' where id='$id'";
		$r=mysqli_query($db, $q);
	   }
	   if($_POST['w']==4)
	   {	
    	$q="update jobdetails set education='$education' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==5)
	   {	
    	 $q="update jobdetails set experience='$experience' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==6)
	   {	
    	 $q="update jobdetails set training='$training' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==7)
	   {	
    	 $q="update jobdetails set skill='$skill' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==8)
	   {	
    	 $q="update jobdetails set ability='$ability' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==9)
	   {	
    	 $q="update jobdetails set administrative='$administrative' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==10)
	   {	
    	 $q="update jobdetails set financial='$financial' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==11)
	   {	
    	 $q="update jobdetails set performance='$performance' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	   if($_POST['w']==12)
	   {	
    	 $q="update jobdetails set conditions='$conditions' where id='$id'";
		$r=mysqli_query($db, $q);
	   }

	}
	//echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=create+job&e=1\">";
}	
	
?>
<form name="job" action="" method="post">
  <table width="850" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><input name="w" type="radio" value="1"   <? if($_GET['w']==1) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=1'" />
      Job Summary </td>
      <td><input name="w" type="radio" value="2" <? if($_GET['w']==2) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=2'"  />
        Job Task </td>
      <td><input name="w" type="radio" value="3" <? if($_GET['w']==3) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=3'"  />
        Job Activities </td>
      <td><input name="w" type="radio" value="4" <? if($_GET['w']==4) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=4'"  />
       Education</td>
	   <td><input name="w" type="radio" value="5" <? if($_GET['w']==5) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=5'"  />
        Experience </td>
      <td><input name="w" type="radio" value="6" <? if($_GET['w']==6) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=6'"  />
        Knowledge </td></tr>
	
	<tr>
      <td><input name="w" type="radio" value="7" <? if($_GET['w']==7) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=7'"  />
       Skills </td>
      <td><input name="w" type="radio" value="8" <? if($_GET['w']==8) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=8'"  />
        Ability </td>
	<td><input name="w" type="radio" value="9" <? if($_GET['w']==9) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=9'"  />
        Administrative </td>
      <td><input name="w" type="radio" value="10" <? if($_GET['w']==10) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=10'"  />
        Financial </td>
      <td><input name="w" type="radio" value="11" <? if($_GET['w']==11) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=11'"  />
        Standard of Performance </td>
      <td><input name="w" type="radio" value="12" <? if($_GET['w']==12) echo "checked";?> onClick="location.href='../employee/createJob1.php?w=12'"  />
        Working condition </td>
    </tr>
</table>
  <br />
 <? if($_GET['w']==1 || $_GET['w']==2 || $_GET['w']==3 || $_GET['w']==4 || $_GET['w']==5 || $_GET['w']==6 || $_GET['w']==7 || $_GET['w']==8 || $_GET['w']==9 || $_GET['w']==10 || $_GET['w']==11 || $_GET['w']==12){?>

 <table width="850" border="1" cellspacing="0" cellpadding="0" align="center"  bordercolor="#CC9999" >
    <tr bgcolor="#CC9999">
      <? if($_GET['w']==1) { ?>
      <td valign="top" align="center">Job Summary </td>
      <? } ?>
      <? if($_GET['w']==2) { ?>
      <td valign="top" align="center">Job Task </td>
      <? } ?>
      <? if($_GET['w']==3) { ?>
      <td valign="top" align="center">Job Activities </td>
      <? } ?>
      <? if($_GET['w']==4) { ?>
      <td valign="top" align="center">Education</td>
      <? } ?>
	  <? if($_GET['w']==5) { ?>
      <td valign="top" align="center">Experience</td>
      <? } ?>
      <? if($_GET['w']==6) { ?>
      <td valign="top" align="center">Knowledge</td>
      <? } ?>
      <? if($_GET['w']==7) { ?>
      <td valign="top" align="center">Skills</td>
      <? } ?>
      <? if($_GET['w']==8) { ?>
      <td valign="top" align="center">Ability</td>
      <? } ?>
      <? if($_GET['w']==9) { ?>
      <td valign="top" align="center">Administrative</td>
      <? } ?>
      <? if($_GET['w']==10) { ?>
      <td valign="top" align="center">Financial</td>
      <? } ?>
      <? if($_GET['w']==11) { ?>
      <td valign="top" align="center">Standard of Performance</td>
      <? } ?>
      <? if($_GET['w']==12) { ?>
      <td valign="top" align="center">Working condition</td>
      <? } ?>
   </tr>
   <? include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
      $sqlp = "SELECT * from `itemlist` WHERE itemCode BETWEEN '71-00-000' AND '96-99-999'";
//echo $sqlp;
$sqlrunp=mysqli_query($db, $sqlp);
$i=1;
while($app=mysqli_fetch_array($sqlrunp))
{
	$itemCode=$app['itemCode'];
$sqlp1 = "SELECT * from `jobdetails` where itemCode='$itemCode' order by itemCode";

$sqlrunp1= mysqli_query($db, $sqlp1);
$num1=mysql_num_rows($sqlrunp1);
while($app1= mysqli_fetch_array($sqlrunp1))
{
$id=$app1['id'];

?>
    <tr>
	<input name="id<? echo $i?>" type="hidden" value=" <? echo $id; ?>" />
      <? if($_GET['w']==1) { ?>
	  
      <td style="padding-left:3px;padding-right:3px;">
	  <? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", "; echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea cols="150" rows="7" name="summary<? echo $i;?>"><? echo $app1[summary];?></textarea></td>
      <?
	   } ?>
      <? if($_GET['w']==2) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", ";  echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea  cols="150" rows="7" name="dduties<? echo $i;?>"><? echo $app1[dduties];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==3) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", "; echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea  cols="150" rows="7" name="pduties<? echo $i;?>"><? echo $app1[pduties];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==4) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", ";  echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea  cols="150" rows="3" name="education<? echo $i;?>"><? echo $app1[education];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==5) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", ";  echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea  cols="150" rows="7" name="experience<? echo $i;?>"><? echo $app1[experience];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==6) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", "; echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea  cols="150" rows="7" name="training<? echo $i;?>"><? echo $app1[training];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==7) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", ";  echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea  cols="150" rows="7" name="skill<? echo $i;?>"><? echo $app1[skill];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==8) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", ";  echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea  cols="150" rows="7" name="ability<? echo $i;?>"><? echo $app1[ability];?></textarea></td>
      <? } ?>
	  <? if($_GET['w']==9) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", ";  echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea cols="150" rows="3" name="administrative<? echo $i;?>"><? echo $app1[administrative];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==10) { ?>
      <td style="padding-left:3px;padding-right:3px;"><?  echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", "; echo hrDesignation($app[itemCode]); echo "<br>";?>
          <textarea cols="150" rows="3" name="financial<? echo $i;?>"><? echo $app1[financial];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==11) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", ";  echo hrDesignation($app[itemCode]); echo "<br>";?>
         <textarea  cols="150" rows="7" name="performance<? echo $i;?>"><? echo $app1[performance];?></textarea></td>
      <? } ?>
      <? if($_GET['w']==12) { ?>
      <td style="padding-left:3px;padding-right:3px;"><? echo "<font color='#FF0000'>"; echo $app[itemCode]; echo "</font>"; echo ", "; echo hrDesignation($app[itemCode]); echo "<br>";?>
         <textarea  cols="150" rows="3" name="conditions<? echo $i;?>"><? echo $app1[conditions];?></textarea></td>
      <? } ?>
    </tr>
    <? $i++;} }  ?>
    <tr>
      <td colspan="12" align="center"><input type="Submit" value="Save" name="save"  /></td>
    </tr>
  </table>
  <?  } ?>
<input type="hidden" name="n" value="<? echo $i;?>">
</form>
<!--<a target="_blank" href="./print/print_createJob.php?designation=<? echo $itemCode;?>">Print</a> By Salma-->