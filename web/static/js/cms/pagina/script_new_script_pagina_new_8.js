$('#admin_paginabundle_pagina_dtPublicacao').daterangepicker(optionSet1);
$('#admin_paginabundle_pagina_status label').css({"margin":"10px 20px 5px 0px"});
function onAddTag(tag) {
    alert("Added a tag: " + tag);
};
function onRemoveTag(tag) {
    alert("Removed a tag: " + tag);
};
function onChangeTag(input, tag) {
    alert("Changed a tag: " + tag);
};
$(function () {
    $('#admin_paginabundle_pagina_paginaSeo_0_keyWord').tagsInput({
        width: 'auto'
    });
});