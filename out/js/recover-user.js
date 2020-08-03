$(document).ready(function () {
    $("#form_recover").submit(function () {
        var data = $(this).serializeArray();
        var btn = $(this).find('button[type="submit"]')[0], l = loader({ btn: btn }).on();
        $.ajax({
            type: "POST",
            url: "out/responses/recover-user.php",
            data: data,
            dataType: "text",
            success: function (response) {
                var title = "Oops!";
                setInterval(function () {
                    document.title = ". " + document.title;
                }, 700);
                alert(response);
                setTimeout(function () {
                    window.location = "index";
                }, 5000);
            }
        });
        return false;
    });
    var input = $("#form_recover").find('input:first')[0];
    input.focus();
});