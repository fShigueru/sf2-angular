$('input.tableflat').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
});
var asInitVals = new Array();
var oTable = $('#example').dataTable({
    "oLanguage": {
        "sSearch": "Buscar por todas as colunas:"
    },
    "aoColumnDefs": [
        {
            'bSortable': false,
            'aTargets': [0]
        } //disables sorting for column one
    ],
    'iDisplayLength': 12,
    "sPaginationType": "full_numbers",
    "dom": 'T<"clear">lfrtip',
    "tableTools": {
        "sSwfPath": ""
    }
});
$("tfoot input").keyup(function () {
    /* Filter on the column based on the index of this element's parent <th> */
    oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
});
$("tfoot input").each(function (i) {
    asInitVals[i] = this.value;
});
$("tfoot input").focus(function () {
    if (this.className == "search_init") {
        this.className = "";
        this.value = "";
    }
});
$("tfoot input").blur(function (i) {
    if (this.value == "") {
        this.className = "search_init";
        this.value = asInitVals[$("tfoot input").index(this)];
    }
});
jQuery(".sorting_dis").removeClass("sorting").addClass("sorting_disabled");
jQuery("#ToolTables_example_0").remove();
jQuery("#ToolTables_example_1").remove();
jQuery("#ToolTables_example_2").remove();
jQuery("#ToolTables_example_3").remove();