$("#wform").submit(function (e) {
    var btn = $(this).find('button[type="submit"]')[0],
        l = loader({
            btn: btn
        }).on();
    tinyMCE.triggerSave();
    $.ajax({
        type: "POST",
        url: "out/responses/write-workevents.php",
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: "text",
        success: function (r) {
            // alert(r.URL);
            modal("Sucesso!", '<h5 style="color: #00FF00">Estamos redirecionando você para a tela de pagamento!</h5>', null);
            location.href = r.URL;
            //w.open(r.URL);
        }
    });
    e.preventDefault();
});