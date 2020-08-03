;(function(w,d,$,undefined) {
    // requires autoform.js
    w.autoCtrl = function($el, title, target, err) {
        function current() {
            var id = $el.val();
            return isNaN(id) || Number(id) <= 0 ? 0 : Number(id);
        }
        function filter() {
            var value = $el.attr('data-filter');
            if(value == undefined) {
                return "-1";
            }
            return value;
        }
        var started = false, builded = false, builders = $el.add(".to-select2");
        function build() {
            if(!builded) {
                var target = $el;
                if(!started)
                    target.add('.to-select2');
                target.select2({
                    placeholder: "clique para selecionar",
                    width: "off",
                    formatResult: function(option) {
                        if(target.find('option[data-color]').length == 0) {
                            return option.text;
                        }
                        var hex = $(option.element[0]).attr('data-color');
                        return option.text + '<span style="background-color: ' + hex + '; height: 20px; width: 20px; display: inline-block; position: absolute; right: 5px;">&nbsp;<?span>';
                    },
                    formatResultCssClass: "form-control",
                    matcher: function matchStart(term, text) {
                        return text.toUpperCase().indexOf(term.toUpperCase()) == 0;
                    }
                });
                started = true;
                builded = true;
            }
        }
        function destroy() {
            if(builded) {
                $el.select2('destroy');
                builded = false;
            }
        }
        var ctrl = {
            add: function() {
                w.autoForm.open('Cadastrar ' + title, 'add', target, null, function() {
                    ctrl.ref();
                    modal_kill();
                });
            },
            upd: function() {
                var ID = current();
                if(ID == 0) {
                    alert(err);
                    return false;
                }
                w.autoForm.open('Alterar ' + title, 'upd', target, 'ID=' + ID.toString(), function() {
                    ctrl.ref();
                    modal_kill();
                });
            },
            del: function() {
                var ID = current();
                if(ID == 0) {
                    alert(err);
                    return false;
                }
                deleteModel(ID, 'responses/del-' + target + '.php', function() {
                    ctrl.ref();
                    modal_kill();
                });
            },
            apply: function(html, value) {
                destroy();
                var multiple = $el.attr('multiple');
                if(multiple) {
                    value = [];
                    $el.find('option:selected').each(function() {
                        value.push($(this).attr('value'));
                    });
                }
                $el.html(html);
                if(multiple) {
                    for(var x in value) {
                        $el.find('option[value="' + value[x] + '"]').prop('selected', true);
                    }
                } else {
                    if($el.find('option[value="' + value + '"]').length > 0)
                        $el.val(value);
                }
                build();
            },
            ref: function() {
                var ID = current().toString(),
                    fill = filter();
                $.ajax({
                    type: "POST",
                    url: "responses/get-" + target.toLowerCase() + ".php",
                    data: "filter=" + fill,
                    dataType: "text",
                    success: function(r) {
                        ctrl.apply(r, ID);
                    }
                });
            }
        };
        w.autoForm.callback = function(target) {
            ctrl.ref();
            modal_kill();
        };
        var target_lower = target.toLowerCase();
        $(".add-" + target_lower + ':not(.populated)').addClass('populated').click(function(e) {
            e.preventDefault();
            ctrl.add();
        }).css('cursor', 'pointer');
        $(".upd-" + target_lower + ':not(.populated)').addClass('populated').click(function(e) {
            e.preventDefault();
            ctrl.upd();
        }).css('cursor', 'pointer');
        $(".del-" + target_lower + ':not(.populated)').addClass('populated').click(function(e) {
            e.preventDefault();
            ctrl.del();
        }).css('cursor', 'pointer');
        $(".ref-" + target_lower + ':not(.populated)').addClass('populated').click(function(e) {
            e.preventDefault();
            ctrl.ref();
        }).css('cursor', 'pointer');
        ctrl.ref();
        var targetCtrl = target + 'Ctrl';
        if(typeof(w[targetCtrl]) == "function") {
            var targetCbk = w[targetCtrl];
            w[targetCtrl] = function() {
                targetCbk();
                ctrl.ref();
            }
        } else {
            w[targetCtrl] = ctrl.ref;
        }
    }
})(window, document, jQuery);