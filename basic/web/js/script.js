var $form = $('#form-generate-link');
$form.on('beforeSubmit', function() {
    var data = $form.serialize();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        dataType: 'json',
        success: function (data) {
            console.log(data)
            // Implement successful
        },
        error: function(jqXHR, errMsg) {
            console.log(data)
            console.log(errMsg);
        }
    });
    return false; // prevent default submit
});