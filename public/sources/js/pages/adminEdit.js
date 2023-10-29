function getRandomInt(min, max) {
    return min + Math.floor(Math.random() * (max - min + 1));
}

let deleteUser = false;

$(document).ready(function () {
    M.AutoInit();

    $('#deleteUser').on('click', function () {
        const form = $('#updateUserInfo');
        const requestConfirmationResult = confirm('Вы действительно хотите удалить пользователя? Это невозможно отменить!');

        if (requestConfirmationResult) {
            deleteUser = true;
            let verificationCode = getRandomInt(111111, 999999);

            let userInput = prompt('Введите проверочный код ' + verificationCode);
            if (Number(userInput) === verificationCode) {
                form.find('button').addClass('disabled');
                form.find('input').attr('disabled', true);

                $.post({
                    url: form.attr('action'),
                    contentType: 'application/json',
                    xhrFields: {
                        withCredentials: true
                    },
                    data: {
                        user_delete: true
                    },
                    success: function (response) {
                        if (response.ok) {
                            setTimeout(function () {
                                return window.location.href = '/admin';
                            }, 2000);
                            return M.toast({html: 'Пользователь удален'});
                        }

                        form.find('button').removeClass('disabled');
                        form.find('input').removeAttr('disabled');
                        if (response.error) {
                            return M.toast({html: response.error});
                        }
                        return M.toast({html: 'Пользователь не удален!'});
                    },
                    error: function () {
                        form.find('button').removeClass('disabled');
                        form.find('input').removeAttr('disabled');
                        M.toast({htnl: 'При обновлении данных произошла ошибка запроса'});
                        deleteUser = false;
                    }
                })
            } else {
                deleteUser = false;
                return M.toast({html: 'Не совпадает проверочный код. Отменяем удаление.'})
            }
        }

        return false;
    });
    $('#updateUserInfo').on('submit', function () {
        if (deleteUser) {
            return false;
        }
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
