var $table = $("#items");
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
		},
		error: function () {
			console.log("ERROR WITH GET");
		}
	});
}
function ajax_put(element) {
	info = {
		item: 'testing',
		price: 4,
		stock: 5,
		off: 6,
		num: 9
	};
	$.ajax({
		type: 'PUT',
		url: 'http://localhost:1234/scripts/php_handler.php',
		data: info,
		success: function(data) {
			console.log(data);
			var temp = JSON.parse(data);
			console.log(temp)
		},
		error: function() {
			console.log("ERROR WITH PUT");
		}

	});
}
function ajax_delete(element) {
	var num = element.attr('data-id');
	info = {
		delete: num
	};
	$.ajax({
		type:'DELETE',
		url: 'http://localhost:1234/scripts/php_handler.php',
		data: info,
		success: function() {
			var $row = $('tr[data-id='+num+']');
			$row.fadeToggle("slow", "linear", function(){
				$row.remove();
			});
		},
		error: function() {
			console.log("ERROR WITH DELETE");
		}
	})

}
function inject(data) {
	var temp = "<tr data-id='" + data.num + "'class ='item_row'><td>"+ data.item + "</td><td>" +
	data.price + "</td><td>" + data.stock + "</td><td>" +
	data.off + "%</td><td>" + 
	"<button data-id ='" +data.num+ "' class ='remove'>Delete</button>" +
	"<button data-id ='" +data.num+ "' class = 'edit'>Edit</button></td></tr>";
	$table.append(temp);
}