var optionSet1 = {
    singleDatePicker: true,
    calender_style: "picker_4",
    startDate: moment().subtract(29, 'days'),
    endDate: moment(),
    minDate: '01/01/2015',
    maxDate: '31/12/2020',
    dateLimit: {
        days: 60
    },
    showDropdowns: false,
    showWeekNumbers: false,
    timePicker: true,
    timePickerIncrement: 1,
    timePicker12Hour: true,
    ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Último dia do mês': [moment().startOf('month'), moment().endOf('month')]
    },
    opens: 'left',
    buttonClasses: ['btn btn-default'],
    applyClass: 'btn-small btn-primary',
    cancelClass: 'btn-small',
    format: 'DD/MM/YYYY HH:mm',
    separator: ' : ',
    locale: {
        applyLabel: 'Selecionar',
        cancelLabel: 'Fechar',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom',
        daysOfWeek: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
        monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho', 'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        firstDay: 1,
        autoClose: false
    }
};