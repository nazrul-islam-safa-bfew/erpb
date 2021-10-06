<?
//include('global_hack.php'); 
require_once('global_hack.php'); 
/*
input: row number
return: set row color
*/
function trColor($i){
if($i%2) return " bgcolor=#E1E1FF ";
else return " bgcolor=#FFFFFF ";
}

?>
<?
/* 
return the store item group 
*/
function itemGroup($d){
$itemGroups=array('01'=>'CONSTRUCTION MATERIALS',
'02'=>'PLUMBING,SANITARY & BATHROOM FITTINGS',
'03'=>'TIMBER AND BAMBOO',
'04'=>'DOOR WINDOW AND BOARD',
'05'=>'RAW MATERIALS AND CHEMICALS',
'06'=>'GENERAL HARDWARE',
'07'=>'PACKING,GASKETS AND INSULATING MATERIALS',
'08'=>'PIPES,TUBES,HOSEES AND FITTING',
'09'=>'IRON,STEEL AND NON-FERROUS METAL',
'10'=>'PAINT AND VARNISHES',
'11'=>'FUEL,OIL AND LUBRICANTS',
'12'=>'ELECTRODE',
'13'=>'GAS,DISC AND WELDING ACCESSARIES',
'14'=>'BRUSH,EMERY,BROOM ETC',
'15'=>'CORDS,ROPES AND CHAINS',
'16'=>'SAFETY MATERIALS',
'17'=>'COMSUMABLE TOOLS',
'18'=>'ELECTRIC CABLES & WIRE',
'19'=>'ELECTRICAL FITTINGS',
'20'=>'STATIONERY MATERIALS',
'21'=>'OFFICE STATIONERY TOOL',
'22'=>'FURNITURE AND FIXTURE',
'23'=>'KITCHEN WARE, CROCKERIES AND CUTLARIES',
'24'=>'MICSCELLANEOUS',
'25'=>'TRANSPORT & MACHINERIES SPARES',
'35'=>'WELDING TOOLS',
'36'=>'PAINT & SAND BLASTING TOOLS',
'37'=>'CUTTING TOOLS',
'38'=>'MEASURING TOOLS',
'39'=>'GRINDER,PULLER,VICE,DRILL TOOLS',
'40'=>'SCREW DRIVER,HAMMER ETC',
'41'=>'FILE TOOLS',
'42'=>'CRIMPING TOOLS',
'50'=>'Cutting,Drilling & Grinding Equipment',
'51'=>'Power Equipment',
'52'=>'Welding Equipments',
'54'=>'Transport Vehicles',
'55'=>'Workshop Machineries',
'56'=>'Civil Construction Machineries & Plants',
'57'=>'Earth  Excavation Equipment',
'58'=>'Road Construction Macheniries & Plants',
'59'=>'Material Handling Machineries',
'60'=>'Pipeline Contruction Machineries',
'61'=>'Testing Equipments',
'62'=>'Elecrical Instrumental Tools',
'63'=>'Instrument Erection Equipment',
'64'=>'Survey Equipments',
'65'=>'Piling Equipments',
'66'=>'Office Equipment');

return $itemGroups[$d];;
}
?>


<?
/* ---------------------------
 Input date yyyy-mm-dd
 return number of days
------------------------------*/
function daysofmonth($d){
//echo "DDDD=$d";
return date("t",strtotime($d));
}
?>
<?
/* ---------------------------
 Input date Range
 return start date and end date of all month 
------------------------------*/
 function getMonth_sd_ed($from,$to){
/*
2006-10-12
2007-02-25


2006-10-12 2006-10-31

2006-11-01 2006-11-30
2006-12-01 2006-12-31
2007-01-01 2007-01-31

2007-02-01 2007-02-25
*/
list($year1, $month1, $day1) = explode('-', $from);
list($year2, $month2, $day2) = explode('-',$to);
         
$month = ($year2 * 12 + $month2) - ($year1 * 12 + $month1)+1;

if($month==1){
$d[0][0]=$from;
$d[0][1]=$to;
}
else{
	for($i=1;$i<=$month;$i++){
	if($i==1)
	{
	$daysofmonth=daysofmonth($from);
	$d[$i][0]=$from; 
	$d[$i][1]=date("Y-m-d",mktime(0,0,0,date('m',strtotime($from)),$daysofmonth,date('Y',strtotime($from))));
	}
	elseif($i==$month)
	{
	$j=$i-1;
	$d[$i][0]=date("Y-m-d",strtotime($d[$j][1])+86400);
	$d[$i][1]=$to;
	 }	
	 else{
	    $j=$i-1;
		$d[$i][0]=date("Y-m-d",strtotime($d[$j][1])+86400);
 	    $daysofmonth=daysofmonth($d[$i][0]);		
		$d[$i][1]=date("Y-m-d",mktime(0,0,0,date('m',strtotime($d[$i][0])),$daysofmonth,date('Y',strtotime($d[$i][0]))));
	 }
	 
	 //echo $d[$i][0].'=='.$d[$i][1]."<br>";
	}//for
}//else
//print_r ($d);
return $d;
}
//print_r (getMonths('2006-10-12','2007-02-25'));

?>
<?php
/* ---------------------------
 return Current date as Dhaka
------------------------------*/
function todat(){
putenv ('TZ=Asia/Dacca'); 
return date("Y-m-d");
}
?>


<?php
/* ---------------------------
 return Current date as Dhaka custome formate
------------------------------*/
function todat_new_format($date_formate){
putenv ('TZ=Asia/Dacca'); 
return date($date_formate,  mktime(date('H'),date('i'),date('s'),date('n'),date('j')+1,date('Y')));
}
?>


<?php
/* ---------------------------

 return current Year as Dhaka
------------------------------*/
function thisYear(){
putenv ('TZ=Asia/Dacca'); 
return date("Y");
//return "2006";
}
?>
<? 
/*
return TRUE if given year is leapyear

*/
function isLeapyear($year)
{
if($year % 400 == 0)
{ return true; }
else if($year % 4 == 0 && $year % 100 != 0)
{ return true; }
else
{ return false; }
}
?>

