<?
function myUpload($test,$testTemp,$loc,$qid){
   //echo "Still Here";
	$filemain = ".$loc/$qid.$test";
	echo $filemain.'<br>';
	//echo $test.'<br>';
	//echo $testTemp.'<br>';	
	if (move_uploaded_file($testTemp, $filemain)) {
	   echo "File is valid, and was successfully uploaded.\n";
	   $filemain = "$loc/$qid.$test";
	   return $filemain;
	} else {
	   echo "Possible file upload attack!\n";
	   return 0;
	}
}
?>
<?

if($saveVendor){
include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	$as="SELECT vname FROM vendor ";
	$bbv = mysql_query($as,$db);
	//echo $as;

	while($bbval = mysql_fetch_array($bbv))
	{
		if($bbval[vname]==$vname)
			{
			echo "  <p align=center><br><br><br><font face=Verdana size=1 color=#FF0000>Please Change your user name </font></p>";
			echo "<b><font face=Verdana size=1><a href=./index.php?keyword=vendor>Back to Previous page</a></font></b><br><br>";
			//echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=new+user\">";
			exit();
			}

     }//while ends


if($vname){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
	$point= $type + $quality + $reliability + $availability+ $experienceM + $experienceB + $service + $cfacility;
	//echo $point;

    print $sql = "INSERT INTO `vendor` (`vid`, `vname`, `address`, `contactName`, `designation`, `mobile`, `accInfo`, `vGL`, `type`, `quality`, `qualityText`, `reliability`, `reliabilityText`, `availability`, `availabilityText`, `experienceM`, `experienceMText`, `experienceB`, `experienceBText`, `service`, `serviceText`, `advance`, `advanceText`, `cfacility`, `cfacilityText`, `camount`, `cduration`, `datev`, `point`)";
	 $sql.= " VALUES ('', '$vname', '$address', '$contactName', '$designation', '$mobile', '$accInfo', '$vGL','$type', '$quality', '$qualityText', '$reliability', '$reliabilityText', '$availability', '$availabilityText', '$experienceM', '$experienceMText', '$experienceB', '$experienceBText', '$service', '$serviceText', '$advance', '$advanceText', '$cfacility', '$cfacilityText', '$camount', '$cduration', '$todat', '$point')";
	$adduserdb = mysql_query($sql,$db);
    $qid= mysql_insert_id();	
	
   print  $sql = "INSERT INTO `vendorrating` (`id`,`vid`,`quality`, `qualityText`, `reliability`, `reliabilityText`, `availability`, `availabilityText`, `experienceM`, `experienceMText`, `experienceB`, `experienceBText`, `service`, `serviceText`, `advance`, `advanceText`, `cfacility`, `cfacilityText`, `camount`, `cduration`, `datev`, `point`,`ratedBy`)";
	 $sql.= " VALUES ('','qid', '$vname', '$address', '$contactName', '$designation', '$mobile', '$accInfo', '$vGL','$type', '$quality', '$qualityText', '$reliability', '$reliabilityText', '$availability', '$availabilityText', '$experienceM', '$experienceMText', '$experienceB', '$experienceBText', '$service', '$serviceText', '$advance', '$advanceText', '$cfacility', '$cfacilityText', '$camount', '$cduration', '$todat', '$point','$ratedBy')";
	$adduserdb = mysql_query($sql,$db);
    $qid= mysql_insert_id();
	
$fileName=$_FILES['quoUpload']['name'];
if($fileName)
 {
	$fileTemp=$_FILES['quoUpload']['tmp_name'];
	$uploadFile= myUpload($fileName, $fileTemp, './vendor/attachment', $qid);
	//echo $uploadFile;
	if($uploadFile)
	  { 
	   $sql ="UPDATE `vendor` SET att='$uploadFile' WHERE qid=$qid";
	  // echo "<br>$sql";
	   $sqlrunp= mysql_query($sql);
	   }
  }
}

echo "<div id='msg' style='background:#FFFF99; width:200px;' >Your information has been updated.. Please wait </div>";
echo "<script>setTimeout('removeMsg()',3000);</script>";
//echo $sql;

//echo " <meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=vendor\">";	
}//signup ends


