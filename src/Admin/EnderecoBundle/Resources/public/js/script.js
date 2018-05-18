jQuery('#form_estados').on('change', function (e) {
    jQuery('#admin_enderecobundle_bairro_cidade').prop('disabled', 'disabled');
    jQuery('#form_cidades').prop('disabled', 'disabled');
    jQuery('#admin_enderecobundle_logradouro_bairro').prop('disabled', 'disabled');
    if(jQuery(this).val() != 0){
        jQuery('#admin_enderecobundle_bairro_cidade').html('');
        jQuery('#form_cidades').html('');
        jQuery('.buscando_cidade').show();
        jQuery.get('/admin/cidade/ajax/lista-cidade/' + jQuery(this).val(), function( data ) {
            jQuery('.buscando_cidade').hide();
            jQuery('#admin_enderecobundle_bairro_cidade').prop('disabled', false);
            jQuery('#form_cidades').prop('disabled', false);
            jQuery('#form_estados').prop('disabled', false);
            jQuery('.selecione_cidade').show();
            jQuery('#admin_enderecobundle_bairro_cidade').append('<option value="">--Selecione uma cidade--</option>');
            jQuery('#form_cidades').append('<option value="">--Selecione uma cidade--</option>');
            for (x in data) {
                jQuery('#admin_enderecobundle_bairro_cidade').append('<option value="'+x+'">' + data[x] + '</option>');
                jQuery('#form_cidades').append('<option value="'+x+'">' + data[x] + '</option>');
            }
        },"json");
    }
});
