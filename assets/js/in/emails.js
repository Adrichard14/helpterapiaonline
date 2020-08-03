;(function(w,d,$,undefined) {
    var lang = w.lang;
    var module = "email";
    w.delete = function(ID) {
        deleteModel(ID, 'responses/del-' + module + '.php');
    };
    w.toggle = function(ID) {
        d.toggle(ID, module);
    };
})(window, document, jQuery);