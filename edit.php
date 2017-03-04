<!DOCTYPE html>
<html>
<head>
	<title>Edit Column</title>
</head>
<body>
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
	if(isset($_POST["submit"])){

		$item = trim($_POST['item']);

		$price = trim($_POST['price']);

		$stock = trim($_POST['stock']);

		require_once('../mysqli_connect.php');

		$query = 'UPDATE shayona SET item =? price=? stock=? WHERE num = ?';

		$stmt = mysqli_prepare($dbc, $query);

		mysqli_stmt_bind_param($stmt, "sssi", $item, $price, $stock, $counter);
		mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);

		mysqli_close($dbc);
	}
?>
<script type="text/javascript">
	function submit_function(){
		var item = document.forms["myForm"]["item"].value();
		var price = document.forms["myForm"]["price"].value();
		var stock = document.forms["myForm"]["stock"].value();
		if(item == null || item == "" || price == null || price == "" || stock = null || stock == ""){
			alert("One or more fields empty");
			return false;
		}
		else{
			return true;
		}
	}
</script>
<b><h1>Edit Row</h1></b>
<form action = "http://localhost:1234/edit.php" onsubmit= "return submit_function()" name = "myForm" method = "POST">
<p> Item:
<input type = "text" name = "item" value = "" size = "30"/>
</p>
<p> Price:
	<input type = "text" name = "price" value = "" size = "30"/>
</p>
<p> Stock:
	<input type = "text" name = "stock" value = "" size = "30" />
</p>
<p>
	<input type = "submit" name = "submit" value = "Send Edit"/>
</p>
</form>
</body>
</html>
