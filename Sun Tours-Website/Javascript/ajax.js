
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
                url: 'php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                alert(response + " U wordt nu herleid naar de activatie pagina.");
                window.location = "activatie.html";
            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
        }
    })

    $("#codeVerify").validate({
        rules:
        {
            activateCode: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages:
        {
            activateCode: "please enter code",
            email: "please enter a valid email address",

        },

        submitHandler: function () {

            var form = $("#codeVerify");
            var sData = form.serialize();

            $.ajax({
                url: 'php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                alert(response + " U wordt nu herleid naar de homepagina.");
                window.location = "index.html";
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
                url: 'php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                alert(response);
            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
        }
    })

    $("#bookingForm").validate({
        rules:
        {
            reistijden: {
                required: true,
            },
            AantalVolwassenen: {
                required: true,
            },
            AantalKinderen: {
                required: true,
            },
            vervoer: {
                required: true,
            },
            autoverhuur: {
                required: true,
            },
        },
        messages:
        {
            reistijden: {
                required: "<span class='test'>Vul dit in a.u.b</span>",
            },
            AantalVolwassenen: {
                required: "<span class='test'>Vul dit in a.u.b</span>",
            },
            AantalKinderen: {
                required: "<span class='test'>Vul dit in a.u.b</span>",
            },
            vervoer: {
                required: "<span class='test'>Vul dit in a.u.b</span>",
            },
            autoverhuur: {
                required: "<span class='test'>Vul dit in a.u.b</span>",
            },
        },

        submitHandler: function () {

            var form = $('#bookingForm');
            var sData = form.serialize();
            console.log(sData);

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
    })

    $("#logoutForm").validate({
        rules:
        {
            logout: {
                required: true,
            },
        },
        messages:
        {
            logout: {
                required: "true",
            },
        },

        submitHandler: function () {

            var form = $('#logoutForm');
            var sData = form.serialize();
            console.log(sData);

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
    })

    $("#reviewForm").validate({
        rules:
        {
            holidays: {
                required: true,
            },
            Waardering: {
                required: true,
            },
            titel: {
                required: true,
            },
            review: {
                required: true,
            },
            keuze: {
                required: true,
            },
        },
        messages:
        {
            holidays: "Gekozen vakantie is vereist",
            Waardering:"Waardering is vereist",
            titel: "Een onderwerp is vereist",
            review: "Review is vereist",
            keuze: "Keuze is vereist"
        },

        submitHandler: function () {
            var form = $('#reviewForm');
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
    });
});