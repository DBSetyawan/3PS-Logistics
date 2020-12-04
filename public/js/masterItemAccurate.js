var Script = function () {

    // https://datatables.net/reference/option/dom
    // https://legacy.datatables.net/examples/basic_init/dom.html
    // begin first table
    $('#sample_1').dataTable({
        "bProcessing":true,
        "bServiceSide":false,
        "scrollX":true,
        "scrollCollapse": true,
        "sScrollY": "589px",
        "sScrollX": "98.5%",
        "sScrollYInner": "230px",
        "bPaginate": false,
        "bFilter": true,
        // "sDom": '<"search-box"r><"H"lf>t<"F"ip>',
        "sDom": '<"top"i><"H"lf>rt<"F"ip><"clear">',
        "columnDefs": [
            { width: '79%', targets: 0 }
        ],
        "oLanguage": {
            "sSearch": "Cari :",
			"sLoadingRecords": "Silahkan tunggu Sebentar...",
            "sInfoEmpty": "Menampilkan total dari _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
            "sEmptyTable": "Tidak ada data dalam database.",
			"sZeroRecords": "Pencarian tidak sama dengan kata kunci didalam database!",
            "sInfo": "Menampilkan hasil dari jumlah _TOTAL_ antrian ke seluruh antrian (_START_ to _END_)",
            "sLengthMenu": "_MENU_ Isi yang ditampil perhalaman",
            "oPaginate": {
                "sPrevious": "Sebelumnya",
                "sNext": "Selanjutnya"
            }
        },
        "aaSorting": [[1, "asc" ]]
      
    });

    jQuery('#sample_1 .group-checkable').change(function () {
        var set = jQuery(this).attr("data-set");
        var checked = jQuery(this).is(":checked");
        jQuery(set).each(function () {
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });
        jQuery.uniform.update(set);
    });

    jQuery('#sample_1_wrapper .dataTables_filter input').addClass("input-medium"); // modify table search input
    jQuery('#sample_1_wrapper .dataTables_length select').addClass("input-mini"); // modify table per page dropdown

    // begin second table
    $('#sample_2').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ per page",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
        }]
    });

    jQuery('#sample_2 .group-checkable').change(function () {
        var set = jQuery(this).attr("data-set");
        var checked = jQuery(this).is(":checked");
        jQuery(set).each(function () {
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });
        jQuery.uniform.update(set);
    });

    jQuery('#sample_2_wrapper .dataTables_filter input').addClass("input-small"); // modify table search input
    jQuery('#sample_2_wrapper .dataTables_length select').addClass("input-mini"); // modify table per page dropdown

    // begin: third table
    $('#sample_3').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_ per page",
            "oPaginate": {
                "sPrevious": "Prev",
                "sNext": "Next"
            }
        },
        "aoColumnDefs": [{
            'bSortable': false,
            'aTargets': [0]
        }]
    });

    jQuery('#sample_3 .group-checkable').change(function () {
        var set = jQuery(this).attr("data-set");
        var checked = jQuery(this).is(":checked");
        jQuery(set).each(function () {
            if (checked) {
                $(this).attr("checked", true);
            } else {
                $(this).attr("checked", false);
            }
        });
        jQuery.uniform.update(set);
    });

    jQuery('#sample_3_wrapper .dataTables_filter input').addClass("input-small"); // modify table search input
    jQuery('#sample_3_wrapper .dataTables_length select').addClass("input-mini"); // modify table per page dropdown



}();