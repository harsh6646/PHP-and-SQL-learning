<!DOCTYPE html>
<html>
<head>
	<title>Shayona Foods</title>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/food_css.css" />
</head>
<body>
	<h1 class ="title">FOOD</h1>
	<ul id="items">
	<!-- INJECT HERE -->
	</ul>
	<form id = "item_form">
		<p>Item:
			</br>
			<input type="text" id="item" name ="item" placeholder="Item Name"/>
		</p>
		<p>Price:
			</br> 
			<input type="text" id="price" name="price" placeholder="Item Price"/>
		</p>
		<p>Stock:
			</br>
			<input type="text" id="stock" name="stock" placeholder="Item stock"/>
		</p>
		<p>Off:
			</br>
			<input type="text" id="off" name ="off" placeholder="off Name"/>
		</p>
		<div>
			<button type="submit">Submit</button>
			<p id="test_output"></p>
		</div>
	</form>
	<script type="text/javascript" src="http://localhost:1234/scripts/ajax_script.js"></script>
	<script type="text/javascript" src="http://localhost:1234/scripts/validate.js"></script>
	
</body>
</html>