var $form = $('#form-generate-link');
$form.on('beforeSubmit', function() {

    $('.ajax-result').removeClass('d-flex');
    $('.alert').removeClass('show');

    var data = $form.serialize();
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: data,
        dataType: 'json',
        success: function (data) {
            $('.ajax-result').addClass('d-flex');
            $('.ajax-result .link').text(data.result.short_link)
            $('.ajax-result img').attr('src', data.result.qr_code_path)
        },
        error: function(requestXHR, textStatus, error) {
            console.log(requestXHR, error);
            let json = requestXHR.responseJSON
            if (json){
                $('.alert').text(json.errors.url[0]);
                $('.alert').addClass('show');
            }
        }
    });
    return false; // prevent default submit
});