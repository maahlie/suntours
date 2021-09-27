
var counter = 0;
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
                minlength: 4,
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
                minlength: "wachtwoord moet minimaal 8 karakters lang zijn."
            },
            email: "please enter a valid email address",
            passwd3: {
                required: "please retype your password",
                equalTo: "password doesn't match !"
            }
        },

        submitHandler: function () {
            //$("#registreerpage").submit(function (e) {

            //e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $("#registreerpage");
            var sData = form.serialize();
            //var url = form.attr('action');

            $.ajax({
                url: '../php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                alert(response);
            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
        }
    })


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

        submitHandler: function () {
            // $("#loginPage").submit(function (e)  {
            // alert('#loginPage');
            //e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $('#loginPage');
            var sData = form.serialize();

            // var formdata = $('#loginpage').serialize();
            // $.post('/ajaxHandler', formdata, function (response) {
            //     console.log(response)
            // });
            //var url = form.attr('action');
            // var data = new FormData();
            // data.append('usernLogin', 'usernLogin');
            // data.append('passwdLogin', 'passwdLogin');

            $.ajax({
                url: '../php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                alert(response);
            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
            //})
        }
    })
});

