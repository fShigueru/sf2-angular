$('#admin_commonbundle_vitrine_dtPublicacao').daterangepicker(optionSet1);
$('#admin_commonbundle_vitrine_dtExpiracao').daterangepicker(optionSet1);
$('#admin_commonbundle_vitrine_status label').css({"margin":"10px 20px 5px 0px"});
$('#admin_commonbundle_vitrine_target label').css({"margin":"10px 20px 5px 0px"});
jQuery('#abaOpcaoData').on("click", function(){
    if (jQuery(".collapse").is(":visible") == true) {jQuery("#ifFiltroData").val(0);}
    else {jQuery("#ifFiltroData").val(1);};
});
var configuracao = {minWidth:1399, minHeight:620, maxWidth:1401, maxHeight:622};
jQuery("#admin_commonbundle_vitrine_file").change(function(){readURL(this,configuracao);});