<?
/* ---------------------------
 Input the Project Code
 return the project Name
------------------------------*/

function myprojectName($p)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql=mysql_query(" SELECT pname FROM project where pcode= '$p' ORDER by pcode ASC") ;
 $row=mysql_num_rows($sql);
 if($row){ $pn=mysql_fetch_array($sql);
	   $pname = "$pn[pname]";
  	   return $pname;
	   }
	 return $p;
}
 ?>

<?
/* --------------------------- 
Input the Iow Code
return the IOw Name
---------------------------------*/

 function iowCode($iow)
{
 /*include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
*/
 $sqlf=mysql_query(" SELECT iowCode FROM iowtemp where iowId= '$iow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowName= "$f[iowCode]";
  	   return $iowName;
	   }
else {
 $sqlf=mysql_query(" SELECT iowCode FROM iow where iowId= '$iow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowName= "$f[iowCode]";
  	   return $iowName;
	   }
} //else
	 return 0;
}
 ?>
<?
/* --------------------------- 
Input the Iow Code
return the IOw Name
---------------------------------*/

 function iowName($iow)
{
 /*include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
*/

 $sqlf=mysql_query(" SELECT iowDes FROM iowtemp where iowId= '$iow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowDes= "$f[iowDes]";
  	   return $iowDes;
	   }
else {
 $sqlf=mysql_query(" SELECT iowDes FROM iow where iowId= '$iow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowDes= "$f[iowDes]";
  	   return $iowDes;
	   }

	 else return 0;
	 }
}
 ?>

<?
/* --------------------------- 
Input the Iow Code
return the SIOw Code
---------------------------------*/

 function siowCode($iow)
{
 $sqlq=" SELECT siowCode FROM siowtemp where iowId= '$iow' ORDER by siowCode DESC" ;
 //echo  $sqlq;
 $sqlf=mysql_query($sqlq) ;
 $rowf=mysql_fetch_array($sqlf);

 if($rowf[siowCode])$inv=ord($rowf[siowCode]);
  else $inv=65;
 if($inv<65) $inv=65; 
 $siowCode= $inv+1;
  	   return chr($siowCode);
  }
 ?>
<?
/* --------------------------- 
Input the siow Code
return the  SIOw Name
---------------------------------*/

 function viewsiowCode($siow)
{

 $sqlf=mysql_query(" SELECT siowCode FROM siowtemp where siowId= '$siow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $siowCode= "$f[siowCode]";
  	   return $siowCode;
	   }
else {
 $sqlf=mysql_query(" SELECT siowCode FROM siow where siowId= '$siow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $siowCode= "$f[siowCode]";
  	   return $siowCode;
	   }
	 else return 0;
	 }
}
 ?>
<?
/* --------------------------- 
Input the Iow Code
return the View SIOw Name
---------------------------------*/

 function viewiowCode($iow)
{

 $sqlf=mysql_query(" SELECT iowCode FROM iowtemp where iowId= '$iow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowCode= "$f[iowCode]";
  	   return $iowCode;
	   }
else{
 $sqlf=mysql_query(" SELECT iowCode FROM iow where iowId= '$iow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowCode= "$f[iowCode]";
  	   return $iowCode;
	   }
   else 	 return 0;	   
  }	   

}
 ?>

<?
/* --------------------------- 
Input the Iow Code
return the IOW Quantity and Unit
---------------------------------*/

 function iowQty($iow)
{

 $sqlff=" SELECT iowQty,iowUnit FROM iowtemp where iowId= '$iow'" ;
 //echo $sqlff;
 $sqlf=mysql_query($sqlff) ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowQty= "$f[iowQty] $f[iowUnit]";
  	   return $iowQty;
	   }
 else {
 $sqlff=" SELECT iowQty,iowUnit FROM iow where iowId= '$iow'" ;
 //echo $sqlff;
 $sqlf=mysql_query($sqlff) ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $iowQty= "$f[iowQty] $f[iowUnit]";
  	   return $iowQty;
	   }
  }
	 return 0;
}
 ?>

<?
/*-------------------------------
 Input the SIow Code
 return the SIOw Name
---------------------------------*/

 function siowName($siow)
{
 $sqlf=mysql_query(" SELECT siowName FROM siow where siowId= '$siow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $siowName= "$f[siowName]";
  	   return $siowName;
	   }

	 return 0;
}
 ?>


<?
/*-------------------------------
Input the SIow Code
return the days to go by material at hand
---------------------------------*/

 function siowDay($siow,$actual,$issued,$stock)
{
 $sqlf=mysql_query(" SELECT siowSdate,siowCdate FROM siow where siowId= '$siow'") ;
 $rowf=mysql_num_rows($sqlf);
  
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $sdate= strtotime($f[siowSdate]);
	   $edate= strtotime($f[siowCdate]);
	   $todat=time();
	   if($todat<$sdate)
	   $sdate=$sdate;
	   $sdate=$todat;	   
	   
	   $duration= $edate-$sdate;
	   
     $duration=floor($duration/(3600*24));// duration
	   
// echo "$duration,$actual,$issued,$stock";	   
 if($duration>0){
	   $remainingQty=$actual-$issued; // remaining Qty for 
	   $perDay=$remainingQty/$duration; // per day can be issued
	   $actualPerDay=$stock/$perDay; // actual

	   $siowDate=floor($actualPerDay);
  	   //return "duration: $duration,remainingQty: $remainingQty,perDay: $perDay,stock: $stock==$siowDate";
	   return $siowDate;
	   } // if
	 else return 0;	   
	 }// if  

	 else return 0;
}
 ?>


<?
/*--------------------------------
Input the SIow Code
return the SIOw Qty and Unit
---------------------------------*/

 function siowQty($siow)
{
 $sqlf=mysql_query(" SELECT siowQty,siowUnit FROM siow where siowId= '$siow'") ;
 $rowf=mysql_num_rows($sqlf);
 if($rowf){ $f=mysql_fetch_array($sqlf);
	   $siowQty= "$f[siowQty], $f[siowUnit]";
  	   return $siowQty;
	   }
	 return 0;
}
 ?>

