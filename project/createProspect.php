<style type="text/css">
	/* YOU CAN REMOVE THIS PART */
	/*body{
		background-image:url('../../images/heading3.gif');
		background-repeat:no-repeat;
		padding-top:85px;	
		font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
		font-size:0.9em;
		line-height:130%;

	}
	h1{
		line-height:130%;*/
	}
	a{
		border-bottom:none;
		color: #CA136A;
		text-decoration:none;

	}
	
	a:hover{
		border-bottom:none;
		color: #307082;
	}
   		
	/* END PART YOU CAN REMOVE */
	
	
	#dhtmlgoodies_tooltip{
		background-color:#EEE;
		border:1px solid #000;
		position:absolute;
		display:none;
		color:#000033;
		z-index:20000;
		padding:2px;
		font-size:0.9em;
		-moz-border-radius:6px;	/* Rounded edges in Firefox */
		font-family: "Trebuchet MS", "Lucida Sans Unicode", Arial, sans-serif;
		
	}
	#dhtmlgoodies_tooltipShadow{
		position:absolute;
		background-color:#555;
		display:none;
		z-index:10000;
		opacity:0.7;
		filter:alpha(opacity=70);
		-khtml-opacity: 0.7;
		-moz-opacity: 0.7;
		-moz-border-radius:6px;	/* Rounded edges in Firefox */
	}
	</style>
	
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	
	
	
	
	<SCRIPT type="text/javascript">
	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, October 2005
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Updated:	
		March, 11th, 2006 - Fixed positioning of tooltip when displayed near the right edge of the browser.
		April, 6th 2006, Using iframe in IE in order to make the tooltip cover select boxes.
		
	Terms of use:
	You are free to use this script as long as the copyright message is kept intact. However, you may not
	redistribute, sell or repost it without our permission.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	
	var dhtmlgoodies_tooltip = false;
	var dhtmlgoodies_tooltipShadow = false;
	var dhtmlgoodies_shadowSize = 4;
	var dhtmlgoodies_tooltipMaxWidth = 600;
	var dhtmlgoodies_tooltipMinWidth = 100;
	var dhtmlgoodies_iframe = false;
	var tooltip_is_msie = (navigator.userAgent.indexOf('MSIE')>=0 && navigator.userAgent.indexOf('opera')==-1 && document.all)?true:false;
	function showTooltip(e,tooltipTxt)
	{
		
		var bodyWidth = Math.max(document.body.clientWidth,document.documentElement.clientWidth) - 20;
	
		if(!dhtmlgoodies_tooltip){
			dhtmlgoodies_tooltip = document.createElement('DIV');
			dhtmlgoodies_tooltip.id = 'dhtmlgoodies_tooltip';
			dhtmlgoodies_tooltipShadow = document.createElement('DIV');
			dhtmlgoodies_tooltipShadow.id = 'dhtmlgoodies_tooltipShadow';
			
			document.body.appendChild(dhtmlgoodies_tooltip);
			document.body.appendChild(dhtmlgoodies_tooltipShadow);	
			
			if(tooltip_is_msie){
				dhtmlgoodies_iframe = document.createElement('IFRAME');
				dhtmlgoodies_iframe.frameborder='5';
				dhtmlgoodies_iframe.style.backgroundColor='#FFFFFF';
				dhtmlgoodies_iframe.src = '#'; 	
				dhtmlgoodies_iframe.style.zIndex = 100;
				dhtmlgoodies_iframe.style.position = 'absolute';
				document.body.appendChild(dhtmlgoodies_iframe);
			}
			
		}
		var mouseX=e.pageX;
		var mouseY=e.pageY;
		
		dhtmlgoodies_tooltip.style.display='block';
		dhtmlgoodies_tooltipShadow.style.display='block';
		if(tooltip_is_msie)dhtmlgoodies_iframe.style.display='block';
		
		var st = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
		if(navigator.userAgent.toLowerCase().indexOf('safari')>=0)st=0; 
		var leftPos = e.clientX + 10;
		
		dhtmlgoodies_tooltip.style.width = null;	// Reset style width if it's set 
		dhtmlgoodies_tooltip.innerHTML = tooltipTxt;
		dhtmlgoodies_tooltip.style.left = leftPos + 'px';
		//dhtmlgoodies_tooltip.style.top = e.clientY + 10 + st + 'px';
		dhtmlgoodies_tooltip.style.top = mouseY+ 'px';

		
		dhtmlgoodies_tooltipShadow.style.left =  leftPos + dhtmlgoodies_shadowSize + 'px';
		//dhtmlgoodies_tooltipShadow.style.top = e.clientY + 10 + st + dhtmlgoodies_shadowSize + 'px';
		dhtmlgoodies_tooltipShadow.style.top = mouseY+ 'px';
		
		if(dhtmlgoodies_tooltip.offsetWidth>dhtmlgoodies_tooltipMaxWidth){	/* Exceeding max width of tooltip ? */
			dhtmlgoodies_tooltip.style.width = dhtmlgoodies_tooltipMaxWidth + 'px';
		}
		
		var tooltipWidth = dhtmlgoodies_tooltip.offsetWidth;		
		if(tooltipWidth<dhtmlgoodies_tooltipMinWidth)tooltipWidth = dhtmlgoodies_tooltipMinWidth;
		
		
		dhtmlgoodies_tooltip.style.width = tooltipWidth + 'px';
		dhtmlgoodies_tooltipShadow.style.width = dhtmlgoodies_tooltip.offsetWidth + 'px';
		dhtmlgoodies_tooltipShadow.style.height = dhtmlgoodies_tooltip.offsetHeight + 'px';		
		
		if((leftPos + tooltipWidth)>bodyWidth){
			dhtmlgoodies_tooltip.style.left = (dhtmlgoodies_tooltipShadow.style.left.replace('px','') - ((leftPos + tooltipWidth)-bodyWidth)) + 'px';
			dhtmlgoodies_tooltipShadow.style.left = (dhtmlgoodies_tooltipShadow.style.left.replace('px','') - ((leftPos + tooltipWidth)-bodyWidth) + dhtmlgoodies_shadowSize) + 'px';
		}
		
		if(tooltip_is_msie){
			dhtmlgoodies_iframe.style.left = dhtmlgoodies_tooltip.style.left;
			dhtmlgoodies_iframe.style.top = dhtmlgoodies_tooltip.style.top;
			dhtmlgoodies_iframe.style.width = dhtmlgoodies_tooltip.offsetWidth + 'px';
			dhtmlgoodies_iframe.style.height = dhtmlgoodies_tooltip.offsetHeight + 'px';
		
		}
				
	}
	
	function hideTooltip()
	{
		dhtmlgoodies_tooltip.style.display='none';
		dhtmlgoodies_tooltipShadow.style.display='none';		
		if(tooltip_is_msie)dhtmlgoodies_iframe.style.display='none';		
	}
	
	</SCRIPT>

