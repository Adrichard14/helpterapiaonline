;(function(w,d,$,undefined) {
    w.autoForm = {
        callback: function(target) {
            w.location.reload();
        },
        open: function(title, act, target, data, cbk) {
            if(data == undefined)
                data = null;
            $.ajax({
                type: "POST",
                url: "inc/forms/" + target.toLowerCase() + ".php",
                data: data,
                dataType: "text",
                success: function(r) {
                    modal(title, r, null);
                    w.autoForm.prepare(act, target, cbk);
                },
                error: function(r) {
                    alert("Ocorreu uma falha inesperada enquanto buscávamos o formulário. Por favor, tente novamente mais tarde.");
                    return false;
                }
            });
        },
        prepare: function(act, target, cbk) {
            w.multiSlim();
            tinyLoader();
            var colorInput = $("#colorInput"),
                colorOutput = $("#colorOutput");
            if(colorInput.length > 0) {
                colorInput.colpick({
                    layout: 'hex',
                    color: colorInput.val(),
                    onSubmit: function(hsb,hex,rgb, el) {
                        var $el = $(el);
                        colorInput.val("#" + hex);
                        colorOutput.css('color', '#' + hex);
                        $el.colpickHide();
                    }
                });
                function adjustPos() {
                    var offset = colorInput.offset();
                    colorOutput.css({
                        position: 'absolute',
                        top: "6px",
                        left: (colorInput.outerWidth() - 25).toString() + "px",
                        'z-index': 4
                    });
                }
                $(w).on('resize', adjustPos);
                w.setTimeout(function() {
                    adjustPos();
                }, 600)
                colorInput.colpickShow();
            }
            $("#mform").submit(function(e) {
                e.preventDefault();
                var btn = $(this).find('button[type="submit"]').get(0),
                    l = loader({btn:btn}).on();
                tinyMCE.triggerSave();
                if(l.isLoading()) {
                    $.ajax({
                        type: "POST",
                        url: "responses/writer.php?class=" + target + "&display=0",
                        data: $(this).serializeArray(),
                        dataType: "text",
                        success: function(r) {
                            l.off();
                            if(r.indexOf("sucesso") > 0) {
                                if(typeof(cbk) == "function") {
                                    cbk();
                                } else {
                                    w.autoForm.callback(target);
                                }
                            } else {
                                alert(r);
                            }
                        },
                        error: function(r) {
                            l.off();
                            alert("Ocorreu uma falha inesperada enquanto enviávamos o formulário.\n\nPor favor, tente novamente mais tarde.");
                            console.log(r);
                        }
                    });
                }
            });
        }
    };
})(window, document, jQuery);