<?
/*-------------------------------
Input Validation Date
return Font Color>> if over then red else Black
---------------------------------*/
function valid($d){
	$validTill = $d;
    $lastmonth = date("Y-m-j",mktime(0, 0, 0, date("m", strtotime($validTill))-1, date("d", strtotime($validTill)),   date("Y", strtotime($validTill)) ));
    $now = date("Y-m-j",mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
	
	if($lastmonth < $now)
	{$c="<font style='color:#FF0000; TEXT-DECORATION: underline'>"; }
	else {$c="<font color=#000000>"; }
  return $c;
}

function valid1($d){
	$validTill = $d;
    $lastmonth = date("Y-m-j",mktime(0, 0, 0, date("m", strtotime($validTill)), date("d", strtotime($validTill)),   date("Y", strtotime($validTill)) ));
	
    $now = date("Y-m-j",mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
	if($lastmonth < $now)
	{$c=0; }
	else {$c=1; }

  return $c;
}

?>


<?
// Input  $n=selection name; $ex=extra; $s=selected project name
// return project list with selected project heighlited

function selectPlist($n,$ex,$s){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlp = "SELECT `pcode`,pname from `project` ORDER by pcode ASC";
//echo $sqlp;
$sqlrunp= mysql_query($sqlp);
 
$plist= "<select name='$n'> ";
 if(sizeof($ex)>1){
 for($i=0; $i< sizeof($ex); $i++){
 $plist.= "<option value='".$ex[$i]."'";
 if($s==$ex[$i])  $plist.= " SELECTED";
 $plist.= ">$ex[$i]</option>  ";
 }
 }


 while($typel= mysql_fetch_array($sqlrunp))
{
 $plist.= "<option value='".$typel[pcode]."'";
 if($s==$typel[pcode])  $plist.= " SELECTED";
 $plist.= ">$typel[pcode]--$typel[pname]</option>  ";
 }
 $plist.= '</select>';
 return $plist;
 }
?>

<?
/*
formate date like "dd-mm-yyyy"
 Input  Date Y-m-j
 return Date d-m-Y
*/
function myDate($d){
return date("d-m-Y", strtotime($d));
}
?>

<?
/*-------------------------------
Input the ItemCode Code
return the Item Description
---------------------------------*/
function itemDes($p)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sqlf=" SELECT * FROM itemlist where itemCode='$p'";
//echo  $sqlf;
 $sqlq=mysql_query($sqlf); 
     $pn=mysql_fetch_array($sqlq);
	 $itemDescription= array("des"=>$pn[itemDes],"spc"=>$pn[itemSpec],'unit'=>$pn[itemUnit]);
	 return $itemDescription;
}
 ?>
 

<?
/*--------------------------------
 Input the ItemCode Code
 return the Item Type
---------------------------------*/

function itemType($a){
 $sql="SELECT itemType FROM itemlist WHERE itemCode = '$a'";
//echo '<br>'.$sql.'<br>';
 $sql=mysql_query($sql); 
 $pn=mysql_fetch_array($sql);
 
return $pn[itemType];
}
?>

<?
/*-------------------------------
calculate equipment rent rate

 Input the cost,salvageValue,life,uses
 return rent Rate
 ---------------------------------*/

function rentRate($cost,$salvageValue,$life,$days,$hours){
//echo "cost:$cost,salvageValue:$salvageValue,life:$life,days:$days,hours:$hours<br>";
if($cost AND $salvageValue AND $life AND $days AND $hours){
	$dep = ($cost-$salvageValue)/$life ; // as Straigth Line method

	$rateY= $dep; // per Year
	 $rateM= 3* ($rateY/$days); // per Month
	 $rateD= $rateM/30; // per Day	 
	 
	if($rateD<0) return '0';
	else 
	return number_format($rateD);
}
return '0';
}
?>

<? 
/*-------------------------------
calculate tool rate

first try to calculate tool rate from bfew center store tool if tool is not available then

input tool code
output rent rate
---------------------------------*/
function toolRate($toolCode){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT max(rate) as rate from store where itemCode = '$toolCode'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
     $pn=mysql_fetch_array($sqlQuery);
	 $toolRate = $pn[rate];
	 $vendor='99';
/*if tool does not find in store search in quotation*/	 
if($toolRate<=0){
 $sql="SELECT quotation.*, vendor.vid from quotation,vendor where".
 " quotation.itemCode = '$toolCode'  AND quotation.vid= vendor.vid order by point DESC";
//echo $sql;
 $sqlQuery=mysql_query($sql);
     $pn=mysql_fetch_array($sqlQuery);
	 $toolRate = $pn[rate];
	 $vendor=$pn[vid];
}
/* now calculate per hour rate of tool*/
 $sql1="SELECT * FROM toolrate WHERE itemCode ='$toolCode' ";
//echo '<br>'.$sql1.'<br>';
 $sql1=mysql_query($sql1); 
 $pn1=mysql_fetch_array($sql1);
 $cost=$toolRate;
 $salvageValue=$cost*($pn1[salvageValue]/100);
 $life=$pn1[life];
 
if($cost AND $life){
	$dep = ($cost-$salvageValue)/($life*30) ; // as Straigth Line method rate per day
	$rateD= 2*$dep;
	$rateH= $rateD/8;	//rate per hour

	if($rateH<0) $rateH="$vendor_0";
	else $rateH=$vendor.'_'.$rateH;
	return $rateH;
}
	else return 0;

return $vendor.'_'.$toolRate;	
}
?>
<? 
/*---------------------------
input: equipment Code
output: equipment  Rate from vendor
---------------------------------*/
function toolVendorRate($code){
 $sql="SELECT quotation.*, vendor.vid 
 from quotation,vendor 
 where quotation.itemCode = '$code'  
 AND quotation.vid= vendor.vid order by point DESC";
//echo $sql;
 $sqlQuery=mysql_query($sql);
     $pn=mysql_fetch_array($sqlQuery);

     $ftemp = toolSalvage($code);	 
	 $rate=($pn[rate]-($pn[rate]*$ftemp[salvageValue]))/$ftemp[life];
	 //$rate= $pn[rate];
	  $eqRate = $pn[vid].'_'.$rate*4;
	 return $eqRate;
}
?>

<? 
/*---------------------------
input: code
output: salvage value
---------------------------------*/
function toolSalvage($Code){
 $sql="SELECT * from toolrate where itemCode = '$Code'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
     $pn=mysql_fetch_array($sqlQuery);	 
	 $salvageValue=$pn[salvageValue]/100;
	 $life=$pn[life]*30;
	 $salvage=array('salvageValue'=>$salvageValue,'life'=>$life);
	 return $salvage;
}
?>


<?
/*----------------------------------
 Input the equipment Code
 return the equipment Condation
---------------------------------*/
function eqCondition($a){

$condition = array('1'=> 'Good','2'=> 'Periodic Maintenence',
'3'=> 'Breakdown Maintenence','4'=> 'Unrepairable',
'5'=> 'New','6'=> 'Re-conditioned','7'=> 'Used'
);

return '<font color="#FF3333">'.$condition[$a].'</font>';
}
?>

<?
// error message genarotor

function errMsg($m){
$errorMsg= "<table width=400 align=center border=1 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td background=../images/tbl_error.png><font color=#FFFFFF> ERROR</font></td></tr>";
$errorMsg.="<tr><td>";
$errorMsg.="<p><font face=Verdana size=1 color=red><b> $m </font><b><p>";
$errorMsg.="</td>";
$errorMsg.="</tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>

<?
// error message genarotor

function inerrMsg($m){
$errorMsg= "<table width=400 align=center border=1 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td background=./images/tbl_error.png><font color=#FFFFFF> ERROR</font></td></tr>";
$errorMsg.="<tr><td>";
$errorMsg.="<p><font face=Verdana size=1 color=red><b> $m </font><b><p>";
$errorMsg.="</td>";
$errorMsg.="</tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>

<?
/*----------------------------------
INPUT: mysql query
OUTPUT: mysql result seet
---------------------------------*/

function safeQuery($query){
include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
//echo $sqlf;
$sqlrunf= mysql_query($query)
          or die("query failed:"
		         ."<li>errorno=".mysql_errno()
				 ."<li>error=".mysql_error()
				 ."<li>query=".$query
		  ) ;
return $sqlrunf;
}

?>

<? 
/*-------------------------------
INPUT: dd/mm/yyyy
OUTPUT: formate date
---------------------------------*/
function formatDate($date,$format){
if (ereg ("([0-9]{2})/([0-9]{2})/([0-9]{4})", $date, $regs)) {
	return date($format, mktime(0,0,0,$regs[2], $regs[1], $regs[3]));
  }
}
?>


<?
/*---------------------------------
INPUT : project code; vemdor id; puchase order type
type 1: material and sub contract
type 2: equipment rent
tyoe 4: equipment purchase
OUTPUT: perchase order serial NO
---------------------------------*/
function posl($p,$v,$t){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

if($t==1){ $sql=" SELECT posl FROM `pordertemp` WHERE posl Like 'PO_%' AND potype IN ('1','3') ORDER by poid DESC";

$posl='PO_';
}
if($t==2) {
 $sql=" SELECT posl FROM `pordertemp` WHERE posl Like 'EQ_%' AND potype='2' ORDER by poid DESC";
 $posl='EQ_';
}
if($t==4) { $sql=" SELECT posl FROM `pordertemp` 
WHERE posl Like 'EQP_%' AND potype='4' ORDER by poid DESC";
$posl='EQP_';
}
// echo "$sql";
 $sqlQuery=mysql_query($sql);
 $sqlf=mysql_fetch_array($sqlQuery);
 //echo $sqlf[posl].'<br>';
 $tpo=explode('_',$sqlf[posl]);

 $pn=mysql_num_rows($sqlQuery)+1;
 $pn=$tpo[2]+1; // increment by 1
 if($pn < 10) $pn="0000$pn";
 else if($pn < 100) $pn="000$pn";
 else if($pn < 1000) $pn="00$pn"; 
 else if($pn < 10000) $pn="0$pn"; 

$posl=$posl.$p.'_'.$pn.'_'.$v ; // format purchase order

/*$sql="select posl from `pordertemp` where posl='$posl' ";
$sqlq=mysql_query($sql);
$num_rows = mysql_num_rows($sqlq);
if($num_rows>=1) {echo "There is may be some ERROR..<br>please Contact with ERP administrator.."; exit;}
else return $posl;
*/
return $posl;
}
?>
<?
/*---------------------------------
INPUT: project code
OUTPUT: store teturn serial no.
---------------------------------*/
function storeReturnsl($p){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sql=" SELECT rsl FROM `storet` WHERE rsl LIKE 'SR_".$p."_%' ORDER by rsl DESC";
//echo "<br>$sql<br>";

$sqlQuery=mysql_query($sql);
$sqlf=mysql_fetch_array($sqlQuery);

$t=explode('_',$sqlf[rsl]);

	 $num_rows=$t[2]+1;
	 if($num_rows<10) $po="0000$num_rows";
	 else if($num_rows<100) $po="000$num_rows";	 
	 else if($num_rows<1000) $po="00$num_rows";	 	 
	 else if($num_rows<10000) $po="0$num_rows";	 	 
	  else $po=$num_rows;
	  $sl="SR_".$p."_".$po;	 	 
return $sl;
}
?>

<?
/*-------------------------------
input: project Code and Item Code
return: total purchase Ordered Quantity
---------------------------------*/
function orderQty($p,$q){
$orderQtyf=0;
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlf="SELECT SUM(qty) as orderQtyf from pordertemp WHERE location='$p' and itemCode='$q'";
//echo $sqlf;
 $sqlQueryf=mysql_query($sqlf);
 $sqlRunf=mysql_fetch_array($sqlQueryf);
 $orderQtyf1=$sqlRunf[orderQtyf];
 
$sqlf="SELECT SUM(qty) as orderQtyf from porder WHERE location='$p' and itemCode='$q' AND posl LIKE 'EP_%'";
//echo $sqlf;
 $sqlQueryf=mysql_query($sqlf);
 $sqlRunf=mysql_fetch_array($sqlQueryf);
 $orderQtyf2=$sqlRunf[orderQtyf];
 
 $orderQty=$orderQtyf1+$orderQtyf2;
 
 if($orderQty>0) return $orderQty;
  else return 0;
}
?>
<?
/*-------------------------------
input: project Code and Item Code
return: total purchase order qty in purchase order revesion/create mode 

calculate total purchase order qty except give porder 
---------------------------------*/
function orderQty_temp($p,$q,$posl){
$orderQtyf=0;
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
$sqlf="SELECT SUM(qty) as orderQtyf from pordertemp WHERE location='$p' and itemCode='$q' AND posl <>'$posl'";
//echo $sqlf;
 $sqlQueryf=mysql_query($sqlf);
 $sqlRunf=mysql_fetch_array($sqlQueryf);
 $orderQtyf1=$sqlRunf[orderQtyf];
 
$sqlf="SELECT SUM(qty) as orderQtyf from porder WHERE location='$p' and itemCode='$q' AND posl LIKE 'EP_%'";
//echo $sqlf;
 $sqlQueryf=mysql_query($sqlf);
 $sqlRunf=mysql_fetch_array($sqlQueryf);
 $orderQtyf2=$sqlRunf[orderQtyf];
 
 $orderQty=$orderQtyf1+$orderQtyf2;
 
 if($orderQty>0) return $orderQty;
  else return 0;
}
?>


<? 
/*-------------------------------
input: project Code and Item Code
return: total approved Quantity in iow of given project and itemCode
---------------------------------*/

function totaldmaQty($p,$ic){
$totalQtyf=0;
$sqlf="SELECT SUM(dmaQty) as dmaTotal 
from dma 
WHERE  dmaItemCode='$ic' AND dmaProjectCode='$p' AND dmaRate <>0";


/*$sqlf="SELECT SUM(dmaQty) as dmaTotal from dma,iow WHERE 
 iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow 
AND dmaItemCode='$ic' AND dmaProjectCode='$p' AND dmaRate <>0";
*/
//	echo "<br>$sqlf<br>";
 $sqlQueryf=mysql_query($sqlf);
 $sqlRunf=mysql_fetch_array($sqlQueryf);
 $totalQtyf=$sqlRunf[dmaTotal];
 if($totalQtyf>0) return $totalQtyf;
  else return 0;
}
?>

<? 
/*-------------------------------
input: project Code and Item Code
return: total approved Quantity in iow of given project and itemCode
---------------------------------*/
//created function by salma
function dRate($ic){
$sqlf="SELECT MAX(dmaRate) as dmaRate from dma WHERE  dmaItemCode='$ic' order by dmaDate desc limit 0,1";


/*$sqlf="SELECT SUM(dmaQty) as dmaTotal from dma,iow WHERE 
 iowStatus IN ('Approved by Mngr P&C','Approved by MD') AND iow.iowId=dma.dmaiow 
AND dmaItemCode='$ic' AND dmaProjectCode='$p' AND dmaRate <>0";
*/
//	echo "<br>$sqlf<br>";
 $sqlQueryf=mysql_query($sqlf);
 $sqlRunf=mysql_fetch_array($sqlQueryf);
 $drate=$sqlRunf[dmaRate];
 if($drate>0) return $drate;
  else return 0;
}
?>

<?
/*---------------------------------
input vendor ID 
 output vendor Name and rating
 ---------------------------------*/
function vendorName($v){
if($v){
 $vendor = "SELECT * FROM vendor WHERE vid=$v";
// echo '<br>'.$vendor.'<br>';
$sqlrunvendor= mysql_query($vendor);
$ven= mysql_fetch_array($sqlrunvendor);

$vendor=array('vname'=>$ven[vname],'rating'=>$ven[point]);
return $vendor;
}
 else return 'Not found';
}
?>
<?
/*---------------------------------
input vendor ID 
 output vendor Name
 ---------------------------------*/
function vName($v){
 $vendor = "SELECT vname FROM vendor WHERE vid=$v";
//echo $vendor.'<br>';
$sqlrunvendor= mysql_query($vendor);
$ven= mysql_fetch_array($sqlrunvendor);
return $ven[vname];
}
?>


<?
/*---------------------------------
enter iow Code
return total material Cost of that Iow
---------------------------------*/
function materialCost($iow){
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as materialRate 
 FROM `dma` WHERE dmaiow=$iow AND  dmaItemCode between '01-00-000' AND '39-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlRunf= mysql_fetch_array($sqlQ);
return $sqlRunf[materialRate];
}
?>
<?
/*-------------------------------
enter iow Code
return total equipment Cost of that Iow
---------------------------------*/
function equipmentCost($iow){
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as equipmentRate 
 FROM `dma` WHERE dmaiow=$iow AND  dmaItemCode between '50-00-000' AND '69-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlRunf= mysql_fetch_array($sqlQ);
return $sqlRunf[equipmentRate];
}
?>

<?
/*--------------------------------
enter iow Code
return total human Cost of that Iow
---------------------------------*/
function humanCost($iow){
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as humanRate 
 FROM `dma` WHERE dmaiow=$iow AND  dmaItemCode between '70-00-000' AND '99-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlRunf= mysql_fetch_array($sqlQ);
return $sqlRunf[humanRate];
}
?>

<?
/*---------------------------------
enter siow Code
return total material Cost of that sIow
---------------------------------*/
function siow_materialCost($siow){
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as materialRate 
 FROM `dma` WHERE dmasiow=$siow AND  dmaItemCode between '01-00-000' AND '39-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlRunf= mysql_fetch_array($sqlQ);
return $sqlRunf[materialRate];
}
?>
<?
/*-------------------------------
enter siow Code
return total equipment Cost of that sIow
---------------------------------*/
function siow_equipmentCost($siow){
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as equipmentRate 
 FROM `dma` WHERE dmasiow=$siow AND  dmaItemCode between '50-00-000' AND '69-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlRunf= mysql_fetch_array($sqlQ);
return $sqlRunf[equipmentRate];
}
?>

<?
/*--------------------------------
enter siow Code
return total human Cost of that sIow
---------------------------------*/
function siow_humanCost($siow){
 $sqlf = "SELECT SUM(dmaRate*dmaQty) as humanRate 
 FROM `dma` WHERE dmasiow=$siow AND  dmaItemCode between '70-00-000' AND '99-99-999'";
//echo $sqlf.'<br>';
$sqlQ= mysql_query($sqlf);
$sqlRunf= mysql_fetch_array($sqlQ);
return $sqlRunf[humanRate];
}
?>

<? 
/*---------------------------
input: itemCode Code
output: total quotation Found
---------------------------------*/
function quotationNo($itemCode,$p){
if($p=='0'){
 $sql="SELECT * from quotation where quotation.itemCode = '$itemCode' AND type='1'";
//echo $sql.'AAAA';
 $sqlQuery=mysql_query($sql);
 $pn=mysql_num_rows($sqlQuery);
 $qutNo =  $pn;

}
elseif($p=='1'){
 $sql="SELECT * from quotation where quotation.itemCode = '$itemCode'";
//echo $sql.'AAAA';
 $sqlQuery=mysql_query($sql);
 $pn=mysql_num_rows($sqlQuery);
 $qutNo =  $pn;

}
else{
 $sql="SELECT * from quotation where quotation.itemCode = '$itemCode' AND pCode in ( '$p','000')";
 //echo $sql;
 $sqlQuery=mysql_query($sql);
 $pn=mysql_num_rows($sqlQuery);
 $qutNo =  $pn;
  
 $sql="SELECT itemCode from equipment where itemCode = '$itemCode' ";
 //echo $sql;
 $sqlQuery=mysql_query($sql);
 $pn=mysql_num_rows($sqlQuery);
 if($pn>0)  $qutNo += 1;

 $sql="SELECT itemCode from store where itemCode = '$itemCode' ";
 //echo $sql;
 $sqlQuery=mysql_query($sql);
 $pn=mysql_num_rows($sqlQuery);
 if($pn>0)  $qutNo += 1;
}
 return $qutNo;
}
?>

<? 
/*---------------------------
input: itemCode Code
output: total quotation Found
---------------------------------*/
function isquotationNo($itemCode){
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

  
 $sql="SELECT itemCode from equipment where itemCode = '$itemCode' ";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $pn=mysql_num_rows($sqlQuery);
 if($pn>0)  $qutNo = 1;

 $sql="SELECT itemCode from store where itemCode = '$itemCode' ";
 //echo $sql;
 $sqlQuery=mysql_query($sql);
 $pn=mysql_num_rows($sqlQuery);
 if($pn>0)  $qutNo = 1;

 return $qutNo;
}
?>


<?

/*---------------------------
input: seconds
output: h:m:s
---------------------------------*/

function sec2hms($sec,$padHours=false)
{
//echo $sec;
$sec=$sec*3600;
//holdes formated string
$hms="";
//there are 360 seconds in an hour,so if we divide total seconds by 3600 and throw away the remainder, we've got the number of hours
$hours=intval($sec/3600);
//echo $hours.'<br>';
// add to $hms, with a leading 0 if asked for
$hms.=($padHours)? str_pad($hours,2, "0", STR_PAD_LEFT).':' : $hours.':';
//dividing the total seconds by 60 will givesus the number of minutes, but we're interested in minutes past the hour: to get that, we need to divided by 60 again and keep the remainder
$minutes = intval(($sec / 60) % 60);
//echo $minutes.'<br>';
// then add to $hms (with a leading 0 if needed)
$hms.= str_pad($minutes,2, "0", STR_PAD_LEFT);

//seconds are simple- just divided the total seconds by 60 and keep the remainder

//$seconds=intval($sec % 60);
// add to $hms, again a leading 0 if needed
//$hms.= str_pad($seconds,2, "0", STR_PAD_LEFT);
return $hms;
}

?>

<?
/*---------------------------
input: posl, itemCode Code, project
output: total remain Qty in this proder
---------------------------------*/

function remainQty6($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $remainQty0=mysql_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];

 $sql1="SELECT sum(receiveQty) as total from  `store` where itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 $remainQty1[total];
$remainQty= $order- $remainQty1[total];

 return $remainQty;
}


function remainQty($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $remainQty0=mysql_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];

 $sql1="SELECT sum(receiveQty) as total from  `store$pp` where paymentSL = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];

 return $remainQty;
}
?>
<?
/*---------------------------
input: posl, itemCode Code
output: total remain equipment 
---------------------------------*/

function eqp_remainQty($posl,$item){
 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $remainQty0=mysql_fetch_array($sqlQuery);
 $order=  $remainQty0[qty];

 $sql1="SELECT COUNT(eqid) as total from  `equipment` where reference = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];
 return $remainQty;
}
?>

<?
/*---------------------------
input: posl, itemCode Code
output: total remain Qty for receive from store in transit to store
---------------------------------*/

function remainQty_storet($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * from  porder where posl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $remainQty0=mysql_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];

 $sql1="SELECT sum(receiveQty) as total from  `storet$pp` where reference = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];

 return $remainQty;
}
?>