?>
<?
if($vid)
 {
  include("./includes/config.inc.php");
$db11 = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db11);
$sqlp11 = "SELECT * from `vendor` WHERE vid=$vid";
//echo $sqlp;
$sqlrunp11= mysql_query($sqlp11);
$vendor= mysql_fetch_array($sqlrunp11);
}
?>
<? if($vid) echo '<form name="ven" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./vendor/vendorupdate.sql.php?vid='.$vid.'" method="post" enctype="multipart/form-data">';
 else echo '<form name="ven" onsubmit="return validateForm( this, 0, 1, 0, 0, 15 );" action="./index.php?keyword=vendor" method="post" enctype="multipart/form-data">';?>
<table   class="vendorTable" align="center"  width="95%"   >
<tr>
    <td colspan="3" class="vendorAlertHd" >Create New Vendor</td>
</tr>	
<tr>
    <td width="16%"  class="vendorTdl"><LABEL for=vname> Company Name</LABEL></td>
	<td ><input name="vname" type="text" size="50" maxlength="45" value="<? echo $vendor[vname];?>" alt=blank ></td>
	<td width="50%">Accounts Payable account: 
    <input type="text" name="vGL" value="<? echo $vendor[vGL];?>"></td>
</tr>	

<tr>
   <td  class="vendorTdl"><LABEL for=address>Address</LABEL></td> 
<td colspan="2"><input name="address" type="text" size="50" maxlength="100" value="<? echo $vendor[address];?>" alt=blank ></td>
</tr>	
<tr>
 <td  class="vendorTdl"> <LABEL for=contactName>Contact Name</LABEL></td> 
<td colspan="2"><input name="contactName" type="text" size="50" maxlength="100" value="<? echo $vendor[contactName];?>"  alt=blank></td>
</tr>	
<tr>
    <td  class="vendorTdl"> -  Designation</td>
	<td colspan="2"><input name="designation" type="text" size="50" maxlength="100" value="<? echo $vendor[designation];?>" ></td>
</tr>	
<style>
	.radio_group p{ margin:0px;}
</style>
<tr>
    <td  class="vendorTdl"> -  Contract Phone No</td> 
	<td colspan="2"><input name="mobile" type="text" size="50" maxlength="100" value="<? echo $vendor[mobile];?>" ></td>
</tr>	
<tr>
    <td  class="vendorTdl"> Accounts Information</td>
	<td colspan="2"><input name="accInfo" type="text" size="50" maxlength="100" value="<? echo $vendor[accInfo];?>" ></td>
</tr>	
<tr>
    <td  class="vendorTdl"> Vendor Type</td> 
	  <td width="34%">
	  <div style="margin:5px 0px;" class="radio_group">
	  <p><input type="radio" name="type" value="10" <? if($vendor[type]=='10') echo 'SELECTED';?> onChange="selector4Type(document.ven,this.value)">
	  Manufacture/ Importer/ 1st Class national contractor/ Monopolist/ MNC (10 Points)</p>
<p>	       <input type="radio" name="type" value="5" <? if($vendor[type]=='5') echo 'SELECTED';?> onChange="selector4Type(document.ven,this.value)">
Distributor/ Wholeseller/ 2nd class & regional contractor (5 points),</p>
<p>		   <input type="radio" name="type" value="0" <? if($vendor[type]=='0') echo 'SELECTED';?> onChange="selector4Type(document.ven,this.value)">
Retailer/ Local Vendor/ Local contractor with complete setup (0 points)</p>
<p>			<input type="radio" name="type" value="-10" <? if($vendor[type]=='-10') echo 'SELECTED';?> onChange="selector4Type(document.ven,this.value)">
Agents (opportunist)/ 1 man company (-10 points),</p>
</div>
       </td>
	   <td align="left"><input type="text" name="VendorTypeTxt" id="VendorTypeTxt" value="<? echo $vendor[qualityText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>	

<tr>
    <td  class="vendorTdl"> Market Reputation</td>
	<td width="34%">
	  <div style="margin:5px 0px;" class="radio_group" >

               <p> <input  onchange="selector1(document.ven,this.value)" type="radio" name="quality"  value="10" <? if($vendor[quality]=='10') echo 'SELECTED';?>>Premium vendor (within top 10%) (10 points)</p>
