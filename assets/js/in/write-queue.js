;(function(w,d,$,undefined) {
    var lang = w.lang;
    var form = $("#wform"), btn = form.find('button[type="submit"]');
    if(form.length == 0 || btn.length == 0)
        return false;
    tinyLoader();
    $("#execution_date").datetimepicker({
        lang: 'pt-BR',
        format: 'd/m/Y',
        timepicker: false,
        allowBlank: false,
        scrollMonth: false
    });
    form.submit(function(e) {
        e.preventDefault();
        var bt = btn.get(0);
        if(bt.disabled)
            return false;
        bt.disabled = true;
        tinyMCE.triggerSave();
        var FD = new FormData(this);
        $.ajax({
            type: "POST",
            url: "responses/write-queue.php",
            data: FD,
            dataType: 'text',
            contentType: false,
            processData: false,
            success: function(r) {
                bt.disabled = false;
                if(r.indexOf("sucesso") > 0) {
                    location.href = 'queues.php';
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