$('#admin_commonbundle_banner_dtPublicacao').daterangepicker(optionSet1);
$('#admin_commonbundle_banner_dtExpiracao').daterangepicker(optionSet1);
jQuery('#admin_commonbundle_banner_local').on('change', function(){
    if(jQuery("#admin_commonbundle_banner_local option:selected").val() != ""){
        jQuery('.image-editor').show();
    }else{
        jQuery('.image-editor').hide();
    }
});
if(jQuery("#admin_commonbundle_banner_local option:selected").val() != ""){
    jQuery('.image-editor').show();
}