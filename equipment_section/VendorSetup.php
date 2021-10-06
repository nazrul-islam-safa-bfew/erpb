
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
*/
else if(isNaN(frmvendor.txtstate.value)==false)
{
alert("Invalid Data Format For Vendor's State Name.Please Enter Character Data.");
frmvendor.txtstate.focus();
return false;
}
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
else if(isNaN(frmvendor.txtcomment.value)==false)
{
alert("Invalid Data Format For Comment.Please Enter Character Data.");
frmvendor.txtcomment.focus();
return false;
}
return true;
}



function doFinish(frmvendor)
{
if(validate(frmvendor)==true)
{
frmvendor.submit();
}

}


</script>



<body>
<form id="frmvendor" name="frmvendor" method="post" action="VendorMedium.php">	
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
      <td colspan="4" bgcolor="#33CC33">Add New Vendor </td>
    </tr>
    <tr>
      <td>Name:</td>
      <td><label>
        <input name="txtname" type="text" id="txtname" />
      </label></td>
      <td> :Country:</td>
      <td><input name="txtcountry" type="text" id="txtcountry" /></td>
    </tr>
    <tr>
      <td>Contact:</td>
      <td><input name="txtcontact" type="text" id="txtcontact" /></td>
      <td>Phone:</td>
      <td><input name="txtphone" type="text" id="txtphone" /></td>
    </tr>
    <tr>
      <td>Address:</td>
      <td><input name="txtaddress" type="text" id="txtaddress" /></td>
      <td>Mobile:</td>
      <td><input name="txtmobile" type="text" id="txtmobile" /></td>
    </tr>
    <tr>
      <td>City:</td>
      <td><input name="txtcity" type="text" id="txtcity" /></td>
      <td>Fax:</td>
      <td><input name="txtfax" type="text" id="txtfax" /></td>
    </tr>
    <tr>
      <td>State/Prov:</td>
      <td><input name="txtstate" type="text" id="txtstate" /></td>
      <td>E-mail:</td>
      <td><input name="txtemail" type="text" id="txtemail" /></td>
    </tr>
    <tr>
      <td>Postal Code:</td>
      <td><input name="txtpostal" type="text" id="txtpostal" /></td>
      <td>Comments:</td>
      <td><a href="javascript:NewCal('txt_issued','yyyymmdd','true',12)">
        <textarea name="txtcomment" id="txtcomment"></textarea>
      </a></td>
    </tr>
  </table>
  <br />
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="66"><label></label></td>
      <td width="178">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      <input type="button" name="Button" value="Add Employee" accesskey="S"  onclick="doFinish(frmvendor)"/></td>
      <td width="199"><center>
        <input type="reset" name="Reset" value="Clear Form" accesskey="C" />
      </center></td>
      <td width="157"><input name="Bclose" type="button" id="Bclose" accesskey="C" value="   Close   " onclick="javascript:location.href='BrowseVendor.php'"/></td>
    </tr>
  </table>
  </form>
</body>
</html>
