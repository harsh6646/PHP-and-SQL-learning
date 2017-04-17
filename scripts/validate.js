$(function(){
	$("#item_form").validate({
		debug: true,
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
				number: "Percent off must be a decmial number"
			},
		},
		submitHandler: function() {
			
			// call the ajax post method
			ajax_post();
			// add the bootstrap success method if post is successful
		},
		invalidHandler: function(form) {

			// add the bootstrap error message
		}
	});
});