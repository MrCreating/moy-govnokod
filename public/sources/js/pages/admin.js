$(document).ready(function () {
    M.AutoInit();

    $('#saveProjectSettings').on('submit', function () {
        const form = $(this);

        form.find('button').addClass('disabled');
        form.find('input').attr('disabled', true);

        $.post({
            url: form.attr('action'),
            data: {
                min_password_length: form.find('#min_password_length').val()
            },
            contentType: 'application/json',
            xhrFields: {
                withCredentials: true
            },
            success: function (response) {
                form.find('button').removeClass('disabled');
                form.find('input').removeAttr('disabled');

                if (response.error) {
                    return M.toast({html: response.error});
                }

                if (response.ok) {
                    return M.toast({html: 'Настройки проекта обновлены'});
                }

                return M.toast({html: 'При обновлении настроек произошла ошибка'});
            },
            error: function () {
                M.toast({html: 'Form sending error'});
                form.find('button').removeClass('disabled');
                form.find('input').removeAttr('disabled');
            }
        });

        return false;
    });
});