<p>                 <input  onchange="selector1(document.ven,this.value)" type="radio" name="quality"  value="5" <? if($vendor[quality]=='5') echo 'SELECTED';?>>
Reputed & well-known vendor (between top 11% to 25%) (5 points)</p>
       <p>          <input  onchange="selector1(document.ven,this.value)" type="radio" name="quality"  value="0" <? if($vendor[quality]=='0') echo 'SELECTED';?>>
       General vendor (0 points)</p>
              <p>   <input  onchange="selector1(document.ven,this.value)" type="radio" name="quality"  value="-10" <? if($vendor[quality]=='-10') echo 'SELECTED';?>>
              Vendor with bad reputation (-10 points)</p>
    </div></td>
	<td align="left"><input type="text" name="qualityText" value="<? echo $vendor[qualityText];?>" disabled class="disabled"  style="width:470px"></td>
	
</tr>	











<tr>
    <td  class="vendorTdl">Management Culture</td>
	<td>
	
	  <div style="margin:5px 0px;" class="radio_group" >
        <p><input type="radio" name="mngCulture" onchange="selector4Cul(document.ven,this.value)" value="10" <? if($vendor[experienceM]=='10') echo 'SELECTED';?>>
        Task culture (10 points)</p>
        <p><input type="radio" name="mngCulture" onchange="selector4Cul(document.ven,this.value)" value="5" <? if($vendor[experienceM]=='5') echo 'SELECTED';?>>
        Role culture (5 points)</p>
       <p><input type="radio" name="mngCulture" onchange="selector4Cul(document.ven,this.value)" value="0" <? if($vendor[experienceM]=='0') echo 'SELECTED';?>>
       Power culture (0 points)</p>
        
      </div></td>
	<td><input type="text" name="mngCultureTxt" id="mngCultureTxt" value="<? echo $vendor[experienceMText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>

<tr>
    <td  class="vendorTdl">Organization Behavior</td>
	<td>
	
	  <div style="margin:5px 0px;" class="radio_group" >
        <p><input type="radio" name="orgBehavior" onchange="selector4Beha(document.ven,this.value)" value="10" <? if($vendor[experienceM]=='10') echo 'SELECTED';?>>
        Prospector (10 points)</p>
        <p><input type="radio" name="orgBehavior" onchange="selector4Beha(document.ven,this.value)" value="5" <? if($vendor[experienceM]=='5') echo 'SELECTED';?>>
        Analyzer (5 points)</p>
       <p><input type="radio" name="orgBehavior" onchange="selector4Beha(document.ven,this.value)" value="0" <? if($vendor[experienceM]=='0') echo 'SELECTED';?>>
       Defender (0 points)</p>
        <p><input type="radio" name="orgBehavior" onchange="selector4Beha(document.ven,this.value)" value="-10" <? if($vendor[experienceM]=='-10') echo 'SELECTED';?>>
        Reactor (-10 points)</p>
      </div></td>
	<td><input type="text" name="orgBehaviorTxt" id="orgBehaviorTxt" value="<? echo $vendor[experienceMText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>











<tr>
    <td  class="vendorTdl">Resource Availability (Labour force, Materials, Equipments, Working capital, Safety items, Management personnel, Qualification certificate, Local presence, Business connections, Enlistment, etc.)</td>
	<td>
	

	  <div style="margin:5px 0px;" class="radio_group" >
	<p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="10" <? if($vendor[reliability]=='10') echo 'SELECTED';?>>
	Able to meet delivery schedule, able to influence market (10 points)</p>
	   <p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="5" <? if($vendor[reliability]=='5') echo 'SELECTED';?>>
	   Able to meet delivery schedule, able to support contingency events (5 points)</p>
	    <p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="0" <? if($vendor[reliability]=='0') echo 'SELECTED';?>>
	    Able to meet delivery schedule, limited ability to support contingency events (0 points)</p>
                 <p><input type="radio" name="reliability" onchange="selector2(document.ven,this.value)"  value="-10" <? if($vendor[reliability]=='-10') echo 'SELECTED';?>>
                 No visible assurance of ability to meet delivery schedule (-10 points)</p>
	             
