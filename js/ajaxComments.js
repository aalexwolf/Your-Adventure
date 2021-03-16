$(document).ready(function () {

	var selectedRate = 0,
	    userComment = '';

    upadateComments();
	selectStarRating();

	function upadateComments() {
		$.ajax({
			url: "/functions/comments_update.php",
			method: "post",
			success: function (data) {
                $('.review__wrapper').html(data);
				selectStarRating();
			}
		});
	}

    function addComment() {
		$.ajax({
			url: "/functions/comment_add.php",
			method: "post",
			data: {
				rate: selectedRate,
				comment: userComment
			},
			success: function (response) {
				if (response == 'OK') {
					upadateComments();
				} else {
					alert(response);
				}
			}
		});
	}

	function deleteComment() {
		$.ajax({
			url: "/functions/comment_delete.php",
			method: "post",
			success: function (response) {
				if (response == 'OK') {
					upadateComments();
				} else {
					alert(response);
				}
			}
		});
	}


	$(document).on('click', '.comment__send', function () {
		userComment = document.querySelector('#comment_text').value;
		addComment();
	});


	$(document).on('click', '.review__delete', function () {
		deleteComment();
	});


	function selectStarRating() {
		stars = document.querySelectorAll('.star-img');
		stars.forEach(star => {
			star.addEventListener('click', e => {
				selectedRate = e.target.dataset.rate;
				for (let i = 0; i < stars.length; i++) {
					if (i < selectedRate) {
						stars[i].src = '/img/rating/yellow.svg';
					} else {
						stars[i].src = '/img/rating/gray.svg';
					}
					
				}
			});
		});
	}
});