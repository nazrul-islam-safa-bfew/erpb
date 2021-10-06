<html>
<head>
<script language="JavaScript">
 Begin
<!--
// Add the selected items in the parent by calling method of parent
function addSelectedItemsToParent() {

for (counter = 0; counter < radio_form.ch.length; counter++)
{
if (radio_form.ch[counter].checked)
//alert(radio_form.ch[counter].value);
radio_choice = radio_form.ch[counter].value; 
}

self.opener.addToParentList(radio_choice);
window.close();

}

// End -->
</SCRIPT>
</head>
<body >
<center>
<form method="POST" name="radio_form">
<table bgcolor="#FFFFCC">
<tr>
<td bgcolor="#FFFFCC" ><input type="radio" name="ch" value="t" >  Vendor1</td></tr>
<tr><td bgcolor="#FFFFCC" ><input type="radio" name="ch" value="t"> Vendor2</td>
</tr>
<tr>
<td colspan=3 align="center">
<input type="button" value="Done" onClick = "javascript:addSelectedItemsToParent()">
</td>
</tr>
</table>
</form>
</body>
</html>
