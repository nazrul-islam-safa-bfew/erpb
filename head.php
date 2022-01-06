<?
session_start();
$loginDesignation=$_SESSION['loginDesignation'];
// exit;
//if($_SESSION['loginDesignation']!="Chairman & Managing Director"){echo "<h1>Server busy. Please check after 20 minute.";exit;}
//check($todat);
//echo $loginDesignation;
?>
<table width="100%" class="ablue" border="1">
<tr>
  <td>
    <table width="100%" class="dblue" >
	  <tr>
	     <td valign="top"  align="center" colspan="2">Welcome to BFEW Web based Enterprise Resource Planning System</td>
	  </tr>month+attendance+report
	  <tr class="dblueAlertHd_small">
		<? if($loginUid){echo "<td align=left>Welcome <b><i>$loginFullName</i></b>, ";
		if($loginDesignation=="Task Supervisor")echo "Site Engineer";
		else echo $loginDesignation;
		if($loginDesignation!='Chairman & Managing Director' & $loginDesignation!='Director' & $loginDesignation!='Managing Director')
			echo ", Project Name: $loginProjectName";
		 echo "</td><td>[<a href='index.php?keyword=log+off' title='Log off' target='_self'> Log Off </a>]
		 </td>";}?>
	  </tr>
	</table>
  </td>
</tr>
<?
if($loginDesignation=='Project Accountant'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
		 <td  align="center"><a href='./index.php?keyword=spr+NIOW'>Enter Purchase Requisition for NIOW</a></td>
		 <td  align="center"><a href='./index.php?keyword=site+spr+IOW'>Enter Purchase Requisition for IOW</a></td>
	   </tr>
	 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Construction Manager'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20">
	   <tr bgcolor="#CCCCCC">
         <td>Entry Forms: </td>
		<td  align="center"><a href='./index.php?keyword=site+daily+report+entry'>Daily Report Entry From</a></td>
		<td  align="center"><a   href='./index.php?keyword=staff+leave+report&status=0'>Leave (<? echo countLeave(0,$loginProject);?>)</a></td>
<!-- 		<td  align="center"><a   href='./index.php?keyword=cash+payment+approval'>Cash Payments</a></td> -->
		<td align="center"><a  href='./index.php?keyword=site+iow+detail&status=Not+Ready'> View IOW Detail</a></td>
   	     <td  align="center"><a  href='./index.php?keyword=pmview+IOW&status=Raised by PM'>All IOW</a></td>
		<td align="center"><a  href='./index.php?keyword=cash+payment+approval'> Cash Payment Approval</a></td>
			 
			 
<td<? if($keyword=='employee details')echo " id='current' ";?> align=center><a   href='./index.php?keyword=employee+details&a=1&page=1'>Human Resource Details</a></td>
			 
        </tr>
	  <tr bgcolor="#E4E4E4">
         <td>Reports: </td>
		<td  align="center"><a  href='./index.php?keyword=equipment+details&a=1&page=1'>Equipment Section</a></td>
		<td  align="center"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td>
<!-- 		 <td  align="center"><a   href='./index.php?keyword=employee+details&a=1&page=1'>Project Human Resources</a></td> -->
		 <td  align="center"><a href='./index.php?keyword=site+daily+report'>Work Progress Report</a></td>
     <td align="center"><a href='./index.php?keyword=local+eq+ut+report+b&a=1&page=1'>Equipment Utilization</a></td>		 
     <td align="center"><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a></td>		 
		 <td  align="center"><a   href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=attendance+report'>Attendance Report</a></td>
		<td align="center"><a href='./index.php?keyword=sitecash+ledger'>Cash Ledger</a></td>
        <td align="center"><a href="index.php?keyword=view+project+calender">Calander</a></td>
	   </tr>
	   <tr bgcolor="#CCCCCC">
         <td bgcolor="#99CCFF">Store: </td>
		 <td  align="center"><a href='./index.php?keyword=site+store+finish'>Finished Products Inventory</a></td>		 		 
		 <td  align="center"><a href='./index.php?keyword=site+store'>Inventory Status</a></td>
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=mat&page=0">Current Req. Material</a></td>	   
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=eqp&page=0">Current Req. Equipment</a></td>	   
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=lab&page=0">Current Req. Labour</a></td>
	   <td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>		
	   	 

		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Equipment Schedule</a></td>

		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Manpower Schedule</a></td>

		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Material Schedule</a></td>

		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Sub-Contractor Schedule</a></td>
			 
    </tr>
	 </table>
   </td>
</tr>
<? }
// new id by suvro
elseif($loginDesignation=='Human Resource Executive'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
         <td>Entry Forms: </td>
         <td  align="center"><a   href='./index.php?keyword=local+emp+recruit'>Direct Labour Recruitment</a></td>
        <td align="center"><a href='./index.php?keyword=local+emp+attendance'>Direct Labour Attendance</a></td>	 
		 <td  align="center"><a href='./index.php?keyword=attendance'>Attendance Form</a></td>
		 <td  align="center"><a   href='./index.php?keyword=staff+leave+form'>Leave Form</a></td>		 
		 <td  align="center"><a   href='./index.php?keyword=all+staff+leave+report&status=0'>Leave Verify(<? echo countLeave(0,$loginProject);?>)</a></td> 
         <td align="center"><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a></td>
			 
<td><a  href='./index.php?keyword=mdsalary+advance'>Salary Advance</a></td>
        </tr>
	   <tr bgcolor="#E4E4E4">
         <td>Reports: </td>
		 <td  align="center"><a   href='./index.php?keyword=empSalary+report'>Wages Report</a></td>
			 <td  align="center"><a   href='./index.php?keyword=month+attendance+report'>Monthly Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=employee+details&a=1&page=1'>Project Human Resources</a></td>	 
		 <td  align="center"><a   href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=attendance+report'>Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=staff+leave+report&status=0'>Leave (<? echo countLeave(0,$loginProject);?>)</a></td>
        <td align="center"><a href="index.php?keyword=view+project+calender">Calander</a></td>	 		 
	   </tr>
	   
	 </table>
   </td>
</tr>
<? }





//end of new id
elseif($loginDesignation=='Site Cashier'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">

		<? if($loginProject=='000'){?> 		
		 <td  align="center"><a href='./index.php?keyword=payments'>Payments</a></td>		
		 <td  align="center"><a href='./index.php?keyword=receive'>Receive</a></td>
		<? }else {?>
		 <td  align="center"><a href='./index.php?keyword=site+payments'>Payments</a></td>		
 		 <td  align="center"><a href='./index.php?keyword=receive&w=3'>Receive</a></td><? }?>				 
		<? if($loginProject=='000'){?> 
			<td  align="center"><a href='./index.php?keyword=general+ledger'>General Ledger</a></td>
			<td  align="center"><a href='./index.php?keyword=lander+ledger'>lander ledger</a></td>
		<? }?>
		<? if($loginProject=='000'){?> 
		<td  align="center"><a href='./index.php?keyword=hcash+disbursment'>Cash Disbursment</a></td>
		<td  align="center"><a href='./index.php?keyword=cash+receivejournal'>Cash Receive Journal</a></td>
		<!-- <td  align="center"><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>	-->
		<td  align="center"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td>
		 <td  align="center"><a   href='./index.php?keyword=trial+balance'>Trial Balance</a></td>
		<? }?>

		<? if($loginProject!='000'){?> 
		<td  align="center"><a href='./index.php?keyword=scash+disbursment'>Cash Disbursment</a></td>

		<? }?>

		<? if($loginProject!='000'){?> <td  align="center"><a href='./index.php?keyword=sitecash+ledger'>Cash Ledger</a></td><? }?>
<!-- 		 <td  align="center"><a   href='./index.php?keyword=staff+leave+form'>Leave Form</a></td> -->
		<!-- <td  align="center"><a   href='./index.php?keyword=staff+leave+report'>Leave Report</a></td>		--> 
		 <td  align="center"><a href='./index.php?keyword=attendance'>Attendance Form</a></td>
		<!--<td align="center"><a href='./index.php?keyword=local+emp+attendance'>Direct Labour Attendance</a></td>	-->	 
		 <td  align="center"><a href='./index.php?keyword=attendance+report'>Attendance Report</a></td>
	   </tr>
	 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Accounts Manager'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
		 <td  align="center"><h4>Entry Form</h4></td>
		 <td  align="center"><a  href='./index.php?keyword=item+require'>Create Purchase Order</a></td>
		 <td  align="center"><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>		  
		 <td  align="center"><a href='./index.php?keyword=mca'>Maintain Chart of Accounts</a></td>
		 <td  align="center"><a href='./index.php?keyword=payments'>Payments</a></td>
		 <td  align="center"><a href='./index.php?keyword=salary+advance'>Salary Advance</a></td>
		 <td  align="center"><a href='./index.php?keyword=add+lander'>Add lander</a></td>
		 <td  align="center"><a target="_blank" href='./account/delete.php'>Delete Entry</a></td>
		 <td  align="center"><a target="_blank" href='./account/delete special.php'>Special Delete Entry</a></td>	
		 <td  align="center"><a href='./index.php?keyword=accounts+locker'>Account Locker</a></td>
		 <td  align="center"><a href='./cache/getAllRevisionBack.php' target="_blank">IOW Optimization</a></td>
			          <td align="center"><a  href='./index.php?keyword=cash+payment+approval'> Cash Payment Approval</a></td>
	   </tr>
<tr bgcolor="#E4E4E4">
	<td  align="center"><h4>Report</h4></td>
	<td  align="center"><a   href='./index.php?keyword=employee+details&page=1'>Human Resource Details</a></td>
	<td  align="center"><a href='./index.php?keyword=cash+receivejournal'>Cash Receive Journal</a></td>
	<td  <? if($keyword=='mdvendor Report')echo " id='current' ";?>> <a  href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td>
	<td  align="center"<? if($keyword=='store')echo " id='current' ";?>><a  href='./index.php?keyword=store'>Inventory Status</a></td>
	<td  align="center"<? if($keyword=='inventory activity')echo " id='current' ";?>><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td>
	<td  align="center"<? if($keyword=='mr report')echo " id='current' ";?>><a href='./index.php?keyword=mr+report'>MR Report</a></td>
	<td  align="center"<? if($keyword=='po ledger')echo " id='current' ";?>><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>
	<td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td>

	<td  align="right"<? if($keyword=='aged vendor payable approval')echo " id='current' ";?>>
	<a href='./index.php?keyword=aged+vendor+payable+approval'>Vendor Payments</a></td>

	
 <td  align="center"><a href='./index.php?keyword=equipment+details&page=1'>Equipment Details</a></td>
	<td  align="center" <? if($keyword=='local eq ut report b')echo " id='current' ";?>><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
		<td  align="center"><a   href='./index.php?keyword=staff+leave+report&status=0'>Leave</a></td>
</tr>
	   
	<tr bgcolor="#E4E4E4">
		<td align="left"<? if($keyword=='salary disbursment')echo " id='current' ";?>><a href='./index.php?keyword=salary+disbursment'>Salary &amp; Wages Disbursment</a></td>
		<td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td>
		<td  align="left"<? if($keyword=='bank disbursment')echo " id='current' ";?>><a href='./index.php?keyword=bank+disbursment'>Bank Disbursment</a></td>
		<td  align="center"<? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td>
		<td  align="center"<? if($keyword=='htrial balance')echo " id='current' ";?>><a href='./index.php?keyword=htrial+balance'>Trial Balance</a></td>
		<td  align="center"<? if($keyword=='income statement')echo " id='current' ";?>><a href='./index.php?keyword=income+statement'>Income Statement</a></td>
		<td  align="center"<? if($keyword=='balance sheet')echo " id='current' ";?>><a href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td>
		
		<td  align="right"<? if($keyword=='financial overview')echo " id='current' ";?>><a   href='./index.php?keyword=financial+overview'>Financial  Overview</a></td>
		<td  align="right"<? if($keyword=='lander ledger')echo " id='current' ";?>><a   href='./index.php?keyword=lander+ledger'>lander  ledger</a></td>
		<td  align="right"<? if($keyword=='lander ledger')echo " id='current' ";?>><a   href='./index.php?keyword=lander+ledger'>Advance Ledger</a></td>
		<td  align="center"><a href='./index.php?keyword=closing+cash+inventory'>Closing Cash &amp; Inventory</a></td>
		<td  align="center"><a href='./index.php?keyword=Daily+Site+Cash+Report'>Daily site cash report</a></td>
			
	  <td align="right" <? if($keyword=='rate Item')echo " id='current' ";?> ><a href='./index.php?keyword=rate+Item'>Enter ItemCode</a></td>
		
	  <td   align="center" <? if($keyword=='rate Item type')echo " id='current' ";?> ><a   href='./index.php?keyword=rate+Item+type'>Acure At</a></td>

	  <td   align="center"><a href='./angular/itemcodes.php'>All Item Code</a></td>

	  <td  align="center"><a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td>
      <td align="center"><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
      <td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>	



		</tr>
	   
	 </table>
   </td>
</tr>
<? } //new designation == MIS
elseif($loginDesignation == 'MIS'){?>
	<tr>
	   <td>
		<table width="100%"  height="20" >
		   <tr bgcolor="#CCCCCC">
			 <td  align="center"><h4>Entry Form</h4></td>
			 <td  align="center"><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>		  
			 <td  align="center"><a href='./index.php?keyword=mca'>Maintain Chart of Accounts</a></td>
		   </tr>
	<tr bgcolor="#E4E4E4">
			<td  align="center"><h4>Report</h4></td>
			<td  align="center"><a href='./index.php?keyword=cash+receivejournal'>Cash Receive Journal</a></td>
			<td  align="center"<? if($keyword=='store')echo " id='current' ";?>><a  href='./index.php?keyword=store'>Inventory Status</a></td>
			<td  align="center"<? if($keyword=='inventory activity')echo " id='current' ";?>><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td>
			<td  align="center"<? if($keyword=='mr report')echo " id='current' ";?>><a href='./index.php?keyword=mr+report'>MR Report</a></td>
			<td  align="center"<? if($keyword=='po ledger')echo " id='current' ";?>><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>
			<td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td>
			<td  align="center"><a href='./index.php?keyword=equipment+details&page=1'>Equipment Details</a></td>
	</tr>	  
	<tr bgcolor="#E4E4E4">
			<td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td>
			<td  align="left"<? if($keyword=='bank disbursment')echo " id='current' ";?>><a href='./index.php?keyword=bank+disbursment'>Bank Disbursment</a></td>
			<td  align="center"<? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td>
			<td  align="center"<? if($keyword=='htrial balance')echo " id='current' ";?>><a href='./index.php?keyword=htrial+balance'>Trial Balance</a></td>
			<td  align="center"<? if($keyword=='income statement')echo " id='current' ";?>><a href='./index.php?keyword=income+statement'>Income Statement</a></td>
			<td  align="center"<? if($keyword=='balance sheet')echo " id='current' ";?>><a href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td>
			<td  align="right"<? if($keyword=='financial overview')echo " id='current' ";?>><a   href='./index.php?keyword=financial+overview'>Financial  Overview</a></td>
			<td  align="right"<? if($keyword=='lander ledger')echo " id='current' ";?>><a   href='./index.php?keyword=lander+ledger'>lander  ledger</a></td>
	</tr>	   
		 </table>
	   </td>
	</tr>
	<? }
elseif($loginDesignation=='MIS Manager'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
		<!-- <td  align="center"><a  href='./index.php?keyword=item+require'>Create Purchase Order</a></td>-->
		 <td  align="center"><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>		  
		 <td  align="center"><a href='./index.php?keyword=mca+report'>Maintain Chart of Accounts</a></td>
		  <td  align="center"><a href='./index.php?keyword=equipment+details&page=1'>Equipment Details</a></td>		
		  <td  <? if($keyword=='mdvendor Report')echo " id='current' ";?>> <a  href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td>

<td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td>
		<td  align="right"<? if($keyword=='financial overview')echo " id='current' ";?>><a   href='./index.php?keyword=financial+overview'>Financial  Overview</a></td>

		 <!--<td  align="center"><a href='./index.php?keyword=payments'>Payments</a></td>
		 <td  align="center"><a href='./index.php?keyword=salary+advance'>Salary Advance</a></td>
		 <td  align="center"><a href='./index.php?keyword=add+lander'>Add lander</a></td>
		 <td  align="center"><a target="_blank" href='./account/delete.php'>Delete Entry</a></td>
		 <td  align="center"><a target="_blank" href='./account/delete special.php'>Special Delete Entry</a></td>	-->
		 		 	 		 		 		 
	   </tr>
<tr bgcolor="#E4E4E4">
		<td  align="center"><a href='./index.php?keyword=cash+receivejournal'>Cash Receive Journal</a></td>
<td  align="center"<? if($keyword=='store')echo " id='current' ";?>><a  href='./index.php?keyword=store'>Inventory Status</a></td>
<td  align="center"<? if($keyword=='inventory activity')echo " id='current' ";?>><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td>	
<td  align="center"<? if($keyword=='mr report')echo " id='current' ";?>><a href='./index.php?keyword=mr+report'>MR Report</a></td>		 
<td  align="center"<? if($keyword=='po ledger')echo " id='current' ";?>><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>	
		<td  align="right"<? if($keyword=='lander ledger')echo " id='current' ";?>><a   href='./index.php?keyword=lander+ledger'>lander  ledger</a></td>

</tr>
	   
	<tr bgcolor="#E4E4E4">
		<td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td>
		<td  align="center"<? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td>
		<td  align="center"<? if($keyword=='htrial balance')echo " id='current' ";?>><a   href='./index.php?keyword=htrial+balance'>Trial Balance</a></td>
		<td  align="center"<? if($keyword=='income statement')echo " id='current' ";?>><a   href='./index.php?keyword=income+statement'>Income Statement</a></td>
		<td  align="center"<? if($keyword=='balance sheet')echo " id='current' ";?>><a   href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td>
		<td  align="center"><a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td>
        <td align="center"><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
        <td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>	


				
		</tr>
	   
	 </table>
   </td>
</tr>
<? }
/*
elseif($loginDesignation=='Store Officer'){?>
<tr><!-- main link-->
   <td>
		<table width="100%"  height="20" >
		   <tr bgcolor="#CCCCCC">		   	
		 <td  align="center"><a   href='./index.php?keyword=all+staff+leave+report&status=0'>Leave (<? echo countLeave(0,$loginProject);?>)</a></td>
		   </tr>
		</table>
	</td>
</tr>


<? } */ 
elseif($loginDesignation=='Store Officer'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
		 <td  align="center"><a href='./store/verifyIssuedMaterial.php' target="_blank">Verify Issued Material</a></td>
		 <td  align="center"><a href='./index.php?keyword=delevery+mode'>Delevery Mode</a></td>
		 <td  align="center"><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td>
		 <td  align="center"><a href='./index.php?keyword=mr+report'>MR Report</a></td>		 
		 <td  align="center"><a href='./index.php?keyword=store'>Raw Material Inventory</a></td>

		<td  align="center"><a href='./index.php?keyword=finished+product+dispatch'>Finished Product Dispatch</a></td>
		<!--<td  align="center"><a href='./index.php?keyword=store+transfer'>Store Transfer Form</a></td>-->
		<td align="center"><a href='./index.php?keyword=store+return'>Store Return Form</a></td>

		 <td align="center"><a href='./index.php?keyword=purchase+order+receive'>Receive</a></td>
		 <!--<td  align="center"><a href='./index.php?keyword=issue'>Issue</a></td>-->
		 <td  align="center"><a href='./index.php?keyword=tool+purchase+order+receive'>Tools Receive</a></td>
		 <td  align="center"><a href='./index.php?keyword=tool+issue'>Tools Issue</a></td>
      <td  ><a  href='./index.php?keyword=purchase+order+store+receive&s=0'>Accept EP</a></td>
	  </tr>
	 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Store Controller'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
		 <td  align="center"><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td>
		 <td  align="center"><a href='./index.php?keyword=mr+report'>MR Report</a></td>	
   	     <td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>		
		 <td  align="center"><a href='./index.php?keyword=store'>Store Details</a></td>
     	<td><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>	
      	<td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td>
	   </tr>
	 </table>
   </td>
</tr>
<? }
	

elseif($loginDesignation=='Task Supervisor'){?>
<tr>
	<td>
	<table width="200"  height="20" >
	 <tr bgcolor="#fff">	
	   <td  align="left">Entry</td>
	   <td  align="center"><a href='./index.php?keyword=task+daily+report'>Work Progress Entry</a></td>
<!-- 		<td  align="center" <? if($keyword=='site daily report')echo " id='current' ";?>> -->
<a href='./index.php?keyword=site+daily+report'>Work Progress Report</a></td>
		</tr>
		</table>
	</td>
</tr>
	
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	 <tr bgcolor="#CCCCCC">
	   <td  align="left">Reports</td>	   
	   <td  align="center"><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a></td>
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=eqp&page=0">Current Req. Equipment</a></td>	   
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=lab&page=0">Current Req. Labour</a></td>
	   
<? if($loginProject=='000'){?>
	 <td  align="center"><a href='./index.php?keyword=eq+attendance'>Equipment Attendance</a></td>
		 	<? }?>
				   
	<? if($loginProject=='002'){?>	
		 <td  align="center"><a href='./index.php?keyword=eq+attendance+ws'>Equipment Attendance</a></td>
		 <td  align="center"><a href='./index.php?keyword=eq+utilization+report+ws'>Equipment Utilization</a></td>
		 	<? }
			
	 else {?>
		 <td  align="center" <? if($keyword=='local eq ut report b')echo " id='current' ";?>><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
		 <? } ?>

<!--		<td align="center"><a href='./index.php?keyword=local+emp+ut+report'>Direct Labour Utilization</a></td>
		<td align="center"><a href='./index.php?keyword=sub+con+pro+entry'>Sub Contractor Progress Entry</a></td>
		 <td  align="center"><a href='./index.php?keyword=issue'>Issue</a></td>		
->
	   </tr>
	  <tr>
<!--	  
	   <td rowspan="2">Reports</td>
	   <td align="center"><a href="./index.php?keyword=local+eq+ut+report+b">Details by date</a></td>
	   <td align="center"><a href="./index.php?keyword=local+eq+ut+report+d">Details by Equipment</a></td>
	   <td align="center"><a href="./index.php?keyword=local+eq+ut+report+c">Summary by Equipment Group</a></td>
     </tr> 
	  <tr>
	   <td align="center"><a href="./index.php?keyword=local+emp+ut+report+b">Details by date</a></td>
	   <td align="center"><a href="./index.php?keyword=local+emp+ut+report+d">Details by Employee</a></td>
	   <td align="center"><a href="./index.php?keyword=local+emp+ut+report+c">Summary by Designation</a></td>
      </tr>
	-->
	 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Site Equipment Co-ordinator'){
echo "<font class='out'>To give utilization U have to login as task Supervisor </font>"; 
?>
<tr>
  <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
	   <td>Entry Form</td>
	   
<? if($loginProject=='000'){?>
	 <td  align="center"><a href='./index.php?keyword=eq+attendance'>Equipment Attendance</a></td>
	<? }?>
	 <td  align="center"><a href='./index.php?keyword=eq+out'>Equipment Present</a></td>
			 
	
		 <td  align="center"><a href='./index.php?keyword=eq+utilization+report'>Equipment Utilization</a></td>
		 <td  align="center"><a href='./index.php?keyword=Equipment+Usage+Details'>Equipment Usage Details</a></td>
		 <td  align="center"><a href='./index.php?keyword=purchase+order+receive&type=eq'>Equipment Receive</a></td>
		 <td  align="center"><a href='./index.php?keyword=eq+dispach'>Equipment Dispach</a></td>
			 <td align="center"><a href='./index.php?keyword=fuel+issue'>Fuel Issue</a></td>

	   </tr>
	  <tr>
	   <td>Reports</td>
	   <td align="center"><a href="./index.php?keyword=local+eq+ut+report+b">Details by date</a></td>
	   <td align="center"><a href="./index.php?keyword=local+eq+ut+report+d">Details by Equipment</a></td>
	   <td align="center"><a href="./index.php?keyword=local+eq+ut+report+c">Summary by Equipment Group</a></td>
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=eqp&page=0">Current Req.</a></td>
	   
	  </tr> 
	 </table>
   </td>
</tr>

<? }
elseif($loginDesignation=='Equipment Co-ordinator'){
?>

<tr>
   <td>
	<table width="100%"  height="20" >
	   
	  <tr>
	  <td>Entry</td>
	 		<td  align="center"><a href='./index.php?keyword=eq+out'>Equipment Present</a></td>   
	 		<td  align="center"><a href='./index.php?keyword=eq+out'>Rental Quotation</a></td>   
	 		<td  align="center"><a href='./index.php?keyword=New+Maintenance+IOW'>New Maintenance</a></td> <td  align="center"><a   href='./index.php?keyword=rate+Item'>Oil &amp; Lub.</a></td>
	  </tr> 
		
	  <tr>
	   <td>Reports</td>
		 <td  align="center"><a href='./index.php?keyword=equipment+details&page=1'>Equipment Details</a></td>
	   <td align="center"><a href="./index.php?keyword=local+eq+ut+report+b">Equipment Usage Details</a></td>
   	     <td  align="center"><a  href='./index.php?keyword=pmview+IOW&status=Raised by PM'>Task Details</a></td>
         <td align="center"><a  href='./index.php?keyword=site+iow+detail&status=Not+Ready'> View Task Detail</a></td>   
       <td align="" ><a href='./index.php?keyword=item+require+eq'>Requisition by Equipment</a></td>
	  </tr> 
	 </table>
   </td>
</tr>

<? }
elseif($loginDesignation=='Site Engineer'){
?>

<tr>
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
		<td>Entry Form</td>	   
		<td  align="center"><a   href='./index.php?keyword=local+emp+recruit'>Recruitment</a></td>
		<!--<td  align="center"><a href='./index.php?keyword=attendance'>Attendance Form</a></td>
		<td  align="center"><a   href='./index.php?keyword=staff+leave+form'>Leave Form</a></td>-->
		<td align="center"><a href='./index.php?keyword=local+emp+attendance'>Direct Labour Attendance</a></td>

	   </tr>
	  <tr>
	   <td>Reports</td>
		 <td  align="center"><a   href='./index.php?keyword=employee+details&a=1&page=1'>Project Human Resources</a></td>	   
<!--		<td  align="center"><a   href='./index.php?keyword=staff+leave+report'>Leave Report</a></td>	-->	
		<td  align="center"><a href='./index.php?keyword=attendance+report'>Attendance Report</a></td>		    
		<td align="center"><a href="./index.php?keyword=local+emp+ut+report+b">Details by date</a></td>
		<td align="center"><a href="./index.php?keyword=local+emp+ut+report+d">Details by Employee</a></td>
		<td align="center"><a href="./index.php?keyword=local+emp+ut+report+c">Summary by Designation</a></td>
		<td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>		
		
	  </tr> 
	   
	 </table>
   </td>
</tr>

<? }

elseif($loginDesignation=='Human Resource Manager'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
	   <td>Entry Form</td>
		 <td  align="center"><a   href='./index.php?keyword=employee+entry'>Recruitment</a></td>
		 <td  align="center"><a   href='./index.php?keyword=leave+form'>Leave Form</a></td>
		 <td  align="center"><a   href='./index.php?keyword=attendance'>Attendance</a></td>
		<td align="center"><a href='./index.php?keyword=local+emp+attendance'>Direct Labour Attendance</a></td>		 
		 <td  align="center"><a href='./index.php?keyword=employee+transfer'>Transfer</a></td>
		 <td  align="center"><a   href='./index.php?keyword=create+job&e=1'>Job</a></td>
		  <td align="center"><a href="employee/salary_Report.php" target="_blank">Salary Structure</a></td>	
         <td align="center"><a href="index.php?keyword=appraisal+action&a=1">Appraisal Action</a></td>
         <td align="center"><a href="index.php?keyword=project+calender">Calander</a></td>	
         <td align="center"><a href="index.php?keyword=monthly+salary+adjustment">Monthly Salary Adjustment</a></td>
		 <td  align="center"><a   href='./index.php?keyword=payments&w=5'>Salary Cash/Bank Allocation</a></td>
		 <td><a  href='./index.php?keyword=mdsalary+advance'>Salary Advance</a></td>
	   <td  align="center" <? if($keyword=='rate Item')echo " id='current' ";?> ><a href='./index.php?keyword=rate+Item'>Enter ItemCode</a></td>
		<td  align="center"><a  href='./index.php?keyword=cash+payment+approval'> Cash Payment Approval</a></td>
		 </tr>
		 <tr>
	   <td rowspan="2"> Reports</td>
		 <td  align="center"><a   href='./index.php?keyword=employee+details&page=1'>Human Resource Details</a></td>
		 <td  align="center"><a   href='./index.php?keyword=released+employee+details&page=1'>Released Human Resource Details</a></td>
		 <!-- <td  align="center"><a   href='./index.php?keyword=staff+leave+report&status=0'>Leave (<? echo countLeave(0,$loginProject);?>)</a></td> -->
		 <td  align="center"><a   href='./index.php?keyword=staff+leave+report&status=0'>Leave(<? echo countLeaveHrm(0,$status);?>)</a></td>
		 <td  align="center"><a  href="./index.php?keyword=site+item+require&type=mat&page=0">Current Req. Material</a></td>	   
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=eqp&page=0">Current Req. Equipment</a></td>	   
	   <td  align="center"><a  href="./index.php?keyword=site+item+require&type=lab&page=0">Current Req. Labour</a></td>  
	   <td  align="center"><a   href='./index.php?keyword=site+rate'>Direct Labour Rate</a></td>
		 <td  align="center"><a   href='./index.php?keyword=month+attendance+report'>Monthly Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td>
	     <tr> 
		 <td align="left"<? if($keyword=='salary disbursment')echo " id='current' ";?>><a href='./index.php?keyword=salary+disbursment'>Salary &amp; Wages Disbursment</a></td>
		 <td  align="center"><a   href='./index.php?keyword=attendance+report'>Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=empSalary+report'>Wages Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=empSalary+report+detail'>Salary Report Detail</a></td>		 
		 		 
		 <td  align="center"><a   href='./index.php?keyword=empsalaryAdv+report'>Adv Salary Report</a></td>		 		 


		       <td align="center"><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a></td>
			   <td  align="center"><a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td>
               <td align="center"><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
               <td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>	

	
         </tr>
	 </table>
   </td>
</tr>
<? }

elseif($loginDesignation=='Executive, HR Productivity management'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
	   <td>Entry Form</td>
		 <td  align="center"><a   href='./index.php?keyword=employee+entry'>Recruitment</a></td>
		 <td  align="center"><a   href='./index.php?keyword=leave+form'>Leave Form</a></td>
		 <td  align="center"><a   href='./index.php?keyword=attendance'>Attendance</a></td>
		<td align="center"><a href='./index.php?keyword=local+emp+attendance'>Direct Labour Attendance</a></td>		 
		 <td  align="center"><a href='./index.php?keyword=employee+transfer'>Transfer</a></td>
         <td align="center"><a href="index.php?keyword=project+calender">Calander</a></td>	
		 <td><a  href='./index.php?keyword=mdsalary+advance'>Salary Advance</a></td>
		<td  align="center"><a  href='./index.php?keyword=cash+payment+approval'> Cash Payment Approval</a></td>
		 </tr>
		 <tr>
	   <td rowspan="2"> Reports</td>
		 <td  align="center"><a   href='./index.php?keyword=employee+details&page=1'>Human Resource Details</a></td>
		 <td  align="center"><a   href='./index.php?keyword=released+employee+details&page=1'>Released Human Resource Details</a></td>
		 <td  align="center"><a   href='./index.php?keyword=staff+leave+report&status=0'>Leave (<? echo countLeave(0,$loginProject);?>)</a></td>	 
		 <td  align="center"><a   href='./index.php?keyword=all+staff+leave+report&status=0'>Leave Verify(<? echo countLeave(0,$loginProject);?>)</a></td>  
		 <td  align="center"><a   href='./index.php?keyword=month+attendance+report'>Monthly Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td>
	     <tr> 
		 <td  align="center"><a   href='./index.php?keyword=attendance+report'>Attendance Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=empSalary+report'>Wages Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=empSalary+report+detail'>Salary Report Detail</a></td>	
		 <td align="center"><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a></td>	
         </tr>
	 </table>
   </td>
</tr>
<? }
//if($loginDesignation=='Store Manager' OR ($loginProject=='004' AND $loginDesignation=='Project Manager')){?>
<? if($loginDesignation=='Store Manager' ){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
		 <td  align="center"><a href='./index.php?keyword=purchase+order+receive'>PO Receive</a></td>	   
		 <td  align="center"><a href='./index.php?keyword=store+entry'>Store Entry</a></td>
		 <td  align="center"><a href='./index.php?keyword=store+return+receive'>Material Receive</a></td>		 
		 <td  align="center"><a href='./index.php?keyword=store'>Store Details</a></td>
		 <td  align="center"><a href='./index.php?keyword=store+transfer'>Material Dispatch</a></td>
		 
		 <td  align="center"><a href='./index.php?keyword=equipment+transfer'>Equipment Dispatch</a></td>
		 <td  align="center"><a href='./index.php?keyword=equipment+receive'>Equipment Receive</a></td>		 		 
		 <td  align="center"><a href='./index.php?keyword=equipment+entry'>New Equipment Receive</a></td>
		 <td  align="center"><a href='./index.php?keyword=equipment+details&page=1'>Equipment Details</a></td>
		 <td  align="center"><a   href='./index.php?keyword=rate+Item'>Enter Rate of Item</a></td>
		 <td  align="center"><a href='./angular/itemcodes.php'>All Item Code</a></td>
	   </tr>
	   
	   <tr bgcolor="#E4E4E4">
          <td rowspan="2" >Reports: </td>
		</tr>
	 </table>
   </td>
</tr>

<? }
elseif($loginDesignation=='Procurement Executive'){?>
<tr><!-- main link-->
   <td>
	<table class="dblue" cellpadding="0" cellspacing="0"> 	 
		 <tr bgcolor="#E4E4E4"><td>Entry Form</td></tr>  
		
				
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payable+approval'>Vendor Payments</a></td></tr>
	
	<tr><td <? if($keyword=='aged vendor payables entry cp')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payable+approval+cp'>Cash Purchase
		</a></td></tr>
		
       <tr ><td align="" ><a href='./index.php?keyword=item+require'>Create Purchase Order</a></td></tr>
       <tr ><td align="" ><a href='./index.php?keyword=item+require+eq'>Requisition by Equipment</a></td></tr>
       <!--<tr ><td   align="" ><a  href='./index.php?keyword=item+require'>Equipment Purchase</a></td></tr>-->
      <tr ><td  ><a  href='./index.php?keyword=purchase+order+report&s=0'>Verify PO</a></td>		</tr>  
      <tr ><td  ><a  href='./index.php?keyword=purchase+order+store+receive&s=0'>Verify Challan</a></td></tr>  
    <td align="" ><a href='./index.php?keyword=mdvendor+Report'>Vendor Evaluation</a></td>
    
	  
	 <tr bgcolor="#E4E4E4"><td>Reports:</td></tr>    
		
		

<!-- 	   <tr ><td  align="left"><a  href="./index.php?keyword=site+item+require&type=mat&page=0">Current Req. Material</a></td></tr>	   
	  <tr ><td  align="left"><a  href="./index.php?keyword=site+item+require&type=eqp&page=0">Current Req. Equipment</a></td></tr>  
	 <tr ><td  align="left"><a  href="./index.php?keyword=site+item+require&type=lab&page=0">Current Req. Labour</a></td></tr> -->
		
		
      <tr><td  ><a  href='./index.php?keyword=store'>Store Stocks Status</a></td></tr>
		<tr><td><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td></tr>
      <tr ><td  ><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td></tr>	
      <tr ><td  ><a href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td></tr>
	   
      <tr><td><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>		</tr>  
	  <tr ><td  align="center"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td></tr>
	
<!--      <tr ><td  ><a href='./index.php?keyword=vendor+payment+report'>Vendor Payment Rep.</a></td></tr>-->
<!--      <tr ><td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td></tr>
	<tr><td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td></tr>-->
<!--<tr><td  <? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td></tr>
<tr><td  <? if($keyword=='htrial balance')echo " id='current' ";?>><a   href='./index.php?keyword=htrial+balance'>Trial Balance</a></td></tr>-->

	 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Project Purchase Officer'){?>
<tr><!-- main link-->
   <td>
		 <table class="dblue" cellpadding="0" cellspacing="0"> 	 
			<tr bgcolor="#E4E4E4"><td>Entry Form</td></tr>
			<tr>
			 <td align="center"><a href='./index.php?keyword=ep+receive'>Receive</a></td>
			</tr>
		 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Procurement Manager'){?>
<tr><!-- main link-->
   <td>
	<table class="dblue" cellpadding="0" cellspacing="0"> 
		<tr bgcolor="#E4E4E4"><td>Entry Form</td></tr>  
    <tr ><td  ><a  href='./index.php?keyword=purchase+order+report&s=0'>Edit/Forward Purchase Order</a></td></tr>
    <!--<tr ><td   align="" ><a  href='./index.php?keyword=item+require'>Equipment Purchase</a></td></tr>-->
    <tr ><td   align="" ><a  href=''>Fixed Asset Purchase</a></td></tr>
     <tr ><td  align=""  ><a href="./index.php?keyword=vendor"> New Vendor</a></td></tr>
		 <tr><td ><a href='./index.php?keyword=cash+payment+approval'> Cash Payment Approval</a></td></tr>
    
	  
	 <tr bgcolor="#E4E4E4"><td>Reports:</td></tr>    
	  <tr ><td  align=""><a  href="./index.php?keyword=site+item+require&type=eqp&page=0">Current Req.</a></td></tr>
      <tr ><td  ><a  href='./index.php?keyword=store'>Store Stocks</a></td></tr>	
      <tr ><td  ><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td></tr>	
      <tr ><td  ><a href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td></tr>
	   
      <tr ><td  ><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>		</tr>  
      <tr ><td  ><a href='./index.php?keyword=equipment+purchase'>Equipment Purchase</a></td></tr>
	  <tr ><td  align=""><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td></tr>
	  <tr><td><a href='./index.php?keyword=rate+Item'>Enter Rate of Item</a></td></tr>
	  <tr><td><a href='./angular/itemcodes.php'>All Item Code</a></td></tr>

	  <tr><td  align="center"><a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td></tr>
	  <tr><td align="center"><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td></tr>
	  <tr><td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td></tr>
	  

	


	
<!--      <tr ><td  ><a href='./index.php?keyword=vendor+payment+report'>Vendor Payment Rep.</a></td></tr>-->
<!--      <tr ><td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td></tr>
	<tr><td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td></tr>-->
<!--<tr><td  <? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td></tr>
<tr><td  <? if($keyword=='htrial balance')echo " id='current' ";?>><a   href='./index.php?keyword=htrial+balance'>Trial Balance</a></td></tr>-->

	 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Price Management Executive'){ ?>
<tr><!-- main link-->
   <td>
	<table class="dblue" width="40%">
	 <tr bgcolor="#E4E4E4">
	   <td>Entry Form</td></tr>
		<tr ><td  ><a href='./index.php?keyword=enter+Quotation'>Enter Quotation</a></td></tr>
     <tr > <td   align="" ><a   href='./index.php?keyword=rate+DMA'>Update Price &amp; Validity</a></td></tr>

<?php
if($loginProject=="000" & 1==2){ //turned off for random change purformed by user
?>
	   <tr ><td  ><a   href='./index.php?keyword=rate+Item'>Enter ItemCode</a></td></tr>	    
<?php } ?>   
	   

    </tr>

	
	   <tr bgcolor="#E4E4E4">
          <td rowspan="" >Reports: </td></tr>
	 

    <tr ><td  align=""  ><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>	</tr>
  <tr >  <td align="" ><a href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td></tr>
	<tr ><td align=""><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>	</tr>
		  
		
      
	 </table>
   </td>
</tr>
<? }

/*
<!--temp-->
<!-- 
     <td  align="center"  ><a href="./index.php?keyword=vendor"> New Vendor</a></td>
 <td   align="center" ><a   href='./index.php?keyword=rate+DMA'>Enter Rate of DMA</a></td>
      <td   align="center" ><a  href='./index.php?keyword=item+require'>Create Purchase Order</a></td>
	 
	    <td  align="center"  ><a href='./index.php?keyword=equipment+purchase'>Equipment Purchase</a></td>
    <td align="center"   ><a  href='./index.php?keyword=store'>Store Stocks</a></td>
   <td  align="center"  ><a href='./index.php?keyword=equipment+purchase'>Equipment Purchase</a></td>
    <td align="center"   ><a  href='./index.php?keyword=store'>Store Stocks</a></td>
	<td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td>	 
	<td align="center"><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>	
	<td  align="center"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td>
	-->
<!--temp-->	
*/

elseif($loginDesignation=='Supply Chain Management'){ ?>
<tr><!-- main link-->
   <td>
	<table class="dblue" width="50%">
	 <tr bgcolor="#E4E4E4">
	   <td>Entry Form</td>
     <td  align="center"  ><a href="./index.php?keyword=vendor"> New Vendor</a></td>	 
    <td align="center" ><a href='./index.php?keyword=mdvendor+Report'>Vendor Evaluation</a></td>
     
    </tr>

	
	   <tr bgcolor="#E4E4E4">
          <td rowspan="" >Reports: </td>
    <td  align="center"  ><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>	
    <td align="center" ><a href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td>
		  
		</tr>
      
	 </table>
   </td>
</tr>
<? }


elseif($loginDesignation=='Project Engineer'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
	     <td >Entry Form: </td>
		 <td  align="center"><a  href='./index.php?keyword=enter+item+work'>New IOW</a></td>
<!--	<td  align="center"><a  href='./index.php?keyword=item+require'>Create Purchase Order</a></td>-->
		 <td  align="center"><a  href='./index.php?keyword=site+item+required'>Emergency Purchase</a></td>			 
		 <td  align="center"><a  href='./index.php?keyword=tool_eq+require'>Tools &amp; Equipment Pur. Req.</a></td>		 
		 <td  align="center"><a  href='./index.php?keyword=purchase+order+report&s=0'>Purchase Order</a></td>
		 <td  align="center"><a href='./index.php?keyword=new+invoice'>New Invoice</a></td>	
<!-- 		 <td  align="center"<? if($keyword=='income statement')echo " id='current' ";?>><a   href='./index.php?keyword=income+statement'>Income Statement</a></td>	  -->
	   </tr>
	   <tr bgcolor="#E4E4E4">
          <td rowspan="2" >Reports: </td>
 <td  align="center"><a href='./index.php?keyword=equipment+details&page=1'>Equipment Details</a></td>
			 <td  align="center"><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td>
		 <td  align="center"><a  href='./index.php?keyword=item+require&p=1'>Requisition</a></td>
         <td align="center"><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
         <td align="center"><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a></td>
		 <td align="center"><a href="index.php?keyword=view+invoice">Invoice</a></td>
 		 <td  align="center"><a  href='./index.php?keyword=store'>Inventory Status</a></td>
		 <td  align="center"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td>
 

		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Equipment Schedule</a></td>

		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Manpower Schedule</a></td> 
			 
	   </tr>
	   <tr bgcolor="#E4E4E4">
<!-- 		 <td  align="center"><a   href='./index.php?keyword=employee+details&a=1&page=1'>Human Resource Details</a></td>		  -->
<!--    	     <td  align="center"><a href='./index.php?keyword=ongoing+project+main'>Ongoing Projects</a></td> -->
   	     <td  align="center"><a  href='./index.php?keyword=pmview+IOW&status=Raised by PM'>IOW</a></td>
         <td align="center"><a  href='./index.php?keyword=site+iow+detail&status=Not+Ready'> View IOW Detail</a></td>
		 <!-- <td  align="center"><a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td> -->
		 <td  align="center"><a   href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td>		 
		 <td  align="center"><a href='./index.php?keyword=mdvendor+payment'>Vendor Payment</a></td>	
	     <td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>
	     <td  align="center"><a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td>
         <td align="center"><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>



		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Material Schedule</a></td>

		 <td  align="center" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Sub-Contractor Schedule</a></td>
			 
	   </tr>
	   
	 </table>
   </td>
</tr>
<? }



elseif($loginDesignation=='Manager Planning & Control'){?>
<tr><!-- main link-->
   <td>
	<table width="100%"  height="20" >
	   <tr bgcolor="#CCCCCC">
	     <td >Entry Form: </td>
		 <td  align="center"><a  href='./index.php?keyword=create+new+project'>Create New project</a></td>
		 <td  align="center"><a  href='./index.php?keyword=enter+item+work'>New IOW</a></td>
<!--	<td  align="center"><a  href='./index.php?keyword=item+require'>Create Purchase Order</a></td>-->
		 <td  align="center"><a  href='./index.php?keyword=tool_eq+require'>Tools & Equipment Pur. Req.</a></td>		 
		 <td  align="center"><a  href='./index.php?keyword=purchase+order+report&s=0'>All Purchase Order</a></td>
		 <td  align="center"><a href='./index.php?keyword=new+invoice'>New Invoice</a></td>	
		 <td  align="center"<? if($keyword=='income statement')echo " id='current' ";?>><a   href='./index.php?keyword=income+statement'>Income Statement</a></td>
		 <td  align="center"><a   href='./index.php?keyword=staff+leave+report&status=0'>Leave</a></td>
		<td  align="center"><a  href='./index.php?keyword=cash+payment+approval'> Cash Payment Approval</a></td>	 
	   </tr>
	   <tr bgcolor="#E4E4E4">
          <td rowspan="2" >Reports: </td>
		<td align="center"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td>
		 <td  align="center"><a  href='./index.php?keyword=item+require&p=1'>Requisition</a></td>
         <td align="center"><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
         <td align="center"><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a></td>
		 <td align="center"><a href="index.php?keyword=view+invoice">ALL Invoice</a></td>
 		 <td  align="center"><a  href='./index.php?keyword=store'>Inventory Status</a></td>
		 <td  align="center"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td>		 		 		 		 		  		 
	   </tr>
	   <tr bgcolor="#E4E4E4">
        
		 <td  align="center"><a   href='./index.php?keyword=employee+details&a=1&page=1'>Human Resource Details</a></td>		 
   	     <td  align="center"><a href='./index.php?keyword=ongoing+project+main'>Ongoing Projects</a></td>
   	     <td  align="center"><a  href='./index.php?keyword=pmview+IOW&status=Raised by PM'>All IOW</a></td>
		 <td  align="center"><a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td>
		 <td  align="center"><a   href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td>		 
		 <td  align="center"><a href='./index.php?keyword=mdvendor+payment'>Vendor Payment</a></td>		 
        <td align="center"><a href="./index.php?keyword=subCon+poreport">Subcontractor report</a></td>	

			 

	   </tr>
	   
	 </table>
   </td>
</tr>
<? }
elseif($loginDesignation=='Finance Executive'){?>
<table  width="100%" class="dblue" >
<tr bgcolor="#E4E4E4">
<td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td>
<td  align="center"<? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td>
<td  align="center"<? if($keyword=='htrial balance')echo " id='current' ";?>><a   href='./index.php?keyword=htrial+balance'>Trial Balance</a></td>
<td  align="center"<? if($keyword=='income statement')echo " id='current' ";?>><a   href='./index.php?keyword=income+statement'>Income Statement</a></td>
<td  align="right"<? if($keyword=='balance sheet')echo " id='current' ";?>><a   href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td>
<td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td>	
<td  align="right"<? if($keyword=='financial overview')echo " id='current' ";?>><a   href='./index.php?keyword=financial+overview'>Financial  Overview</a></td>

</tr>

</table>
</td>
</tr>
<? }
elseif($loginDesignation=='Accounts Executive'){?>
<table  width="100%" class="dblue">	
	 <tr bgcolor="#E4E4E4">
	   <td>Entry Form</td>
     <td  align="right"<? if($keyword=='aged vendor payables')echo " id='current' ";?>><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td>	
		 <td <? if($keyword=='aged vendor payables entry cp')echo " id='current' ";?>>
	<a href='./index.php?keyword=aged+vendor+payable+approval+cp'>Cash Purchase
			</a></td>
   </tr>
	   <tr bgcolor="#E4E4E4">
          <td rowspan="" >Reports: </td>
<td  align="left"<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td>

<td  align="center"<? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td>
<td  align="center"<? if($keyword=='po ledger')echo " id='current' ";?>><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>

<td  align="center"<? if($keyword=='income statement')echo " id='current' ";?>><a   href='./index.php?keyword=income+statement'>Income Statement</a></td>
<td  align="right"<? if($keyword=='balance sheet')echo " id='current' ";?>><a   href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td>
			 
<td <? if($keyword=='purchase order report')echo " id='current' ";?>>
<a href="index.php?keyword=purchase+order+report&s=0">Purchase Order</a></td>

</tr>

</table>
</td>
</tr>
<? }
elseif($loginDesignation=='Managing Director'){?>
<tr><!-- main link-->
<td>
<table class="dblue" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC"><td align="center"  rowspan="8">Waiting for Approval:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="7" width="10"></td></tr>
<tr><td <? if($keyword=='mdview IOW')echo " id='current' ";?>>
<a   href="index.php?keyword=mdview+IOW&status=Forward%20to%20MD"> IOW (<? echo countiow ("Forward to MD",'');?> nos)</a></td></tr>
<tr><td <? if($keyword=='purchase order report')echo " id='current' ";?>>
<a href="index.php?keyword=purchase+order+report&s=0">Purchase Order (<? echo countpo(0);?> nos)</a></td></tr> 

<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payable+approval'>Vendor Payments ( <?php echo vendorApprovalCounter(); ?> nos)</a></td></tr> 


<tr><td <? if($keyword=='staff leave report')echo " id='current' ";?>>
<a   href='./index.php?keyword=staff+leave+report&status=1'>Leave (<? echo countLeave(1,'');?>)</a></td></tr>
<tr><td  <? if($keyword=='mdsalary advance')echo " id='current' ";?>>
<a  href='./index.php?keyword=mdsalary+advance'>Salary Advance</a></td></tr>		 
<tr><td<? if($keyword=='view invoice')echo " id='current' ";?>>
<a href="index.php?keyword=view+all+invoice&s=1">Invoice (<? echo countInvoice(1);?> nos)</a></td></tr>
<tr><td height="10" bgcolor="#FFFFFF" colspan="3" ></td></tr>
<tr bgcolor="#CCCCCC"><td rowspan="21">Reports:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="21" ></td></tr>
<!--<tr><td><a href="../bfewsales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>
<tr><td><a href="../sales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>-->
<tr><td  <? if($keyword=='income statement')echo " id='current' ";?>>
<a   href='./index.php?keyword=income+statement'>Income Statement</a></td></tr>

<tr>
  <td  align="left" <? if($keyword=='site daily report')echo " id='current' ";?>>
<a href='./index.php?keyword=site+daily+report'>Work Progress Report</a></td></tr>
<tr><td>
</td></tr>
<tr><td>
</td></tr>
<tr><td>
</td></tr>
<tr><td>
</td></tr>
<tr ><td>
</td></tr>


<tr><td><a  href='./index.php?keyword=item+require'>Site Requisitions</a></td></tr>
<tr><td>
</td></tr>
<tr><td >
</td></tr>	
<tr><td >
</td></tr>
<tr><td>
</td></tr>
<tr><td <? if($keyword=='aged vendor payables')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td></tr>
<tr><td <? if($keyword=='store')echo " id='current' ";?>><a  href='./index.php?keyword=store'>Inventory Status</a>
</td></tr>
<tr ><td ><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a>
</td></tr>
<tr><td><a href='./index.php?keyword=local+emp+ut+report+b'>Direct Labour Utilization</a>
</td></tr>
<tr><td>
</td></tr>
<tr><td  <? if($keyword=='balance sheet')echo " id='current' ";?>>
<a   href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td></tr>
<tr><td  <? if($keyword=='financial overview')echo " id='current' ";?>>
<a   href='./index.php?keyword=financial+overview'>Financial Overview</a></td></tr>
<tr><td height="10" bgcolor="#FFFFFF" colspan="3" ></td></tr>
<tr >
  <td rowspan="39" bgcolor="#CCCCCC">Journals and Ledgers</td>
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='daily attendance report')echo " id='current' ";?>><a    href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td>

</tr>
<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td  <? if($keyword=='equipment details')echo " id='current' ";?>><a  href='./index.php?keyword=equipment+details&a=2&page=0'>Equipment Details</a></td>
</tr>
<tr>
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td <? if($keyword=='attendance report')echo " id='current' ";?>><a   href='./index.php?keyword=attendance+report'>Attendance Report</a></td>
</tr>
<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='employee details')echo " id='current' ";?>><a   href='./index.php?keyword=employee+details&a=1&page=1'>Human Resource Details</a></td>

