;(function(w,d,$,list,selected,separator,undefined) {
    var forming = false;
    function form(act, title, data) {
        if(forming)
            return false;
        forming = true;
        if(data == undefined)
            data = null;
        $.ajax({
            type: "POST",
            url: "inc/forms/" + act + "-email.php",
            dataType: "text",
            data: data,
            success: function(r) {
                modal(title, r, null);
                submt(act);
                forming = false;
            },
            error: function(r) {
                alert("Ocorreu uma falha inesperada enquanto buscávamos o formulário. Por favor, tente novamente em instantes ou contacte um administrador.");
                forming = false;
            }
        });
    }
    function submt(act) {
        var btn = $("#mform button[type='submit']").get(0);
        $("#mform").submit(function(e) {
            e.preventDefault();
            var l = loader({btn:btn}).on();
            if(l.isLoading())
                $.ajax({
                    type: "POST",
                    url: "responses/" + act + "-email.php",
                    data: $(this).serializeArray(),
                    dataType: "text",
                    success: function(r) {
                        l.off();
                        if(r.indexOf("sucesso") > 0) {
                            modal_kill();
                            ctrl.ref();
                        }
                        alert(r);
                    },
                    error: function(r) {
                        alert("Ocorreu uma falha inesperada enquanto enviávamos o formulário. Por favor, tente novamente em instantes ou contacte um administrador.");
                        l.off();
                    }
                });
        });
    }
    var template = '<div class="col-xs-12 col-sm-6 col-md-3 form-group"><label><input type="checkbox" class="email-remove init" data-id="{ID}" checked /> {value}</label> <i class="clip-pencil-3 text-warning email-edit init" data-id="{ID}"></i></div>';
    var input = $("#emailIDs_input"), draw_output = $("#emailIDs_draw"), output = $("#emailIDs_output");
    var refreshing = false;
    var ctrl = {
        add: function() {
            form('add', 'Cadastrar e-mail');
        },
        upd: function(e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('data-id');
            if(isNaN(id) || Number(id) <= 0) {
                alert("E-mail inválido. Por favor, atualize a página.");
                return false;
            }
            form('upd', 'Alterar e-mail', 'ID=' + id);
        },
        del: function(e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('data-id');
            if(isNaN(id) || Number(id) <= 0) {
                alert("E-mail inválido. Por favor, atualize a página.");
                return false;
            }
            var index = selected.indexOf(id);
            if(index >= 0)
                selected.splice(index, 1);
            output.val(selected.join(separator));
            ctrl.draw();
        },
        ref: function() {
            if(refreshing)
                return false;
            refreshing = true;
            $.ajax({
                type: "POST",
                url: "responses/get-emails.php",
                dataType: "json",
                success: function(r) {
                    refreshing = false;
                    if(r.status == 0) {
                        alert("Este serviço está indisponível. Por favor, verifique se há e-mails cadastrados para enviar boletins informativos.");
                        location.href = "emails.php";
                        return false;
                    }
                    list = r.list;
                    ctrl.draw();
                }
            });
        },
        get: function() {
            var ID = input.val();
            if(isNaN(ID) || Number(ID) <= 0) {
                alert("Isto não é um e-mail.");
                return false;
            }
            selected.push(ID);
            output.val(selected.join(separator));
            ctrl.draw();
        },
        draw: function() {
            var HTML = '<div class="row">';
            for(var x in selected) {
                var ID = selected[x], value = list[ID];
                if(value == undefined) {
                    selected.splice(x,1);
                    continue;
                }
                HTML += template.replace(/{ID}/g, ID).replace(/{value}/g, value);
            }
            HTML += '</div>';
            draw_output.html(HTML);
            $(".email-remove.init").each(function() {
               $(this).on('change', ctrl.del);
            }).removeClass('init').css('cursor', 'pointer');
            $(".email-edit.init").each(function() {
                $(this).click(ctrl.upd);
            }).removeClass('init').css('cursor', 'pointer');
            ctrl.draw_select();
        },
        draw_select: function() {
            var HTML = '';
            for(var ID in list) {
                if(selected.indexOf(ID) == -1) {
                    HTML += '<option value="' + ID.toString() + '">' + list[ID] + '</option>';
                }
            }
            if(HTML == '')
                HTML = '<option value="0">sem e-mails</option>';
            input.html(HTML);
        }
    };
    $(".email-refresh.init").click(function(e) {
        e.preventDefault();
        ctrl.ref();
    }).removeClass("init").css('cursor', 'pointer');
    $(".email-add.init").click(function(e) {
        e.preventDefault();
        ctrl.add();
    }).removeClass("init").css('cursor', 'pointer');
    $(".email-select.init").click(function(e) {
        e.preventDefault();
        ctrl.get();
    }).removeClass("init").css('cursor', 'pointer');
    separator = input.attr('data-separator');
    selected = input.val().split(separator);
    for(var x in selected) {
        if(selected[x] == "")
            selected.splice(x,1);
    }
    ctrl.ref();
})(window, document, jQuery, {}, [],';');