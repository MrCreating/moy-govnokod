$(document).ready(function () {
    M.AutoInit();

    $('#changePassword').on('submit', function () {
        const changeButton = $(this).find('button');
        const oldPassword = $(this).find('#old_password');
        const newPassword = $(this).find('#password');
        const repeatPassword = $(this).find('#repeat_password');

        if (newPassword.val() !== repeatPassword.val()) {
            toggleBtn(changeButton, false);
            M.toast({html: 'Пароли не совпадают'});
            return false;
        }

        toggleBtn(changeButton, true);
        $.post({
            url: $(this).attr('action'),
            contentType: 'application/json',
            data: $(this).serialize(),
            success: function (response) {
                if (response.error) {
                    M.toast({html: response.error})
                }

                if (response.ok) {
                    M.toast({html: 'Пароль обновлён.'});
                }

                toggleBtn(changeButton, false);
            },
            error: function (err) {
                toggleBtn(changeButton, false);
            },
            xhrFields: {
                withCredentials: true
            }
        });
        return false;
    })
})

function toggleBtn (jQueryButton, state = true) {
    if (state) {
        jQueryButton.addClass('disabled');
        jQueryButton.html('Loading...');
    } else {
        jQueryButton.removeClass('disabled');
        jQueryButton.html('Change password');
    }
}
