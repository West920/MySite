$(document).ready(function(){
	
	$("#addcomm").submit(function(){

		var data = $(this).serialize();
		
		$.ajax({
			type: "POST",
			url: "pages/addcomm.php",
			data: data,
			success: function(){

			}
		})
		//return false;
	});

	$(".delcomm").submit(function()
	{
		var data = $(this).serialize();
		$(this).closest(".border.border-comment").hide(500); 
		
		$.ajax({
			type: "POST",
			url: "admin/delcomm.php",
			data: data,
		})
		return false;
	});

	
	
});