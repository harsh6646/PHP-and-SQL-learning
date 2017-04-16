$(function(){
	$('#button').on("click", function(){
		$("#test").html("<li>test</li>");
		ajax_test();
	});
	function ajax_test(){
	$.ajax({
			type: "GET",
			url: "php_handler.php",
			success: function(data) {
				var temp = JSON.parse(data);
				console.log(temp);
				console.log(temp.test);
			},
			error: function () {
				console.log("didn't work");
			}
		});
	}
});