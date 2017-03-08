<!DOCTYPE html>
<html>
<head>
	<title>Edit Column</title>
</head>
<body>
<script type="text/javascript">
	function submit_function(){
		var item = document.forms["myForm"]["item"].value();
		var price = document.forms["myForm"]["price"].value();
		var stock = document.forms["myForm"]["stock"].value();
		if(item == null || item == "" || price == null || price == "" || stock = null || stock == ""){
			alert("One or more field empty");
			return false;
		}
		else{
			return true;
		}
	}
</script>
<form action = "http://localhost:1234/edit.php" onsubmit= "return submit_function()" name = "myForm" method = "POST">
	<?php
		if(!isset($_POST['counter'])){
			$counter = 0;
			$found = false;
			while(!$found){
				if(isset($_POST[(string)$counter]))
				{
					$found = true;
					$pos = $counter;
				}
				$counter++;
			}
			echo '<input type="hidden" name="counter" value= "' . $pos . '"/>';
		}
		else{
			if(!empty($_POST)){
				$counter = (int)$_POST['counter'];
				$item = trim($_POST['item']);
				$price = trim($_POST['price']);
				$stock = trim($_POST['stock']);
				require_once('../mysqli_connect.php');
				$query = 'UPDATE shayona SET item =?, price=?, stock=?, num=? WHERE num = ?';
				$stmt = mysqli_prepare($dbc, $query);
				mysqli_stmt_bind_param($stmt, "sssii", $item, $price, $stock, $counter, $counter);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				mysqli_close($dbc);
			}
		}
	?>
	<b><h1>Edit Row</h1></b>
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
