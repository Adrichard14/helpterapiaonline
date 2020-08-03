//by Kaique Garcia Menezes
$(document).ready(function() {
	var div = $("<div/>");
	div.attr({
		id: 'modal_point',
		class: 'modal fade'
	});
	$("body").append(div);
	$('#modal_point').on('hidden.bs.modal', function () {
		if($("#cropimg").length > 0) {
			$("#cropimg").imgAreaSelect({remove:true});
		}
		document.getElementById('modal_point').innerHTML = "";
	});
});
function modal(title, msg, footertxt) {
	var fade = document.getElementById('modal_point');
	var footer = "";
	var header = "";
	if(title != null) {
		header = "		<div class='modal-header text-center'>" +
				"			<h4 class='modal-title'>" + title + "</h4>" +
				"			<button type='button' class='close' data-dismiss='modal'>" +
				"				<span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span>" +
				"			</button>" +
				
				"		</div>";
	}
	if(footertxt !== null) {
		footer = "		<div class='modal-footer'>" + footertxt
				"		</div>";
	}
	var html = "<div class='modal-dialog text-cnet'>" +
				"	<div class='modal-content'>" + header +
				"		<div class='modal-body'>" + msg +
				"		</div>" + footer +
				"	</div>" +
				"</div>";
	fade.innerHTML = html;
	$('#modal_point').modal('show');
}
function supermodal(title, msg, footertxt) {
	modal(title, msg, footertxt);
	$(".modal-dialog").css("max-width", "100%").css("width", "100%").css("padding", "0");
	$(".modal-content").css("border-radius", "");
	$(".modal-body").css("padding", "5px").css("padding-top", "2px");
	$(".modal-title").css("line-height", "");
	$(".modal-header").css("padding-bottom", "2px");
}
function modal_kill() {
	$('#modal_point').modal('hide');
}
function modalConfirm(preinputs, text, url) {
	preinputs = preinputs == null ? "" : preinputs;
	text = text == null ? "" : "<div class='alert alert-danger'>"+ text + "</div>";
	url = url == null ? "" : url;
	modal('Confirme com sua senha!',
		'<form id="modal_form" role="form" method="post" action="' + url + '">' + preinputs +
		'	' + text +
		'	<div class="form-group">' +
		'		<label>Digite sua senha para continuar:</label>' +
		'		<input type="password" name="confirm_password" class="form-control" value="" placeholder="Digite sua senha!" required onfocus/> ' +
		'	</div>' +
		'</form>',
		'<div class="btn-group btn-group-justified">' +
		'		<a href="javascript::void(0);" class="btn btn-success" onClick="document.getElementById(\'modal_form\').submit();">Confirmar</a>' +
		'		<a href="javascript::void(0);" class="btn btn-danger" onClick="modal_kill()">Cancelar</a>' +
		'</div>');
}