<?
/*---------------------------
input: posl, itemCode Code
output: total remain Qty
---------------------------------*/
/*
function cstoreRemainQty($posl,$item,$pp){
 include("config.inc.php");
 //include("session.inc.php"); 
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * from  sporder where sposl = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $remainQty0=mysql_fetch_array($sqlQuery);
 
$order=  $remainQty0[qty];

 $sql1="SELECT sum(receiveQty) as total from  `store$pp` where paymentSL = '$posl' AND itemCode ='$item'";
//echo '<br>'.$sql1.'<br>';
 $sqlQuery1=mysql_query($sql1);
 $remainQty1=mysql_fetch_array($sqlQuery1);
 $remainQty= $order- $remainQty1[total];

 return $remainQty;
}
*/
?>




<?
/*---------------------------------
INPUT: project code , iow status
OUTPUT:  total iow in that status
---------------------------------*/
function countiow($d,$p){
 $sql="SELECT count(*) as total FROM `iowtemp` WHERE iowProjectCode LIKE '%$p%' AND iowStatus LIKE '%$d%'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 return $rr[total];
}
?>
<?
/*---------------------------------
INPUT: project code , iow status
OUTPUT:  total approved iow
---------------------------------*/
function countapviow($d,$p){
 $sql="SELECT count(*) as total FROM `iow` WHERE iowProjectCode LIKE '%$p%' AND iowStatus LIKE '%$d%'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 return $rr[total];
}
?>

