$('document').ready(function () {
    $("#registreerpage").validate({
        rules:
        {
            usern: {
                required: true,
                minlength: 3
            },
            passwd2: {
                required: true,
                minlength: 1,
                maxlength: 15
            },
            passwd3: {
                required: true,
                equalTo: '#passwd2'
            },
            email: {
                required: true,
                email: true
            },
        },
        messages:
        {
            usern: "please enter username",
            passwd2: {
                required: "please provide a password",
                minlength: "password at least have 8 characters"
            },
            email: "please enter a valid email address",
            passwd3: {
                required: "please retype your password",
                equalTo: "password doesn't match !"
            }
        },

    submitHandler: function() { 
        $("#registreerpage").submit(function (e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    url: url,
                    method: "POST",
                    data: form.serialize(),
                }).done(function (response) {
                    alert(response);
                }).fail(function (jqXHR, textstatus) {
                    alert(response, textstatus);
                })
            })
        }
    })
});

$('document').ready(function () {
    $("#loginPage").validate({
        rules:
        {
            usern: {
                required: true,
            },
            passwd: {
                required: true,
            },
        },
        messages:
        {
            usern: "geef username",
            passwd: {
                required: "geef wachtwoord",
            },
        },

    submitHandler: function() { 
         $("#loginPage").submit(function (e) {

                e.preventDefault(); // avoid to execute the actual submit of the form.

                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    url: url,
                    method: "POST",
                    data: form.serialize(),
                }).done(function (response) {
                    alert(response);
                }).fail(function (jqXHR, textstatus) {
                    alert(response, textstatus);
                })
            })
        }
    })
});