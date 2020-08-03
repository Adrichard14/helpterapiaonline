var winterval = null,
    original_title = document.title,
    titles = [". - - ", "- . - ", "-  - ."],
    index = 0,
    p;

function waiting(show) {
    if (winterval == null) {
        winterval = window.setInterval(function () {
            if (index == 0) p = 1;
            else if (index == titles.length - 1) p = -1;
            index = (index + p) % titles.length;
            document.title = titles[index] + original_title;
        }, 300);
        return false;
    } else if (show !== false) alert("Por favor, aguarde um pouco, se a conexão estiver lenta o processo pode demorar.");
    return true; //was waiting before!
}

function loader(def) {
    this.btn = def.btn || def;
    this.on = function () {
        if (typeof this.btn != "undefined" && !waiting()) {
            this.basefolder = def.basefolder || "../";
            this.img = def.img || 'help/assets/images/loader.gif';
            this.style = def.style || 'margin: auto auto;';
            this.disabledClass = def.disabledClass || "disabled";
            this.oldValue = this.btn.innerHTML;
            this.callback = def.callback || false;
            this.btn.innerHTML = '<img src="' + this.basefolder + this.img + '" style="' + this.style + '" />';
            this.btn.disabled = true;
        }
        return this;
    };
    this.off = function () {
        if (typeof this.btn != "undefined") {
            var pos = this.btn.className != null ? this.btn.className.indexOf(this.disabledClass) - 1 : 0, //length: 8
                className = pos > 0 ? this.btn.className.substr(0, pos) + this.btn.className.substr(pos + this.disabledClass.length) : this.btn.className;
            this.btn.className = className;
            this.btn.innerHTML = this.oldValue;
            this.btn.disabled = false;
            if (typeof this.callback == "function") this.callback();
            done();
        }
        return this;
    };
    this.isLoading = function () {
        return typeof this.btn != "undefined" && waiting(false);
    }
    return this;
}

function newPsychologist() {
    $("#userform").submit(function (e) {
        var btn = $(this).find('button[type="submit"]')[0],
            l = loader({
                btn: btn
            }).on();
        if (l.isLoading())
            $.ajax({
                type: "POST",
                url: "out/responses/new-psychologist.php",
                data: $(this).serializeArray(),
                dataType: "text",
                 success: function (r2) {
                    if (r2.indexOf("sucesso") > 0) {
                        setTimeout(function () {
                            window.location = "selecionar-plano";
                        }, 3000);
                        modal("Atenção!", r2, null);
                    }else{
                        modal("Ops", r2, null); 
                         $('button[type="submit"]')[0].disabled = false;
                    }
	            },
                // error: function(r2){
                //     modal("Ops", r2, null);
                // }
            });
        e.preventDefault();
    });

}