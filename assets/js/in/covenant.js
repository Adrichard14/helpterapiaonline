;(function(w,d,$,undefined) {
    var lang = w.lang;
    w.order = function(ID, val, diff, callback) {
        if(val == undefined) {
            modal(lang.SET_ORDER, '<form id="orderform" method="post">' +
                  '<div class="form-group">' +
                  '     <div class="input-group">' +
                  '         <label class="input-group-addon">' + lang.NEW_ORDER + '</label>' +
                  '         <input type="number" class="form-control" name="order" required />' +
                  '     </div>' +
                  '</div>' +
                  '<div class="form-group">' +
                  '     <button type="submit" class="btn btn-success form-control">' + lang.SEND + '</button>' +
                  '</div>' +
                 '</form>', null);
            $("#orderform").submit(function(e) {
                e.preventDefault();
                val = $(this).find('input')[0].value;
                var btn = $(this).find('button[type="submit"]')[0],
                    l   = loader({btn:btn}).on();
                if(isNaN(val)) {
                    alert(lang.INVALID_ORDER);
                    return false;
                }
                if(l.isLoading())
                    w.order(ID, val, 0, function() { l.off(); });
            });
        } else {
            diff = diff == undefined ? 1 : diff;
            if(diff == 0 || !waiting())
                $.ajax({
                    type: "POST",
                    url: "responses/order-convenant.php",
                    data: "ID=" + ID.toString() + "&value=" + val.toString() + "&diff=" + diff.toString(),
                    dataType: "text",
                    success: function(r) {
                        if(typeof(callback) == "function")
                            callback();
                        else
                            done();
                        if(r.indexOf("sucesso") > 0)
                            location.reload();
                        else
                            alert(r);
                    }
                });
        }
    };
})(window, document, jQuery);