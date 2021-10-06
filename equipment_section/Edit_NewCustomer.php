<?php  
include("common.php");
CreateConnection();
//EDITING ----qry to retreive data for the customer which need to be edited(tHIS WILL DISPLAY DATA WHEN THE FORM IS LOADED FOR EDITING).......
//retreiving session value which holds the id of the customer thats need to be edited..
session_start();
$cust_id=$_SESSION['CUSTOMER_ID'];

$qry="SELECT * FROM customer_setup WHERE cust_id='$cust_id'";
$qryexecute=mysqli_query($db, $qry);
$rs=mysql_fetch_row($qryexecute);
//$cust_id=$rs[0];
$cust_name=$rs[1];
$cust_contact=$rs[2];
$cust_add1=$rs[3];
$cust_add2=$rs[4];
$cust_city=$rs[5];
$cust_state=$rs[6];
$cust_postal_code=$rs[7];
$cust_country=$rs[8];
$cust_phone=$rs[9];
$cust_mobile=$rs[10];
$cust_fax=$rs[11];
$cust_Email=$rs[12];
$cust_comment=$rs[13];
//----THIS VALUE IS USED TO Check wheather the form is submitted or not
$hid=$_POST['hidFiled'];
//UPDATE the data after editing is complete
if($hid==1)
{
//...receives Posted value and assigned to the variable...
//$cust_id=$_POST['txt_id'];
$cust_name=$_POST['txt_name'];
$cust_contact=$_POST['txt_contact'];
$cust_add1=$_POST['txt_add1'];
$cust_add2=$_POST['txt_add2'];
$cust_city=$_POST['txt_city'];
$cust_state=$_POST['txt_state'];
$cust_postal_code=$_POST['txt_postal_code'];
$cust_country=$_POST['txt_country'];
$cust_phone=$_POST['txt_phone'];
$cust_mobile=$_POST['txt_mobile'];
$cust_fax=$_POST['txt_fax'];
$cust_Email=$_POST['txt_Email'];
$cust_comment=$_POST['txt_comment'];

/*echo"$cust_id<br>";
echo"$cust_name<br>";
echo"$cust_contact<br>";
echo"$cust_add1<br>";
echo"$cust_add2<br>";
echo"$cust_city<br>";
echo"$cust_state<br>";
echo"$cust_postal_code<br>";
echo"$cust_country<br>";
echo"$cust_phone<br>";
echo"$cust_mobile<br>";
echo"$cust_fax<br>";
echo"$cust_Email<br>";
echo"$cust_comment<br>";
*/
//inserting data...




$qry1="UPDATE customer_setup SET cust_name='$cust_name',cust_contact='$cust_contact',cust_add1='$cust_add1',cust_add2='$cust_add2',cust_city='$cust_city',cust_state='$cust_state',cust_postal_code='$cust_postal_code',cust_country='$cust_country',cust_phone='$cust_phone',cust_mobile='$cust_mobile',cust_fax='$cust_fax',cust_Email='$cust_Email',cust_comment='$cust_comment' WHERE cust_id='$cust_id'";
$qryexecute1=mysqli_query($db, $qry1);
//check wheather the query is successfully successeded or not
if($qryexecute1)
{
header("Location: BrowseCustomer.php");
}
else
{
header("Location: Edit_NewCustomer.php");
}
}
?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Edit Customer - Customer ID #<?php echo $cust_id; ?></title>
<script language="javascript">
//-----Validates Form Inputs
function validate(frm)
{
if(frm.txt_name.value=="")
{
alert("Please Enter Customer's Name.");
frm.txt_name.focus();
return false;
}
else if(frm.txt_add1.value=="")
{
alert("Please Enter Customer's Address.");
frm.txt_add1.focus();
return false;
}
else if(frm.txt_country.value=="")
{
alert("Please Enter Customer's Country.");
frm.txt_country.focus();
return false;
}
else if(isNaN(frm.txt_name.value)==false)
{
alert("Invalid Name.Please Enter Character Data.");
document.frm.txt_name.focus();
return false;
}
else if(isNaN(frm.txt_city.value)==false)
{
alert("Invalid City Name.Please Enter Character Data.");
document.frm.txt_city.focus();
return false;
}
else if(isNaN(frm.txt_state.value)==false)
{
alert("Invalid State/Prov./District Name.Please Enter Character Data.");
document.from1.txt_state.focus();
return false;
}
else if(isNaN(frm.txt_postal_code.value))
{
alert("Invalid Postal Code.Please Enter Numeric Data.");
document.from1.txt_postal_code.focus();
return false;
}
else if(isNaN(frm.txt_country.value)==false)
{
alert("Invalid Country Name.Please Enter Character Data.");
document.from1.txt_country.focus();
return false;
}
return true;
}

