;(function(w,d,$,undefined) {
    // require ../slim-ctrl.js
    var lang = w.lang, cls = 'Appointment', list = 'appointments.php';
    var form = $("#wform"), btn = form.find('button[type="submit"]');
    if(form.length == 0 || btn.length == 0)
        return false;
    var date_regex = /^(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2})$/,
        date_output = '$3/$2/$1';
    function get_date(str) {
        return str.match(date_regex) ? str.replace(date_regex, date_output) : false;
    }
    $("input[name='date']").datetimepicker({
        lang: 'pt-BR',
        format: 'd/m/Y',
        timepicker: false,
        allowBlank: false,
        scrollMonth: false,
        mask:"99/99/9999"
        
    });
    $("input[name='telephone']").inputmask({
        mask:['(99) 999-9999','(99) 9999-9999','(99) 99999-9999']
    });
    var covenants = $("#covenants");
    $("select[name='type']").on('change',function(){
        var t = $(this).val(); 
        if(t == 1 ){ //Tipo convênio
            covenants.css("display","block");
        }
        else {
            covenants.css("display","none");
        }
    }).trigger("change");
    var bt = btn.get(0);
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
        d.formAjax(cls, new FormData(this), cbk);
    });
})(window, document, jQuery);