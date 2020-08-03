var target = $("#cropimg"),
    src = target.attr("src"),
    x0 = 0,
    y0 = 0,
    w = 0,
    h = 0;
target.imgAreaSelect({
    aspectRatio: window.crop_info.width.toString() + ':' + window.crop_info.height.toString(),
    maxWidth: window.crop_info.width*5,
    maxHeight: window.crop_info.height*5,
    handles: true,
    onSelectEnd: fetchVars,
    imageWidth: document.getElementById('cropimg').naturalWidth,
    imageHeight: document.getElementById('cropimg').naturalHeight
});
function fetchVars(img, selection) {
	x0 = selection.x1;
	y0 = selection.y1;
	w = selection.width;
	h = selection.height;
}
$("#cropform").submit(function(e) {
    if(w > 0 && h > 0) {
    var btn = $(this).find('button[type="submit"]')[0], l = loader({btn:btn}).on();
        $.ajax({
            type: "POST",
            url: "responses/crop.php",
            data: "name=" + window.crop_info.name + "&URL=" + src + "&x0=" + x0 + "&y0=" + y0 + "&crop_w=" + w + "&crop_h=" + h + "&w=" + window.crop_info.width*5 + "&h=" + window.crop_info.height*5,
            success: function(response) {
                l.off();
                alert(response);
                if(response.indexOf("sucesso") > 0)
                    window.close();
            }
        });
    } else alert("A imagem não foi recortada pois nenhuma área foi selecionada.");
    e.preventDefault();
});