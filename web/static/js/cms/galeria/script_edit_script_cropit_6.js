function initCrop(image,x,y,scale,index,w,h){
    var id =  parseInt(index)-1;
    jQuery('#admin_galeriabundle_galeria_image_' + id + '_proporcoes_cropStartLeft').val(x);
    jQuery('#admin_galeriabundle_galeria_image_' + id + '_proporcoes_cropStartTop').val(y);
    jQuery('#admin_galeriabundle_galeria_image_' + id + '_proporcoes_scale').val(scale);

    x = parseFloat("-" + x);
    y = parseFloat("-" + y);
    scale = parseFloat(scale);

    var objectEditor = jQuery('.image-editor'+index);
    objectEditor.cropit({
        imageState: {
            src: image,
            zoom: scale,
            offset: {x: x, y: y}
        }
    });
    objectEditor.cropit('previewSize', { width: w, height: h });
    objectEditor.cropit('maxZoom', 2.0);
    objectEditor.cropit('minZoom', .3);

};
function initCropNew(index,w,h){
    var objectEditor = jQuery('.image-editor'+index);
    objectEditor.cropit();
    objectEditor.cropit('previewSize', { width: w, height: h });
    objectEditor.cropit('maxZoom', 2.0);
    objectEditor.cropit('minZoom', .3);
};
function getCor(index){
    var objectEditor = jQuery('.image-editor'+index);
    var crop = objectEditor.cropit('offset');
    var x = crop.x.toString();
    var y = crop.y.toString();
    x = x.replace("-", "");
    y = y.replace("-", "");

    var id =  parseInt(index)-1;
    var scale = objectEditor.cropit('zoom');
    jQuery('#admin_galeriabundle_galeria_image_' + id + '_proporcoes_cropStartLeft').val(x);
    jQuery('#admin_galeriabundle_galeria_image_' + id + '_proporcoes_cropStartTop').val(y);
    jQuery('#admin_galeriabundle_galeria_image_' + id + '_proporcoes_scale').val(scale);
    objectEditor.cropit('disable');
}
function reenable(index){
    var objectEditor = jQuery('.image-editor'+index);
    objectEditor.cropit('reenable');
}