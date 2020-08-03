var target, src, x0, y0, w, h; //for crop
function confirmFirst(f) {
	f = f || function() {
		alert("Detectamos uma falha. Por favor, tente novamente mais tarde.");
	};
	$.ajax({
		type: "POST",
		url: "inc/forms/confirm.php",
		dataType: "text",
		success: function(response) {
			modal("Confirme a ação digitando sua senha", response, null);
			var errors = 0;
			$("#form").submit(function() {
				var btn = $(this).find('button[type="submit"]')[0], l = loader({btn:btn}).on();
				var data = $(this).serializeArray();
				$.ajax({
					type: "POST",
					url: "responses/confirm.php",
					data: data,
					dataType: "text",
					success: function(response) {
						l.off();
						if(response.indexOf("sucesso") >= 0) {
							f();
						} else {
							errors++;
							if(errors == 3) {
								$.ajax({
									type: "POST",
									url: "logout.php",
									dataType: "text",
									success: function() {
										alert("Você errou sua senha três vezes. Estamos te desconectando por segurança.");
									}
								});
								location.href = "login.php";
							}
							alert(response + "\nRestam " + (3-errors) + " tentativas.");
						}
					}
				});
				return false;
			});
		}
	});
}

var winterval = null, original_title = document.title, titles = [". - - ","- . - ","-  - ."], index = 0, p;
function waiting(show) {
	if(winterval == null) {
		winterval = window.setInterval(function() {
			if(index == 0) p = 1;
			else if(index == titles.length-1) p=-1;
			index = (index+p)%titles.length;
			document.title = titles[index] + original_title;
		}, 300);
		return false;
	} else if(show !== false) alert("Por favor, aguarde um pouco, se a conexão estiver lenta o processo pode demorar.");
	return true; //was waiting before!
}
function done(callback) {
	if(winterval != null) {
		window.clearInterval(winterval);
		document.title = original_title;
		index = 0;
		p = 1;
		if(typeof callback == "function") callback();
		winterval = null;
	}
}
function loader(def) {
	this.btn = def.btn || def;
	this.on = function() {
		if(typeof this.btn != "undefined" && !waiting()) {
			this.basefolder = def.basefolder || "../";
			this.img = def.img || 'assets/images/loader.gif';
			this.style = def.style || 'margin: auto auto;';
			this.disabledClass = def.disabledClass || "disabled";
			this.oldValue = this.btn.innerHTML;
			this.callback = def.callback || false;
			this.btn.innerHTML = '<img src="' + this.basefolder + this.img + '" style="' + this.style + '" />';
			this.btn.disabled = true;
		}
		return this;
	};
	this.off = function() {
		if(typeof this.btn != "undefined") {
			var pos = this.btn.className != null ? this.btn.className.indexOf(this.disabledClass)-1 : 0, //length: 8
				className = pos > 0 ? this.btn.className.substr(0, pos) + this.btn.className.substr(pos+this.disabledClass.length) : this.btn.className;
			this.btn.className = className;
			this.btn.innerHTML = this.oldValue;
			this.btn.disabled = false;
			if(typeof this.callback == "function") this.callback();
			done();
		}
		return this;
	};
	this.isLoading = function() {
		return typeof this.btn != "undefined" && waiting(false);
	}
	return this;
}

function crop(URL, name, width, height) {
	$.ajax({
		type: "POST",
		url: "inc/forms/crop.php",
		data: "URL=" + URL,
		dataType: "text",
		success: function(r) {
			supermodal("Ferramenta de Corte", r, null);
			target = $("#cropimg");
			src = target.attr("src");
			target.imgAreaSelect({
				aspectRatio: width.toString() + ':' + height.toString(),
				maxWidth: width*5,
				maxHeight: height*5,
				handles: true,
				onSelectEnd: fetchVars,
				imageWidth: document.getElementById('cropimg').naturalWidth,
				imageHeight: document.getElementById('cropimg').naturalHeight
			});
			$("#cropform").submit(function(e) {
				if(w != null && w != 0) {
				var btn = $(this).find('button[type="submit"]')[0], l = loader({btn:btn}).on();
					$.ajax({
						type: "POST",
						url: "responses/crop.php",
						data: "name=" + name + "&URL=" + src + "&x0=" + x0 + "&y0=" + y0 + "&crop_w=" + w + "&crop_h=" + h + "&w=" + width*5 + "&h=" + height*5,
						success: function(response) {
							l.off();
							alert(response);
							if(response.indexOf("sucesso") > 0) modal_kill();
						}
					});
				} else alert("A imagem não foi recortada pois nenhuma área foi selecionada.");
				e.preventDefault();
			});
		}
	});
}

