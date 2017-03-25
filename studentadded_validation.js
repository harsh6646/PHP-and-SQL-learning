$(function(){
	$("#myForm").validate({
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
			}
		}
	});
});