<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" >document.write(getCalendarStyles());</SCRIPT>






<script>


function getprojects(str)
{


var src="./project/getprojects.php?q="+str;
var preeTxt="<div class='text-align:center; width:90%'><h2 style='text-align:center; width:200px; height:130px; margin:auto; top:50%; left:45%; position:absolute; border:1px gray solid; background:#F5F5F5' ><br><br>Loading...</h2></div>";

	$(document).ready(function(){
		$("#projectnamediv")
			.html(preeTxt)
			.fadeIn(1000,function(){
				$("#projectnamediv").load(src,function(r,s,xht){})
			
		});
	});


//this function will call an php code and make a new project list drop down and put to that div (projectnamediv)
//alert(str);
/*
if (str=="")
  {
  document.getElementById("projectnamediv").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	document.getElementById("projectnamediv").innerHTML=xmlhttp.responseText;
    }
  }
 //alert("getmanu.php?q="+str+"&qsub="+str_sub+"&qt="+qt+"&items="+vals+"&items1="+vals1);
//xmlhttp.open("GET","./project/getprojects.php?q="+str,true);  //path thik silo na. done , need to fix db connection
xmlhttp.send();
*/



}


function getdist(str,selected_val)
{
//this function will call an php code and make a new project list drop down and put to that div (projectnamediv)
//alert(str);
if (str=="")
  {
  document.getElementById("distnamediv").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	document.getElementById("distnamediv").innerHTML=xmlhttp.responseText;
    }
  }
 //alert("getmanu.php?q="+str+"&qsub="+str_sub+"&qt="+qt+"&items="+vals+"&items1="+vals1);
//alert("project/getdist.php?d="+str+"&s="+selected_val);
xmlhttp.open("GET","project/getdist.php?d="+str+"&s="+selected_val,true);  //path thik silo na. done , need to fix db connection
xmlhttp.send();
}

</script>
 

<?
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
mysql_select_db($SESS_DBNAME,$db);

putenv ('TZ=Asia/Dacca');
$openDate=date('Y-m-d');
$cd=formatdate2($closeDate,'Y-m-d');
$cd2=formatdate2($bidsubDate,'Y-m-d');
$userId=$_SESSION["a_loginUid"];

function is_address_accessable($typeId,$userId){
    mysql_query("select * from marketing_address where typeId='$typeId' and userId='$userId'");
	
    return mysql_affected_rows();
}

//echo "Opening date".$openDate.'<br>'."closing date".$closeDate."<br>";
$dat=(strtotime(formatdate2($bidsubDate,'Y-m-d'))-strtotime(formatdate2($openDate,'Y-m-d')))/86400;
 //calculate days
