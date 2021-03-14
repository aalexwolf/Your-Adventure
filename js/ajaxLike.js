$(document).ready(function () {

    likeCount();

	function like() {
		$.ajax({
			url: "/functions/like.php",
			method: "post",
			success: function (data) {
                if (data == 'error') {
                    alert('Чтобы поставить лайк, необходимо войти!');
                } else {
                    updateColor(data);
                    likeCount();
                }
                
			}
		});
	}

    function likeCount() {
		$.ajax({
			url: "/functions/likeCount.php",
			method: "post",
			success: function (data) {
                updateCount(data);
			}
		});
	}

	$(document).on('click', '.like', function () {
		like();
	});

    function updateColor(color) {
        document.querySelector('.like').style.color = color;
    }

    function updateCount(count) {
        $('.likesCount').html(count);
    }
});