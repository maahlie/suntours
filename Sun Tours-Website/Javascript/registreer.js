// $("#registreerpage").submit(function(e) {

//     e.preventDefault(); // avoid to execute the actual submit of the form.

//     var form = $(this);
//     var url = form.attr('action');

//     $.ajax({
//            type: "POST",
//            url: url,
//            data: form.serialize(), // serializes the form's elements.
//             }).done(function(response) {
//                 alert(response);
//                 //$('#title').html(response);
//             }).fail(function( jqXHR, textstatus){
//                 alert(response, textstatus);
//             });
//          });


//$('#title').html('nieuwe titel');


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

        errorPlacement: function(error, element) {
            if (element.attr("name") == "passwd2") {
                // an example
                error.insertAfter($("#passwd2"));
       
            } else {
       
                // the default error placement for the rest of the elements in form
                error.insertAfter(element);
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


// function submitForm() {  
//     var data = $("#register-form").serialize();    
//     $.ajax({    
//     type : 'POST',
//     url  : 'register.php',
//     data : data,

// { action: "register", email: "email", phoneNum: "phonenumber", firstName: "firstName", surName: "surName", userName: "usern", address: "address", postalCode: "postalCode", passwd1: "passwd2", passwd2: "passwd3"}