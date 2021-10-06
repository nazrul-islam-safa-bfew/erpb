<?php
ini_set('register_globals', true);
if(isset($_POST))
{
	foreach ($_POST as $key => $val)
	{
		$$key = $val;
	}
	
}
if(isset($_GET))
	foreach ($_GET as $key => $val)
	{
		$$key = $val;
	}

if(isset($_SESSION))
{
	foreach ($_SESSION as $key => $val)
	{
		$$key = $val;
	}	
}
?>