$(function() {
  $('.image-editor').cropit();
  /*
  $('.rotate-cw').click(function() {
    $('.image-editor').cropit('rotateCW');
  });
  $('.rotate-ccw').click(function() {
    $('.image-editor').cropit('rotateCCW');
  });
   $('.export').click(function() {
   var imageData = $('.image-editor').cropit('export');
   window.open(imageData);
   });
  */
  $('.get-cor').click(function() {

    var crop = $('.image-editor').cropit('offset');
    var x = crop.x.toString();
    var y = crop.y.toString();
    x = x.replace("-", "");
    y = y.replace("-", "");

    var scale = $('.image-editor').cropit('zoom');
    jQuery('#admin_paginabundle_pagina_foto_proporcoes_0_cropStartLeft').val(x);
    jQuery('#admin_paginabundle_pagina_foto_proporcoes_0_cropStartTop').val(y);
    jQuery('#admin_paginabundle_pagina_foto_proporcoes_0_scale').val(scale);
    console.log($('.image-editor').cropit('offset'));
    console.log($('.image-editor').cropit('zoom'));
    $('.image-editor').cropit('disable');
  });

  //$('.image-editor').cropit('previewSize', { width: 800, height: 450 });
});