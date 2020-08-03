;(function(w,d,$,undefined) {
    function attatch_sortable() {
        $("#photos.populated.sort-attatchted").each(function() {
            $(this).sortable('refresh');
        });
        var newContainer = $("#photos.populated:not(.sort-attatched)").addClass('sort-attatched');
        if(newContainer.children('li').length > 1) {
            newContainer.each(function() {
                $(this).sortable({
                    "containment": "parent",
                    "cursor": "move",
                    "delay": 100,
                    "dropOnEmpty": false,
                    "items": "> li",
                    "update": function(e,ui) {
                        var id = ui.item.attr('id'),
                            children = ui.item.parent().children('li'),
                            i = 0, v = 0;
                        for(i;i<children.length;i++)
                            if(children.get(i).id == id) {
                                v = i+1;
                                break;
                            }
                        if(v == 0)
                            return false;
                    }
                }).disableSelection();
            });
        }
    };
    function attatch_functions(pctrl) {
        $('.admin-gallery > ul > li[data-attatched="0"]').each(function() {
            var func = $(this).attr('data-func');
            if(typeof pctrl[func] == "function")
                $(this).click(pctrl[func]).attr('data-attatched', '0');
        });
    }
    w.delete_photo = function(ID) {
        var el = $("#" + ID + "_rm");
        if(el.attr('data-send') == 1) {
            var URL = el.attr('data-URL');
            $.ajax({
                type: "POST",
                url: "responses/multiphoto-del.php",
                data: "URL=" + URL
            });
        }
        $("#" + ID).remove();
        attatch_sortable();
    };
    w.attatchMultiphoto = function(zoneID, formID) {
        var pctrl = {
            'open': function(e) {
                e.preventDefault();
                $(this).parent().parent().children('a').click();
            },
            'upd': function(e) {
                e.preventDefault();
                w.update($(this).attr('data-ID'));
            },
            'del': function(e) {
                e.preventDefault();
                w.delete_photo($(this).attr('data-ID'));
            }
        };
        var ctrl = {
            'output': $("#photos:not(.populated)").addClass('populated'),
            'rid': function() {
                var id = 'multiphoto_' + (Math.random()*1000).toFixed(0).toString();
                return $("#" + id).length > 0 ? ctrl.rid() : id;
            },
            'add_photo': function(HTML) {
                ctrl.output.append(HTML);
                attatch_sortable();
                attatch_functions(pctrl);
                w.multiSlim();
            },
            'toInput': function(form, inputName) {
                if(inputName == undefined) {
                    inputName = "photoURLs";
                }
                if(form.find('input[name="' + inputName + '"]').length > 0)
                    form.find('input[name="' + inputName + '"]').remove();
                var input = '<input type="hidden" name="' + inputName + '" value="',
                    n = '';
                ctrl.output.find('input.admin-gallery-title').each(function() {
                    var URL = $(this).attr('data-URL'),
                        title = $(this).val();
                    input+= n + URL + ":" + title.replace(/"/g, '');
                    n = ";";
                });
                form.append(input + '" />');
                ctrl.output.find("li[data-send='1']").attr("data-send", "0");
            }
        };
        if(typeof(w.multiphoto) != "function") {
            w.multiphoto = ctrl.toInput;
        }
        var row = $("<div class='row' />"),
            col = $("<div class='col-sm-12' />"),
            form = $('<form id="' + formID + '" method="post" enctype="multipart/form-data" class="dropzone to-attatch" />');
        col.append(form);
        row.append(col);
        $(zoneID + ':not(.populated)').addClass('populated').html(row);
        $("#" + formID + '.to-attatch').removeClass('to-attatch').dropzone({
            paramName: "img", // The name that will be used to transfer the file
            maxFilesize: 16.0, // MB
            addRemoveLinks: true,
            url: "responses/multiphoto-add.php",
            uploadMultiple: false,
            parallelUploads: 1,
            thumbnailWidth: "100px",
            thumbnailHeight: "100px",
            acceptedFiles: ".jpg,.jpeg,.gif,.png,.JPG,.JPEG,.GIF,.PNG",
            autoProcessQueue: true,
            dictDefaultMessage: "Arraste imagens aqui",
            dictFallbackMessage: "Este navegador n&atilde;o suporta adicionar m&uacute;ltiplas imagens.",
            dictFallbackText: "Por favor, utilize a fun&ccedil;&atilde;o para adicionar uma imagem por vez.",
            dictInvalidFileType: "Envie apenas imagens.",
            dictFileTooBig: "Esta imagem &eacute; muito grande.",
            dictCancelUpload: "Cancelar",
            dictCancelUploadConfirmation: "Voc&ecirc; deseja mesmo cancelar este upload?",
            dictRemoveFile: "Remover",
            dictMaxFilesExceeded: "Voc&ecirc; n&atilde;o pode enviar mais do que dez arquivos.",
            init: function() {
                var dropzone = this;
                dropzone.on("success", function(file, r) {
                    dropzone.removeFile(file);
                    if(r === "")
                        r = "''";
                    eval("var obj=" + r + ";");
                    if(typeof(obj) == "string")
                        alert(obj);
                    else if(obj.status == 1) {
                        var rid = ctrl.rid();
                        ctrl.add_photo(obj.HTML.replace(/{id}/g, rid));
                    }
                });
            }
        });
        attatch_sortable();
        attatch_functions(pctrl);
        w.multiSlim();
        return ctrl.toInput;
    };
    w.attatchMultiphoto("#dropzone", "dropform");
})(window, document, jQuery);