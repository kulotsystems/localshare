$(function() {
    var frmUpload = $('#frmUpload');
    frmUpload.submit(function(event) {
        setTimeout(function() {
            $('#btnUpload').prop('disabled', true);
        }, 320);
    });
});