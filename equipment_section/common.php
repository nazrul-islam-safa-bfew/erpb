<?php 


/*--------------------------------------------------------------------
--Creating MySQL connection
----------------------------------------------------------------------*/

function CreateConnection()
{
@mysql_connect('mysqleq.bfew.net','eqsection','eqsection') or die('Could not connect to MySQL server!!');

@mysql_select_db('equipment_section') or die('Could not select database!!'); 
}

//-------------------------END-----------------------------------------//




/*--------------------------------------------------------------------
--  VENDOR ID GENERATION
----------------------------------------------------------------------*/

function ThiryTwoBaseNumber($lngTheNumber)
{
    //$strAray;
    $intCounter=0;
    $strValues="";
    $ThirtyTwoNo="";
    pGetNumberSet($strValues, $lngTheNumber);
	//echo($strValues)."<br>";
    
    if (substr($strValues, 0, 1) == ",")
	{
        $strValues = substr($strValues, 1);
		//echo($strValues);
	}
    
    $strAray = split(",", $strValues);
	$arrCount = sizeof($strAray);
	//echo("<br>".$arrCount);
    while($intCounter < $arrCount)
	{
		//echo($strAray[($arrCount-1)-$intCounter]."<br>");
		
		//$strAlf = pGetAlfaNumaricValue($strAray[($arrCount-1)-$intCounter]);
        $ThirtyTwoNo = $ThirtyTwoNo . pGetAlfaNumaricValue($strAray[($arrCount-1)-$intCounter]);
		//echo(pGetAlfaNumaricValue($strAray[($arrCount-1)-$intCounter])."--".$strAray[($arrCount-1)-$intCounter]."<br>");
		$intCounter++;
    }
    return $ThirtyTwoNo;
}


//-----------------------------------------------------------------------------------------------------------------------//

function pGetNumberSet(&$strNumbers, $lngNumber)
{
    $lngTemp = 0;
    if ($lngNumber >= 32)
	{
        if (($lngNumber % 32) == 0)
		{
            $lngTemp = ($lngNumber - ($lngNumber % 32)) / 32;
            $strNumbers = $strNumbers . "," . ($lngNumber % 32);
		}
        else
		{
            $lngTemp = ($lngNumber - ($lngNumber % 32)) / 32;
            $strNumbers = $strNumbers . "," . ($lngNumber % 32);
        }
        
        if ($lngTemp >= 32)
		{
            pGetNumberSet($strNumbers, $lngTemp);
        }
		else
		{
            $strNumbers = $strNumbers . "," . $lngTemp;
        }
	}
    else
	{
        $strNumbers = $lngNumber;
    }
}



//------------------------------------------------------------------------------------------------------------------------//

//echo(pGetAlfaNumaricValue(18));
function pGetAlfaNumaricValue($strValue)
{
    switch ($strValue)
	{
        Case "0":
            $pGetAlfaNumaricValue = "0";
			break;
        Case "1":
            $pGetAlfaNumaricValue = "1";
			break;
        Case "2":
            $pGetAlfaNumaricValue = "2";
			break;
        Case "3":
            $pGetAlfaNumaricValue = "3";
			break;
        Case "4":
            $pGetAlfaNumaricValue = "4";
			break;
        Case "5":
            $pGetAlfaNumaricValue = "5";
			break;
        Case "6":
            $pGetAlfaNumaricValue = "6";
			break;
        Case "7":
            $pGetAlfaNumaricValue = "7";
			break;
        Case "8":
            $pGetAlfaNumaricValue = "8";
			break;
        Case "9":
            $pGetAlfaNumaricValue = "9";
			break;
        Case "10":
            $pGetAlfaNumaricValue = "A";
			break;
        Case "11":
            $pGetAlfaNumaricValue = "B";
			break;
        Case "12":
            $pGetAlfaNumaricValue = "C";
			break;
        Case "13":
            $pGetAlfaNumaricValue = "D";
			break;
        Case "14":
            $pGetAlfaNumaricValue = "E";
			break;
        Case "15":
            $pGetAlfaNumaricValue = "F";
			//return $pGetAlfaNumaricValue;
			break;
        Case "16":
            $pGetAlfaNumaricValue = "U";
			break;
        Case "17":
            $pGetAlfaNumaricValue = "V";
			break;
        Case "18":
            $pGetAlfaNumaricValue = "T";
			break;
        Case "19":
            $pGetAlfaNumaricValue = "S";
			break;
        Case "20":
            $pGetAlfaNumaricValue = "Y";
			break;
        Case "21":
            $pGetAlfaNumaricValue = "Z";
			break;
        Case "22":
            $pGetAlfaNumaricValue = "X";
			break;
        Case "23":
            $pGetAlfaNumaricValue = "W";
			break;
        Case "24":
            $pGetAlfaNumaricValue = "J";
			break;
        Case "25":
            $pGetAlfaNumaricValue = "K";
			break;
        Case "26":
            $pGetAlfaNumaricValue = "H";
			break;
        Case "27":
            $pGetAlfaNumaricValue = "G";
			break;
        Case "28":
            $pGetAlfaNumaricValue = "P";
			break;
        Case "29":
            $pGetAlfaNumaricValue = "R";
			break;
        Case "30":
            $pGetAlfaNumaricValue = "N";
			break;
        Case "31":
            $pGetAlfaNumaricValue = "M";
			break;
    }
	return $pGetAlfaNumaricValue;
}




?>