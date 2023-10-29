$(document).ready(function () {
    M.AutoInit();

    $('#updateUserInfo').on('submit', function () {
        const form = $(this);

        if (form.find('#new_password').val() !== form.find('#repeat_password').val()) {
            M.toast({html: 'Пароли не совпадают'});
            return false;
        }

        form.find('button').addClass('disabled');
        form.find('input').attr('disabled', true);

        $.post({
            url: form.attr('action'),
            data: {
                user_role: form.find('#user_role').val(),
                min_password_length: form.find('#min_password_length').val(),
                new_password: form.find('#new_password').val()
            },
            contentType: 'application/json',
            success: function (response) {
                form.find('button').removeClass('disabled');
                form.find('input').removeAttr('disabled');

                if (response.error) {
                    return M.toast({html: response.error});
                }

                if (response.ok) {
                    return M.toast({html: 'Данные пользователя обновлены'});
                }

                return M.toast({html: 'При обновлении данных пользователя произошла ошибка'});
            },
            error: function () {
                form.find('button').removeClass('disabled');
                form.find('input').removeAttr('disabled');
                M.toast({htnl: 'При обновлении данных произошла ошибка запроса'});
            }
        });

        return false;
    });
});