//validates form inputs before submitting it//
function doFinish(frm)
{
if(validate(frm)==true)
{
document.form1.hidFiled.value=1;
frm.submit();
}

}
//Validates customer name
function goCheck(m)
{
if(isNaN(m)==false)
{
alert("Invalid Name.Please Enter Character Data.");
document.from1.txt_name.focus();
}
}

//Validates customer City
function goChk1(m)
{
if(isNaN(m)==false)
{
alert("Invalid City Name.Please Enter Character Data.");
document.from1.txt_city.focus();
}
}

//Validates customer State/Prov./District
function goChk2(m)
{
if(isNaN(m)==false)
{
alert("Invalid State/Prov./District Name.Please Enter Character Data.");
document.from1.txt_state.focus();
}
}

//Validates customer Postal code
function goChk3(m)
{
if(isNaN(m))
{
alert("Invalid Postal Code.Please Enter Numeric Data.");
document.from1.txt_postal_code.focus();
}
}

//Validates customer Country
function goChk4(m)
{
if(isNaN(m)==false)
{
alert("Invalid Country Name.Please Enter Character Data.");
document.from1.txt_country.focus();
}
}

//Validates Comments
/*function goChk5(m)
{
if(isNaN(m)==false)
{
alert("Invalid Country Name.Please Enter Character Data.");
document.from1.txt_comment.focus();
}
}*/
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <input name="hidFiled" type="hidden" id="hidFiled" />
  <table width="641" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#333333" bgcolor="#999999">
    <tr>
      <td>Customer ID: </td>
      <td><input name="txt_id" type="text" id="txt_id" value="<?php echo $cust_id; ?>" READONLY/></td>
    </tr>
    <tr>
      <td width="160">Name:</td>
      <td width="481"><label>
        <input name="txt_name" type="text" id="txt_name" onchange="goCheck(this.value)" value="<?php echo $cust_name; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>Contact:</td>
      <td><label>
      <input name="txt_contact" type="text" id="txt_contact" value="<?php echo $cust_contact; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>Address #1: </td>
      <td><label>
      <input name="txt_add1" type="text" id="txt_add1" value="<?php echo $cust_add1; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>Address #2: </td>
      <td><label>
      <input name="txt_add2" type="text" id="txt_add2" value="<?php echo $cust_add2; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>City:</td>
      <td><label>
      <input name="txt_city" type="text" id="txt_city" onchange="goChk1(this.value)" value="<?php echo $cust_city; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>State/Prov./District:</td>
      <td><label>
      <input name="txt_state" type="text" id="txt_state" onchange="goChk2(this.value)" value="<?php echo $cust_state; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>Postal Code: </td>
      <td><label>
      <input name="txt_postal_code" type="text" id="txt_postal_code" onchange="goChk3(this.value)" value="<?php echo $cust_postal_code; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>Country:</td>
      <td><label>
      <input name="txt_country" type="text" id="txt_country" onchange="goChk4(this.value)" value="<?php echo $cust_country; ?>"/>
      </label></td>
    </tr>
    <tr>
      <td>Phone : </td>
      <td><label>
      <input name="txt_phone" type="text" id="txt_phone" value="<?php echo $cust_phone; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>Mobile:</td>
      <td><label>
      <input name="txt_mobile" type="text" id="txt_mobile" value="<?php echo $cust_mobile; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>Fax:</td>
      <td><label>
      <input name="txt_fax" type="text" id="txt_fax" value="<?php echo $cust_fax; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>E-mail:</td>
      <td><label>
      <input name="txt_Email" type="text" id="txt_Email" value="<?php echo $cust_Email; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>Comments:</td>
      <td><label>
      <textarea name="txt_comment" cols="40" rows="5" id="txt_comment" onchange="goChk5(this.value)"><?php echo $cust_comment; ?></textarea>
      </label></td>
    </tr>
  </table>
<br />  
<table width="641" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#999999">
    <tr>
      <td width="164">&nbsp;</td>
      <td width="115"><label>
        <input name="Bsave" type="button" id="Bsave" value="     Update     "  onclick="doFinish(form1)"//>
      </label></td>
      <td width="95">&nbsp;</td>
      <td width="267"><input name="Bclose" type="button" id="Bclose" value="    Close    " onclick="javascript:location.href='BrowseCustomer.php'"></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>
