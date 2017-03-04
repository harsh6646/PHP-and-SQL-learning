<?php
	$counter = 0;
	$found = false;
	while(!$found){
		if(isset($_POST[(string)$counter]))
		{
			$found = true;
			echo $counter;
		}
		$counter++;
	}

?>