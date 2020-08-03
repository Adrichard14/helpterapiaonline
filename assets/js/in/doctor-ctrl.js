;(function(w,d,$,undefined) {
    // requires autoform.js + autoctrl.js
    var $select = $("select[name='doctorID']");
    w.autoCtrl($select, "médico", "Doctor", "Selecione um médico");
})(window, document, jQuery);