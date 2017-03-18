<?php

require_once('../mysqli_connect.php');

$query = "SELECT item, price, stock, num, off FROM shayona";

$response = @mysqli_query($dbc, $query);
echo '<form action = "/edit.php" name = "Num" method = "POST">';
if ($response){
	echo '<table align="left" cellspacing = "5" cellpadding = "8">
	<tr><td align = "left"><b>Name</b></td>
	<td align = "left"><b>Price</b></td>
	<td align = "left"><b>stock</b></td>
	<td align = "left"><b>Percent Off</b></td></tr>';
	$counter = 0;
	while($row = mysqli_fetch_array($response)){
		echo '<tr><td align = "left">' .
		$row['item'] . '</td><td align = "left">$' .
		round($row['price']*(100-$row['off'])/100, 2) . '</td><td align = "left">' .
		$row['stock'] . '</td><td align = "left">' .
		round($row['off'], 2) . '</td>' .
		'<td align = "left"><input type ="submit" name = "'.
		$counter .'" value = "Edit"/></td>';
		echo '</tr>';
		$counter++;
	}

	echo '</table>';
	echo '</form>';
}
else {
	echo "couldn't issue databease query<br>";
	echo mysqli_error($dbc);
}

mysqli_close($dbc);

?>