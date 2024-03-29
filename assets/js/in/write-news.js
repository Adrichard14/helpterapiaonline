;(function(w,d,$,undefined) {
    // require ../slim-ctrl.js
    var lang = w.lang, cls = 'News', list = 'news.php';
    var form = $("#wform"), btn = form.find('button[type="submit"]');
    if(form.length == 0 || btn.length == 0)
        return false;
    var date_regex = /^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/,
        date_output = '$3/$2/$1';
    function get_date(str) {
        return str.match(date_regex) ? str.replace(date_regex, date_output) : false;
    }
    $("#init").datetimepicker({
        lang: 'pt-BR',
        format: 'd/m/Y H:i',
        allowBlank: true,
        scrollMonth: false,
        onShow: function(ct) {
            this.setOptions({maxDate: get_date($("#end").val())});
        }
    });
    $("#end").datetimepicker({
        lang: 'pt-BR',
        format: 'd/m/Y H:i',
        allowBlank: true,
        scrollMonth: false,
        onShow: function(ct) {
            this.setOptions({minDate: get_date($("#init").val())});
        }
    });
    var bt = btn.get(0);
    tinyLoader();
    function cbk(r) {
        bt.disabled = false;
        if(r.indexOf("sucesso") > 0) {
            w.location.href = list;
        } else {
            modal('Ops...', r, null);
        }
    }
    form.submit(function(e) {
        e.preventDefault();
        if(bt.disabled)
            return false;
        bt.disabled = true;
        tinyMCE.triggerSave();
        d.formAjax(cls, new FormData(this), cbk);
    });
})(window, document, jQuery);