</div>
		
		</td>
	<td><input type="text" name="reliabilityText" value="<? echo $vendor[reliabilityText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>	
<!--<tr>
    <td  class="vendorTdl">Availability</td>
	<td><select name="availability" onchange="selector3(document.ven,document.ven.availability.options[document.ven.availability.selectedIndex].value)" >
                 <option value="0" <? if($vendor[availability]=='0') echo 'SELECTED';?>>Unknown (0 points)</option>
                 <option value="-2" <? if($vendor[availability]=='-2') echo 'SELECTED';?>>Unsatisfactory (-2 points)</option>
                 <option value="3" <? if($vendor[availability]=='3') echo 'SELECTED';?>>Good (3 points)</option>
	             <option value="5" <? if($vendor[availability]=='5') echo 'SELECTED';?>>Outstanding (5 points)</option>
		</select></td>
	<td><input type="text" name="availabilityText" value="<? echo $vendor[availabilityText];?>" disabled class="disabled"  style="width:470px" ></td>
</tr>-->


















	
<tr>
    <td  class="vendorTdl">Business Experience</td>
	<td>
	
	  <div style="margin:5px 0px;" class="radio_group" >
        <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="10" <? if($vendor[experienceM]=='10') echo 'SELECTED';?>>
        Above 10 years of continous operation (10 points)</p>
        <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="5" <? if($vendor[experienceM]=='5') echo 'SELECTED';?>>
        Less than 10 years  of continous operation (5 points)</p>
       <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="0" <? if($vendor[experienceM]=='0') echo 'SELECTED';?>>
       Less than 3 years  of continous operation (0 points)</p>
        <p><input type="radio" name="experienceM" onchange="selector4(document.ven,this.value)" value="-10" <? if($vendor[experienceM]=='-10') echo 'SELECTED';?>>
        No Experience (-10 points)</p>
      </div></td>
	<td><input type="text" name="experienceMText" value="<? echo $vendor[experienceMText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>	



<tr>
    <td  class="vendorTdl">Experience with BFEW</td>
	<td>
	 <div style="margin:5px 0px;" class="radio_group" >
	
                 	<p><input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="10" <? if($vendor[experienceB]=='10') echo 'SELECTED';?>>
                 	Above 5 years with no records of failure (10 points)</p>
                 	<p><input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="5" <? if($vendor[experienceB]=='5') echo 'SELECTED';?>>
                 	Less than 5 years  with no records of failure (5 points)</p>
                 	<p><input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="0" <? if($vendor[experienceB]=='0') echo 'SELECTED';?>>
                 	No Experience with BFEW (0 points)</p>

		
			              	<input type="radio" name="experienceB" onchange="selector5(document.ven,this.value)" value="-10" <? if($vendor[experienceB]=='-10') echo 'SELECTED';?> id="theValue" title=""/>
			              	Failure experienced with BFEW <i>(failed to maintain delivery schedule with materials, equipments or
    labour; quality problems with materials/labour supplied; equipment supplied with excess breakdown;
    PO closed because of price escalation; Required additional support from BFEW with equipments, 
    Labours, Advance payment or required to split PO quantity to other vendor to maintain schedule etc.)</i> in last 5 years (-10 points) </p>
	  </div>				  
		</td>
		<script type="text/javascript">
	function theTitle(receiver,switcher){
		vtitle=receiver.checked;
			switcher.disabled=vtitle;					
	}
		
		</script>
	<td><input type="text" name="experienceBText" value="<? echo $vendor[experienceMText];?>" disabled class="disabled"  style="width:470px"></td>
</tr>	
<!--<tr>
    <td  class="vendorTdl">After Sales service</td>
	<td><select name="service" onchange="selector6(document.ven,document.ven.service.options[document.ven.service.selectedIndex].value)" >
                 <option value="0" <? if($vendor[service]=='0') echo 'SELECTED';?>>Unknown (0 points)</option>
                 <option value="-2" <? if($vendor[service]=='-2') echo 'SELECTED';?>>Unsatisfactory (-2 points)</option>
                 <option value="3" <? if($vendor[service]=='3') echo 'SELECTED';?>>Good (3 points)</option>
	             <option value="5" <? if($vendor[service]=='5') echo 'SELECTED';?>>Outstanding (5 points)</option>
		</select></td>
	<td><input type="text" name="serviceText" value="<? echo $vendor[serviceText];?>" disabled class="disabled"  style="width:470px" ></td>
