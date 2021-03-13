$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"/functions/fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('.tours__wrapper').html(data);
			}
		});
	}
	
	$('.search__input').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data();			
		}
	});
});