;(function(w,d,$,undefined) {
    var lang = w.lang;
    var form = $("#wform"), btn = form.find('button[type="submit"]');
    if(form.length == 0 || btn.length == 0)
        return false;
    form.submit(function(e) {
        e.preventDefault();
        var bt = btn.get(0);
        if(bt.disabled)
            return false;
        bt.disabled = true;
        var FD = new FormData(this);
        $.ajax({
            type: "POST",
            url: "responses/writer.php?class=Email&display=1",
            data: FD,
            dataType: 'text',
            contentType: false,
            processData: false,
            success: function(r) {
                bt.disabled = false;
                if(r.indexOf("sucesso") > 0) {
                    location.href = 'emails.php';
                } else {
                    modal('Ops...', r, null);
                }
            },
            error: function(r) {
                alert('Ocorreu uma falha inesperada enquanto enviávamos o formulário. Por favor, tente novamente mais tarde. Se o problema persistir, entre em contato com um administrador.');
                console.log(r.responseText);
                bt.disabled = false;
            }
        });
    });
})(window, document, jQuery);