</tr>

<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='mdvendor Report')echo " id='current' ";?>><a  href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td>

</tr>
<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='inventory activity')echo " id='current' ";?>><a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td>

</tr>

<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='mr report')echo " id='current' ";?>><a href='./index.php?keyword=mr+report'>MR Report</a></td>

</tr>

<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='po ledger')echo " id='current' ";?>><a href='./index.php?keyword=po+ledger'>PO Ledger</a></td>

</tr>
<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='cash disbursment')echo " id='current' ";?>><a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td>

</tr>
<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='cash receivejournal')echo " id='current' ";?>><a href='./index.php?keyword=cash+receivejournal'>Cash Receive Journal</a></td>

</tr>

<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td<? if($keyword=='general ledger')echo " id='current' ";?>><a href='./index.php?keyword=general+ledger'>General Ledger</a></td>

</tr>

<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td  <? if($keyword=='htrial balance')echo " id='current' ";?>><a   href='./index.php?keyword=htrial+balance'>Trial Balance</a></td>

</tr>

<tr >
  <td rowspan="3" bgcolor="#0066FF"></td>
 <td></td>
 </tr>
<tr>
<td></td>
</tr>
<tr>
<td></td>

</tr>



</table>
</td>
</tr>

<? }
//Director
elseif($loginDesignation=='Director'){?>
<tr><!-- main link-->
<td>
<table class="dblue" cellpadding="0" cellspacing="0">
<!--<tr bgcolor="#CCCCCC"><td align="center"  rowspan="7">Waiting for Approval:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="6" width="2"></td></tr>
<tr><td <? if($keyword=='mdview IOW')echo " id='current' ";?>>
<a   href="index.php?keyword=mdview+IOW&status=Forward%20to%20MD"> IOW (<? echo countiow ("Forward to MD",'');?> nos)</a></td></tr>
<tr><td <? if($keyword=='purchase order report')echo " id='current' ";?>>
<a href="index.php?keyword=purchase+order+report&s=0">Purchase Order (<? echo countpo(0);?> nos)</a></td></tr> 
<tr><td <? if($keyword=='staff leave report')echo " id='current' ";?>>
<a   href='./index.php?keyword=staff+leave+report&status=1'>Leave (<? echo countLeave(1,'');?>)</a></td></tr>
<tr><td  <? if($keyword=='mdsalary advance')echo " id='current' ";?>>
<a  href='./index.php?keyword=mdsalary+advance'>Salary Advance</a></td></tr>		 
<tr><td<? if($keyword=='view invoice')echo " id='current' ";?>>
<a href="index.php?keyword=view+all+invoice&s=1">Invoice (<? echo countInvoice(1);?> nos)</a></td></tr>
<tr><td height="10" bgcolor="#FFFFFF" colspan="3" ></td></tr>-->
<tr bgcolor="#CCCCCC"><td rowspan="26" width="100">Reports:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="26" width="10"></td></tr>
<!--<tr><td><a href="../bfewsales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>-->
<tr><td<? if($keyword=='view invoice')echo " id='current' ";?>>
<a href="index.php?keyword=view+all+invoice&s=1">Invoice (<? echo countInvoice(1);?> nos)</a></td></tr>
<!--<tr><td><a href="../sales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>-->
<tr><td  align="left" <? if($keyword=='site daily report')echo " id='current' ";?>>
<a href='./index.php?keyword=site+daily+report'>Daily Progress Report</a></td></tr>
<tr><td <? if($keyword=='daily attendance report')echo " id='current' ";?>>
<a    href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td></tr>
<tr><td <? if($keyword=='equipment details')echo " id='current' ";?>>
<a  href='./index.php?keyword=equipment+details&a=2&page=1'>Equipment Details</a></td></tr>
<tr><td<? if($keyword=='attendance report')echo " id='current' ";?>>
<a   href='./index.php?keyword=attendance+report'>Attendance Report</a></td></tr>
<tr><td   <? if($keyword=='employee details')echo " id='current' ";?>>
<tr><td><a  href="./employee/createJob1.php" target="_blank">Employee Job Entry Form</a></td></tr>
<tr> <td><a   href='./index.php?keyword=create+job&e=1'>Employee Job Details</a></td></tr>
<tr><td><a   href='./index.php?keyword=employee+details&a=1&page=1'>Human Resource Details</a></td></tr>
<tr><td><a  href="./employee/salary_Report.php" target="_blank">Salary Report</a></td></tr>

<tr><td><a  href="./employee/salary_static_Report.php" target="_blank">Salary Structure</a></td></tr>

<tr ><td  <? if($keyword=='mdvendor Report')echo " id='current' ";?>>
<a  href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td></tr>
<tr><td <? if($keyword=='store')echo " id='current' ";?>>
<a  href='./index.php?keyword=store'>Inventory Status</a></td></tr>
<tr><td <? if($keyword=='inventory activity')echo " id='current' ";?>>
<a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td></tr>	
<tr><td <? if($keyword=='mr report')echo " id='current' ";?>>
<a href='./index.php?keyword=mr+report'>MR Report</a></td></tr>
<tr><td <? if($keyword=='po ledger')echo " id='current' ";?>>
<a href='./index.php?keyword=po+ledger'>PO Ledger</a></td></tr>
<tr><td <? if($keyword=='aged vendor payables')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td></tr>
<tr ><td <? if($keyword=='cash disbursment')echo " id='current' ";?>>
<a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td></tr>
<tr ><td <? if($keyword=='cash receivejournal')echo " id='current' ";?>>
<a href='./index.php?keyword=cash+receivejournal'>Cash Receive Journal</a></td></tr>
<tr><td  <? if($keyword=='general ledger')echo " id='current' ";?>>
<a href='./index.php?keyword=general+ledger'>General Ledger</a></td></tr>
<tr><td  <? if($keyword=='htrial balance')echo " id='current' ";?>>
<a   href='./index.php?keyword=htrial+balance'>Trial Balance</a></td></tr>
<tr><td  <? if($keyword=='income statement')echo " id='current' ";?>>
<a   href='./index.php?keyword=income+statement'>Income Statement</a></td></tr>
<tr><td  <? if($keyword=='balance sheet')echo " id='current' ";?>>
<a   href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td></tr>
<tr><td  <? if($keyword=='financial overview')echo " id='current' ";?>>
<a   href='./index.php?keyword=financial+overview'>Financial  Overview</a></td></tr>

</table>
</td>
</tr>
<? }








