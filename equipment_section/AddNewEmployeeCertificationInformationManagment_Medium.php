<?php
include("common.php");
CreateConnection();
//-Assigning posted hidden valeu to the variable to check which button is clicked at the AddNewEmployeeCertificationInformationManagment.php page..............................//

$hid=$_POST['hidField'];

//-------These code will be executed based on $hid value..............//
if($hid==1)
{
header("Location: AddNewEmployee_Certification_Information.php");
}
 ?>