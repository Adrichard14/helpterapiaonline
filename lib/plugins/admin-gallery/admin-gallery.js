/*
    Admin Gallery by Kaique Garcia
    kaique@freedomdigital.com.br
*/
;(function(w,d,$,undefined) {
    var ctrl = {
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
        },
        'crop': function(e) {
            e.preventDefault();
            crop($(this).attr('data-URL'), $(this).attr('data-name'), $(this).attr('data-width'), $(this).attr('data-height'));
        }
    };
    w.attatch_gallery_functions = function() {
        $('.admin-gallery > ul > li[data-attatched="0"]').each(function() {
            var func = $(this).attr('data-func');
            if(typeof ctrl[func] == "function")
                $(this).click(ctrl[func]).attr('data-attatched', '0');
        });
    };
    $(d).ready(function() {
        w.attatch_gallery_functions();
        $('.admin-gallery > a').fancybox({
            type: 'image',
            beforeLoad: function() {
                var fancy = this;
                $('input.admin-gallery-title').each(function() {
                    var title = $(this).val();
                    if(title == "")
                        title = "Imagem sem título";
                    $(this).parent().find('.admin-gallery > a').attr('title', title);
                    if(fancy.element[0].id == 'photo' + $(this).attr('data-ID'))
                        fancy.title = title;
                });
            }
        });
        $('.admin-gallery-title').on('keyup, change', function() {
            
        });
        var photo_container = $("#photos"), attatched = false;
        w.attatch_sortable = function() {
            if(attatched)
                photo_container.sortable('refresh');
            else if(photo_container.children('li').length > 1) {
                photo_container.sortable({
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
                attatched = true;
            }
        };
        w.attatch_sortable();
    });
})(window, document, jQuery);