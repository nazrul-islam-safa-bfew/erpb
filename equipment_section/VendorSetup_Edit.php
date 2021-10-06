<?php
include("common.php");
CreateConnection();
//this code will be executed when the form is loaded for the first time...
//assign posted vendor id(posted by header) to the variable..
$vendor_id=$_GET['vend_id'];
//creating session for the vendor id which needs to be edited..
session_start();
$_SESSION['vend_id']=$vendor_id;
//select vendor specific information from the vendor_setup table......
$qry="SELECT * FROM vendor_setup WHERE vendor_id='$vendor_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
	//$vendor_id=$rs[0];
	$vendor_name=$rs[1];
	$vendor_contact=$rs[2];
	$vendor_address=$rs[3];
	$vendor_city=$rs[4];
	$vendor_state=$rs[5];
	$vendor_postal_code=$rs[6];
	$vendor_country=$rs[7];
	$vendor_phone=$rs[8];
	$vendor_mobile=$rs[9];
	$vendor_fax=$rs[10];
	$vendor_email=$rs[11];
	$vendor_comment=$rs[12];

//this value is used to track wheather update or delete is happend...
$hid=$_POST['hidField'];
//echo"$hid";
//update
if($hid==1)
{
//retreiving session value which contains vendor id...
session_start();
$vendor_id=$_SESSION['vend_id'];

//assigning posted value...
$txtname=$_POST['txtname'];
$txtcontact=$_POST['txtcontact'];
$txtaddress=$_POST['txtaddress'];
$txtcity=$_POST['txtcity'];
$txtstate=$_POST['txtstate'];
$txtpostal=$_POST['txtpostal'];
$txtcountry=$_POST['txtcountry'];
$txtphone=$_POST['txtphone'];
$txtmobile=$_POST['txtmobile'];
$txtfax=$_POST['txtfax'];
$txtemail=$_POST['txtemail'];
$txtcomment=$_POST['txtcomment'];

//query to update data...
$qry1="UPDATE vendor_setup SET vendor_name='$txtname',vendor_contact='$txtcontact',vendor_address='$txtaddress',vendor_city='$txtcity',vendor_state='$txtstate',vendor_postal_code='$txtpostal',vendor_country='$txtcountry',vendor_phone='$txtphone',vendor_mobile='$txtmobile',vendor_fax='$txtfax',vendor_email='$txtemail',vendor_comment='$txtcomment' WHERE vendor_id='$vendor_id'";

$qryexexute1=mysqli_query($db, $qry1);
//checking wheather the query is succeffuly executed
if($qryexexute1)
{
header("Location: BrowseVendor.php?vnd_id=$vendor_id");
}
else
{
echo("Couldn't Connect To The Database.");
}
}
//DELETE...
else if($hid==2)
{
//retreiving session value which contains vendor id...
session_start();
$vendor_id=$_SESSION['vend_id'];
$qry2="DELETE FROM vendor_setup WHERE vendor_id='$vendor_id'";
$qryexexute2=mysqli_query($db, $qry2);
if($qryexexute2)
{
header("Location: BrowseVendor.php?vnd_id=$vendor_id");
}
else
{
echo("Couldn't Connect To The Database.");
}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vendor Setup Entry Form...</title>
<link href="common.css" rel="stylesheet" type="text/css" />
</head>


<script language="javascript">

function validate(frmvendor)
{
if(frmvendor.txtname.value=="")
{
alert("Please Enter Vendor's Name.");
frmvendor.txtname.focus();
return false;
}
else if(isNaN(frmvendor.txtname.value)==false)
{
alert("Invalid Vendor's Name.Please Enter Character Data.");
frmvendor.txtname.focus();
return false;
}
else if(frmvendor.txtaddress.value=="")
{
alert("Please Enter Vendor's Address.");
frmvendor.txtaddress.focus();
return false;
}
else if(isNaN(frmvendor.txtaddress.value)==false)
{
alert("Invalid Data Format For Vendor's Address.Please Enter Character Data.");
frmvendor.txtaddress.focus();
return false;
}
else if(frmvendor.txtcity.value=="")
{
alert("Please Enter Vendor's City Name.");
frmvendor.txtcity.focus();
return false;
}
else if(isNaN(frmvendor.txtcity.value)==false)
{
alert("Invalid Data Format For Vendor's City Name.Please Enter Character Data.");
frmvendor.txtcity.focus();
return false;
}

/*else if(frmvendor.txtstate.value=="")
{
alert("Please Enter Vendor's State Name.");
frmvendor.txtstate.focus();
return false;
}

else if(isNaN(frmvendor.txtstate.value)==false)
{
alert("Invalid Data Format For Vendor's State Name.Please Enter Character Data.");
frmvendor.txtstate.focus();
return false;
}*/
else if(frmvendor.txtpostal.value=="")
{
alert("Please Enter Vendor's Postal code.");
frmvendor.txtpostal.focus();
return false;
}
else if(isNaN(frmvendor.txtpostal.value))
{
alert("Invalid Data Format For Postal code.Please Enter Number.");
frmvendor.txtpostal.focus();
return false;
}

else if(frmvendor.txtcountry.value=="")
{
alert("Please Enter Vendor's Country Name.");
frmvendor.txtcountry.focus();
return false;
}
else if(isNaN(frmvendor.txtcountry.value)==false)
{
alert("Invalid Data Format For Vendor's Country Name.Please Enter Character Data.");
frmvendor.txtcountry.focus();
return false;
}
else if(isNaN(frmvendor.txtemail.value)==false)
{
alert("Invalid Data Format For Vendor's E-mail Address.Please Enter Character Data.");
frmvendor.txtemail.focus();
return false;
}
/*else if(isNaN(frmvendor.txtcomment.value)==false)
{
alert("Invalid Data Format For Comment.Please Enter Character Data.");
frmvendor.txtcomment.focus();
return false;
}*/
return true;
}


//submitting form after the validation is done..
function doFinish(frmvendor)
{
if(validate(frmvendor)==true)
{
document.frmvendor.hidField.value=1;
document.frmvendor.submit();
}
}

function goDelete()
{
if(confirm("Do You Want To Delete The Record?")==true)
{
document.frmvendor.hidField.value=2;
document.frmvendor.submit();
}
}

</script>



<body>
<form id="frmvendor" name="frmvendor" method="post" action="">	
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td colspan="4" bgcolor="#33CC33">Add New Vendor </td>
    </tr>
    <tr>
      <td>Name:</td>
      <td><label>
        <input name="txtname" type="text" id="txtname" value="<?php echo $vendor_name;  ?>" />
      </label></td>
      <td> :Country:</td>
      <td><input name="txtcountry" type="text" id="txtcountry" value="<?php echo $vendor_country;  ?>" /></td>
    </tr>
    <tr>
      <td>Contact:</td>
      <td><input name="txtcontact" type="text" id="txtcontact" value="<?php echo $vendor_contact;  ?>" /></td>
      <td>Phone:</td>
      <td><input name="txtphone" type="text" id="txtphone" value="<?php echo $vendor_phone;  ?>" /></td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><input name="txtaddress" type="text" id="txtaddress" value="<?php echo $vendor_address;  ?>" /></td>
      <td>Mobile:</td>
      <td><input name="txtmobile" type="text" id="txtmobile" value="<?php echo $vendor_mobile;  ?>" /></td>
    </tr>
    <tr>
      <td>City:</td>
      <td><input name="txtcity" type="text" id="txtcity" value="<?php echo $vendor_city;  ?>" /></td>
      <td>Fax:</td>
      <td><a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)"></a>
      <input name="txtfax" type="text" id="txtfax" value="<?php echo $vendor_fax;  ?>" /></td>
    </tr>
    <tr>
      <td>State/Prov:</td>
      <td><input name="txtstate" type="text" id="txtstate" value="<?php echo $vendor_state;  ?>" /></td>
      <td>E-mail:</td>
      <td><input name="txtemail" type="text" id="txtemail" value="<?php echo $vendor_email;  ?>" /></td>
    </tr>
    <tr>
      <td>Postal Code:</td>
      <td><input name="txtpostal" type="text" id="txtpostal" value="<?php echo $vendor_postal_code;  ?>" /></td>
      <td>Comments:</td>
      <td>
        <textarea name="txtcomment" id="txtcomment"><?php echo $vendor_comment;  ?>
        </textarea>
      </td>
    </tr>
  </table>
  <input name="hidField" type="hidden" id="hidField" />
  <br />
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="117"><label>
        <input name="Bupdate" type="button" id="Bupdate" accesskey="S"  onclick="doFinish(frmvendor)" value="   Update   "/>
      </label></td>
      <td width="122">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
        <label>
        <input name="Bdelete" type="button" id="Bdelete" value="   Delete   " onclick="goDelete()"/>
      </label></td>
      <td width="281"><center>
        <input type="reset" name="Reset" value="Clear Form" accesskey="C" />
      </center></td>
      <td width="80"><input name="Bclose" type="button" id="Bclose" accesskey="C" value="   Close   " onclick="javascript:location.href='BrowseVendor.php'"/></td>
    </tr>
  </table>
  </form>
</body>
</html>
