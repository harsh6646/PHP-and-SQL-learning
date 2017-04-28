<?php
	$method = $_SERVER['REQUEST_METHOD'];
	$response = array("status" => false);
	$response['error'] = false;
	require_once("../../mysqli_connect.php");
	if($method == "POST"){
		// check all the conditions need w/ lazy evaluation
		if(isset($_POST['item']) && isset($_POST['price']) && is_numeric($_POST['price']) && isset($_POST['stock']) && is_numeric($_POST['stock']) && isset($_POST['off']) && is_numeric($_POST['off'])){
			// cast and trim the variable for database
			$item = trim($_POST['item']);
			$price = (double) trim($_POST['price']);
			$stock = (int) trim($_POST['stock']);
			$off = (double) trim($_POST['off']);
			// get the number of rows in the database
			$query = 'SELECT columns FROM counter';
			$result = @mysqli_query($dbc, $query);
			while($row = mysqli_fetch_array($result)){
				$num = $row['columns'];
			}
			$num++;
			$query = "UPDATE counter SET columns =" . $num . " WHERE temp=0";
			@mysqli_query($dbc, $query);
			// prepare and execute the insertion
			$query = 'INSERT INTO shayona (item, price, stock, num, off) VALUES (?, ?, ?, ?, ?)';
			$stmt = mysqli_prepare($dbc, $query);
			mysqli_stmt_bind_param($stmt, 'sdiid', $item, $price, $stock, $num, $off);
			mysqli_stmt_execute($stmt);
			$affected = mysqli_stmt_affected_rows($stmt);
			if($affected == 1){
				// check if only one row is affected and clean up the connection
				mysqli_stmt_close($stmt);
				$response['status'] = true;
				$response['obj'] = array('item' => $item, 'price' => $price, 'stock' => $stock, 'off' => $off, 'num' => $num);
			}
			else {
				$response['error'] = mysqli_error();
				mysqli_stmt_close($stmt);
			}
		}
		else{
			$response['error'] = "Invalid inputs";
		}
		$response = json_encode($response, JSON_FORCE_OBJECT);
	}
	elseif($method == "GET"){
		$query = 'SELECT item, price, stock, num, off FROM shayona ORDER BY item ASC';
		$result = @mysqli_query($dbc, $query);
		$response['objs'] = array();
		while($row = mysqli_fetch_array($result)){
			$obj = array('item' => $row['item'], 'price' => round($row['price'],2), 'stock' => (int)$row['stock'], 'off' => round($row['off'], 2), 'num' => (int)$row['num']);
			array_push($response['objs'], $obj);
		}
		$response = json_encode($response);
	}
	elseif($method == "PUT"){
		parse_str(file_get_contents("php://input"), $temp);
		if(isset($temp['item']) && isset($temp['price']) && is_numeric($temp['price']) && isset($temp['stock']) && is_numeric($temp['stock']) && isset($temp['off']) && is_numeric($temp['off']) && isset($temp['num']) && is_numeric($temp['num'])){
			$item = trim($temp['item']);
			$response['temp'] = $temp;
			$price = (double) trim($temp['price']);
			$stock = (int) trim($temp['stock']);
			$off = (double) trim($temp['off']);
			$num = (int) trim($temp['num']);
			$query = "UPDATE shayona SET item=?, price=?, stock=?, off=? WHERE num=?";
			$stmt = mysqli_prepare($dbc, $query);
			mysqli_stmt_bind_param($stmt, 'sdidi', $item, $price, $stock, $off, $num);
			mysqli_stmt_execute($stmt);
			$affected = mysqli_stmt_affected_rows($stmt);
			$response['affected'] = $affected;
			mysqli_stmt_close($stmt);
		}
		else{
			$response['error'] = "Invalid inputs";
		}
		$response = json_encode($response);
	}
	elseif($method == "DELETE"){
		parse_str(file_get_contents("php://input"), $temp);
		if(isset($temp['delete']) && is_numeric($temp['delete'])){
			$num = (int) trim($temp['delete']);
			$query = "DELETE FROM shayona WHERE num=?";
			$stmt = mysqli_prepare($dbc, $query);
			mysqli_stmt_bind_param($stmt, 'i', $num);
			mysqli_stmt_execute($stmt);
			$affected = mysqli_stmt_affected_rows($stmt);
			$response['affected'] = $affected;
			mysqli_stmt_close($stmt);
		}
		else {
			$response['error'] = "Invalid inputs";
		}
		$response = json_encode($response);
	}
	else{
		$response['error'] = 'Invalid HTTP request method';
	}
	mysqli_close($dbc);
	echo $response;
?>