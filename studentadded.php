<html>
<head>
	<title>Add item</title>
</head>
<body>
<?php

if (isset($_POST['submit'])){
	$data_missing = array();
	if (empty($_POST['item'])) {
		$data_missing[] = 'item';
	}
	else {
		$item = trim($_POST['item']);
	}
	if (empty($_POST['price'])) {
		$data_missing[] = 'price';
	}
	else {
		$price = trim($_POST['price']);
	}
	if (empty($_POST['stock'])){
		$data_missing[] = 'stock';
	}
	else {
		$stock = trim($_POST['stock']);
	}
	if(empty($data_missing)){
		require_once('../mysqli_connect.php');

		$query1 = 'SELECT * FROM shayona';

		$stmt1 = mysqli_prepare($dbc, $query1);

		mysqli_stmt_execute($stmt1);

		mysqli_stmt_store_result($stmt1);

		$num = mysqli_stmt_num_rows($stmt1);

		mysqli_stmt_close($stmt1);

		$query = 'INSERT INTO shayona (item, price, stock, num) VALUES (?, ?, ?, ?)';

		$stmt = mysqli_prepare($dbc, $query);

		mysqli_stmt_bind_param($stmt, "sssi", $item, $price, $stock, $num);

		mysqli_stmt_execute($stmt);

		$affected_rows = mysqli_stmt_affected_rows($stmt);

		if($affected_rows == 1){
			echo 'Item Entered';
			mysqli_stmt_close($stmt);
			mysqli_close($dbc);
		}
		else{
			echo 'Error Occurred<br>';
			echo mysqli_error();
			mysqli_stmt_close($stmt);
			mysqli_close($dbc);
		}
	}
	else {
		echo 'You need to enter the following data<br>';
		foreach($data_missing as $missing){
			echo "$missing<br>";
		}
	}
}
?>

<script type="text/javascript">
function submit_function(){
	var item = document.forms["myForm"]["item"].value;
	var price = document.forms["myForm"]["price"].value;
	var stock = document.forms["myForm"]["stock"].value;
	if(item == null || item == "" || price == null || price == "" || stock == null || stock == ""){
		alert("One or more field is empty")
		return false;
	}
	else{
		return true;
	}
}
</script>
<form action = "http://localhost:1234/studentadded.php" onsubmit="return submit_function()" name = "myForm" method = "POST">

<b>Add a New Item</b>

<p> Item:
<input type = "text" name = "item" size = "30" value = "" />
</p>
<p> Price:
<input type = "text" name = "price" size = "30" value = "" />
</p>
<p> stock:
<input type = "text" name = "stock" size = "30" value = "" />
</p>
<p>
	<input type="submit" name= "submit" value="Send" />
</p>

</form>

</body>
</html>