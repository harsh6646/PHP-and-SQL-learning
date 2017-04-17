function ajax_post() {
	var $form = $("#item_form");
	var $item = $form.find("#item");
	var $price = $form.find("#price");
	var $stock = $form.find("#stock");
	var $off = $form.find("#off");
	if($off === null) {
		$off = 0;
	}
	var info = {
		item: $item.val(),
		price: $price.val(),
		stock: $stock.val(),
		off: $off.val()
	};
	$.ajax({
		type:'POST',
		url: 'http://localhost:1234/scripts/php_handler.php',
		data: info,
		success: function(data) {
			var temp = JSON.parse(data);
			console.log(temp);
		},
		error: function() {
			console.log("ERROR WITH POST");
		}
	});
}