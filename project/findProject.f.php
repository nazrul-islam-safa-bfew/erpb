<?
/*
well this page is create to find active, non-active & complete projects 

go to page siteDailyReport.php and find this variables

$actualTotalEx=$iow_subContractorissuedEx+$iow_issuedEx+$iow_equipmentReport+$iow_humanReport;

now 
if $actualTotalEx=0 then it is non active project
if $actualTotalEx=100 then it is non complete project
if 0< $actualTotalEx <100  then it is active project

now function 
iow_subContractorissuedEx=A
iow_issuedEx=B
iow_equipmentReport=C
iow_humanReport=D



Wrote by 
Rony
*/
?>
<?

function remove_array_empty_values($array, $remove_null_number = true)
{
	
	if($array==true){
	$new_array = array();

	$null_exceptions = array();

	foreach ($array as $key => $value)
	{
		$value = trim($value);

        if($remove_null_number)
		{
	        $null_exceptions[] = '0';
		}

        if(!in_array($value, $null_exceptions) && $value != "")
		{
            $new_array[] = $value;
        }
    }
    return $new_array;
	
	}
}
/*

?>
<?
function A($iow,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls1 = "SELECT sum(qty*rate) as total from `subut` WHERE iow='$iow' and pcode='$pp' AND edate<='$ed'";
//echo $sqls1;
$sqlruns1= mysql_query($sqls1);
$out = mysql_fetch_array($sqlruns1);
$iss=$out[total];
if($iss==0 || $iss=='' )return $iow;
}//function end

function B($iow,$pp,$ed){
$iss=0;
$issQty=0;

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls1 = "SELECT sum(issuedQty*issueRate) as total from `issue$pp` WHERE iowId='$iow' AND issueDate<='$ed'";
//echo $sqls1;
$sqlruns1= mysql_query($sqls1);
$out = mysql_fetch_array($sqlruns1);
$iss=$out[total];
if($iss==0 || $iss=='')return $iow;
}//function end

function C($iow,$project,$ed){
 include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls = "SELECT * from `dma` WHERE dmaiow='$iow' AND dmaItemCode BETWEEN '50-00-000' AND '69-99-999'";
//echo $sqls;
$sqlruns= mysql_query($sqls);

 while($redma= mysql_fetch_array($sqlruns)){ 
   $eqTotalWorkiow = eqTotalWorkhriow($redma[dmaItemCode],$ed,$iow);
   $eqTotalWorkiowtk+=($eqTotalWorkiow/3600)*$redma[dmaRate];
   }
if($eqTotalWorkiowtk==0 || $eqTotalWorkiowtk=='') return $iow;
 }//function end

function D($iow,$project,$ed){
include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$sqls = "SELECT * from `dma` WHERE dmaiow='$iow' AND dmaItemCode BETWEEN '70-00-000' AND '97-99-999'";
//echo $sqlp;
$sqlruns= mysql_query($sqls);

 while($redma= mysql_fetch_array($sqlruns)){ 
   $empTotalWorkiow =empTotalWorkiow($redma[dmaItemCode],$iow,$ed,0);
   
  // $empTotalWorksiowtk =empTotalWorksiow($redma[dmaItemCode],$siow)*$redma[dmaRate];
   $empTotalWorkiowtk+=($empTotalWorkiow/3600)*$redma[dmaRate];
 }
 
 if($empTotalWorksiowtk==0 || $empTotalWorksiowtk=='') return $iow;
}//function end


function found2($iow,$project,$date){
//$i=iow, $p=project, $d=date

if(A($iow,$project,$date) == B($iow,$project,$date) && A($iow,$project,$date) == C($iow,$project,$date) && A($iow,$project,$date) == D($iow,$project,$date) && B($iow,$project,$date) == C($iow,$project,$date) && B($iow,$project,$date) == D($iow,$project,$date) && D($iow,$project,$date) == C($iow,$project,$date)) return $iow;


}
*/

// == iow_equipmentReportf($iow,$project,$date) == iow_humanReportf($iow,$project,$date)
//|| A($i,$p,$d) == C($i,$p,$d) || A($i,$p,$d)==D($i,$p,$d) || B($i,$p,$d) == C($i,$p,$d) || B($i,$p,$d) == D($i,$p,$d) || C($i,$p,$d) == D($i,$p,$d)

function foundf($iow,$project,$date){
$iow_subContractorissuedEx=iow_subContractorissuedEx($iow,$project,$date);	
	//echo $siow_subContractorissuedEx;
	$iow_issuedEx=iow_issuedEx($iow,$project,$date);
	//echo "<br>$siow_issuedEx";
	$iow_equipmentReport=iow_equipmentReport($iow,$project,$date);
	//echo "<br>".number_format($siow_equipmentReport);
	$iow_humanReport=iow_humanReport($iow,$project,$date);
	//echo "<br>".$siow_humanReport;
	
	$actualTotalEx=$iow_subContractorissuedEx+$iow_issuedEx+$iow_equipmentReport+$iow_humanReport;
	
$materialCost=materialCost($iow);
$equipmentCost=equipmentCost($iow);
$humanCost=humanCost($iow);
$directCost=$materialCost+$equipmentCost+$humanCost;
	
if($directCost==0){$directCost=1;}
	$actualTotalExp=($actualTotalEx/$directCost)*100;
	$actualTotalExp=number_format($actualTotalExp);
	
if($actualTotalExp>0 && $actualTotalExp<100) return $iow;
}


function found($iow,$project,$date){
$iow_subContractorissuedEx=iow_subContractorissuedEx($iow,$project,$date);	
	//echo $siow_subContractorissuedEx;
	$iow_issuedEx=iow_issuedEx($iow,$project,$date);
	//echo "<br>$siow_issuedEx";
	$iow_equipmentReport=iow_equipmentReport($iow,$project,$date);
	//echo "<br>".number_format($siow_equipmentReport);
	$iow_humanReport=iow_humanReport($iow,$project,$date);
	//echo "<br>".$siow_humanReport;
	
	$actualTotalEx=$iow_subContractorissuedEx+$iow_issuedEx+$iow_equipmentReport+$iow_humanReport;
	
$materialCost=materialCost($iow);
$equipmentCost=equipmentCost($iow);
$humanCost=humanCost($iow);
$directCost=$materialCost+$equipmentCost+$humanCost;
	
if($directCost==0){$directCost=1;}
	$actualTotalExp=($actualTotalEx/$directCost)*100;
	$actualTotalExp=number_format($actualTotalExp);
	
if($actualTotalExp==0) return $iow;
}

//if(A2($iow,$project,$date)==true || B2($iow,$project,$date)==true || C2($iow,$project,$date)==true || D2($iow,$project,$date)==true ) return $iow;
?>