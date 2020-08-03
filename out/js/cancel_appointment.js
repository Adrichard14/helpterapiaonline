    var form = $('#cancelForm'),
        btn = form.find("button[type='submit']")[0];
    sucessLabel = $('#sucess');
    errorLabel = $('#error');
    form.submit(function (e) {
        e.preventDefault();
        if (btn.disabled) {
            return false;
        }
        btn.disabled = true;
        $.ajax({
            type: "POST",
            url: "out/responses/cancel_appointment.php",
            data: $(this).serialize(),
            dataType: "text",
            success: function (r) {
                alert(r);
                $('#sucess').show();
                $("form#cancelForm :input").each(function () {
                    var input = $(this);
                    input.val('');
                });
            },
            error: function (r) {
                alert(r);
                $('#error').show();
            }

        })
    });