<?
/*---------------------------------
INPUT: invoiceStatus
OUTPUT:  total invoice number in that Status
---------------------------------*/
function countInvoice($d){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT DISTINCT invoiceNo FROM `invoice` WHERE invoiceStatus='$d' ";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_num_rows($sqlQuery);
return $rr;
}

/*---------------------------------
INPUT: invoiceStatus
OUTPUT:  total invoice number in that Status
---------------------------------*/
function countVoucher($d){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT COUNT(id) as total FROM `voucher` WHERE voucherStatus='$d' ";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
return $rr[total];
}

?>
<?
/*
function iowProgress_preport($d,$id){
//echo "-DAYY$d-";
//$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
//echo $sql.'<br>';
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(86400));
	 $qty=$rr[iowQty];
	 
	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	 $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';	 

return "Planned $tillyesterdayWork <font class=out>$rr[iowUnit]</font> ($ptillyesterdayWork%), ";	 
	}
	else 
return "Planned $rr[iowQty]$rr[iowUnit] <font class=out> (100%)</font>, ";	 
}
else 
return "Planned 0 $rr[iowUnit] <font class=out>(0%)</font>, ";	 
}
?>
<?

function iowActualProgress_preport($d,$id,$p){
$worked=0;
//echo $d;
//$d=formatDate($d,'Y-m-j');
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(qty) as total FROM `iowdaily` WHERE iowId=$id AND edate<='$d'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
if($rr[total]) $worked = $rr[total];
 
  $sql1="SELECT iowQty,iowUnit FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery1=mysql_query($sql1);
 $rr1=mysql_fetch_array($sqlQuery1);
 
 if($rr1[iowUnit]=='L.S' OR $rr1[iowUnit]=='LS' OR $rr1[iowUnit]=='l.s' OR $rr1[iowUnit]=='l.s') 
{
 $pworked= $worked;
 $worked= ''; 
} 
else {
 $qt=$rr1[iowQty];
 if($qt>0) $pworked= round(($worked*100)/$qt);
}
//  echo "$worked  <font class=out>$rr1[iowUnit]</font> ($pworked%)";
  
 if($p) return "Actual ".$worked." ".$rr1[iowUnit]." <font class=out>(".$pworked."%)</font>";
 //printiowActualProgress_preport($rr1[iowUnit],$worked,$pworked);
else return $worked;  

}
function printiowActualProgress_preport($unit,$worked,$qt)
{
return "Actual $worked $unit <font class=out>($qt%)</font>;";	 
}
*/
?>


