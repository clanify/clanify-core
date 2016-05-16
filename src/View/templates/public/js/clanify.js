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


$(document).ready(function() {

    var selForm = $('form.ajax');
    var selFormAlert = selForm.find('.alert');


    //hide the alert.
    selFormAlert.hide();

    //the submit.
    selForm.on('submit', function(e) {
        e.preventDefault();

        //the ajax call.
        $.ajax({
            method: "POST",
            url: selForm.attr('data-action'),
            data: selForm.serialize(),
            timeout: 3000,
            dataType: 'json',
            encode: true
        }).done(function(msg) {
            if (msg.state == 'info') {
                $(location).attr('href', msg.redirect);
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
});