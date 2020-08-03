$("#wform").submit(function (e) {
    var btn = $(this).find('button[type="submit"]')[0],
        l = loader({
            btn: btn
        }).on();
    tinyMCE.triggerSave();
    $.ajax({
        type: "POST",
        url: "out/responses/write-workhours.php",
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: "text",
        success: function (r) {
            l.off();
            setInterval(function () {
                document.title = ". " + document.title;
            }, 700);
            setTimeout(function () {
                window.location = "cadastrar-agenda";
            }, 3000);
        }
    });
    e.preventDefault();
});