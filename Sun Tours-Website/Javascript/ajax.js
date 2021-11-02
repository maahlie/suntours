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
                minlength: 8,
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
            City: {
                required: true
            },
            address: {
                required: true
            },
            postalCode: {
                required: true
            }
        },
        messages:
        {
            usern: "<span class='opmaakError'>Voer a.u.b een gebruikersnaam in.</span>",
            passwd2: {
                required: "<span class='opmaakError'>Voer a.u.b een wachtwoord in.</span>",
                minlength: "<span class='opmaakError'>Wachtwoord moet minstens 8 karakters lang zijn.</span>"
            },
            email: "<span class='opmaakError'>Voer a.u.b een geldig e-mail adres in in.</span>",
            passwd3: {
                required: "<span class='opmaakError'>Voer a.u.b een controle wachtwoord in.</span>",
                equalTo: "<span class='opmaakError'>Wachtwoorden zijn niet hetzelfde.</span>"
            },
            City: {
                required: "<span class='opmaakError'>Voer a.u.b een stad in.</span>"
            },
            address:  {
                required: "<span class='opmaakError'>Voer a.u.b een adres in.</span>"
            },
            postalCode: {
                required: "<span class='opmaakError'>Voer a.u.b een postcode in.</span>"
            },
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
            if(window.location.href.indexOf('.php') > -1) 
            {
                $.ajax({
                    url: '../php/ajaxHandler.php',
                    method: "POST",
                    data: sData,
                }).done(function (response) {
                    alert(response);
                }).fail(function (jqXHR, textstatus) {
                    alert(response, textstatus);
                })
            }else{
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
    })

    $("#changePswrd").validate({
        rules:
        {
            secCode: {
                required: true,
            },
            newPswrd: {
                required: true,
                minlength: 4,
            },
            confPaswrd: {
                required: true,
                equalTo: '#newPswrd',
            },
            pswrdEmail: {
                required: true,
                email: true,
            },
        },
        messages:
        {
            secCode: "Vul a.u.b de code in.",
            newPswrd: {
                required: "please provide a password",
                minlength: "password at least have 8 characters"
            },
            confPaswrd: {
                required: "please retype your password",
                equalTo: "password doesn't match !"
            },
            pswrdEmail: "please enter a valid email address",

        },

        submitHandler: function () {

            var form = $("#changePswrd");
            var sData = form.serialize();

            $.ajax({
                url: 'php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                alert(response);
                console.log('te');
            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
        }
    })

    $("#pswrdSendCode").validate({
        rules:
        {
            codeEmail: {
                required: true,
                email: true,
            },
        },
        messages:
        {
            codeEmail: "please enter a valid email address",

        },

        submitHandler: function () {

            var form = $("#pswrdSendCode");
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

    $("#delAcc").validate({
        rules:
        {
            delAcc: {
                required: true,
            },
        },
        messages:
        {
            delAcc: {
                required: "true",
            },
        },

        submitHandler: function () {

            var form = $('#delAcc');
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

    $("#annuleerForm").validate({
        rules:
        {
            annuleer: {
                required: true,
            },
        },
        messages:
        {
            annuleer: {
                required: "true",
            },
        },

        submitHandler: function () {

            var form = $('#annuleerForm');
            var sData = form.serialize();
            console.log(sData);
            
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
});