//echo "<br>here is the diff";

  $days=floor($dat/3).'<br>';
  $openDate.'<br>';
  $pb2=caldate($re['openDate'],$days,1).'<br>';
  $pb3=caldate($re['openDate'],$days,2).'<br>';
  $pb4=caldate($re['openDate'],$days,3).'<br>';
 //echo $pb5=caldate($re[openDate],$days,3).'<br>';
  $bidsubDate."<br>";
  $dat2=(strtotime($cd)-strtotime($cd2))/86400;
//echo "<br>";
  $days2=floor($dat2/5).'<br>';
 
  $pb6=caldate($cd2,$days2,1).'<br>';
  $pb7=caldate($cd2,$days2,2).'<br>';
  $pb8=caldate($cd2,$days2,3).'<br>';
  $pb9=caldate($cd2,$days2,4).'<br>';
$type=$_POST['prostyp'];
$project_name=$_POST['project_name'];
$pb2=formatdate2($pb2,'Y-m-d');
$pb3=formatdate2($pb3,'Y-m-d');
$pb4=formatdate2($pb4,'Y-m-d');
$pb6=formatdate2($pb6,'Y-m-d'); 
$pb7=formatdate2($pb7,'Y-m-d');
$pb8=formatdate2($pb8,'Y-m-d');
$pb9=formatdate2($pb9,'Y-m-d');

if($_POST['nproject']=="Save")
{
//include("config.inc.php");
$sq="select ptype from user where designation='Business Development Manager' and id='$a_loginUid' ";
				$gg= mysql_query($sq);
				$re1l=mysql_fetch_array($gg);
				$psid=$re1l['ptype'];
	 $tprojnm=$_POST['txtprojnm'];

   $sql="insert into project (psid,type,pname,paddress1,paddress2,pdiv,userId,pcity,ppcode,pphone,pfax,pemail,purl,probability,openDate,pb2,pb3,pb4,pb5,pb6,pb7,pb8,pb9) values('$psid', '$type', '$tprojnm','$paddress1','$paddress2','$pdiv', '$a_loginUid',
'$pcity','$ppcode','$pphone','$pfax','$pemail','$purl', '0','$openDate','$pb2','$pb3','$pb4','$cd2','$pb6','$pb7','$pb8','$pb9') ";
// user record code -- , userId='$a_loginUid'
if(mysql_query($sql))echo "<div align='center'>DATA is successfully inserted</div>";
else echo "<div class='pdf' align='center'>There was a problem in DATA entry</div>";


$projid=mysql_insert_id();
 $sq2="INSERT INTO afp set  pid='$projid',uid='$a_loginUid', bfewtba='0' ";
if(mysql_query($sq2))echo "<div align='center'>DATA is successfully inserted</div>";
else echo "<div class='pdf' align='center'>There was a problem in DATA entry</div>";
}
?>
<? 
if($eproject){
//$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
//mysql_select_db($SESS_DBNAME,$db);

putenv ('TZ=Asia/Dacca');
$cd=formatdate2($closeDate,'Y-m-d');
$cd2=formatdate2($bidsubDate,'Y-m-d');
//echo $cd;
//echo $closeDate;
	$tprojnm=$_POST['txtprojnm'];

  $sql="update project set type='$type', pname='$tprojnm',  paddress1='$paddress1', paddress2='$paddress2', pdiv='$pdiv', userId='$a_loginUid',
pcity='$pcity',ppcode='$ppcode',pphone='$pphone',pfax='$pfax',pemail='$pemail',purl='$purl' where id='$pid'";

if(mysql_query($sql))echo "<div align='center'>DATA is successfully Updated</div>";
else echo "<div class='pdf' align='center'>There was a problem in DATA entry</div>";

//-----------Date include--------------

 $sql="SELECT  * from project where id='$pid' ";
 $sqlq=mysql_query($sql);
 $re=mysql_fetch_array($sqlq);
 $dat=(strtotime($re['pb5'])-strtotime($re['openDate']))/86400;
 //echo "<br>";

  $days=floor($dat/3).'<br>';
  $re[openDate]."<br>";
  $pb3=caldate($re['openDate'],$days,1).'<br>';
  $pb4=caldate($re['openDate'],$days,2).'<br>';
 //echo $pb5=caldate($re[openDate],$days,3).'<br>';
  $bidsubDate."<br>";
  $dat2=(strtotime($re['closeDate'])-strtotime($re['pb5']))/86400;
 //echo "<br>";
  $days2=floor($dat2/5).'<br>';
 
  $pb6=caldate($re['pb5'],$days2,1).'<br>';
  $pb7=caldate($re['pb5'],$days2,2).'<br>';
  $pb8=caldate($re['pb5'],$days2,3).'<br>';
  $pb9=caldate($re['pb5'],$days2,4).'<br>';

//$cd=formatdate2($pb3,'Y-m-d');
$sql="update project set pb3='".formatdate2($pb3,'Y-m-d')."',pb4='".formatdate2($pb4,'Y-m-d')."', pb6='".formatdate2($pb6,'Y-m-d')."', pb7='".formatdate2($pb7,'Y-m-d')."', pb8='".formatdate2($pb8,'Y-m-d')."', pb9='".formatdate2($pb9,'Y-m-d')."' where id='$pid' ";

if(mysql_query($sql))echo "<div align='center'>DATE is successfully Updated</div>";
else echo "<div class='pdf' align='center'>There was a problem in DATE entry</div>";

}
?>
<? 
if($_GET['id']){
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
mysql_select_db($SESS_DBNAME,$db);
$sql1="SELECT * From project WHERE id='".$_GET['id']."'";
//echo $sql1;
$sqlQur1=mysql_query($sql1);
$sqlr=mysql_fetch_array($sqlQur1);
}
?>
<style type="text/css">
.UND {border-bottom:1px double black; font-weight:bold;}
.style1 {
	font-size: 16px;
	font-weight: bold;
}
.style2 {font-size: 16px}
</style>
<SCRIPT LANGUAGE="JavaScript">
		var now = new Date(); 
		var cal = new CalendarPopup("testdiv1");
		//cal.showNavigationDropdowns();
		cal.setWeakStartDay(6); // Weak is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"dd-MM-yyyy")); 
		//cal.setCssPrefix("TEST");		
		cal.offsetX = 100;
		cal.offsetY = 0;
	</SCRIPT>
	
	
	<style>
 input[type="text"],textarea{
			width:300px;
			}
			#inputtext1 {
 width: 300px; 
 }
 
		
	</style>
	
	
