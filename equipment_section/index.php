<?php /**/  ");}?><?php
include("common.php");
CreateConnection();
//assigning todates date...
$today_date=date('Y-m-d');
//echo"$today_date";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Equipment Section - Home Page</title>
<!-- JAVA SCRIPT FOR THE MENUE -->
<script type="text/javascript" language="JavaScript1.2" src="stm31.js"></script>
<!-----   END  ----------------->

<!-- Javascript for using xmlhttp obsects -->
<script src="script.js" type="text/javascript"></script>
<!--  END -->

<script language="javascript">

//----------------------------------These Functions are for the member of Employee Menue under Edit menu----------------//

//----Opens a seperet window to load EmployeeManagmentScreen.php page.....
function employee_managment(){
var centerWidth=(screen.width/2)-(200/2);
var centerHeight=(screen.height/2)-(200/2);
winpops=window.open("EmployeeManagment.php","","height=400,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a sepere window to load EmployeeCategoryManagment.php page.....
function open_category(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EmployeeCategoryManagment.php","","height=250,width=350,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}




//----Opens a seperet window to load EmployeeStatusManagment.php page.....
function emp_status(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EmployeeStatusManagment.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}


//----Opens a seperet window to load EmployeeTypeManagment.php page.....
function emp_type(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EmployeeTypeManagment.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}

//----Opens a seperet window to load EmployeeEmailManagment.php page.....
function emp_email(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EmployeeEmailManagment.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}

//-------------------------------------------END-----------------------------------------------------------------------//

//----------------------------------These Functions are for the member of Employee Menue under Edit menu----------------//

//----Opens a seperet window to load  page.....
function fluid_type(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("FluidTypes.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}

//----Opens a seperet window to load FluidUnitsType.php page.....
function fluid_unit_type(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("FluidUnitsType.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}



//----Opens a seperet window to load EquipmentRepairTypeSetup.php page.....
function openpopup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EquipmentRepairTypeSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}


//----Opens a seperet window to load PMTypeSetup.php page.....
function open_pm_type(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("PMTypeSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}



//-------------------------------------------FOR PART SUBMENU UNDER SETUP MENU--------------------------------------------//

//----Opens a seperet window to load PartCategorySetup.php page.....
function open_part_category(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("PartCategorySetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}

//----Opens a seperet window to load PartManufacturersSetup.php page.....
function open_part_manufacturer(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("PartManufacturersSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}

//----Opens a seperet window to load PartUnitsSetup.php page.....
function open_part_unit(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("PartUnitsSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}

//------------------------------------------------------------------------------END-----------------------------------------

//-------------------------------------------END-----------------------------------------------------------------------//

//----Opens a seperet window to load NewWorkWorder_Add_PM_Entry.php page.....
function open_work_order_Add_PM_Entry(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("NewWorkWorder.php","","height=500,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a seperet window to load work_order_managment.php page.....
function open_work_order_managment(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("WorkOrderManagment.php","","height=500,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}



//-------------------------For INVENTORY-------------------------//

//----Opens a seperet window to load PartsInventory.php(For part inventory menu under inventory menu) page(WHICH DISPLAYS CREATED part LIST).....
function open_part_list(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("PartsInventory.php","","height=400,width=900,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a seperet window to load Tire_Inventory_Managment.php(For Tire inventory menu under inventory menu) page(WHICH DISPLAYS CREATED Tire LIST).....
function open_tire_list(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("Tire_Inventory_Managment.php","","height=400,width=900,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}

//----Opens a seperet window to load purchaseOrderManagment.php page.....
function open_purchase_order_managment(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("Browse_Purchase_Order.php","","height=600,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a seperet window to load purchaseOrderAdd.php. page.....
function open_purchase_order(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("purchaseOrderAdd.php","","height=600,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}



//----Opens a seperet window to load BrowseCustomer.php page(WHICH DISPLAYS CUSTOMER LIST).....
function open_cust_list(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("BrowseCustomer.php","","height=470,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}

//----------------------Billing Menu-----------------------------------------------------///

//----Opens a seperet window to load BrowseInvoice.php page(WHICH DISPLAYS CREATED INVOICE LIST).....
function open_invoice_list(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("BrowseInvoice.php","","height=400,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a seperet window to load Browse_invoice_Payments_Add.php(For Record Payment menu item under billing menu) page).....
function open_invoice_payment_add(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("Browse_invoice_Payments_Add.php","","height=400,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}



//----Opens a seperet window to load Browse_invoice_Payments.php(For Browse Payment menu item under billing menu) page(WHICH DISPLAYS CREATED INVOICE_payments LIST).....
function open_invoice_payment(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("Browse_invoice_Payments.php","","height=400,width=800,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a seperet window to load BrowseVendor.php(For Vendor menu item under Setup menu) page(WHICH DISPLAYS CREATED Vendors LIST).....
function open_vendor(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("BrowseVendor.php","","height=400,width=900,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}





//---------------------------------For Maintenance Menu..........................


//----Opens a seperet window to load Update_Meter_Reading.php(For Update Meter Readings... menu under maintenance menu) page(WHICH DISPLAYS METER LIST FOR EQUIPMENTS).....
function open_meter_reading(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("Update_Meter_Reading.php","","height=350,width=850,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}



//----Opens a seperet window to load PMScheduleSetup.php(For pm schedule setup menu under maintenance menu) page(WHICH DISPLAYS CREATED Schedule LIST).....
function open_schedule_list(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("PMScheduleSetup.php","","height=400,width=900,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}



//----Opens a seperet window to load Advance_PM_Setup.php (For For adding cost,pm service,pm schedule with an equipment which is already added for the Maintenance...) page(WHICH DISPLAYS CREATED Schedule LIST).....
function open_advance_PMsetup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("Advance_PM_Setup.php","","height=400,width=900,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//-----------------------------equipment submenu under setup menu..


//----Opens a seperet window to load EquipmentMakeSetup.php page.....
function equip_make(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EquipmentMakeSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a seperet window to load EquipmentMeterSetup.php page.....
function equip_meter_setup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EquipmentMeterSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


//----Opens a seperet window to load EquipmentModelSetup.php page.....
function equip_model_setup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EquipmentModelSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}

//----Opens a seperet window to load EquipmentStatusSetup.php.php page.....
function equip_status_setup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EquipmentStatusSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}

//----Opens a seperet window to load EquipmentTypeSetup.php page.....
function equip_type_setup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("EquipmentTypeSetup.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}

//----Opens a seperet window to load replace_meter_reading.php page.....
function replace_meter_reading(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("replace_meter_reading.php","","height=350,width=850,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}

//*****************************This function is used to backup the database through the use of Ajax technology*****************

function backup_database()
{
if(confirm("Do You Want To Backup The Database?")==true)
{
xmlhttp.open("GET", '../equipment_section/phpMySQLAutoBackup/run.php');
xmlhttp.send(null);
alert("Data has been successfuly backed up.");
}
else
{
alert("Couldn't Connect To The Database.");
}

}


//******************************This function is used to restore the backedup database*****************************//
function restore_database()
{
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("../equipment_section/phpMySQLAutoBackup/Restore backups/bigdump.php","","height=450,width=810,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=1,menubar=0,resizable=0,");
}


</script>
<style type="text/css">
<!--
@import url("common.css");
-->
</style>
</head>


<body>

<script type="text/javascript" language="JavaScript1.2">
<!--
stm_bm(["uueoehr",430,"","blank.gif",0,"","",0,0,0,0,0,1,0,0,"","",0],this);
stm_bp("p0",[0,4,0,0,3,4,0,7,100,"",-2,"",-2,90,0,0,"#000000","#f1f2ee","",3,0,0,"#000000"]);
stm_ai("p0i0",[2,"","IMS_Logo2.jpg","IMS_Logo2.jpg",62,25,0,"","_self","","","","",0,0,0,"","",0,0,0,0,1,"#f1f2ee",0,"#93a070",0,"","",3,3,0,0,"#fffff7","#000000","#000000","#ffffff","8pt 'Tahoma','Arial'","8pt 'Tahoma','Arial'",0,0]);
stm_aix("p0i1","p0i0",[0," File ","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_r.gif","arrow_r.gif",7,7]);
stm_bpx("p1","p0",[1,4,0,0,3,4,0,0]);
stm_aix("p1i0","p0i0",[0,"Add New Equipment For Maintenance","","",-1,-1,0,"AddNewEquipment.php"]);
stm_ai("p1i1",[6,1,"#000000","",-1,-1,0]);
stm_aix("p1i2","p0i0",[0,"Edit Equipment","","",-1,-1,0,"EditNewEquipment.php"]);
stm_aix("p1i3","p0i0",[0,"Delete Equipment","","",-1,-1,0,"DeleteNewEquipment.php"]);
stm_aix("p1i4","p1i1",[]);
stm_aix("p1i5","p0i0",[0,"Backup Data Files","","",-1,-1,0,"javascript:backup_database()"]);
stm_aix("p1i6","p0i0",[0,"Restore Data Files","","",-1,-1,0,"javascript:restore_database()"]);
stm_aix("p1i7","p1i1",[]);
stm_aix("p1i8","p0i0",[0,"Exit","","",-1,-1]);
stm_ep();
stm_aix("p0i2","p0i1",[0,"Setup"]);
stm_bpx("p2","p0",[1,4]);
stm_aix("p2i1","p1i8",[0,"Accident Types..."]);
stm_aix("p2i1","p0i0",[0,"Customer List...","","",-1,-1,0,"javascript:open_cust_list()"]);
stm_aix("p2i2","p0i1",[0,"Employees"]);
stm_bpx("p3","p1",[1,2]);
stm_aix("p3i0","p0i0",[0,"Employees","","",-1,-1,0,"javascript:employee_managment()"]);
stm_aix("p3i1","p0i0",[0,"Categories","","",-1,-1,0,"javascript:open_category()"]);
stm_aix("p3i2","p0i0",[0,"Status","","",-1,-1,0,"javascript:emp_status()"]);
stm_aix("p3i3","p0i0",[0,"Types","","",-1,-1,0,"javascript:emp_type()"]);
stm_aix("p3i4","p0i0",[0,"E-mail Addresses","","",-1,-1,0,"javascript:emp_email()"]);
stm_ep();
stm_aix("p2i3","p0i1",[0,"Equipment"]);
stm_bpx("p4","p3",[]);
stm_aix("p4i0","p0i0",[0,"Makes","","",-1,-1,0,"javascript:equip_make()"]);
stm_aix("p4i1","p0i0",[0,"Models","","",-1,-1,0,"javascript:equip_model_setup()"]);
stm_aix("p4i2","p0i0",[0,"Meter Types","","",-1,-1,0,"javascript:equip_meter_setup()"]);
stm_aix("p4i3","p0i0",[0,"Equipment Types","","",-1,-1,0,"javascript:equip_type_setup()"]);
stm_aix("p4i4","p0i0",[0,"Status","","",-1,-1,0,"javascript:equip_status_setup()"]);
stm_ep();
stm_aix("p2i4","p0i1",[0,"Fluids"]);
stm_bpx("p5","p3",[]);
stm_aix("p5i0","p0i0",[0,"Fluid Types","","",-1,-1,0,"javascript:fluid_type()"]);
stm_aix("p5i1","p0i0",[0,"Unit Types","","",-1,-1,0,"javascript:fluid_unit_type()"]);
stm_ep();
stm_aix("p2i5","p1i8",[0,"General Expense Types"]);
stm_aix("p2i6","p0i1",[0,"Maintenance"]);
stm_bpx("p6","p3",[]);
stm_aix("p6i0","p1i8",[0,"Common Repair List"]);
stm_aix("p6i1","p0i0",[0,"PM Types","","",-1,-1,0,"javascript:open_pm_type()"]);
stm_aix("p6i2","p0i0",[0,"Repair Types","","",-1,-1,0,"javascript:openpopup()"]);
stm_ep();
stm_aix("p2i7","p0i1",[0,"Parts"]);
stm_bpx("p7","p3",[]);
stm_aix("p7i0","p0i0",[0,"Part Categories","","",-1,-1,0,"javascript:open_part_category()"]);
stm_aix("p7i1","p0i0",[0,"Part Manufacturers","","",-1,-1,0,"javascript:open_part_manufacturer()"]);
stm_aix("p7i2","p0i0",[0,"Unit Type","","",-1,-1,0,"javascript:open_part_unit()"]);
stm_ep();
stm_aix("p2i8","p0i0",[0,"Payment Terms...","","",-1,-1,0,"paymentTerms.php"]);
stm_aix("p2i9","p0i0",[0,"Ship To Addresses...","","",-1,-1,0,"shipToAddress.php"]);
stm_aix("p2i10","p0i0",[0,"Shiping Methods...","","",-1,-1,0,"shippingMethod.php"]);
stm_aix("p2i11","p0i1",[0,"Tires"]);
stm_bpx("p8","p3",[]);
stm_aix("p11i0","p0i0",[0,"Tire Inventory...","","",-1,-1,0,"javascript:open_tire_list()"]);
stm_aix("p8i1","p1i1",[]);
stm_aix("p8i2","p0i0",[0,"Makes...","","",-1,-1,0,"TireMake.php"]);
stm_aix("p8i3","p0i0",[0,"Models...","","",-1,-1,0,"TireModel.php"]);
stm_aix("p8i4","p0i0",[0,"Positions...","","",-1,-1,0,"TirePosition.php"]);
stm_aix("p8i5","p0i0",[0,"Types...","","",-1,-1,0,"TireType.php"]);
stm_ep();
stm_aix("p2i12","p0i0",[0,"Vendors...","","",-1,-1,0,"javascript:open_vendor()"]);
stm_ep();
stm_aix("p0i3","p1i8",[0," View "]);
stm_aix("p0i4","p2i3",[]);
stm_bpx("p8","p1",[]);
stm_aix("p8i0","p1i8",[0,"Enter Maintenance Performed..."]);
stm_aix("p8i1","p1i8",[0,"Schedule Repair..."]);
stm_aix("p8i2","p1i1",[]);
stm_aix("p8i3","p1i8",[0,"Maintenance Due..."]);
stm_aix("p8i4","p1i8",[0,"Fluid Consumption History"]);
stm_aix("p8i5","p1i8",[0,"General Expence History"]);
stm_aix("p8i6","p1i8",[0,"Maintenance History"]);
stm_aix("p8i7","p1i1",[]);
stm_aix("p8i8","p1i8",[0,"Cost Statistics..."]);
stm_aix("p8i9","p1i8",[0,"Graphing..."]);
stm_aix("p8i10","p1i1",[]);
stm_aix("p8i11","p1i8",[0,"Current Maintenance Status<BR>"]);
stm_aix("p8i12","p1i8",[0,"Last PM Setup"]);
stm_aix("p8i13","p1i1",[]);
stm_aix("p8i14","p1i8",[0,"Meter Replacements...","","",-1,-1,0,"javascript:replace_meter_reading()"]);
stm_aix("p8i15","p1i1",[]);
stm_aix("p8i16","p1i8",[0,"Import Custom Labels..."]);
stm_ep();
stm_aix("p0i5","p2i6",[]);
stm_bpx("p9","p2",[]);
stm_aix("p9i0","p0i1",[0,"PM Check Wizard..."]);
stm_bpx("p10","p3",[]);
stm_aix("p10i0","p1i8",[0,"Selected Equipment"]);
stm_aix("p10i1","p1i8",[0,"Selected Category..."]);
stm_aix("p10i2","p1i8",[0,"Selected Category &amp; Subcategories..."]);
stm_aix("p10i3","p1i8",[0,"All Equipment..."]);
stm_ep();
stm_aix("p9i1","p1i8",[0,"Update Meter Readings...","","",-1,-1,0,"javascript:open_meter_reading()"]);
stm_aix("p9i2","p1i1",[]);
stm_aix("p9i3","p0i0",[0,"PM Schedule Setup","","",-1,-1,0,"javascript:open_schedule_list()"]);
stm_aix("p9i4","p1i8",[0,"PM Associations...","","",-1,-1,0,"javascript:open_advance_PMsetup()"]);
stm_aix("p9i5","p1i8",[0,"Scheduled Repairs"]);
stm_aix("p9i6","p1i1",[]);
stm_aix("p9i7","p0i0",[0,"Issue Work Order...","","",-1,-1,0,"javascript:open_work_order_Add_PM_Entry()"]);
stm_aix("p9i8","p0i0",[0,"Work Order Managment","","",-1,-1,0,"javascript:open_work_order_managment()"]);
stm_ep();
stm_aix("p0i6","p0i1",[0,"Inventory"]);
stm_bpx("p11","p1",[]);
stm_aix("p11i0","p0i0",[0,"Parts Inventory...","","",-1,-1,0,"javascript:open_part_list()"]);
stm_aix("p11i0","p0i0",[0,"Tire Inventory...","","",-1,-1,0,"javascript:open_tire_list()"]);
stm_aix("p11i1","p1i1",[]);
stm_aix("p11i2","p0i0",[0,"Purchase Orders - Browse...","","",-1,-1,0,"javascript:open_purchase_order_managment()"]);
stm_aix("p11i3","p0i0",[0,"Purchase Orders - Add...","","",-1,-1,0,"javascript:open_purchase_order()"]);
stm_aix("p11i4","p1i1",[]);
stm_aix("p11i5","p0i0",[0,"PO Receipt - by PO #...","","",-1,-1,0,"POReceiptByPO.php"]);
stm_aix("p11i6","p0i0",[0,"PO Receipt - by Part #...","","",-1,-1,0,"POReceiptByPart.php"]);
stm_aix("p11i7","p1i1",[]);
stm_aix("p11i8","p0i0",[0,"Adjust / Receive into inventory","","",-1,-1,0,"Adjust%20/%20Receive%20into%20inventory.php"]);
stm_ep();
stm_aix("p0i7","p0i1",[0,"Billing"]);
stm_bpx("p12","p1",[]);
stm_aix("p12i0","p0i0",[0,"Generate Invoice ... ","","",-1,-1,0,"GenerateInvoice.php"]);
stm_aix("p12i1","p0i0",[0,"Browse Invoices ... ","","",-1,-1,0,"javascript:open_invoice_list()"]);
stm_aix("p12i2","p1i1",[]);
stm_aix("p12i3","p0i0",[0,"Record Payment ... ","","",-1,-1,0,"javascript:open_invoice_payment_add()"]);
stm_aix("p12i4","p0i0",[0,"Browse Payments ... ","","",-1,-1,0,"javascript:open_invoice_payment()"]);
stm_ep();
stm_aix("p0i7","p0i1",[0,"Tools"]);
stm_bpx("p12","p2",[]);
stm_aix("p12i0","p0i1",[0,"Backup/Restore Utility"]);
stm_bpx("p13","p3",[]);
stm_aix("p1i5","p0i0",[0,"Backup Data Files","","",-1,-1,0,"javascript:backup_database()"]);
stm_aix("p1i6","p0i0",[0,"Restore Data Files","","",-1,-1,0,"javascript:restore_database()"]);
stm_ep();
stm_aix("p12i1","p1i8",[0,"Optimize/Repair Utility..."]);
stm_aix("p12i2","p1i1",[]);
stm_aix("p12i3","p1i8",[0,"Options..."]);
stm_ep();
stm_aix("p0i8","p0i1",[0,"Reports"]);
stm_bpx("p14","p2",[]);
stm_aix("p14i0","p2i2",[]);
stm_bpx("p15","p3",[]);
stm_aix("p15i0","p1i8",[0,"Detailed Contact List..."]);
stm_aix("p15i1","p1i8",[0,"General Contact List..."]);
stm_aix("p15i2","p1i8",[0,"License Information..."]);
stm_aix("p15i3","p1i8",[0,"Other Certification..."]);
stm_aix("p15i4","p1i8",[0,"Personnel Information..."]);
stm_aix("p15i5","p1i8",[0,"Physical Information"]);
stm_ep();
stm_aix("p14i1","p2i3",[]);
stm_bpx("p16","p3",[]);
stm_aix("p16i0","p1i8",[0,"Equipment Insurance Information..."]);
stm_aix("p16i1","p1i8",[0,"Equipment Loan/Lease Information..."]);
stm_aix("p16i2","p1i8",[0,"Equipment Purchase Information..."]);
stm_aix("p16i3","p1i8",[0,"Equipment Roster..."]);
stm_aix("p16i4","p1i8",[0,"Equipment Specification..."]);
stm_aix("p16i5","p1i8",[0,"Equipment Usage (Detailed)..."]);
stm_aix("p16i6","p1i8",[0,"Equipment Usage (Summary)..."]);
stm_aix("p16i7","p1i8",[0,"Fluid Consumption..."]);
stm_aix("p16i8","p1i8",[0,"General Expense History..."]);
stm_aix("p16i9","p1i8",[0,"General Information..."]);
stm_aix("p16i10","p1i8",[0,"Meter Replacement Log..."]);
stm_ep();
stm_aix("p14i2","p0i1",[0,"History"]);
stm_bpx("p17","p3",[]);
stm_aix("p17i0","p1i8",[0,"Overall PM Statistics..."]);
stm_aix("p17i1","p1i8",[0,"Overall Repair Statistics..."]);
stm_aix("p17i2","p1i8",[0,"PM Statistics by Equipment"]);
stm_aix("p17i3","p1i8",[0,"Repair Statistics by Equipment"]);
stm_ep();
stm_aix("p14i3","p0i1",[0,"History (Maintenance)"]);
stm_bpx("p18","p3",[]);
stm_aix("p18i0","p1i8",[0,"History Overview..."]);
stm_aix("p18i1","p1i8",[0,"Maintenance History (Complete)..."]);
stm_aix("p18i2","p1i8",[0,"Maintenance History (Cost Summery)..."]);
stm_aix("p18i3","p1i8",[0,"Maintenance History Vendor (Cost Summery)..."]);
stm_aix("p18i4","p1i8",[0,"Parts Details Only..."]);
stm_aix("p18i5","p1i8",[0,"Parts Details Summary..."]);
stm_aix("p18i6","p1i8",[0,"Parts Usage (Detailed)..."]);
stm_aix("p18i7","p1i8",[0,"Preventive Maintenance Only..."]);
stm_aix("p18i8","p1i8",[0,"Preventive Maintenance Summary..."]);
stm_aix("p18i9","p1i8",[0,"Repair Details Only..."]);
stm_aix("p18i10","p1i8",[0,"Repair Details Summary..."]);
stm_ep();
stm_aix("p14i4","p2i6",[]);
stm_bpx("p19","p3",[]);
stm_aix("p19i0","p1i8",[0,"Maintenance Due (Detailed)..."]);
stm_aix("p19i1","p1i8",[0,"Maintenance Due (Overview)..."]);
stm_aix("p19i2","p1i8",[0,"Maintenance Status (Detailed)..."]);
stm_aix("p19i3","p1i8",[0,"PM Schedule(s)..."]);
stm_aix("p19i4","p1i8",[0,"PM Service (Last Performed)..."]);
stm_ep();
stm_aix("p14i5","p2i7",[]);
stm_bpx("p20","p3",[]);
stm_aix("p20i0","p1i8",[0,"General Part Listing..."]);
stm_aix("p20i1","p1i8",[0,"General Part Listing (by Category)..."]);
stm_aix("p20i2","p1i8",[0,"General Part Listing (by Vendor)..."]);
stm_ep();
stm_aix("p14i6","p0i1",[0,"Schedule Repairs"]);
stm_bpx("p21","p3",[]);
stm_aix("p21i0","p1i8",[0,"Repair Currently Due (by Date)..."]);
stm_aix("p21i1","p1i8",[0,"Repair Currently Scheduled..."]);
stm_ep();
stm_aix("p14i7","p0i1",[0,"Statistics"]);
stm_bpx("p22","p3",[]);
stm_aix("p22i0","p1i8",[0,"Fluid Consumption History (Current Year)..."]);
stm_aix("p22i1","p1i8",[0,"Fluid Consumption History (Last 12 Years)..."]);
stm_aix("p22i2","p1i8",[0,"Fluid Consumption History (Last 3 Yea by Quarterrs)..."]);
stm_aix("p22i3","p1i8",[0,"Fluid Consumption History (Prior Year)..."]);
stm_aix("p22i4","p1i8",[0,"General Expense Analysis (Current Year)..."]);
stm_aix("p22i5","p1i8",[0,"General Expense Analysis (Last 12 Years)..."]);
stm_aix("p22i6","p1i8",[0,"General Expense Analysis (Last 3  Years by Quarter)..."]);
stm_aix("p22i7","p1i8",[0,"General Expense Analysis (Prior Year)..."]);
stm_aix("p22i8","p1i8",[0,"History Cost Analysis (Current Year)..."]);
stm_aix("p22i9","p1i8",[0,"History Cost Analysis (Last 12 Years)..."]);
stm_aix("p22i10","p1i8",[0,"History Cost Analysis (Last 3 Years by Quarter)..."]);
stm_aix("p22i11","p1i8",[0,"History Cost Analysis (Prior Year)..."]);
stm_ep();
stm_aix("p14i8","p0i1",[0,"Vendors"]);
stm_bpx("p23","p3",[]);
stm_aix("p23i0","p1i8",[0,"Complete Vendor Listing..."]);
stm_ep();
stm_ep();
stm_aix("p0i9","p1i8",[0,"Window"]);
stm_aix("p0i10","p1i8",[0,"Security"]);
stm_aix("p0i11","p1i8",[0,"Help"]);
stm_aix("p0i12","p0i0",[2,"","IMS_Logo2.jpg","IMS_Logo2.jpg",60]);
stm_ep();
stm_em();
//-->
</script>


<form id="form1" name="form1" method="post" action="">
  <input name="hidItemid" type="hidden" id="hidItemid" />
  <table width="4758" border="1" cellpadding="0" cellspacing="0" id="itm_table">
    
    <tr bgcolor="#0099CC">
      <th width="246" bgcolor="#0099CC">Identification</th>
      <th width="130">Planned Date OF PM </th>
      <th width="114" bgcolor="#0099CC">Item Code </th>
      <th width="106" bgcolor="#0099CC">Year</th>
      <th width="127">Serial#</th>
      <th width="96">Make</th>
      <th width="77">Model</th>
      <th width="96">Meter </th>
      <th width="193">Type</th>
      <th width="95">Status</th>
      <th width="177">Pm Service </th>
      <th width="114">Base Units </th>
      <th width="114">Base Date </th>
      <th width="161">Assigned To </th>
      <th width="165">Dealer</th>
      <th width="147">Prch Date </th>
      <th width="88">Purch Meter </th>
      <th width="90">Purch Price </th>
      <th width="273">Purch Notes </th>
      <th width="245">Loan/Lease Company </th>
      <th width="170">Acc#</th>
      <th width="86">Lease Start </th>
      <th width="83">Lease End </th>
      <th width="102">Lease Payment </th>
      <th width="105">Residual/Balance</th>
      <th width="153">Lease Notes </th>
      <th width="160">Insurance Company </th>
      <th width="113">Policy</th>
      <th width="107">Coverage Begin </th>
      <th width="99" bgcolor="#0099CC">Coverage End </th>
      <th width="126">Insurance Payment </th>
      <th width="80">Deductible</th>
      <th width="452">Insurance Notes </th>
    </tr>
						<?php
								include("track.php");
						
						?>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>
