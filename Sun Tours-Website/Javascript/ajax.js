
document.addEventListener("DOMContentLoaded", function(){
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

        submitHandler: function () {

            var form = $("#registreerpage");
            var sData = form.serialize();

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

            var form = $('#loginPage');
            var sData = form.serialize();

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
            
    $("#contact").validate({
        rules:
        {
            contact_naam: {
                required: true,
            },
            contact_email: {
                required: true,
            },
            contact_onderwerp: {
                required: true,
            },
            contact_text: {
                required: true,
            },
        },
        messages:
        {
            contact_naam: "Uw naam is vereist",
            contact_email:"Uw email is vereist",
            contact_onderwerp: "Een onderwerp is vereist",
            contact_text: "Input is vereist"
        },

        submitHandler: function () {

            var form = $('#contact');
            var sData = form.serialize();

            $.ajax({
                url: 'php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                alert(response);
            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
        }
    });
});