function fetchVars(img, selection) {
	x0 = selection.x1;
	y0 = selection.y1;
	w = selection.width;
	h = selection.height;
}

function randomID() {
    var rid = "randid_" + (Math.random()*1000).toFixed(0).replace('.','');
    return $("#" + rid).length > 0 ? randomID() : rid;
}
function prepare_summernote(str) {
    return str.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
}
function exec_summernote(str) {
    return str.replace(/</g, '&lt;').replace(/>/g, '&gt;');
}
var summernotes = [];
tinyMCE = {
    triggerSave: function() {
        if(summernotes.length > 0)
            for(var x in summernotes) {
                var data = summernotes[x];
                data.elem.html(data.summernote.summernote('code'));
            }
    }
};
function tinyLoader(def) {
    $("textarea" + (def && def.class ? def.class : ".editor") + ":not(.applied)").each(function() {
        var $this = $(this).css('display', 'none').addClass('applied').prop('required', false);
        var id = $this.attr('data-summernote-id');
        if(id == "" || id == undefined)
            $this.attr('data-summernote-id', randomID());
        var id = $this.attr('data-summernote-id');
        $this.after('<div id="summernote_' + id + '">' + prepare_summernote($this.html()) + '</div>');
        var sm = $("#summernote_" + id);
        var placeholder = $(this).attr('data-placeholder') || "Escreva alguma coisa aqui...";
        sm.summernote({
            lang: 'pt-BR',
            placeholder: placeholder,
            height: 100,
            cleaner: {
                notTime: 2400,
                action: 'paste',
                newline: '<br/>',
                notStyle: '',
                icon: '',
                keepHtml: true,
                keepClasses: false,
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'],
                badAttributes: ['start']
            }
        }).summernote('removeModule', 'autoLink');
        var data = {
            elem: $this,
            summernote: sm
        };
        summernotes.push(data);
    });
    $("textarea" + (def && def.title_class ? def.title_class : ".title-editor") + ":not(.applied)").each(function() {
        var $this = $(this).css('display', 'none').addClass('applied').prop('required', false);
        var id = $this.attr('data-summernote-id');
        if(id == "" || id == undefined)
            $this.attr('data-summernote-id', randomID());
        var id = $this.attr('data-summernote-id');
        var placeholder = $(this).attr('data-placeholder') || "Escreva alguma coisa aqui...";
        $this.after('<div id="summernote_' + id + '">' + prepare_summernote($this.html()) + '</div>');
        var sm = $("#summernote_" + id);
        sm.summernote({
            lang: 'pt-BR',
            placeholder: placeholder,
            cleaner: {
                notTime: 2400,
                action: 'paste',
                newline: '<br/>',
                notStyle: '',
                icon: '',
                keepHtml: true,
                keepClasses: false,
                badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'],
                badAttributes: ['start']
            }
        }).summernote('removeModule', 'autoLink');
        var data = {
            elem: $this,
            summernote: sm
        };
        summernotes.push(data);
    });
    /*
	tinyMCE.init({
		// General options
        setup : function(ed) {
              $(ed).on('change', function(e) {
                 $(".tinymce").text(ed.getContent()); 
              });
        },
		mode : def && def.mode ? def.mode : "specific_textareas",
		editor_selector : def && def.class ? def.class : "editor",
		width: '100%',
		height: 100,
		autoresize_min_width: 50,
		autoresize_max_width: 300,
		autoresize_min_height: 50,
		autoresize_max_height: 100,
		language : "pt",
		theme : "advanced",
		elements : 'abshosturls',
		relative_urls : false,
		remove_script_host : false,
		convert_urls : true,
		skin : "o2k7",
		skin_variant : "silver",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave,youtubeIframe",
		// Theme options
		theme_advanced_buttons1 :"fullscreen,removeformat,cleanup,|,bold,italic,underline,strikethrough,|,forecolor,backcolor,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,anchor,image,|,youtubeIframe",
		theme_advanced_buttons2 : "undo,redo,|,pastetext,pasteword,|,formatselect,fontsizeselect,|,outdent,indent,ltr,rtl,blockquote,sub,sup,hr,|,insertdate,inserttime",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		// Drop lists for link/image/media/template dialogs
		file_browser_callback : "tinyBrowser",
	
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		]
	});
	tinyMCE.init({
		// General options
		mode : def && def.title_mode ? def.title_mode : "specific_textareas",
		editor_selector : def && def.title_class ? def.title_class : "title-editor",
		width: '100%',
		height: '30px',
		autoresize_min_width: 50,
		autoresize_max_width: 300,
		language : "pt",
		theme : "advanced",
		elements : 'abshosturls',
		relative_urls : false,
		remove_script_host : false,
		convert_urls : true,
		skin : "o2k7",
		skin_variant : "silver",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,wordcount,autosave",
		// Theme options
		theme_advanced_buttons1 :"removeformat,cleanup,|,bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,undo,redo",
		theme_advanced_buttons2 : "link,unlink,anchor,|,fontsizeselect,|,outdent,indent,ltr,rtl,sub,sup,|,insertdate,inserttime",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		// Drop lists for link/image/media/template dialogs
		file_browser_callback : "tinyBrowser",
	
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		]
	});
    */
}

