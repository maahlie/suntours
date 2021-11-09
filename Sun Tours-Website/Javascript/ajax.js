document.addEventListener("DOMContentLoaded", function () {

    //valideert elke input van een form aan de hand van het form id, in dit geval #registreerpage. als iets niet voldoet aan de eisen gaat hij niet naar de submithandler
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
            },
            firstName:{
                required: true
            },
            surName:{
                required: true
            },
            phonenumber:{
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
            firstName:{
                required: "<span class='opmaakError'>Vul a.u.b uw voornaam in.</span>"
            },
            surName:{
                required: "<span class='opmaakError'>Vul a.u.b uw achternaam in.</span>"
            },
            phonenumber:{
                required: "<span class='opmaakError'>Vul a.u.b uw telefoon nummer in. in</span>"
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
                if (response == "Email bestaat al!" || response == "Username bestaat al!") {
                    alert(response);
                } else {
                    alert(response + " U wordt nu herleid naar de activatie pagina.");
                    window.location = "activatie.html";                }

            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
        }
    })

    //wachtwoord verificatie voor account activatie, zelfde idee als bij de vorige. Dit hebben we gedaan voor elke form op de website.
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
            activateCode: "<span class='opmaakError'>please enter code</span>",
            email: "<span class='opmaakError'>please enter a valid email address</span>",

        },

        submitHandler: function () {

            var form = $("#codeVerify");
            var sData = form.serialize();

            $.ajax({
                url: 'php/ajaxHandler.php',
                method: "POST",
                data: sData,
            }).done(function (response) {
                console.log(response);
                //dit zorgt ervoor dat je niet herleid word na een mislukte verificatie.
                if (response != "\r\nDe code of email adres was onjuist.") {
                    alert(response + " U wordt nu herleid naar de homepagina.");
                    window.location = "index.html";
                } else {
                    alert(response);
                }

            }).fail(function (jqXHR, textstatus) {
                alert(response, textstatus);
            })
        }
    })

    //login pagina
    $("#loginPage").validate({
        rules:
        {
            usernLogin: {
                required: true,
            },
            passwdLogin: {
                required: true,
            },
        },
        messages:
        {
            usernLogin: "<span class='opmaakError'>Voer een username in a.u.b.</span>",
            passwdLogin: {
                required: "<span class='opmaakError'>Voer een wachtwoord in a.u.b.</span>",
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

    //boekings form
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
                required: "<span class='opmaakError'>Vul de reistijden in a.u.b</span>",
            },
            AantalVolwassenen: {
                required: "<span class='opmaakError'>Vul het aantal volwassenen in a.u.b</span>",
            },
            AantalKinderen: {
                required: "<span class='opmaakError'>Vul het aantal kinderen in a.u.b</span>",
            },
            vervoer: {
                required: "<span class='opmaakError'>Maak uw keuze voor vervoer a.u.b</span>",
            },
            autoverhuur: {
                required: "<span class='opmaakError'>selecteer uw voorkeur voor autoverhuur a.u.b</span>",
            },
        },

        submitHandler: function () {

            var form = $('#bookingForm');
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

    //log uit form
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
            if (window.location.href.indexOf('.php') > -1) {
                $.ajax({
                    url: '../php/ajaxHandler.php',
                    method: "POST",
                    data: sData,
                }).done(function (response) {
                    alert(response);
                }).fail(function (jqXHR, textstatus) {
                    alert(response, textstatus);
                })
            } else {
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

    //contact form
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
            contact_naam: "<span class='opmaakError'>Uw naam is vereist</span>",
            contact_email: "<span class='opmaakError'>Uw email is vereist</span>",
            contact_onderwerp: "<span class='opmaakError'>Een onderwerp is vereist</span>",
            contact_text: "<span class='opmaakError'>Input is vereist</span>"
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

    //review form
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
            holidays: "<span class='opmaakError'>Gekozen vakantie is vereist</span>",
            Waardering: "<span class='opmaakError'>Waardering is vereist</span>",
            titel: "<span class='opmaakError'>Een onderwerp is vereist</span>",
            review: "<span class='opmaakError'>Review is vereist</span>",
            keuze: "<span class='opmaakError'>Keuze is vereist</span>"
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

    //form voor wachtwoord veranderen.
    $("#changePswrd").validate({
        rules:
        {
            secCode: {
                required: true,
            },
            newPswrd: {
                required: true,
                minlength: 8,
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
            secCode: "<span class='opmaakError'>Vul a.u.b de code in.</span>",
            newPswrd: {
                required: "<span class='opmaakError'>Vul a.u.b. een wachtwoord in</span>",
                minlength: "<span class='opmaakError'>Het wachtwoord moet minimaal uit 8 karakters bestaan.</span>"
            },
            confPaswrd: {
                required: "<span class='opmaakError'>Herhaal uw wachtwoord.</span>",
                equalTo: "<span class='opmaakError'>Wachtwoord komt niet overeen.</span>"
            },
            pswrdEmail: "<span class='opmaakError'>Vul een geldig email adres in.</span>",

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

    //form voor het sturen van een code.
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
            codeEmail: "<span class='opmaakError'>Vul een geldig email adres in.</span>",

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

    //account verwijderen
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

    //annuleren (boekingGeschiedenis)
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