var Script = function () {

    // begin first table
    $('#emptyrow').dataTable({
        "bProcessing":true,
        "bServiceSide":false,
        "bPaginate": true,
        "bScrollCollapse": true,
        "bJqueryUI":true,
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sSearch": "Pencarian:",
			"sLoadingRecords": "Silahkan tunggu Sebentar...",
            "sInfoEmpty": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
            "sEmptyTable": "Tidak ada data dalam database.",
			"sZeroRecords": "Pencarian tidak sama dengan kata kunci didalam database!",
            "sInfo": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
            "sLengthMenu": "_MENU_ Isi yang ditampil perhalaman",
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