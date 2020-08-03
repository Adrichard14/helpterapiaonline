;(function(w,d,$,undefined) {
    var recovering = false;
    w.recover = function() {
        var login = $("#login").val();
        if(login == "") {
            alert("Digite seu login para iniciarmos o procedimento.");
            return false;
        }
        if(recovering)
            return false;
        recovering = true;
        if(!waiting())
            $.ajax({
                type: "POST",
                url: "responses/recover.php",
                data: "login=" + login,
                dataType: "text",
                success: function(r) {
                    done();
                    alert(r);
                }
            });
    };
})(window, document, jQuery);