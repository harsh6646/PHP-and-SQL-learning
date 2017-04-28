$(function(){
	ajax_get();
	var table = $('#items');
	table.on('click','.remove', function() {
		ajax_delete($(this));
	});
	table.on('click', '.edit', function(){
		ajax_put($(this));
	});
	valid($("#item_form"));
});