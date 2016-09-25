function preventOnClick()
{
    event.stopPropagation();
}
function enableDatepicker(id)
{
    if ($(id).val() == '0000-00-00') {
        $(id).val("");
    }

    $.fn.datepicker.defaults.format = "yyyy-mm-dd";
    $(id).datepicker({format: "yyyy-mm-dd"});
}

var ajaxCall = function() {
    var tableRow = $(this).closest('tr');
    var tableRowData = tableRow.data();

    if (tableRowData === undefined) {
        tableRowData =  $(this).data();
    }

    //do a ajax call.
    var request = $.ajax({
        method: "POST",
        url: $(this).data('action'),
        data: tableRowData,
        timeout: 3000,
        dataType: 'json',
        encode: true
    });

    //the successfull request.
    request.done(function(msg) {
        if (msg.state == 'info') {
            if (msg.hasOwnProperty('redirect')) {

                var doReload = false;

                console.log(msg.redirect + '|vs.|' + $(location).attr('protocol') + '//' + $(location).attr('host') + $(location).attr('pathname'));
                if (msg.redirect == $(location).attr('protocol') + '//' + $(location).attr('host') + $(location).attr('pathname')) {
                    doReload = true;
                }

                if (msg.hasOwnProperty('tab_selected')) {
                    $(location).attr('href', msg.redirect + '#' + msg.tab_selected);
                } else {
                    $(location).attr('href', msg.redirect);
                }

                if (doReload == true) {
                    location.reload();
                }
            }
        } else {
            selFormAlert.addClass('alert-danger').html(msg.message);
            selFormAlert.show();
            console.log(msg.message);

            if (msg.hasOwnProperty('field')) {
                $("input[name='" + msg.field + "']").focus();
            }
        }
    });

    //the failure request.
    request.fail(function(e) {
        selFormAlert.addClass('alert-danger').html('Something went wrong. Try again later!');
        selFormAlert.show();
        console.log(e)
    });
};


$(document).ready(function() {

    //define the form types.
    var form_table_row = $('tr.ajax');
    var form_link = $('a.ajax');
    var form_real = $('form.ajax');
    var alert = $('div.alert');

    var selFormAlert = form_real.find('.alert');
    selFormAlert.hide();

    //table row click events.
    form_table_row.on('click', 'a.btn-danger', ajaxCall);
    form_link.on('click', ajaxCall);

    //the submit.
    form_real.on('submit', function(e) {
        e.preventDefault();

        //the ajax call.
        $.ajax({
            method: "POST",
            url: form_real.attr('data-action'),
            data: form_real.serialize(),
            timeout: 3000,
            dataType: 'json',
            encode: true
        }).done(function(msg) {
            if (msg.state == 'info') {
                $(location).attr('href', msg.redirect + '#' + msg.tab_selected);
            } else {
                selFormAlert.addClass('alert-danger').html(msg.message);
                selFormAlert.show();
                $("input[name='" + msg.field + "']").focus();
            }
        }).fail(function() {
            selFormAlert.addClass('alert-danger').html('Something went wrong. Try again later!');
            selFormAlert.show();
        });
    });

    //redirect to the tab.
    var url = document.location.toString();

    //check whether a tab is available.
    if (url.match('#')) {
        $('.nav-pills a[data-target="#' + url.split('#')[1] + '"]').tab('show');
    }
});