<?
function iowProgress($d,$id){
//echo "-DAYY$d-";
$d=formatDate($d,'Y-m-d');

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
	 $qty=$rr[iowQty];
	 
	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	  $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';	 

echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $tillyesterdayWork $rr[iowUnit]</td>
 <td width=30% align=right> <font class=out>($ptillyesterdayWork%)</font></td> 
</tr>
</table>
";	 
	//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
	}
	else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $rr[iowQty] $rr[iowUnit]</td>
 <td width=30% align=right> <font class=out>(100%)</font></td> 
</tr>
</table>
";	 
	
	//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
}
else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> 0 $rr[iowUnit]</td>
 <td width=30% align=right> <font class=out>(0%)</font></td> 
</tr>
</table>
";	 

//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';

}
?>
<?
function iowProgress_income_statement($d,$id){
//echo "-DAYY$d-";
$d=formatDate($d,'Y-m-d');

  $sql="SELECT * FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
	 $qty=$rr[iowQty];
	 
	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	  $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $tillyesterdayWork='';	 

 return $ptillyesterdayWork	; 
	//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
	}
	else 
return 100;
	
	//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
}
else 
return 0;

//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';

}
?>

<?
function iowProgress_for_incomestatement($d,$id)
{
/*
$d=formatDate($d,'Y-m-d');

 $sql="SELECT * FROM `iow` WHERE iowId=$id";
 $sqlQuery=mysql_query($sql);
  $ppper=0;
 while($rr=mysql_fetch_array($sqlQuery))
 {
 $sd=$rr[iowSdate];
 $cd=$rr[iowCdate]; 
if($sd<=$d)
{
	 if($d<=$cd)
	 {
		 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
		 $qty=$rr[iowQty];
		 
		 if($rr[iowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
		
		 $perdayWork=$qty/$duration;
		 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-86400)/(86400)));
		 $tillyesterdayWork=round($dayesGone*$perdayWork);
		 $ptillyesterdayWork = ($tillyesterdayWork*100)/$qty; ///ai logic a dhuktasa?
		 
		 $ppper+=round($ptillyesterdayWork);
	
			 
	}
	else 
		echo "<font class=out>(100%)</font>";	 
}
else 
	echo " <font class=out>(0%)</font>";	 
}
echo "<font class=out>($ppper%)</font>";*/
}
?>
<?

