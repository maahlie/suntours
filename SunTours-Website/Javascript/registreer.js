// function rodeOutline()
// {
//     // let regVelden = ['email', 'phonenum', 'Vnaam', 'Anaam', 'usern', 'passwd2', 'passwd3'];
//     // // regVelden[0] = document.getElementById('email');
//     // // regVelden[1] = document.getElementById('phonenum');
//     // // regVelden[2] = document.getElementById('Vnaam');
//     // // regVelden[3] = document.getElementById('Anaam');
//     // // regVelden[4] = document.getElementById('usern');
//     // // regVelden[5] = document.getElementById('passwd2');
//     // // regVelden[6] = document.getElementById('passwd3');

//     for(i = 0; i < regVelden.length; i++){
//         // var n=document.getElementById(i).value;
//         // if (n.length < 1)
//         // {
//         //     window.alert("Field is blank");
//         //     document.getElementById(i).style.border = "2px solid red";
//         // }
        
//     if ($(i).val() == '') {
//         $(i).css('border-color', 'red');
//     }
//     else {
//         $(i).css('border-color', '');
//     }
//     }

        // function checkForm(form)
        // {
        //   if(form.usern.value == "") {
        //     alert("Error: Username cannot be blank!");
        //     form.usern.focus();
        //     return false;
        //   }
        //   re = /^\w+$/;
        //   if(!re.test(form.usern.value)) {
        //     alert("Error: Username must contain only letters, numbers and underscores!");
        //     form.usern.focus();
        //     return false;
        //   }
      
        //   if(form.passwd2.value != "" && form.passwd2.value == form.pwd2.value) {
        //     if(form.passwd2.value.length < 6) {
        //       alert("Error: Password must contain at least six characters!");
        //       form.passwd2.focus();
        //       return false;
        //     }
        //     if(form.passwd2.value == form.usern.value) {
        //       alert("Error: Password must be different from Username!");
        //       form.passwd2.focus();
        //       return false;
        //     }
        //     re = /[0-9]/;
        //     if(!re.test(form.passwd2.value)) {
        //       alert("Error: password must contain at least one number (0-9)!");
        //       form.passwd2.focus();
        //       return false;
        //     }
        //     re = /[a-z]/;
        //     if(!re.test(form.passwd2.value)) {
        //       alert("Error: password must contain at least one lowercase letter (a-z)!");
        //       form.passwd2.focus();
        //       return false;
        //     }
        //     re = /[A-Z]/;
        //     if(!re.test(form.passwd2.value)) {
        //       alert("Error: password must contain at least one uppercase letter (A-Z)!");
        //       form.passwd2.focus();
        //       return false;
        //     }
        //   } else {
        //     alert("Error: Please check that you've entered and confirmed your password!");
        //     form.passwd2.focus();
        //     return false;
        //   }
      
        //   alert("You entered a valid password: " + form.passwd2.value);
        //   return true;
        // }
    