</tr>	-->
<!--<tr>
    <td  class="vendorTdl"> Advance Required</td>    
  <td colspan="2"> 
   <? if($vendor[advance]=='-5') $c1='CHECKED';
      else $c='CHECKED';?>
      <input type="radio" name="advance" value="10" <? echo $c;?> onClick="credit0();"> No (10 points)
      <span>| Yes (0 point): <input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 5% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 10% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 15% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 20% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 25% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 30% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 45% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 50% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 60% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 75% </span>
      <span><input type="radio" name="advance" value="0" <? echo $c1;?> onClick="credit0();"> 100%</span>
	
	
	
	
	</td>
</tr>  

<tr>
    <td  class="vendorTdl" > Credit Facility</td>    
  <td colspan="2">
     <? if($vendor[cfacility]=='10') $c2='CHECKED';
	    elseif($vendor[cfacility]=='0') $c3='CHECKED';		
        // else $c1='CHECKED';?>

 
  <input type="radio" name="cfacility" value="10" <? echo $c3;?> onClick="credit();"> Bill-to-Bill (10 points)
    | Yes (0 points) :
  <input type="radio" name="cfacility" value="0" checked="" onclick="credit();">7 days, 
<input type="radio" name="cfacility" value="0" checked="" onclick="credit();"> 14 days, 
<input type="radio" name="cfacility" value="0" checked="" onclick="credit();"> 21 days, 
<input type="radio" name="cfacility" value="0" checked="" onclick="credit();"> 30 days, 
<input type="radio" name="cfacility" value="0" checked="" onclick="credit();"> 45 days, 
<input type="radio" name="cfacility" value="0" checked="" onclick="credit();"> 60 days, 
<input type="radio" name="cfacility" value="0" checked="" onclick="credit();"> 75 days, 
<input type="radio" name="cfacility" value="0" checked="" onclick="credit();"> 90 days

  </td>
</tr>  -->
<tr >
  <td  class="vendorTdl"> Attachment</td>  
  <td> <input type="file" id="pdf_file" name="quoUpload"></td> 
</tr>
<tr>
 <td  class="vendorTdl">Certified By</td>
  <td>
   <select name="ratedBy" size="1">
 
<? include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

//if($loginProject=='000')
 $sql=@mysql_query("SELECT * FROM employee WHERE (salaryType='Salary' OR salaryType='Salaried' OR salaryType='Consolidated' )  ORDER by designation") or die('Please try later!!');
//else $sql=@mysql_query("SELECT * FROM employee WHERE salaryType='Salary' AND location='$loginProject' ORDER by designation") or die('Please try later!!');
 while($typel= mysql_fetch_array($sql)){

 $plist.= "<option value='".$typel[empId]."'";
 if($empId==$typel[empId]) $plist.=" SELECTED ";
 $plist.= ">".empId($typel[empId],$typel[designation])."--$typel[name]</option>  ";
 }
 echo $plist;
?>
</select>
</td>
</tr>
<tr>
    <td  colspan="3" align="center"> <input type="submit" value="Save" name="saveVendor" class="vendor" onMouseOver="this.className='vendorhov'" onMouseOut="this.className='vendor'" onclick="if(checkThisOut()==0)return false;"></td>
</tr>	
<script type="text/javascript">
function checkThisOut(){
pdf_file=document.getElementById("pdf_file");
file_name=pdf_file.value;
if(file_name){
file_ext=file_name.split(".").pop();
	if(file_ext!="pdf"){
		alert("Please attatch pdf file!");
		return 0;
	}
}
else{
alert("Please attatch pdf file!");
return 0;
}
    var theVendor;
    theVendor={
        qualityText:document.ven.qualityText,
        reliabilityText:document.ven.reliabilityText,
        availabilityText:document.ven.availabilityText,
        experienceMText:document.ven.experienceMText,
        experienceBText:document.ven.experienceBText,
        serviceText:document.ven.serviceText,
        advanceText:document.ven.advanceText
        
    };
	
     
    
}
</script>
</table>
</form>	