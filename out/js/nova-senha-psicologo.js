$(document).ready(function () {
    $("#form_pw").submit(function () {
        var data = $(this).serializeArray();
        var btn = $(this).find('button[type="submit"]')[0], l = loader({ btn: btn }).on();
        $.ajax({
            type: "POST",
            url: "out/responses/nova-senha-psicologo.php",
            data: data,
            dataType: "text",
            success: function (response) {
                var title = "Oops!";
                setInterval(function () {
                    document.title = ". " + document.title;
                }, 700);
                modal("Sucesso!", response, null)
                setTimeout(function () {
                    window.location = "index";
                }, 5000);
            }
        });
        return false;
    });
    var input = $("#form_pw").find('input:first')[0];
    input.focus();
});