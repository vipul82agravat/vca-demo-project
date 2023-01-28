 function Validation(){

                     var stat=1;
                     var email=$('#email').val();
                     var password=$('#password').val();

                     $('#emailcheck').hide();
                     $('#passwordcheck').hide();
                     $('#email').css('border-color', 'green');
                     $('#password').css('border-color', 'green');

                     if(email==""){
                         $('#email').css('border-color', 'red');
                         $("#emailcheck").html("***Email is missing");
                         $('#emailcheck').show();
                         stat=0;
                     }else{
                         var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
                         if(!regEmail.test(email)){
                             $('#email').css('border-color', 'red');
                             $("#emailcheck").html("***Please enter a valid e-mail address");
                             $('#emailcheck').show();
                             stat=0;
                         }
                     }
                     if(password==""){
                         $('#password').css('border-color', 'red');
                         $("#passwordcheck").html("***Password is missing");
                         $('#passwordcheck').show();
                         stat=0;
                     }else{
                         if(password.length < 8){
                             stat=0;
                             $('#password').css('border-color', 'red');
                             $("#passwordcheck").html("***Password length must be grater then 8 characters");
                             $('#passwordcheck').show();
                         }
                     }
                     if(stat==0){
                         return false;
                     }

         }
