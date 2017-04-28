var $table = $("#items");
var row_temp;
function valid(form){
	form.validate({
		rules: {
			item: {
				required: true
			},
			price: {
				required: true,
				number: true
			},
			stock: {
				required: true,
				digits: true
			},
			off: {
				required: true,
				number: true
			}
		},
		messages: {
			item: {
				required: "Item name must be specified"
			},
			price: {
				required: "Item price must be specified",
				number: "Price must be a decimal number"
			},
			stock: {
				required: "Item stock must be specified",
				digits: "Item stock must be a whole number"
			},
			off: {
				required: "Item percent off must be specified",
				number: "Percent off must be a decmial number"
			},
		},
		submitHandler: function() {
			
			// call the ajax post method
			if(form.attr('id') == 'item_form'){
				ajax_post();
			}
			else if(form.attr('id') == '_form'){
				put();
			}
			// add the bootstrap success method if post is successful
		},
		invalidHandler: function(form) {

			// add the bootstrap error message
		}
	});
	}
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
			inject(temp.obj, window.number);
			$item.val("");
			$price.val("");
			$stock.val("");
			$off.val("");
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
				inject(temp.objs[obj], obj);
			}
		},
		error: function () {
			console.log("ERROR WITH GET");
		}
	});
}
function ajax_put(element) {
	var num = element.attr('data-id');
	var row = $('tr[data-id='+num+']');
	row_temp = row;
	var item = row.children('#item').text();
	var price = row.children('#price').text();
	var stock = row.children('#stock').text();
	var off = row.children('#off').text();
	price = price.slice(1);
	off = off.slice(0, -1);
	var html_temp = "<h2>Edit row "+ row.children('#row_num').text() +" here:</h2>" +
	"<form id='_form'>" +
	"<p>Item:</p>" +
	"<input type='text' id='item' name='item' placeholder='Item Name' value='"+item+"'/><br/>" +
	"<p>Price:</p>" +
	"<input type='text' id='price' name='price' placeholder='Item Price' value='"+price+"'/><br/>" +
	"<p>Stock:</p>" +
	"<input type='text' id='stock' name='stock' placeholder='Item Stock' value='"+stock+"'/><br/>" +
	"<p>Percent off:</p>" +
	"<input type='text'  id='off' name='off' placeholder='Item Percent off' value='"+off+"'/><br/>" +
	"<button class ='cancel'>Cancel</button><button type='submit' class ='confirm'>Confirm</button></form>";
	var inject_div = $('#temp_form_div');
	inject_div.html(html_temp);
	valid($('#_form'));
	inject_div.on('click', '.cancel', function() {
		inject_div.html('');
	})
}
function put() {
	var form = $('#_form');
	var item = form.find('#item');
	var price = form.find('#price');
	var stock = form.find('#stock');
	var off = form.find('#off');
	var info  = {
		item: item.val(),
		price: price.val(),
		stock: stock.val(),
		off: off.val(),
		num: row_temp.attr('data-id')
	}
	console.log(info);
	$.ajax({
		type: 'PUT',
		url: 'http://localhost:1234/scripts/php_handler.php',
		data: info,
		success: function(data) {
			// not working
			console.log('testing');
			item = row_temp.find('.item');
			console.log(item);
			console.log(row_temp);
			console.log(form);
			price = row_temp.find('.price');
			stock = row_temp.find('.stock');
			off = row_temp.find('.off');
			item.val(info.item);
			price.val(info.price);
			stock.val(info.stock);
			off.val(info.off);
			// force refresh
			location.reload();
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
		success: function(data) {
			var $row = $('tr[data-id='+num+']');
			$row.fadeToggle("slow", "linear", function(){
				$row.remove();
			});
		},
		error: function(data) {
			var $row = $('tr[data-id='+num+']');	
			$row.fadeToggle("slow", "linear", function(){
				$row.remove();
			});
			console.log("ERROR WITH DELETE");
		}
	})

}
function inject(data, number) {
	number++;
	var temp = "<tr data-id='" + data.num + "'class ='item_row'><td id='row_num'>"+ number +"</td><td id='item'>" + data.item 
	+ "</td><td id='price'>$" +
	data.price + "</td><td id = 'stock'>" + data.stock + "</td><td id='off'>" +
	data.off + "%</td><td>" + 
	"<button data-id ='" + data.num + "' class ='remove'>Delete</button>" +
	"<button data-id ='" + data.num + "' class = 'edit'>Edit</button></td></tr>";
	window.number = number;
	$table.append(temp);
}