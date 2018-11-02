jQuery(document).ready(function ($) {

    $('#form').submit(function (e) {
        e.preventDefault();
        if (document.form.email.value == '') {
            valid = false;
            alert('Поле email не должно быть пустым');
            return valid;
        }
        var name = $('#name').val();
        var email = $('#email').val();

        var data = {
            name: name,
            email: email,
            action: 'send_message'
        };

        $.post(repo.url, data, function (response) {
            $('#form').html(response.data);
            $('#form')[0].reset();
            alert('Сообщение успешно отправлено');
        });

    });
});