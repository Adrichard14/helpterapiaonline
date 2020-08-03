$(document).ready(function () {
	$("#form_login").submit(function () {
		var data = $(this).serializeArray();
		var btn = $(this).find('button[type="submit"]')[0];
		// alert('opa');
		// console.log('opa2');
		$.ajax({
			type: "POST",
			url: "out/responses/login.php",
			data: data,
			dataType: "text",
			success: function (response) {
				var title = "Oops!";
				if (response.indexOf("sucesso") > 0) {
					title = "Sucesso!";
					setInterval(function () {
						document.title = ". " + document.title;
					}, 700);
					setTimeout(function () {
						window.location = "index";
					}, 3000);
				}
				modal(title, response, null);
			}
		});
		return false;
	});
	var input = $("#form_login").find('input:first')[0];
	input.focus();
});