//Chairman
elseif($loginDesignation=='Chairman & Managing Director'){?>
<tr><!-- main link-->
<td>
<table class="dblue" cellpadding="0" cellspacing="0">
<tr bgcolor="#CCCCCC"><td align="center"  rowspan="19">Waiting for Approval:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="18" width="2"></td></tr>
<tr><td <? if($keyword=='mdview IOW')echo " id='current' ";?>>
<a href="index.php?keyword=mdview+IOW&status=Forward%20to%20MD"> Task (<? echo countiow ("Forward to MD",'');?> nos)</a></td></tr>

<tr><td><a href='./index.php?keyword=cash+payment+approval'> Cash Payment Approval</a></td></tr>

<tr><td <? if($keyword=='mdview IOW maintenance')echo " id='current' ";?>>
<a href="index.php?keyword=mdview+IOW+maintenance&status=Forward%20to%20MD"> Maintenance Task (<? echo countiow_maintenance("Forward to MD",'004');?> nos)</a></td></tr>

<!-- <tr><td <? if($keyword=='mdview IOW')echo " id='current1' ";?>><a href="index.php?keyword=mdview+IOW&status=Forward%20to%20MD"> Maintenance Task (<? echo countiow ("Forward to MD",'');?> nos)</a></td></tr> -->

<tr><td <? if($keyword=='purchase order report')echo " id='current' ";?>>
<a href="index.php?keyword=purchase+order+report&s=0">Purchase Order (<? echo countpo(0);?> nos)</a></td></tr> 
<tr><td <? if($keyword=='staff leave report')echo " id='current' ";?>>
<a   href='./index.php?keyword=staff+leave+report&status=1'>Leave (<? echo countLeave(1,'');?>)</a></td></tr>
<tr><td  <? if($keyword=='mdsalary advance')echo " id='current' ";?>>
<a  href='./index.php?keyword=mdsalary+advance'>Salary Advance</a></td></tr>		 
<!-- <tr><td<? if($keyword=='view invoice')echo " id='current' ";?>><a href="index.php?keyword=view+all+invoice&s=1">Invoice (<? echo countInvoice(1);?> nos)</a></td></tr> -->
	
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payable+approval'>Vendor Payments ( <?php echo vendorApprovalCounter(); ?> nos)</a></td></tr>		
	
	<tr><td <? if($keyword=='aged vendor payables entry cp')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payable+approval+cp'>Cash Purchase 
	( <?php echo vendorApprovalCounter("cp"); ?> nos)
		</a></td></tr>	
	
	<tr><td <? if($keyword=='itemcode approval')echo " id='current' ";?>>
<a href='./index.php?keyword=itemcode+approval'>Equipment Consumables
	( <?php echo itemCodeApprovalCounter(); ?> nos)
		</a></td></tr>
	
	
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=appraisal+action+md1&aa=1'>Release Employee ( <?php echo appraisalActionCounter(1); ?> nos)</a></td></tr>
	
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=appraisal+action+md&aa=2'>Suspention ( <?php echo appraisalActionCounter(2); ?> nos)</a></td></tr> 	
	
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=appraisal+action+md&aa=3'>Promotion / Demotion ( <?php echo appraisalActionCounter(3); ?> nos)</a></td></tr>
	
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=appraisal+action+md&aa=4'>Increment ( <?php echo appraisalActionCounter(4); ?> nos)</a></td></tr>	
	
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=appraisal+action+md&aa=5'>Bonus ( <?php echo appraisalActionCounter(5); ?> nos)</a></td></tr>	
	
	<tr><td <? if($keyword=='aged vendor payables entry')echo " id='current' ";?>>
<a href='./index.php?keyword=appraisal+action+md&aa=6'>Incentive ( <?php echo appraisalActionCounter(6); ?> nos)</a></td></tr>
	
<tr><td <? if($keyword=='show force close po')echo " id='current' ";?>>
<a href='./index.php?keyword=show+force+close+po'>PO Force Close Approval ( <?php// echo count_po_fc_approval(); ?> nos)</a></td></tr>
	
	<tr><td <? if($keyword=='show force close po invoice')echo " id='current' ";?>>
<a href='./index.php?keyword=show+force+close+po+invoice'>PO Invoice Force Close Approval ( <?php// echo count_po_invoice_fc_approval(); ?> nos)</a></td></tr>
	
	
	
	
<tr><td height="10" bgcolor="#FFFFFF" colspan="3" ></td></tr>

<!-- <tr bgcolor="#CCCCCC"><td align="center"  rowspan="4">Waiting for Approval:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="3" width="2"></td></tr>
<tr><td <? if($keyword=='mdview IOW')echo " id='current' ";?>>
<a   href="index.php?keyword=mdview+IOW&status=Forward%20to%20MD"> IOW (<? echo countiow ("Forward to MD",'');?> nos)</a></td></tr>
<tr><td <? if($keyword=='aged vendor payables')echo " id='current' ";?>>
<a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payables</a></td></tr>
<tr><td height="10" bgcolor="#FFFFFF" colspan="3"></td></tr> -->



<tr bgcolor="#CCCCCC"><td rowspan="8" width="100">Construction Reports:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="7" width="10"></td></tr>

	
<tr><td  align="left" <? if($keyword=='site daily report')echo " id='current' ";?>>
<a href='./index.php?keyword=site+daily+report'>Work Progress Report</a></td></tr>
	
<tr><td  align="left" <? if($keyword=='local emp ut report dd')echo " id='current' ";?>><a href='./index.php?keyword=local+emp+ut+report+dd'>Labour Utilization</a></td>
	</tr>
<tr><td  align="left" <? if($keyword=='local eq ut report b')echo " id='current' ";?>><a href='./index.php?keyword=local+eq+ut+report+b'>Equipment Utilization</a></td>
	
<tr><td  align="left" <? if($keyword=='local eq ut report d')echo " id='current' ";?>><a href='./index.php?keyword=local+eq+ut+report+d'>Equipment Log Report</a></td>
	</tr>
<tr>	
		 <td  align="left" <? if($keyword=='item require')echo " id='current' ";?>><a  href='./index.php?keyword=item+require&p=1'>Requisition</a></td>
	</tr>
<tr>	
		 <td  align="left" <? if($keyword=='item require eq')echo " id='current' ";?>><a  href='./index.php?keyword=item+require+eq'>Requisition by Equipment</a></td>
	</tr>
	
	
	
	
<tr><td height="10" bgcolor="#FFFFFF" colspan="3"></td></tr>


<tr bgcolor="#CCCCCC"><td rowspan="8" width="100">Financial Reports:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="7" width="10"></td></tr>
<!--<tr><td><a href="../bfewsales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>-->
<tr><td<? if($keyword=='view invoice')echo " id='current' ";?>>
<a href="index.php?keyword=view+all+invoice&s=1">Invoice (<? echo countInvoice(1);?> nos)</a></td></tr>
<!--<tr><td><a href="../sales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>-->


<tr><td  align="lef"><a href='./index.php?keyword=closing+cash+inventory'>Closing Cash &amp; Inventory</a></td></tr>
<tr><td  align="lef"><a href='./index.php?keyword=Daily+Site+Cash+Report'>Daily site cash report</a></td></tr>
<tr><td  align="lef"><a href='./index.php?keyword=aged+vendor+payables'>Aged Vendor Payable</a></td></tr>

<!--<tr><td   <? if($keyword=='employee details')echo " id='current' ";?>>-->




<tr><td  <? if($keyword=='income statement')echo " id='current' ";?>>
<a   href='./index.php?keyword=income+statement'>Income Statement</a></td></tr>
<tr><td  <? if($keyword=='balance sheet')echo " id='current' ";?>>
<a   href='./index.php?keyword=balance+sheet'>Balance Sheet</a></td></tr>
<!--<tr><td  <? if($keyword=='financial overview')echo " id='current' ";?>>
<a   href='./index.php?keyword=financial+overview'>Financial  Overview</a></td></tr>-->
<tr><td height="10" bgcolor="#FFFFFF" colspan="3"></td></tr>




<tr bgcolor="#CCCCCC"><td rowspan="6" width="100">Financial Ledgers:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="5" width="10"></td></tr>
<!--<tr><td><a href="../bfewsales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>-->

<!--<tr><td><a href="../sales/user/redirect.php?un=md&up=md&keyword=create+new+project" target="_blank"> Sales</a></td></tr>-->



<!--<tr><td   <? if($keyword=='employee details')echo " id='current' ";?>>-->




<tr ><td <? if($keyword=='cash disbursment')echo " id='current' ";?>>
<a href='./index.php?keyword=cash+disbursment'>Cash Disbursment</a></td></tr>
<tr ><td <? if($keyword=='cash receivejournal')echo " id='current' ";?>>
<a href='./index.php?keyword=cash+receivejournal'>Cash Receive Journal</a></td></tr>
<tr><td  <? if($keyword=='general ledger')echo " id='current' ";?>>
<a href='./index.php?keyword=general+ledger'>General Ledger</a></td></tr>
<tr><td  <? if($keyword=='htrial balance')echo " id='current' ";?>>
<a   href='./index.php?keyword=htrial+balance'>Trial Balance</a></td></tr>

<tr><td height="10" bgcolor="#FFFFFF" colspan="3"></td></tr>




<tr bgcolor="#CCCCCC"><td rowspan="8" width="100">Inventory Reports:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="7" width="10"></td></tr>
<tr ><td  <? if($keyword=='mdvendor Report')echo " id='current' ";?>>
<a  href='./index.php?keyword=mdvendor+Report'>Vendor Report </a></td></tr>
<tr><td <? if($keyword=='store')echo " id='current' ";?>>
<a  href='./index.php?keyword=store'>Inventory Status</a></td></tr>
<tr><td <? if($keyword=='inventory activity')echo " id='current' ";?>>
<a href='./index.php?keyword=inventory+activity'>Inventory Unit Activity</a></td></tr>	
<tr><td <? if($keyword=='mr report')echo " id='current' ";?>>
<a href='./index.php?keyword=mr+report'>MR Report</a></td></tr>
<tr><td <? if($keyword=='po ledger')echo " id='current' ";?>>
<a href='./index.php?keyword=po+ledger'>PO Ledger</a></td></tr>
<tr><td <? if($keyword=='equipment details')echo " id='current' ";?>>
<a  href='./index.php?keyword=equipment+details&a=2&page=1'>Equipment Details</a></td></tr>
<tr><td height="10" bgcolor="#FFFFFF" colspan="3"></td></tr>


<tr bgcolor="#CCCCCC"><td rowspan="7" width="100">HR Reports:</td></tr>
<tr bgcolor="#0066FF"><td rowspan="6" width="10"></td></tr>
<tr><td <? if($keyword=='daily attendance report')echo " id='current' ";?>>
<a    href='./index.php?keyword=daily+attendance+report'>Daily Attendance Report</a></td></tr>
<tr><td<? if($keyword=='attendance report')echo " id='current' ";?>>
<a href='./index.php?keyword=attendance+report'>Attendance Report</a></td></tr>
<tr><td><a href='./index.php?keyword=employee+details&a=1&page=1'>Human Resource Details</a></td></tr>
<tr><td><a href="./employee/salary_Report.php" target="_blank">Salary Report</a></td></tr>
<tr><td><a  href="./employee/salary_static_Report.php" target="_blank">Salary Structure</a></td></tr>






</table>
</td>
</tr>
<? }







elseif($loginDesignation=='admin'){?>
<tr><!-- main link-->
   <td bgcolor="#444444" >
	<table border="0" id="headbar" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
	   <tr >
		 <td ><a href="./index.php"> Home</a></td>
		 <td ><ul><? if($keyword=='create new project')echo "<li id='current'>"; else echo "<li >";?>
		    <a href="./index.php?keyword=create+new+project"> Projects</a></td>
		 <td ><ul> <? if($keyword=='New User')echo "<li id='current'>"; else echo "<li >";?>
		 <a href="./index.php?keyword=New+User"> New User</a></td>
		 <td <? if($keyword=='edit user') echo "id='current'";?> > <a href="./index.php?keyword=edit+user"> Edit User</a></td>
         <td align="center"><a href="index.php?keyword=purchase+order+report&s=0">Purchase Order (<? echo countpo(0);?> nos)</a></td> 		 
         <td align="center"><a href="index.php?keyword=adminviewIOW">IOW</a></td>
	   </tr>
	 </table>
   </td>
</tr>
<? }//else ?>
</table>
