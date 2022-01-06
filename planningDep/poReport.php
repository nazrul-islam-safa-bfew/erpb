<!-- <h1>
	Under Construction.
</h1> -->
<?php
$pdo=new PDO("mysql:host=$SESS_DBHOST;dbname=$SESS_DBNAME",$SESS_DBUSER,$SESS_DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if($loginDesignation=='Project Manager' || $loginDesignation=='Procurement Executive')$ExtraSql=" AND location='$loginProject' ";

$res=$pdo->prepare("select posl,status from porder where posl not like 'EP%' $ExtraSql group by posl");
$res->execute();
$res->setFetchMode(PDO::FETCH_ASSOC);

if($posl){
	$selectedPO=$pdo->prepare("select status,posl from porder where posl like '$posl' $ExtraSql ");
	$selectedPO->execute();
	$selectedPO->setFetchMode(PDO::FETCH_ASSOC);
	$selectedPosl=$selectedPO->fetch();
	$s=$selectedPosl[status];
	$sPosl=$selectedPosl[posl];	
	$searchMsg=" Search result <input type='button' value='Cancel' id='cancelBtn'>";
}
?>
<table width="100%">
	<form action="" method="post">
		<tr>
			<td></td>
			<td colspan="2" align="center">
			<div style="    height: 10px;
    width: 300px;
    background: #06f;">

			</div>
			</td>
			<td></td>
		</tr>
		<tr style="">
			<td></td>
			<td colspan="2" align="center">
				<div style="width: 300px; border:1px solid #ddd;" >
						<span>PO SL.</span>
						<input type="text" name="searchVal" placeholder="<?php echo $sPosl ? $sPosl : "PO#"; ?>" list="poslLIST" id="polistVal">
						<datalist id="poslLIST">
							<?php
							foreach($res->fetchAll() as $pRow){
								$poArray=explode("_",$pRow[posl]);
								$poslVal=$poArray[0]."_".$poArray[1]."_".$poArray[2]."_".$poArray[3];
								echo '<option value="'.$poslVal.'" rel="'.$pRow[status].'" data-val="'.$pRow[posl].'" >';
							}
							?>
						</datalist>
						<input type="submit" value="Search" name="search" id="searchBtn">
					
					<h3>
						<?php echo $searchMsg; ?>
					</h3>
						
					<script>
					$(document).ready(function(){
						var locVal=document.location.href;
						var locArray=locVal.split("=");
						var loc="./index.php?keyword="+locArray[1]+"="+parseInt(locArray[2]);
						var polistVal=$("#polistVal");
						var searchBtn=$("#searchBtn");
						searchBtn.click(function(){
							window.location.href=loc+"&posl="+polistVal.val();
							return false;
						});
						$("#cancelBtn").click(function(){
							window.location.href=loc;
						});
					});
					</script>
				</div>
				</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2">
				<div style="height: 10px;	width: 300px;">
				</div></td>
			<td></td>
		</tr>
	</form>
	
 <tr>
   <td> <input type="radio" name="c" value="-1" 
   onClick="location.href='index.php?keyword=purchase+order+report&s=-1'" <? if($s=='-1') echo 'checked';?> >
   Under Preparation (<? echo countpo(-1);?>)
   </td>
	 
   <td> <input type="radio" name="c" value="-2" 
   onClick="location.href='index.php?keyword=purchase+order+report&s=-2'" <? if($s=='-2') echo 'checked';?> >
   Waiting for POM Check (<? echo countpo(-2);?>)
   </td>

   <td> <input type="radio" name="c" value="0" 
   onClick="location.href='index.php?keyword=purchase+order+report&s=0'" <? if($s==0) echo 'checked';?> >
   Waiting for Approval (<? echo countpo(0);?>)
   </td>
	 
   <td> <input type="radio" name="c" value="1" 
   onClick="location.href='index.php?keyword=purchase+order+report&s=1'" <? if($s==1) echo 'checked';?>>
   Receiving in Process (<? echo countpo(1);?>)</td>
   <td> <input type="radio" name="c" value="2" 
   onClick="location.href='index.php?keyword=purchase+order+report&s=2'" <? if($s==2) echo 'checked';?>>
   Receiving Completed (<? echo countpo(2);?>)</td>      
 </tr>
</table>

<table align="center" class="dblue" width="98%">
 <tr>
   <td align="right" bgcolor="#0066FF" colspan="6"><font class="englishhead">purchase Orders</font></td>
 </tr>
  <tr>
   <th width="100">Purchase Order</th>
   <th>Item Code</th>
   <th>Description</th>
   <th>Unit</th>   
   <th align="right">Quantity</th>
  <th align="right">Rate</th>
   </tr>
 
<? 

	
if($s=='-1' OR $s=='-2' OR $s=='0' OR $s=='3')
{
	if($loginDesignation=='Project Manager' || $loginDesignation=='Procurement Executive')
	{
		$sqlp1 = "SELECT distinct posl,status,potype,activeDate 
		from `pordertemp` WHERE status='$s' AND potype <>' ' AND posl not like 'EP_%' AND location='$loginProject' order by posl ASC";
	}
	else
	{
		$sqlp1 = "SELECT distinct posl,status,potype,activeDate 
		from `pordertemp` WHERE status='$s' AND potype <>' ' AND posl not like 'EP_%' ";
		if($sPosl)$sqlp1.=" and posl='$sPosl' ";
		$sqlp1.="order by location,posl ASC";
	}
} // if -1 0 3
else 
{
	if($loginDesignation=='Project Manager' || $loginDesignation=='Procurement Executive')
	{
		$sqlp1 = "SELECT distinct posl,status,activeDate 
		from `porder` WHERE status='$s' AND potype <>' ' AND posl not like 'EP_%' AND location='$loginProject' ";
		if($sPosl)$sqlp1.=" and posl='$sPosl' ";
		$sqlp1.=" order by posl ASC";
	}
	else
	{
		$sqlp1 = "SELECT distinct posl,status,activeDate 
		from `porder` WHERE status='$s' AND potype <>' ' AND posl not like 'EP_%' ";
		if($sPosl)$sqlp1.=" and posl='$sPosl' ";
		$sqlp1.="	order by location,posl ASC";
	}

}// else -1 0 3
// echo $sqlp1;
$sqlrunq= mysqli_query($db, $sqlp1);
/* PAge */
$total_result=mysqli_affected_rows($db);
$total_per_page=15;

if($page<=0)
	{
	$page=1;
	}
$curr=($page-1)*$total_per_page;
$sqlp1.=" LIMIT $curr,$total_per_page";
//echo $sqlp1;
$sqlrunp1= mysqli_query($db, $sqlp1);
$i=0;
 while($typel1= mysqli_fetch_array($sqlrunp1))
{
   $te=explode('_',$typel1[posl]);
   $viewPosl=viewPosl($typel1[posl]);
?>
<? 
$r=0;
if($s=='-1' OR $s=='0' OR $s=='3' )
{
	if($loginDesignation=='Project Manager' || $loginDesignation=='Procurement Executive')
	{
		$sqlp = "SELECT poid,itemCode,qty,status,location,rate,potype from `pordertemp` WHERE posl='$typel1[posl]' AND location='$loginProject' order by itemCode ASC";
	}
	else
	{
		$sqlp = "SELECT poid,itemCode,qty,status,location,rate,potype from `pordertemp` WHERE posl='$typel1[posl]' order by itemCode ASC";
	}
}
else 
{
	if($loginDesignation=='Project Manager' || $loginDesignation=='Procurement Executive')
	{
		$sqlp = "SELECT poid,itemCode,qty,status,location,rate,potype from `porder` WHERE posl='$typel1[posl]' AND location='$loginProject' order by itemCode ASC"; 
	}
	else
	{
		$sqlp = "SELECT poid,itemCode,qty,status,location,rate,potype from `porder` WHERE posl='$typel1[posl]' order by itemCode ASC";
	}
}
// echo $sqlp."<br>";
$sqlrunp= mysqli_query($db, $sqlp);
$r=mysqli_num_rows($sqlrunp)*2+1;
$isEQP=strpos($typel1[posl],"EQP_");
$potype=potype($typel1[posl]);
?>
<tr><td colspan="6" bgcolor="#0066FF" height="1" ></td></tr>
<tr><td valign="top"  <? echo " rowspan=$r"; if($i%2==0) echo "  class=po "; else echo "  class=po_off ";?>> 
<?  echo $viewPosl;?><br>

<? $invoice_date =  myDate($typel1[activeDate]);
echo $invoice_date;
// echo "<br>";
//  $today_date =  myDate(date("d-m-Y"));
// if(strtotime($today_date) < strtotime($invoice_date)){
// 	echo "Scedual Failed";
// 	echo "<br>";
// 	echo "sfds".$it = $typel1[itemCode];
// }
//echo "Check".is_po_sch_fail(220,$viewPosl);
?><br>
<? 
if($loginDesignation=='Procurement Manager' OR $loginDesignation=='Procurement Executive'){?>
<?
// 	======================================================================== under pre.
if($typel1[status]==-1){
$vendorInfo=posl2vendorDetails($typel1[posl]);
echo "<p>".$vendorInfo[vname]."</p>";
	
	?>
	[<a target="_blank" href="./planningDep/poUnder/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]
        <a href='./planningDep/poUnder/poDelete.php?posl=<? echo $typel1[posl];?>&status=<? echo $typel1[status];?>'><font class='out'>[ Delete ]</font></a>
	<? if($typel1[potype]==2 ){ ?>	
	[<a href="./index.php?keyword=eqedit+purchase+order&posl=<? echo $typel1[posl];?>">Edit</a>] 	
	<? } ?>
	
	<? if($typel1[potype]==1 OR $typel1[potype]==3 ){?>
	[<a href="./index.php?keyword=edit+purchase+order&posl=<? echo $typel1[posl];?>">Edit</a>]  
	<? }?>	

	[<a href="./index.php?keyword=Forwardfor+Approval&posl=<? echo $typel1[posl];?>">Froword for Approval</a>] 
	<? }?>
	
<!-- 	======================================================================== waiting for approval from MD -->
<?
if($typel1[status]==0 or $typel1[status]==-2){
$vendorInfo=posl2vendorDetails($typel1[posl]);
echo "<p>".$vendorInfo[vname]."</p>";
?>
<!-- 	[<a target="_blank" href="./planningDep/poUnder/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print </a>] -->
<a href="./index.php?keyword=Forwardfor+Approval&posl=<? echo $typel1[posl];?>" target=_blank style="background: #3a89ff;
    color: #fff;
    padding: 5px;
    border-radius: 5px;">
	<?php 
	if($loginDesignation=='Procurement Manager')
		echo "Forward";
	else
		echo "Draft Print";
	?>
	</a>

<br>
<? }?>
<?
	if($potype!=2 && $s==1){
		$a=explode('_',$viewPosl);
		$project= $a[1];
		if(is_po_sch_fail($project,$viewPosl)==1){
			?>
				<div style="
				display: inline-block;
				padding: 5px;
				background: #f00;
				color: #fff;
				border-radius: 5px;
				font-size: 10px;
				">
					Po schedule fail
				</div>
			<?
		};
	}
?>
<? if($typel1[status]==2 OR $typel1[status]==1){
$vendorInfo=posl2vendorDetails($typel1[posl]);
echo "<p>".$vendorInfo[vname]."</p>";

	if($isEQP>-1){ 
	?>
	[<a target="_blank" href="./index.php?keyword=Forwardfor+Approval&posl=<? echo $typel1[posl];?>">Print</a>]
	<?php }else{ ?>
	[<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]	
	<?  viewRevisionPOSL($typel1[posl]);} 
	
	if($potype==2 && $s==1){?>
		[<a target="_blank" href="./planningDep/poRevisionForm.php?posl=<? echo $typel1[posl];?>">Revision Request</a>]
	
    <a href='./planningDep/poDiscount.php?posl=<? echo $typel1[posl];?>' target="_blank"><font class='out'>[ Discount ]</font></a> 
	<?php
	}
$pdfLoc=check_posl_approved($typel1[posl],false);
	if(!$pdfLoc){ ?>
	[<a target="_blank" href="./subcontractor/verify_po.php?posl=<? echo $typel1[posl];?>">Verify</a>] 
	
<div style="
    display: inline-block;
    padding: 5px;
    background: #f00;
    color: #fff;
    border-radius: 5px;
    font-size: 10px;
    ">
		pending
	
	</div>
	
	<? }else{ ?>
	<div style="display: inline-block;
    padding: 5px;
    background: green;
    color: #fff;
    border-radius: 5px;">Verified
		<a href="<?php echo $pdfLoc; ?>" target="_blank" style="color: #000;
    border: 1px solid #ff0;
    padding: 3px;
    background: #ff0;
    border-radius: 5px;">PDF</a>
	</div>
<?php } }



?>
	<? if($typel1[status]==2 && ($loginDesignation=="Procurement Executive")) {?>
    <a href='./planningDep/poUnder/poDelete.php?posl=<? echo $typel1[posl];?>&open=1'><font class='out'>[ Open ]</font></a> 
    <a href='./planningDep/poDiscount.php?posl=<? echo $typel1[posl];?>' target="_blank"><font class='out'>[ Discount ]</font></a> 
	<? }?>

<? }//$loginDesignation=='Accounts Manager' 
elseif($loginDesignation=="Procurement Executive")
{ ?>
	<? if($typel1[status]==-1 OR $typel1[status]==3 )
	{   ?>
	[<a target="_blank" href="./planningDep/poUnder/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]
        
	<? }?>
	
	<? if($typel1[status]==0) 
	{
	?>
	[<a target="_blank" href="./planningDep/poUnder/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]
	<? }?>
	<? if($typel1[status]==1) {?>
	[<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>] 
	<? }?>
	<? if($typel1[status]==2) {?>
	[<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>] 	
	<? }?>

<? }//else $loginDesignation

else{ ?>
	<? if($typel1[status]==-1 OR $typel1[status]==3 ) {   ?>
	[<a target="_blank" href="./planningDep/poUnder/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]
	<? }?>
	<? if($typel1[status]==0) 
	{
	if(($loginDesignation!="MIS Manager") AND ($loginDesignation!="Project Manager"))
	{
	?>
<!--     <a href='./planningDep/poUnder/poDelete.php?posl=<? echo $typel1[posl];?>&status=<? echo $typel1[status];?>'><font class='out'>[ Delete ]</font></a>	 -->
	
	
<!--     <a href='./planningDep/poUnder/pobackforedit.sql.php?posl=<? echo $typel1[posl];?>&status=0'><font class='out'>[ Back for Edit ]</font></a>		 -->
	[<a href="./index.php?keyword=Forwardfor+Approval&posl=<? echo $typel1[posl];?>">View</a>] 
	<? } ?>
	[<a target="_blank" href="./planningDep/poUnder/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]
	<? }?>
	<? if($typel1[status]==1) {
	if($isEQP>-1){
	?>
	[<a target="_blank" href="./index.php?keyword=Forwardfor+Approval&posl=<? echo $typel1[posl];?>">Print</a>]
	<?php }else{ ?>
	[<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]
 <? if(($loginDesignation=='Procurement Executive' AND $loginProject=="000") AND $typel1[status]=='1'){?>
	<a href="./index.php?keyword=close+purchaseOrder&posl=<? echo $typel1[posl];?>
	&itemCode=<? echo $typel[itemCode];?>&potype=<? echo $typel1[potype];?>&rate=<? echo $typel[rate];?>&qty=<? echo $typel[qty];?>" class="closeBTN"><font class="outr">[Close]</font></a><? }?>
	<? viewRevisionPOSL($typel1[posl]); }  }?>
	<? if($typel1[status]==2){
	if($isEQP>-1){
	?>
	[<a target="_blank" href="./index.php?keyword=Forwardfor+Approval&posl=<? echo $typel1[posl];?>">Print</a>] 
	<?php }else{ ?>
	[<a target="_blank" href="./planningDep/printpurchaseOrder1.php?posl=<? echo $typel1[posl];?>">Print</a>]
	<? viewRevisionPOSL($typel1[posl]);}
	}?>

<? }//else $loginDesignation?>
<?
if(is_po_in_fc_list($typel1[posl])){
	?><p>
<p style="border-radius: 5px; background:#0f0; color:#000; text-align:center; border: 1px solid #000;" title="<?= is_po_in_fc_text($typel1[posl]) ?>">Force Close</p>
</p>	
<? 
 }
 ?>

<?
  if($loginDesignation=='admin' OR $loginDesignation=='Accounts Manager' OR $loginDesignation=='Procurement Executive'){?> 
<!--    <br><a href='./planningDep/poUnder/poDelete.php?posl=<? echo $typel1[posl];?>&status=<? echo $typel1[status];?>'><font class='out'>[ Delete ]</font></a>	
	-->	
<!--  <a onClick='if(confirm("Are you sure ?")) window.location="./planningDep/poUnder/poDelete.php?posl=<? echo $typel1[posl];?>&status=<? echo $typel1[status];?>"'  title="Click to Edit Project"><font class='out'>[ Delete ]</font></a> -->
	
	<? if(($loginDesignation=='Procurement Executive') AND $typel1[status]=='1' and !is_po_in_fc_list($typel1[posl]) ){?>
	<a href="./index.php?keyword=close+purchaseOrder&posl=<? echo $typel1[posl];?>
	&itemCode=<? echo $typel[itemCode];?>&potype=<? echo $typel1[potype];?>&rate=<? echo $typel[rate];?>&qty=<? echo $typel[qty];?>" class="closeBTN"><font class="outr">[Close]</font></a>
 <? } ?>

	
<?   
	$tvendor=vendorName($te[3]);
   echo '<br>'.$tvendor[vname];
	}?>
   <br>
    </td> 
</tr>

	
<? while($typel= mysqli_fetch_array($sqlrunp))
{
?>
<tr>
  <td><? echo $typel[itemCode];?></td>
  <td ><? $temp=itemDes( $typel[itemCode]); echo $temp[des].', '.$temp[spc];?></td>
  <td align="center"><? if($typel[potype]=='4') echo 'Nos'; else echo $temp[unit];?></td>  
  <td align="right"><? echo number_format($typel[qty],3);?></td>
 <td align="right" ><? echo number_format($typel[rate],2);?>
 </td> 
</tr>
<tr><td height="1" bgcolor="#EEEEEE" colspan="5"></td></tr>
<? }?>
<? $i++; }?>
	<tr><td height="1" bgcolor="#00f" colspan="6"></td></tr>
<?
	if($s=='0'){
		$extSql="select posl,count(*) r,revisionNo from po_revision where acceptDate='' group by posl";
		$extQ=mysqli_query($db,$extSql);
		while($row=mysqli_fetch_array($extQ)){
			$te=explode('_',$row[posl]);
   		$viewPosl=viewPosl($row[posl]);
	echo "<tr><td>$viewPosl <a href='./index.php?keyword=Forwardfor+Approval+Revision&posl=$row[posl]&revision=$row[revisionNo]' target='_blank'>Click For Details</a><br>";
viewRevisionPOSL($row[posl]);
echo "<br></td>";

		$extSqls="select * from po_revision where acceptDate='' and posl='$row[posl]' order by itemCode limit 1";
		$extQs=mysqli_query($db,$extSqls);
			while($rows=mysqli_fetch_array($extQs)){
				echo "<td>$rows[itemCode]</td>";
				$temp=itemDes($rows[itemCode]);
				echo "<td colspan=3 align=left>$temp[des], $temp[spc] <span style='padding: 5px;
    background: #00f;
    color: #fff;
    border-radius: 10px;
    font-weight: 800;'>Revision Item #$rows[revisionNo]</span></td>";
				echo "<td colspan=1 align=right>$rows[sdate]</td>";
			}
			echo "</tr>";
		}
	} ?>


</table>
<br/>
 <?php
        include("./includes/PageNavigation.php");
        $totalResults= $total_result;
        $resultsPerPage= $total_per_page;
        $page= $_GET[page];
        $startHTML= "<b>Showing Page {page} of {pages}</b>: Go to Page ";
        $appendSearch= "&s=$s";
        $range= 5;
		$rootLink="./index.php?keyword=purchase+order+report";
        $link_on= "<a href='$rootLink&page={num}{appendSearch}' class='hd'><b>{num}</b></a>";
        $link_off= "<a href='$rootLink&page={num}{appendSearch}'>{num}</a>";
        $back= " <a href='$rootLink&page=1{appendSearch}'><<</a> ";
        $forward= " <a href='$rootLink&page={pages}{appendSearch}'>>></a> ";

        $myNavigation = New PageNavigation($totalResults, $resultsPerPage, $page, $startHTML, $appendSearch, $range, $link_on, $link_off, $back, $forward);

        echo $myNavigation->getHTML();

?>
<br>


<div class="fullScreenBlack" style="background: rgba(0, 0, 0, 0.8); width: 100%; height: 100%; left: 0px; top: 0px; position: fixed; overflow: hidden; display:none">
				<div style="display: block;    width: 320px;    height: 240px;    background: white;
    margin: auto;    margin-top: 20vh;    padding: 3px;    border-radius: 4px;">
					<div id="dialog" title="Reason of revision">
						<div class="ui-dialog-titlebar ui-corner-all ui-widget-header ui-helper-clearfix ui-draggable-handle"><span id="ui-id-1" class="ui-dialog-title">Reason of force close</span><button type="button" class="ui-button ui-corner-all ui-widget ui-button-icon-only ui-dialog-titlebar-close" title="Close" style="    float: right;" id="closeBTN"><span class="ui-button-icon ui-icon ui-icon-closethick"></span><span class="ui-button-icon-space"> </span>Close</button></div>
						<div class="">
						<div class="errorMsg" style=" color: #f00;    font-size: 12px;    font-weight: 800;">

						</div>
							<textarea name="revisionTxt" id="revisionTxt" style="margin: 0px; width: 98%; height: 117px; 1px solid rgb(176, 174, 174)"></textarea>
							<input type="button" value="submit" id="revSubmitBTN">
						</div>
					</div>
				</div>
			</div>

<script>	
			$(document).ready(function(){
				var revisionBTN=$("a.closeBTN");
				var revisionHref="";
				var fullScreenBlack=$("div.fullScreenBlack");
				var dialog=$("div#dialog");
				var closeBTN=$("button#closeBTN");
				var revSubmitBTN=$("input#revSubmitBTN");
				var revisionTxt=$("textarea#revisionTxt");
				var errorMsg=$("div.errorMsg");
				var Revision2=$("#Revision2");
				revisionBTN.click(function(){
					revisionHref=$(this).attr("href");
					fullScreenBlack.fadeIn();
					return false;
				});
				closeBTN.click(function(){
					fullScreenBlack.hide();
				});
				
				revSubmitBTN.click(function(){
					var revisionData=revisionTxt.val();
					if(revisionData.length>15){
						errorMsg.html("");
						window.location.href=revisionHref+"&revisionTxt="+encodeURI(revisionData);
					}else{
						var msg="Closed reason should be minimum 15 character."
						errorMsg.html(msg);
					}
				});
			});
</script>