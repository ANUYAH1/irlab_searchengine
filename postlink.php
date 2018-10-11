<?php
	include('dbadapter.php');
	header('Content-type:application/json');
	if  ($sessionid=filter_input(INPUT_POST, 'sessionid'))
	{
		
		$url = filter_input(INPUT_POST, 'url');
		$position = filter_input(INPUT_POST, 'position');
		$searchid =  filter_input(INPUT_POST, 'searchid');
		$cleanedurl = urldecode (filter_input(INPUT_POST, 'r'));
		
		$adapter = new dbadapter ();
		
		if ($adapter->clickedlink ($sessionid,$url,$searchid,$position))
		{
			echo "{'status':'successful'}";
		}else
		{
			echo "{'status':'failed'}";
		}
		
	}
	
?>