function iowActualProgress1($d,$id,$p){
$worked=0;
$d=formatDate($d,'Y-m-j');
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT SUM(qty) as total FROM `iowdaily` WHERE iowId=$id AND edate<='$d'";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $worked = $rr[total];
 
  $sql1="SELECT iowQty,iowUnit FROM `iow` WHERE iowId=$id";
//echo $sql;
 $sqlQuery1=mysql_query($sql1);
 $rr1=mysql_fetch_array($sqlQuery1);
 
 if($rr1[iowUnit]=='L.S' OR $rr1[iowUnit]=='LS' OR $rr1[iowUnit]=='l.s' OR $rr1[iowUnit]=='l.s') 
{
 $pworked= $worked;
 $worked= ''; 
} 
else {

 $qt=$rr1[iowQty];
 if($qt>0) $pworked= round(($worked*100)/$qt);
}
//  echo "$worked  <font class=out>$rr1[iowUnit]</font> ($pworked%)";
  
 if($p) printiowActualProgress1($rr1[iowUnit],$worked,$pworked);
  
//return  0;
}
function printiowActualProgress1($unit,$worked,$qt)
{
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right>  </td>
 <td width=30% align=right> $qt%</td> 
</tr>
</table>";	 
}
?>

<?

function siowProgress($d,$id){
//echo "-DAYY$d-";
$d=formatDate($d,'Y-m-d');
 include("config.inc.php");
 $db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

 $sql="SELECT * FROM `siow` WHERE siowId=$id";
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
 $sd=$rr[siowSdate];
 $cd=$rr[siowCdate]; 
//echo "$d<=$cd<br>";
if($sd<=$d){
	 if($d<=$cd){
	 $duration=round((strtotime($cd)-strtotime($sd))/(84000));
	 $qty=$rr[siowQty];
	 
	 if($rr[siowUnit]=='L.S' OR $rr[iowUnit]=='LS' OR $rr[iowUnit]=='l.s' OR $rr[iowUnit]=='l.s') $qty=100;
	
	 $perdayWork=$qty/$duration;
	 $dayesGone=abs(round((strtotime($d)-strtotime($sd)-84000)/(84000)));
	 $tillyesterdayWork=round($dayesGone*$perdayWork);
	 $ptillyesterdayWork = round(($tillyesterdayWork*100)/$qty);

	 if($rr[siowUnit]=='L.S' OR $rr[siowUnit]=='LS' OR $rr[siowUnit]=='l.s' OR $rr[siowUnit]=='l.s') $tillyesterdayWork='';	 

echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $tillyesterdayWork $rr[siowUnit]</td>
 <td width=30% align=right> <font class=out>($ptillyesterdayWork%)</font></td> 
</tr>
</table>
";	 
	//echo  $tillyesterdayWork.'  <font class=out>'.$rr[iowUnit].'</font>'.' ('.$ptillyesterdayWork.'%) ';
	}
	else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> $rr[siowQty] $rr[siowUnit]</td>
 <td width=30% align=right> <font class=out>(100%)</font></td> 
</tr>
</table>
";	 
	
	//echo  $rr[iowQty].'  <font class=out>'.$rr[iowUnit].'</font>'.' (100%) ';
}
else 
echo "
<table width=100% cellpadding=1 cellspacing=0 >
<tr>
 <td width=70% align=right> 0 $rr[siowUnit]</td>
 <td width=30% align=right> <font class=out>(0%)</font></td> 
</tr>
</table>
";	 

//echo  '00  <font class=out>'.$rr[iowUnit].'</font>'.' (0%) ';

}

