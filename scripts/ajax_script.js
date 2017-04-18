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
			inject(temp.obj);
		},
		error: function() {
			console.log("ERROR WITH POST");
		}
	});
}
function ajax_get() {
	$.ajax({
		type: 'GET',
		url: 'http://localhost:1234/scripts/php_handler.php',
		success: function(data) {
			var temp = JSON.parse(data);
			for(obj in temp.objs){
				inject(temp.objs[obj]);
			}
		}
	});
}
function inject(data) {
	var temp = "<tr class =\"item_row\"><td>" + data.item + "</td><td>" +
	data.price + "</td><td>" + data.stock + "</td><td>" +
	data.off + "%</td>";
	$("#items").append(temp);
}