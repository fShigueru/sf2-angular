$(function () {
    'use strict';
    var countriesArray = $.map(countries, function (value, key) {
        return {
            value: value,
            data: key
        };
    });
    // Initialize autocomplete with custom appendTo:
    $('#autocomplete-custom-append').autocomplete({
        lookup: countriesArray,
        appendTo: '#autocomplete-container'
    });
});
function onAddTag(tag) {
    alert("Added a tag: " + tag);
}
function onRemoveTag(tag) {
    alert("Removed a tag: " + tag);
}
function onChangeTag(input, tag) {
    alert("Changed a tag: " + tag);
}
$(function () {
    $('#tags_1').tagsInput({
        width: 'auto'
    });
});
$.listen('parsley:field:validate', function () {
    validateFront();
});
$('#demo-form .btn').on('click', function () {
    $('#demo-form').parsley().validate();
    validateFront();
});
var validateFront = function () {
    if (true === $('#demo-form').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
    } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
    }
};
$.listen('parsley:field:validate', function () {
    validateFront();
});
$('#demo-form2 .btn').on('click', function () {
    $('#demo-form2').parsley().validate();
    validateFront();
});
var validateFront = function () {
    if (true === $('#demo-form2').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
    } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
    }
};
$(":input").inputmask();
validator.message['date'] = 'Data não é válida';
validator.message['empty'] = 'Não pode ser em branco';
validator.message['select'] = 'Por favor selecione algum valor';
validator.message['file'] = 'Adicione uma imagem';
validator.message['min'] = 'O Logradouro tem um valor muito baixo, por favor antes do nome entre com os valores: Rua,Avenida, etc.';
validator.message['number_min'] = 'O valor informado é muito baixo, por favor verifique se está correto.';
validator.message['number_max'] = 'O valor informado é muito alto, por favor verifique se está correto.';
$('form').on('blur', 'input[required], input.optional, select.required', validator.checkField).on('change', 'select.required', validator.checkField).on('keypress', 'input[required][pattern]', validator.keypress)
$('.multi.required').on('keyup blur', 'input', function () {validator.checkField.apply($(this).siblings().last()[0]);});
$('form').submit(function (e) {
    e.preventDefault();
    var submit = true;
    if (!validator.checkAll($(this))){submit = false;}
    if (submit)this.submit();return false;
});
$('#vfields').change(function () {
    $('form').toggleClass('mode2');
}).prop('checked', false);
$('#alerts').change(function () {
    validator.defaults.alerts = (this.checked) ? false : true;
    if (this.checked)
        $('form .alert').remove();
}).prop('checked', false);
$(".money-mask").maskMoney({prefix:'R$ ', thousands:'.', decimal:',', affixesStay: true});
$(".select2_single").select2({placeholder: "-- Selecione --", allowClear: true});
$(".select2_group").select2({placeholder: "-- Selecione --", allowClear: true});
$(".select2_multiple").select2({maximumSelectionLength: 4, placeholder: "With Max Selection limit 4", allowClear:true});