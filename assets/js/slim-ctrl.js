;(function(w,d,$,croppers,undefined) {
    function rid() {
        var r = (Math.random()*1000).toFixed(0);
        return $('.slim[data-slim-rid="' + r + '"]').length > 0 ? rid() : r;
    }
    if(!w.slimImageUpload)
        w.slimImageUpload = function(error, data, response) {
            if(error || response == undefined) {
                alert("Ocorreu um erro ao tentar enviar essa imagem. Poderia tentar novamente com outra?");
                console.log(error, data, response);
                return false;
            }
            var form = $('form');
            if(form.length == 0)
                return false;
            var $output = $('input[name="slim[]"][value$=\'' + response.file + '"}\']').closest('.slim');
            var form = $output.closest('form');
            $output = $output.attr('data-fieldname');
            if($output == undefined || $output == null)
                $output = 'thumb';
            var file = "uploads/images/" + response.file;
            var input = form.find('input[name="' + $output + '"]');
            if(input.length == 0) {
                form.append('<input type="hidden" class="before_send" name="thumb" value="' + file + '" />');
            } else
                input.val(file);
        };
    if(!w.gallerySlimImageUpload)
        w.gallerySlimImageUpload = function(error, data, response) {
            if(error) {
                alert("Ocorreu um erro ao tentar enviar essa imagem. Poderia tentar novamente com outra?");
                console.log(error);
                return false;
            }
            $('input[name="slim[]"][value$=\'' + response.file + '"}\']').parent().parent().parent().find('img.admin-gallery-image,input.admin-gallery-title').attr({
                'data-file': "uploads/images/" + response.file,
                'data-url': "uploads/images/" + response.file
            });
        };
    w.slimImageRemove = function(data, remove) {
        if(w.confirm("Deseja mesmo remover essa imagem?")) {
            $('input[value="uploads/images/' + data.input.name + '"]').val("");
            remove();
            return true;
        }
        return false;
    };
    var config = {
        "push": "true",
//        "force-type": "jpg",
        "instant-edit": "true",
        "button-remove-class-name": "hidden",
        "did-upload": "window.slimImageUpload",
        "will-remove": "window.slimImageRemove",
        // TEXTOS
        "label": "Solte imagens aqui ou clique para escolher uma imagem.",
        "label-loading": "Carregando...",
        "button-edit-label": "Recortar",
        "button-remove-label": "Apagar",
        "button-download-label": "Baixar",
        "button-upload-label": "Salvar",
        "button-cancel-label": "Cancelar",
        "button-confirm-label": "Aplicar",
        "status-file-type": "Formato de imagem inválido. Aceitamos apenas $0",
        "status-no-support": "Este navegador não suporta esse serviço. Se quiser utilizar, por favor, mude de navegador.",
        "status-unknown-response": "Ocorreu um erro desconhecido.",
        "status-upload-success": "Imagem salva."
    };
    var gallery_config = {
        "push": "true",
//        "force-type": "jpg",
        "instant-edit": "true",
        "button-remove-class-name": "hidden",
        "did-upload": "window.gallerySlimImageUpload",
        // TEXTOS
        "label": "Solte imagens aqui ou clique para escolher uma imagem.",
        "label-loading": "Carregando...",
        "button-edit-label": "Recortar",
        "button-remove-label": "Apagar",
        "button-download-label": "Baixar",
        "button-upload-label": "Salvar",
        "button-cancel-label": "Cancelar",
        "button-confirm-label": "Aplicar",
        "status-file-type": "Formato de imagem inválido. Aceitamos apenas $0",
        "status-no-support": "Este navegador não suporta esse serviço. Se quiser utilizar, por favor, mude de navegador.",
        "status-unknown-response": "Ocorreu um erro desconhecido.",
        "status-upload-success": "Imagem salva."
    };
    w.removeImage = function(selector) {
        $el = $(selector);
        if($el.length == 0)
            return false;
        var rid = $el.attr('data-slim-rid');
        if(typeof(croppers[rid]) == "undefined")
            return false;
        return croppers[rid].slim('remove');
    };
    w.setRatio = function(selector, ratio) {
        $el = $(selector);
        if($el.length == 0)
            return false;
        var rid = $el.attr('data-slim-rid');
        if(typeof(croppers[rid]) == "undefined")
            return false;
        croppers[rid].slim('setRatio', ratio);
    };
    w.multiSlim = function() {
        var slims = $('.slim.slim-gallery:not([data-slim-rid])');
        if(slims.length > 0) {
            slims.each(function() {
                var attr = {'data-slim-rid': rid()};
                for(var x in gallery_config)
                    attr['data-' + x] = gallery_config[x];
                croppers[attr['data-slim-rid']] = $(this).attr(attr).slim();
            });
        }
        slims = $('.slim:not([data-slim-rid])');
        if(slims.length > 0) {
            slims.each(function() {
                var attr = {'data-slim-rid': rid()};
                for(var x in config)
                    attr['data-' + x] = config[x];
                croppers[attr['data-slim-rid']] = $(this).attr(attr).slim();
            });
        }
    };
    w.multiSlim();
})(window, document, jQuery, {});