var Script = function () {

    // begin first table
    $('#companys').dataTable({
        "bProcessing":true,
        "bServiceSide":false,
        "bInfo" : false,
        "bFilter" : true,
        // "sScrollYInner": "180px",
        "bPaginate": true,
        // "bScrollCollapse": true,
        "bJqueryUI":true,
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sZeroRecords":"",
            "sEmptyTable": "",
            // "sSearch": "Pencarians:",
			"sLoadingRecords": "Silahkan tunggu Sebentar...",
            // "sInfoEmpty": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
			// "sZeroRecords": "List job shipment jobs:",
            "sInfo": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
            "sLengthMenu": "_MENU_ Isi yang ditampil perhalamans",
            "oPaginate": {
                "sPrevious": "Sebelumnya",
                "sNext": "Selanjutnya"
            }
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
        }]
    });
}();