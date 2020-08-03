;(function(w,d,$,undefined) {
    var lang = w.lang;
    var module = "queue";
    w.delete = function(ID) {
        deleteModel(ID, 'responses/del-' + module + '.php');
    };
    w.toggle = function(ID) {
        d.toggle(ID, module);
    };
    w.run_service = function() {
        var c = confirm('Isto executará a rotina de envio de e-mails.\nDeseja continuar?');
        if(c && !waiting()) {
            $.post('../queue.php', function(r) {
                alert("Execução efetuada.");
                done();
                console.log(r);
                location.reload();
            });
        }
    }
})(window, document, jQuery);