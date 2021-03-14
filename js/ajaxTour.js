$(document).ready(function () {

	document.getElementById("select-box1").selectedIndex = 0;

	

	var sort = document.querySelector('#select-box1').value;
		search = $('.search__input').val(),
		priceMin = document.querySelector('#rangeMin').min,
		priceMax = document.querySelector('#rangeMax').max,
		date = $('#date-arr').val(),
		people = $('#peopleNum').val();

	load_data();

	function load_data() {
		$.ajax({
			url: "/functions/searchTours.php",
			method: "post",
			data: {
				sort: sort,
				search: search,
				priceMin: priceMin,
				priceMax: priceMax,
				date: date,
				people: people
			},
			success: function (data) {
				$('.tours__wrapper').html(data);
			}
		});
	}

	$(document).on('change', '#select-box1', function () {
		sort = $(this).val();
		load_data();
	});

	$('.search__input').keyup(function () {
		search = $(this).val();
		load_data();
	});

	$(document).on('input', '#rangeMin', function () {
		priceMin = $(this).val();
		load_data();
	});

	$(document).on('input', '#rangeMax', function () {
		priceMax = $(this).val();
		load_data();
	});

	$(document).on('input', '#date-arr', function () {
		date = $(this).val();
		load_data();
	});

	$(document).on('input', '#peopleNum', function () {
		people = $(this).val();
		load_data();
	});

	$(document).on('click', '.btn_clean', function () {
		$("input[type=date]").val("");
		date = $(this).val();
		load_data();
	});
});