function deleteModel(ID, URL, callback) {
	confirmFirst(function() {
		if(!waiting()) {
			$.ajax({
				type: "POST",
				url: URL,
				data: "ID=" + ID.toString(),
				dataType: "text",
				success: function(r) {
					done();
					if(typeof callback == "function") callback(r);
					else {
						if(r.indexOf("sucesso") > 0) location.reload();
						else alert(r);
					}
				},
				error: function() {
					modal("Ops!", "Ocorreu um erro de transferência AJAX. Por favor, informe a um administrador para que seja feita uma reavaliação de código!", null);
				}
			});
		}
	});
}
function newUser() {
	if(!waiting())
		$.ajax({
			type: "POST",
			url: "inc/forms/create-user.php",
			dataType: "text",
			success: function(r) {
				done();
				modal("Cadastrar usuário", r, null);
				$("#userform").submit(function(e) {
					var btn = $(this).find('button[type="submit"]')[0], l = loader({btn:btn}).on();
					if(l.isLoading())
						$.ajax({
							type: "POST",
							url: "responses/create-user.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function(r2) {
								l.off();
								if(r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}
function createLink(eventID) {
	if (!waiting())
		$.ajax({
			type: "POST",
			url: "out/inc/forms/create-link.php",
			data: "eventID=" + eventID,
			dataType: "text",
			success: function (r) {
				done();
				modal("Cadastar link", r, null);
				$("#linkform").submit(function (e) {
					var btn = $(this).find('button[type="submit"]')[0], l = loader({ btn: btn }).on();
					if (l.isLoading())
						$.ajax({
							type: "POST",
							url: "out/responses/create-link.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function (r2) {
								l.off();
								if (r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}
function updateLink(ID, eventID) {
	if (!waiting())
		$.ajax({
			type: "POST",
			url: "out/inc/forms/upd-link.php",
			data: {ID: + ID.toString(), eventID: eventID},
			dataType: "text",
			success: function (r) {
				done();
				modal("Alterar link", r, null);
				$("#linkform").submit(function (e) {
					var btn = $(this).find('button[type="submit"]')[0], l = loader({ btn: btn }).on();
					if (l.isLoading())
						$.ajax({
							type: "POST",
							url: "out/responses/upd-link.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function (r2) {
								l.off();
								if (r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}
function updateUser(ID) {
	if(!waiting())
		$.ajax({
			type: "POST",
			url: "inc/forms/upd-user.php",
			data: "ID=" + ID.toString(),
			dataType: "text",
			success: function(r) {
				done();
				modal("Alterar usuário", r, null);
				$("#userform").submit(function(e) {
					var btn = $(this).find('button[type="submit"]')[0], l = loader({btn:btn}).on();
					if(l.isLoading())
						$.ajax({
							type: "POST",
							url: "responses/upd-user.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function(r2) {
								l.off();
								if(r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}

function newClient() {
	if (!waiting())
		$.ajax({
			type: "POST",
			url: "inc/forms/create-client.php",
			dataType: "text",
			success: function (r) {
				done();
				modal("Cadastrar usuário", r, null);
				$("#userform").submit(function (e) {
					var btn = $(this).find('button[type="submit"]')[0],
						l = loader({
							btn: btn
						}).on();
					if (l.isLoading())
						$.ajax({
							type: "POST",
							url: "responses/create-client.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function (r2) {
								l.off();
								if (r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}

function updateClient(ID) {
	if (!waiting())
		$.ajax({
			type: "POST",
			url: "inc/forms/upd-client.php",
			data: "ID=" + ID.toString(),
			dataType: "text",
			success: function (r) {
				done();
				modal("Alterar usuário", r, null);
				$("#userform").submit(function (e) {
					var btn = $(this).find('button[type="submit"]')[0],
						l = loader({
							btn: btn
						}).on();
					if (l.isLoading())
						$.ajax({
							type: "POST",
							url: "responses/upd-client.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function (r2) {
								l.off();
								if (r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}
function newPsy() {
	if (!waiting())
		$.ajax({
			type: "POST",
			url: "inc/forms/create-psychologist.php",
			dataType: "text",
			success: function (r) {
				done();
				modal("Cadastrar usuário", r, null);
				$("#userform").submit(function (e) {
					var btn = $(this).find('button[type="submit"]')[0],
						l = loader({
							btn: btn
						}).on();
					if (l.isLoading())
						$.ajax({
							type: "POST",
							url: "responses/create-psychologist.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function (r2) {
								l.off();
								if (r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}

function updatePsy(ID) {
	if (!waiting())
		$.ajax({
			type: "POST",
			url: "inc/forms/upd-psychologist.php",
			data: "ID=" + ID.toString(),
			dataType: "text",
			success: function (r) {
				done();
				modal("Alterar usuário", r, null);
				$("#userform").submit(function (e) {
					var btn = $(this).find('button[type="submit"]')[0],
						l = loader({
							btn: btn
						}).on();
					if (l.isLoading())
						$.ajax({
							type: "POST",
							url: "responses/upd-psycholoist.php",
							data: $(this).serializeArray(),
							dataType: "text",
							success: function (r2) {
								l.off();
								if (r2.indexOf("sucesso") > 0) location.reload();
								else alert(r2);
							}
						});
					e.preventDefault();
				});
			}
		});
}

document.toggle = function(ID, target) {
	$.ajax({
		type: "POST",
		url: "responses/toggle-" + target + ".php",
		data: "ID=" + ID.toString(),
		dataType: "text",
		success: function(r) {
			if(r.indexOf("sucesso") > 0) location.reload();
			else modal("Ops", r, null);
		}
	});
};
document.toggle_notify = function(ID, target) {
	$.ajax({
		type: "POST",
		url: "responses/togglenotify-" + target + ".php",
		data: "ID=" + ID.toString(),
		dataType: "text",
		success: function(r) {
			if(r.indexOf("sucesso") > 0) location.reload();
			else modal("Ops", r, null);
		}
	});
};
Element.prototype.del = function(cls, ID, cbk, display) {
    if(display == undefined)
        display = 1;
    var callback = function() {
        if(!waiting()) {
            $.ajax({
                type: "POST",
                url: "responses/delete.php",
                data: "class=" + cls + "&ID=" + ID.toString() + "&display=" + display.toString(),
                dataType: "text",
                success: function(r) {
					done();
					if(typeof cbk == "function") cbk(r);
					else {
						if(r.indexOf("sucesso") > 0) location.reload();
						else alert(r);
					}
				},
				error: function() {
					modal("Ops!", "Ocorreu um erro de transferência AJAX. Por favor, informe a um administrador para que seja feita uma reavaliação de código!", null);
				}
            });
        }
    };
    confirmFirst(callback);
}
Element.prototype.toggle = function(cls, ID, cbk, display) {
    if(display == undefined)
        display = 1;
    if(!waiting()) {
        $.ajax({
            type: "POST",
            url: "responses/toggle.php",
            data: "class=" + cls + "&ID=" + ID.toString() + "&display=" + display.toString(),
            dataType: "text",
            success: function(r) {
                done();
                if(typeof cbk == "function") cbk(r);
                else {
                    if(r.indexOf("sucesso") > 0) location.reload();
                    else alert(r);
                }
            },
            error: function() {
                modal("Ops!", "Ocorreu um erro de transferência AJAX. Por favor, informe a um administrador para que seja feita uma reavaliação de código!", null);
            }
        });
    }
}
document.formAjax = function(cls, data, cbk, display) {
    if(display == undefined)
        display = 1;
    $.ajax({
        type: "POST",
        url: "responses/writer.php?class=" + cls + "&display=" + display.toString(),
        data: data,
        dataType: "text",
        processData: false,
        contentType: false,
        success: function(r) {
            if(typeof(cbk) == "function") {
                cbk(r);
            } else if(r.indexOf("sucesso") !== -1) {
                location.href = "index.php";
            } else {
                modal("Ops...", r, null);
            }
        },
        error: function() {
            modal("Ops!", "Ocorreu um erro de transferência AJAX. Por favor, recarregue a página.", null);
        }
    });
}