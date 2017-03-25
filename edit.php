<!DOCTYPE html>
<html>
<head>
	<title>Edit Column</title>
</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="edit_validation.js"></script>
<script type="text/javascript">
	function submit_function(){
		var item = document.forms["myForm"]["item"].value;
		var price = document.forms["myForm"]["price"].value;
		var stock = document.forms["myForm"]["stock"].value;
		var off = document.forms["myForm"]["stock"].value;
		off = parseFloat(off);
		price = parseFloat(price);
		stock = parseFloat(stock);
		if(item === null || item === "" || price === null || price === "" || stock === null || stock === "" || off === null || off === ""){
			alert("One or more field empty");
			return false;
		}
		else if(isNaN(off) || isNaN(price) || isNaN(stock)){
			alert("Both price and percent off must be numbers");
			return false;
		}
		else{
			return true;
		}
	}
</script>
<form action = "http://localhost:1234/edit.php" onsubmit= "return submit_function()" id="myForm" name = "myForm" method = "POST">
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
				$off = trim($_POST['off']);
				require_once('../mysqli_connect.php');
				$query = 'UPDATE shayona SET item =?, price=?, stock=?, num=?, off =? WHERE num = ?';
				$stmt = mysqli_prepare($dbc, $query);
				$off = (double)$off;
				$price = (double)$price;
				$stock = (int)$stock;
				mysqli_stmt_bind_param($stmt, "sdiidi", $item, $price, $stock, $counter, $off, $counter);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				mysqli_close($dbc);
			}
		}
		require_once('../mysqli_connect.php');
		$query = 'SELECT * FROM shayona WHERE num = ?';
		$stmt = mysqli_prepare($dbc, $query);
		mysqli_stmt_bind_param($stmt, 'i', $counter);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $item, $price, $stock, $num, $off);
		mysqli_stmt_fetch($stmt);
	?>
	<b><h1>Edit Row</h1></b>
	<p> Item:
		<input type = "text" name = "item" value = <?php echo '"'.$item.'"'?> size = "30"/>
	</p>
	<p> Price:
		<input type = "text" name = "price" value = <?php echo '"'.round($price, 2).'"'?> size = "30"/>
	</p>
	<p> Stock:
		<input type = "text" name = "stock" value = <?php echo '"'.$stock.'"'?> size = "30" />
	</p>
	<p> Percent off:
		<input type = "text" name ="off" value= <?php echo '"'.round($off, 2).'"'?> size = "30"/>
	</p>
	<p>
		<input type = "submit" name = "submit" value = "Send Edit"/>
	</p>
</form>
</body>
</html>
