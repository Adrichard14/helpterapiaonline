//Advanced Morphing Modal
var opened = false;
$(document).ready(function() {
	$('[data-type="modal-trigger"]').click(function(){
		var actionBtn = $(this),
			URL = actionBtn.attr('data-url');
		$.ajax({
			type: "POST",
			url: URL,
			dataType: "text",
			success: function(response) {
				morphingModal(actionBtn, response);
			}
		});
	});
	$(document).keyup(function(event){
		if($('.modal-is-visible').length > 0 && event.which=='27') closeModal();
	});

	$(window).on('resize', function(){
		//on window resize - update cover layer dimention and position
		if($('.modal-is-visible').length > 0) window.requestAnimationFrame(updateLayer);
	});
});

function createComponents() {
	var section = $("<section/>");
	section.attr({
		class: "cd-section",
		id: "mm_point"
	});
	var modal = $("<div/>");
	modal.attr({
		class: 'cd-modal'
	});
	var content = $("<div/>");
	content.attr({
		class: 'cd-modal-content',
		id: 'mm_content'
	});
	modal.append(content);
	var closeBtn = $('<a/>').attr({
		href: 'javascript:closeModal()',
		class: 'cd-modal-close',
		id: "mm_close"
	}).html('Fechar').click(function(){
		closeModal();
	});
	section.append(modal).append(closeBtn);
	$('body').append(section);
}

function removeComponents() {
	$('#mm_point').remove();
}

function morphingModal(actionBtn, content) {
	if(!opened) {
		opened = true;
		if($("#mm_content").length == 0) createComponents();
		$('#mm_content').html(content);
		$("body").css("overflow-y", "hidden");
		openModal(actionBtn);
	}
}

function retrieveScale(btn) {
	var btnRadius = btn.width()/2,
		left = btn.offset().left + btnRadius,
		top = btn.offset().top + btnRadius - $(window).scrollTop(),
		scale = scaleValue(top, left, btnRadius, $(window).width(), $(window).height());

	btn.css('position', 'fixed').velocity({
		top: btn.offset().top + btn.height()/2,
		left: btn.offset().left + btn.width()/2,
		translateX: 0,
	}, 0);

	return scale;
}

function scaleValue( topValue, leftValue, radiusValue, windowW, windowH) {
	var maxDistHor = ( leftValue > windowW/2) ? leftValue : (windowW - leftValue),
		maxDistVert = ( topValue > windowH/2) ? topValue : (windowH - topValue);
	return Math.ceil(Math.sqrt( Math.pow(maxDistHor, 2) + Math.pow(maxDistVert, 2) )/radiusValue);
}

function animateLayer(layer, scaleVal, bool, id) {
	layer.velocity({ scale: scaleVal }, 400, function(){
		$('body').toggleClass('overflow-hidden', bool);
		if(bool) {
			$("#mm_point").addClass('modal-is-visible');
		} else {
			layer.removeClass('is-visible').removeAttr('style');
			$('.to-circle[data-type="modal-trigger"]').removeClass('to-circle');
		}
	});
}

function updateLayer() {
	var layer = $('.cd-modal-bg'),
		layerRadius = layer.width()/2,
		layerTop = layer.siblings('.btn').offset().top + layerRadius - $(window).scrollTop(),
		layerLeft = layer.siblings('.btn').offset().left + layerRadius,
		scale = scaleValue(layerTop, layerLeft, layerRadius, $(window).width(), $(window).height());
	
	layer.velocity({
		top: layerTop - layerRadius,
		left: layerLeft - layerRadius,
		scale: scale,
	}, 0);
}

function openModal(actionBtn) {
	var bg = $('.cd-modal-bg');
	actionBtn.addClass('to-circle');
	bg.css("top", actionBtn.offset().top - (actionBtn.height()/2) + "px").
	css("left", actionBtn.offset().left + (actionBtn.width() - 150/2) + "px").
	css("margin-left", actionBtn.css("margin-left"));
	var scaleValue = retrieveScale(bg);
	$('.cd-modal-bg').addClass('is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
		animateLayer($('.cd-modal-bg'), scaleValue, true);
		$(this).off();
	});

	//if browser doesn't support transitions...
	if($('.no-csstransitions').length > 0 ) animateLayer($('.cd-modal-bg'), scaleValue, true);
}

function closeModal() {
	var section = $('.cd-section.modal-is-visible'),
		actionBtn = $('.btn.to-circle');
	$(".cd-modal-bg.is-visible").css("top", actionBtn.offset().top + "px").css("left", actionBtn.offset().left + (actionBtn.width()/2) + "px");
	section.removeClass('modal-is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
		animateLayer($('.cd-modal-bg.is-visible'), 1, false);
		$(this).off();
	});
	//if browser doesn't support transitions...
	if($('.no-csstransitions').length > 0 ) animateLayer($('.cd-modal-bg.is-visible'), 1, false);
	window.setTimeout(function() { removeComponents(); opened = false;}, 900);
	$("body").css("overflow-y", "");
}