<form name="createProject" action="./index.php?keyword=createProspect"  method="post">
<!--./index.php?keyword=create+new+project&pid=<? echo $re[id];?> -->
<div style="width:650px; margin:0 auto">
<div id="fgeneral" class="boxed">
			<h4 class="title">Create New Prospect<div style="float:right; margin:-6px 20px 0px 0px;"><input type="button" onclick="window.open('selectProject_me.php?project=<?php echo $_GET['id']; ?>','_blank')" value="Add Person" /></div></h4>
	  <div class="content">
	  		<label for="inputtext1">Prospect Type:</label>
	  		<select id="select" name="prostyp" onchange="getprojects(this.value)">
	  		  <!--<select id="inputtext3" name="prostyp"  
			onChange="location.href='./index.php?keyword=create+new+project1&pst='+this.options[this.selectedIndex].value">-->
	  		  <option value="">Select Type</option>
              
	  		  <?php
			  
				  if($pst){  $sqlp = "SELECT * From categorie c, prospecttype pt where c.cat_type=pt.pst_id
                    and pt.pst_id='$pst' ORDER by pt.pst_des ASC";}
                    elseif($pst==""){ $sqlp = "SELECT * From categorie c, prospecttype pt
                    where c.cat_type=pt.pst_id and c.cat_type in(1,3,4,5,6,7) ORDER by c.cat_des ASC"; }
                    elseif($pst==0){$sqlp = "SELECT * From categorie c, prospecttype pt
                    where c.cat_type=pt.pst_id ORDER by pt.pst_des ASC";}
                    $sqlrunp= mysql_query($sqlp);
                    while($ps=mysql_fetch_array($sqlrunp)){
					if(is_address_accessable($ps[cat_id],$userId)){?>
	  		  <option value="<? echo $ps['cat_id'];?>"
                    <? if($sqlr['type']==$ps['cat_id']) echo ' selected '; ?>> <? echo $ps['cat_des'].' - '.countprospects($ps[cat_id]);  ?></option>
	  		  <? }}//while ?>
	    </select>
	  		<!--<a onclick="addprospect()">&nbsp;&nbsp;[ add ]</a> -->
		<br>
<script type="text/javascript">
function changetextbox()
{

    if (document.getElementById("inputtext3").value == '0') {
		//alert(document.getElementById("inputtext3").value);
        document.getElementById("txtprojnm2").disabled='false';
    } else {
		//alert(document.getElementById("inputtext3").value);
        document.getElementById("txtprojnm2").disabled='true';
    }
}
</script>


			
			<!--onChange="location.href='./index.php?keyword=create+new+project&prosid='+this.options[this.selectedIndex].value"-->
           <!-- <select id="inputtext3" name="prosnm" onChange="changetextbox()";>
            <option value="0">Select Prospect</option>
				<? 
				//$sqlp = "SELECT * FROM `project1` order by prosn ASC";
				/*if($pst){$sqlp = "SELECT * From project1 p, prspecttype pt where p.pstype=pt.pst_id and pt.pst_id='$pst' ORDER by pt.pst_des,p.prosn ASC";}
				if($pst==""){$sqlp = "SELECT * From project1 p, prspecttype pt where p.pstype=pt.pst_id ORDER by pt.pst_des,p.prosn ASC";}
				if($pst==0){$sqlp = "SELECT * From project1 p, prspecttype pt where p.pstype=pt.pst_id ORDER by pt.pst_des,p.prosn ASC";}*/
				/*if($_REQUEST['pst']){ $sqlp = "SELECT distinct pname From project p, categorie ct where p.type='".$_REQUEST['pst']."' ORDER by p.pname ASC";}
				if($_REQUEST['pst']==""){$sqlp = "SELECT * From project p, categorie ct where p.type=ct.cat_id ORDER by ct.cat_des,p.id ASC";}
				if($_REQUEST['pst']==0){$sqlp = "SELECT * From project p, categorie ct where p.type=ct.cat_id ORDER by ct.cat_des,p.id ASC";}
				
				//echo $sqlp;
				$sqlrunp= mysql_query($sqlp);				
				while($ps=mysql_fetch_array($sqlrunp)){?>					
<option value="<? echo $ps['pname'];?>" <? if($sqlr[type]==$ps[cat_id]) echo ' selected '; ?>><? echo $ps['pname'];?></option>		
				<? }*///while ?>
		</select>-->
<label for="inputtext1"> New Prospect Name:</label>
            <input type="text" id="txtprojnm" name="txtprojnm" value="<? echo $sqlr['pname']; ?>"/>
			<!--<textarea id="txtprojnm222" name="txtprojnm222"  cols="42" rows="5" ><? echo $sqlr['pname']; ?></textarea>-->
			<br>	
<!--onChange="location.href='./index.php?keyword=create+new+project&prosid='+this.options[this.selectedIndex].value"-->
				<!--<label for="inputtext1">Prospect Type</label> 
			<select id="inputtext3" name="pstype"  >
			<? 
				$sqlp = "SELECT * FROM `project1` order by pstype ASC";
				//echo $sqlp;
				$sqlrunp= mysql_query($sqlp);				
				while($ps=mysql_fetch_array($sqlrunp)){?>					
				<option value="<? echo $ps['pstype'];?>" <? if($sqlr['pstype']==$ps['pstype']) echo ' selected '; ?>><? echo view_prospecttype($ps['pstype']);?></option>		
				<? }//while ?>
		</select> -->
				
			<!--onChange="location.href='./index.php?keyword=create+new+project&type='+this.options[this.selectedIndex].value" -->
				<!--<label for="inputtext3">Project Type:</label>
				<select id="inputtext3" name="type" ><? 
				$sqlp = "SELECT * FROM `categorie` order by cat_des ASC";
				//echo $sqlp;
				$sqlrunp= mysql_query($sqlp);				
				while($re1=mysql_fetch_array($sqlrunp)){?>					
				<option value='<? echo $re1['cat_id'];?>'
				<? 
				//if($re[type])$type=$re[type];
				if($sqlr['type']==$re1['cat_id']) echo ' selected ' ;?>><? echo $re1['cat_des']; ?></option>		
				<? }//while ?>
				</select>-- > <!--<a href='index.php?keyword=add+prospect+type'>ADD NEW TYPE</a>-->

<br>
				
				<label for="inputtext1">Address 1:</label>
				<input id="inputtext1" type="text" name="paddress1" value="<? echo $sqlr['paddress1'];?>" ><br>
				<label for="inputtext1">Address 2:</label>
				<input id="inputtext1" type="text" name="paddress2" value="<? echo $sqlr['paddress2'];?>" ><br>
				<label for="inputtext1">Division:</label>
				<select id="inputtext3" name="pdiv" onchange="selected_val=0;getdist(this.value,selected_val)">
                 <option value="">Select Division</option>
				<? 
				$sqlp = "SELECT * FROM `division` order by div_des ASC";
				//echo $sqlp;
				$sqlrunp= mysql_query($sqlp);				
				while($re1=mysql_fetch_array($sqlrunp)){?>					
				<option value='<? echo $re1['div_id'];?>'
				<? 
				//if($re[type])$type=$re[type];
				if($sqlr[pdiv]==$re1[div_id]) echo ' selected ' ;?>><? echo $re1['div_des'];?></option>		
				<? }//while ?>		
				</select><br>
				<label for="inputtext1">City:</label>
                 <div id="distnamediv">
                <script type="text/javascript">

				 	selected_val="<?php echo $sqlr[pcity]; ?>";
					
					
					getdist('<?php echo $sqlr[pdiv]; ?>',selected_val);
</script>
				<select id="inputtext3" name="pcity">
               		<option value="">Select District</option>
                	
				</select>
                </div>
				<label for="inputtext1">Postal Code:</label>
				<input id="inputtext1" type="text" name="ppcode" value="<? echo $sqlr['ppcode'];?>" ><br>
				<label for="inputtext1">Phone:</label>
				<input id="inputtext1" type="text" name="pphone" value="<? echo $sqlr['pphone'];?>" ><br>
				<label for="inputtext1">Fax:</label>
				<input id="inputtext1" type="text" name="pfax" value="<? echo $sqlr['pfax'];?>" ><br>
				<label for="inputtext1">Email:</label>
				<input id="inputtext1" type="text" name="pemail" value="<? echo $sqlr['pemail'];?>" ><br>
				<label for="inputtext1">Url:</label>
				<input id="inputtext1" type="text" name="purl" value="<? echo $sqlr['purl'];?>" ><br>
				<br />
				
				
				<table align="center" width="100%" border="0"  style="border-collapse:collapse">
                
                
 <?php               
class calculator {
	function calculator($p){
		include("config.inc.php");
		$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
		mysql_select_db($SESS_DBNAME,$db);
		
		$sqlff="SELECT * FROM project where id='$p'";
		//echo $sqlff;
		$sqlf=mysql_query($sqlff);
		$r=mysql_fetch_array($sqlf);
		$this->projectName=$r[pname];
		}

	function projectName() {
		return $this->projectName;
	}

}

 //include "./includes/project.inc";
$cc = new calculator($a_loginProject);
//echo 'Selected Project:  <b>'.$cc->projectName()."</b>";
$des=$_POST['des'];
$revenue=$_POST['revenue'];
$profit=$_POST['profit'];
$fyearend=$_POST['fyearend'];
$corAff=$_POST['corAff'];
$custom_req=$_POST['customer_req'];


if( isset($_POST['nproject']) or  isset($_POST['eproject'])){
    $customer_req = implode(",",$custom_req);
    //print_r($customer_req);
}
//$customer_req = implode(",",$custom_req);
//$custom_req=$_POST['customer_req'];

$salesObj=$_POST['salesObj'];
$sourceoffund=$_POST['sourceoffund'];
$quotation=$_POST['quotation'];
$org_culture=$_POST['org_culture'];
$org_behavior=$_POST['org_behavior'];
if($_POST[ck]){

$sql="INSERT INTO cbp(id,pid,org_culture,org_behavior,des,revenue,profit,fyearend,corAff,customer_req,salesObj,sourceoffund,quotation)
 VALUES ('','$pid','$org_culture','$org_behavior','$des','$revenue','$profit','$fyearend','$corAff','$customer_req','$salesObj','$sourceoffund','$quotation')";
// echo "$sql<br>";
 mysql_query($sql);
$ro=mysql_affected_rows();
//echo "RO=$ro<br>";
if($ro=='-1'){
 $sql="UPDATE cbp set org_culture='$org_culture',org_behavior='$org_behavior',des='$des',revenue='$revenue',profit='$profit',
 fyearend='$fyearend',corAff='$corAff' ,customer_req='$customer_req', salesObj='$salesObj',sourceoffund='$sourceoffund',quotation='$quotation'
 WHERE pid='$pid'";
 echo "$sql<br>";
 mysql_query($sql);
 $ro=mysql_affected_rows();
 //echo $ro;
 if($ro=='1')  echo "<br>Record UPDATE.<br>";
}//ro

}
if($id){
 $sql="SELECT  * from cbp where pid='$id' ";
$sqlq=mysql_query($sql);
$cbf_re=mysql_fetch_array($sqlq);
}


//bari




?>
                
                
                
<tr>
<th height="30" colspan="2"><font class="englishhead">Customer's Business and Opportunity Profile</font></th>
</tr>
<tr>
<td><br/>
<P>Describe the customer's business conditions.
 Include finance, revenue, profit and Key performance indicators.
 Identity the customer's major lines of business, affiliations, products, and markets.</P>
  
</td>
</tr>
<tr>
 <tr>
                  <table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">
                    <tr> 
                        <td width="18%">&nbsp;</td>
                            
                        <td width="86%"><textarea name="des" cols="92" rows="5"><?php echo $cbf_re['des'];?></textarea></td>
                    </tr>
                  </table>
</tr>
</table>
<br>
<br>
<table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">
<!--<tr><td width="300">Revenue</td>	<td> <input type="text" name="revenue" value="<?php echo $cbf_re['revenue'];?>" /></td></tr>
<tr><td>Profit</td>	<td> <input type="text" name="profit" value="<?php echo $cbf_re['profit'];?>" /></td></tr>
<tr><td>Fiscal Year End</td>	<td> <input type="text" name="fyearend" value="<?php echo $cbf_re['fyearend'];?>" /></td></tr>-->
    <tr><td colspan="2"><strong>Organization  Management Culture: </strong><br></td></tr>
      <tr>
                  <table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">
                    <tr> 
                        <td width="18%">&nbsp;</td>
                        
                            
                        <td width="86%">
                             <strong>
                                <input name="org_culture" type="radio" value="1" <?php if($cbf_re['org_culture']==1) echo "checked";?>>
                                <font color="#FF0000">Power Culture</font></strong> (Decisions depends on  personal influence of pursuer, reports not important)<br>

                                <input name="org_culture" type="radio" value="2" <?php if($cbf_re['org_culture']==2) echo "checked";?>>
                                    <strong><font color="#FF0000">Role Culture</font></strong> (Decisions depends on investment risk  minimization, report dependent)
                                 <br>
                                    <input name="org_culture" type="radio" value="3" <?php if($cbf_re['org_culture']==3) echo "checked";?>>
                                   <strong><font color="#FF0000">Task Culture</font></strong> (Decisions depends on Return on  Investments analysis)

                                    <br>
                            
                            
                        </td>   
                        
                    </tr>
                  </table>
</tr>
        
 
     
    <tr>
        <td colspan="2"><strong>Organization  &nbsp;Behavior:<br></td>
     </tr>
     
    <tr>
                  <table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">
                    <tr> 
                        <td width="18%">&nbsp;</td>
                        
                            
                        <td width="86%">
                            <input name="org_behavior" type="radio" value="1" <?php if($cbf_re['org_behavior']==1) echo "checked";?>>
<strong>                            <font color="#FF0000">Defender</font> </strong></strong>(Low  risk taker, works in a secure markets and use tried and trusted solutions) <br>

                            <strong>
                            <input name="org_behavior" type="radio" value="2" <?php if($cbf_re['org_behavior']==2) echo "checked";?>>
                            <font color="#FF0000">Prospector</font></strong><strong> </strong>(High risk taker, dominant  beliefs are more to do with results) <br>

                            <strong>

                            <input name="org_behavior" type="radio" value="3" <?php if($cbf_re['org_behavior']==3) echo "checked";?>>
                            <font color="#FF0000">Analyzer</font></strong><strong> </strong>(Try to balance risk and  profits, maintain core products and markets as a base to move into innovative  and risky areas)<br>
                            <input name="org_behavior" type="radio" value="3" <?php if($cbf_re['org_behavior']==4) echo "checked";?>>
                    <strong><font color="#FF0000">Reactor</font></strong><strong> </strong>(Do not have deliberate strategy, strategy emerges and  they are inclined to <em>freewheel </em>and  simply carry on living from <em>'hand to mouth'  muddling</em> through).
                         <br>
                        </td>
                  
                    </tr>
              
                  </table>
              
             </tr>
        
             
     
</table>
<br/>


<script type="text/javascript">
$(document).ready(function(){
                    var limit = 3;
                        $('input.single-checkbox').on('change', function(evt) {

                           if($(this).siblings(':checked').length >= limit) {
                               this.checked = false;
                           }
                        });
});
                        
                       
                        
                </script>

<table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">
    <tr>
  <td><strong>We can offer solutions to (choose most appropiate 3):</strong></td>	
  </tr>
  
  <tr>
      <td>
          <table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">
               <tr> 
                   <td width="18%">&nbsp;</td>
                   <td width="86%">
                       
            <!--<div id="cBox"> -->
                
       <?php     $sentence = $cbf_re['customer_req'];
       
                //$sentence = 'I love Tutorial Arena so much';
 
                // break $sentence using the space character as the delimiter
                $words = explode(',', $sentence);

                
               
      ?>      
          
		  

		  
		    
            
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="1" <?php foreach ($words as $value1){ if($value1==1) echo "checked";}?> >
             	Gain operation capacity.<br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="2" <?php foreach ($words as $value2){ if($value2==2) echo "checked";}?>>
	Reduce operation cost.<br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="3" <?php foreach ($words as $value3){ if($value3==3) echo "checked";}?> >
 	Ensure product/service quality.<br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="4" <?php foreach ($words as $value4){ if($value4==4) echo "checked";}?> >
 	Ensure operation reliability.<br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="5" <?php foreach ($words as $value5){ if($value5==5) echo "checked";}?>>
 	Expand offer variety. <br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="6" <?php foreach ($words as $value6){ if($value6==6) echo "checked";}?> >
 	Enhance customer convenience.<br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="7" <?php foreach ($words as $value7){ if($value7==7) echo "checked";}?>>
 	Build brand image. <br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="8" <?php foreach ($words as $value8){ if($value8==8) echo "checked";}?>>
 	Create barrier for competitors.<br/>
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="9" <?php foreach ($words as $value9){ if($value9==9) echo "checked";}?>>
                Get entertained (no economic gain).<br/>
				
            <input class="single-checkbox" name="customer_req[]" type="checkbox" id="customer_req[]" value="10" <?php foreach ($words as $value10){ if($value10==10) echo "checked";}?>>
 	Overcome negative consequences.<br/>
                
           <!-- </div>-->
<?php //endforeach; ?>
                   </td>

              </tr>
              
          </table>
          
      </td>
  </tr>


    
</table>
<!-------------------------address--------------------------->


<!--

<ul>
      <li><a href="#" class="example-defaults">Open window (with defaults)</a></li>
      <li><a href="#" class="example-small">Open window (custom size: 200x200)</a></li>
      <li><a href="#" class="example-callback">Open window (close callback)</a></li>
      <li><a href="#" class="center-screen">Open window (centered on screen)</a></li>
      <li><a href="#" class="center-parent">Open window (centered on parent)</a></li>
    </ul>



-->

<!------------------------address----------------------------->









<table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">  
    <tr>
        <td width="18%">
            <!--<strong>Select Company:</strong>-->
        </td> <td width="86%"><?php
//include ('add.php');
               // include ('adddisplay.php');
                 ?>

                  <br/>
                  <!--<textarea name="address" id="demo" cols="75" rows="5" style="align:left"></textarea>-->  </td>
        
        <td>
      
           
  </tr>
    
 
   <!-- <tr>
  <td><strong>Project Details</strong></td><td><textarea name="salesObj" cols="75" rows="5" style="align:left">
<?php echo $cbf_re['salesObj'];?></textarea></td></tr>
<tr>

<tr>  
    
    
  <td width="18%"><strong>SOURCE OF FUND</strong></td>
  <td width="86%"><input type="text" name="sourceoffund"  value='<?php echo $cbf_re['sourceoffund'];?>' ></td>
</tr>
<tr>
  <td><strong>BID TYPE</strong></td>
  <td><input type="text" name="quotation"  value='<?php echo $cbf_re['quotation'];?>'></td>
</tr>-->

<tr bgcolor="#666666">
<td  colspan="2">
<input type="hidden" name="ck" value="1" />

</td>
</tr>
</table>		
				
				<input type="hidden" name="pid" value="<? echo $_GET['id'];?>"><br>
			
				<? if($_GET['id']){?> 
				<input type="submit" id="inputsubmit1" name="eproject" value="Edit" class="save"><? } else {?>
				<input type="submit" id="inputsubmit1" name="nproject" value="Save" class="save"><? }?>
	  </div>
	</div>
</div></form>
<table align="center" width="100%" border="0" bordercolor="#999999" style="border-collapse:collapse">
<tr>
  <td><div align="justify"><strong><font color="#FF0000">The Power Culture</font>:</strong> Power culture is dominated by a  powerful individual at the center who controls all resources and takes  virtually all decisions. Problems arise when the organization grows too large  or complex for one person to control.<br>
    <br>
As the organization  grows the leader become unable to play all decision making role. The leader  become an Approver while a group of people surrounding him/her emerge as  Decision Makers who evaluate the information received, choose the solution and  place for approval. This group of Decision Makers creates an unofficial  syndicate called &quot;<strong>Power Circle</strong>&quot; where each Decision Maker controls  the access to different source of information for leader.
  </div></td></tr>
<tr><td><div align="justify"><strong><font color="#FF0000"><br>
  The Role Culture</font></strong><strong>: </strong>The distinguishing characteristic of  this culture is its reliance on formal, impersonal, rational rules and  procedures. It is, in short a bureaucracy by which people are controlled by  rules and regulations, such a culture is found in large, particularly publicly  owned Organization. &quot;<strong>Power Circle</strong>&quot; is official syndicate in  role culture where decision making responsibility is given to a group of officials.&nbsp; 
  <br>
  <br>
  The advantages of such a culture are  its ability to generate economies of scale and a high level of specialization  as well as the uniform standards and close control that it makes possible. 
  <br>
  <br>
  Its disadvantages are its inability to  innovate and adapt. Decisions are made considering risks related to investments  rather then returns. <br>
  </div></td></tr>
<tr><td><div align="justify"><strong><font color="#FF0000">
  <br>
  The Task Culture</font>: </strong>Task culture is concerned primarily with getting a  given task done. Importance is therefore attached to their individuals who have  the skill of knowledge to accomplish a particular task. Organizations with a  task-oriented culture are potentially very flexible, changing constantly as new  tasks arise. Innovation and creativity are highly prized for their own sake.
      <br>
      <br>
      In such organizations power is widely  distributed and is based upon expertise or competence rather than charisma or  the holding of a particular office. The values will include achievement  teamwork, openness and trust, autonomy, personal growth and development. It is  an adaptive culture, responsive to fresh ideas and new needs. It is well suited  to a highly educated, intelligent workforce. It is also appropriate in service  organizations in which front-line service personnel need to be able to provide  a flexible response to customers. &quot;<strong>Power Circle</strong>&quot; is official syndicate in  task culture where decision making responsibility is given to a team of experts.<br>
        &nbsp;&nbsp; <br>
        Its advantage is its adaptability and  innovative potential, since project teams can be formed, reformed and abandoned  according to circumstances.<br>
        <br>
Its  disadvantages are that it creates a high level of stress and conflict within  the organization, that it is difficult for senior managers to closely control  lower management because of the fluidity of the structure and the emphasis on  technical expertise rather than formal authority and that it is inherently  unstable, tending to become in crisis a power or role culture.</div></td></tr>
</table>
<br />
<br />

<!-----------------SHOW TABLE ----------------------------->
  <div id="projectnamediv">

             </div>