function initCrop(image,x,y,scale,iwidth,iheight){
    jQuery('#admin_commonbundle_banner_image_proporcoes_0_cropStartLeft').val(x);
    jQuery('#admin_commonbundle_banner_image_proporcoes_0_cropStartTop').val(y);
    jQuery('#admin_commonbundle_banner_image_proporcoes_0_scale').val(scale);

    x = parseFloat("-" + x);
    y = parseFloat("-" + y);
    scale = parseFloat(scale);

    jQuery('.image-editor').cropit({
        imageState: {
            src: image,
            zoom: scale,
            offset: {x: x, y: y}
        }
    });
    $('.image-editor').cropit('previewSize', { width: iwidth, height: iheight });
};
function initWithCrop(){
    $('.image-editor').cropit();
    $('.image-editor').cropit('previewSize', { width: 250, height: 250 });
};
$(function() {
    $('.image-editor').cropit();
    //$('.image-editor').cropit('previewSize', { width: 250, height: 250 });
    $('.image-editor').cropit('maxZoom', 2.0);
    $('.image-editor').cropit('minZoom', .3);
    $('.get-cor').click(function() {
        var crop = $('.image-editor').cropit('offset');
        var x = crop.x.toString();
        var y = crop.y.toString();
        x = x.replace("-", "");
        y = y.replace("-", "");

        var scale = $('.image-editor').cropit('zoom');
        jQuery('#admin_commonbundle_banner_image_proporcoes_0_cropStartLeft').val(x);
        jQuery('#admin_commonbundle_banner_image_proporcoes_0_cropStartTop').val(y);
        jQuery('#admin_commonbundle_banner_image_proporcoes_0_scale').val(scale);
        $('.image-editor').cropit('disable');
    });
    $('.block-crop').click(function() {
        $('.image-editor').cropit('reenable');
    });
});
function getLocalBanner(){
    var local = jQuery('#admin_commonbundle_banner_local option:selected').text();
    local = local.match( /\((.*?)\)/ )[1];
    var retorno = local.split("x");
    $('.image-editor').cropit('previewSize', { width: retorno[0], height: retorno[1] });
}