?>

<?
/*---------------------------------
INPUT: status 
OUTPUT:  total number in that status
---------------------------------*/
function countpo($p){

 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

if($p==-1)  $sql="SELECT count(distinct posl) as total FROM `pordertemp` WHERE status='$p' AND posl not like 'EP_%'"; 
else if($p==0)  $sql="SELECT count(distinct posl) as total FROM `pordertemp` WHERE status='$p' AND posl not like 'EP_%'"; 
else if($p==3)  $sql="SELECT count(distinct posl) as total FROM `pordertemp` WHERE status='$p' AND posl not like 'EP_%'"; 
else $sql="SELECT count(distinct posl) as total FROM `porder` WHERE status='$p' AND posl not like 'EP_%' "; 
//echo $sql;
 $sqlQuery=mysql_query($sql);
 $rr=mysql_fetch_array($sqlQuery);
//echo $empId;
return $rr[total];
}
?>


<?
// error message genarotor

function inwornMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td><img src='./images/s_warn.png'><b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>
<?
// in ok message genarotor

function inokMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#99FF99>";
$errorMsg.="<tr><td><img src='./images/s_okay.png'>   <b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>
<?
// worning message genarotor

function wornMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#FF0000>";
$errorMsg.="<tr><td><img src='../images/s_warn.png'><b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>
<?
// ok message genarotor

function okMsg($m){
$errorMsg= "<table width=400 align=center border=2 cellspacing=0 cellpading=0 style='border-collapse: collapse' bordercolor=#009933>";
$errorMsg.="<tr><td><img src='../images/s_okay.png'>   <b>$m</b></td></tr>";
$errorMsg.="</table>";
return $errorMsg;
}
?>

<?
/* 
input referrence and project code
return emmergency purchase date*/
function ep_purchaseDate($reff,$pcode){
$sql="SELECT todat from storet$pcode WHERE paymentSL='$reff'";
//echo "$sql";
$sqlq=mysql_query($sql);
$r=mysql_fetch_array($sqlq);
return $r[todat];
}
?>
<? 
/* ---------------------------
  Input iow ID
 return revision list with printable format page link
-------------------------------*/
function getRevisionList($iowId){
$sql="select distinct revisionNo from iowback where iowId='$iowId' ORDER by revisionNo DESC";
$sqlq=mysql_query($sql);
$i=0;
while($r=mysql_fetch_array($sqlq)){
if($i) echo "[ <a target='_blank' href='./print/print_iow.php?iowId=$iowId&r=$r[revisionNo]'>$r[revisionNo]</a> ]";
$i=1;
 }//while

}?>
<?
/* ---------------------------
  Input the posl
 return the activation date of purchase order
-------------------------------*/

function poDate($posl)
{
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 

$sqlff="SELECT activeDate FROM porder where posl='$posl'";
//echo $sqlff;
$sqlf=mysql_query($sqlff);
$r=mysql_fetch_array($sqlf);
 return $r[activeDate];
}

/* ---------------------------
  Input the posl
 return the activation date of purchase order
-------------------------------*/

 ?>


