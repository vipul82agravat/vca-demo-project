
          $( document ).ready(function() {

              $('#email').focusout(function(){
                  var email = $(this).val();

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
                      }else{
                          $('#email').css('border-color', 'green');
                          $('#emailcheck').hide();
                          checkEmail(email);
                      }
                  }
              });


            //call when  sumbit button is click
                $('#password').keyup(function(){
                 var password = $(this).val();
                 $('#pswd_info').show();

                 if (password.length < 8 ) {

                 $('#length').removeClass('valid').addClass('invalid');
                 }else {
                     $('#length').removeClass('invalid').addClass('valid');
                 }
                 if (password.match(/[0-9]/) ) {
                 $('#number').removeClass('invalid').addClass('valid');
                 }else {
                   $('#number').removeClass('valid').addClass('invalid');
                 }
                 if (password.match(/[a-z]/) ) {
                 $('#letter').removeClass('invalid').addClass('valid');
                 }else {
                   $('#letter').removeClass('valid').addClass('invalid');
                 }
                 if (password.match(/[A-Z]/) ) {
                 $('#capital').removeClass('invalid').addClass('valid');
                 }else {
                   $('#capital').removeClass('valid').addClass('invalid');
                 }
            });

          });

          function checkEmail(email){
                $.ajax({
                  method:"POST",
                  url: "http://vca.demoproject.aum/Controller/UserRegisterController.php",
                  data:{emailId:email, type:'emailcheck'},
                  success: function(data){

                      if(data=="1"){
                          $('#emailcheck').html('Email is  Already Exists');
                          $('#emailcheck').show();
                          $(':input[type="submit"]').prop('disabled', true);
                      }else{
                          $(':input[type="submit"]').prop('disabled', false);

                      }

                  }
              });
          }
         function Validation(){

             stat=1;
             var name=$('#name').val();
             var email=$('#email').val();
             var password=$('#password').val();
             var c_password=$('#c_password').val();

             $('#usercheck').hide();
             $('#emailcheck').hide();
             $('#passwordcheck').hide();

             $('#name').css('border-color', 'green');
             $('#email').css('border-color', 'green');
             $('#password').css('border-color', 'green');
             $('#c_password').css('border-color', 'green');

             if(name==""){
                $('#name').css('border-color', 'red');
                 $("#usercheck").html("***Username is missing");
                 $('#usercheck').show();
                 stat=0;

             }
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
             if(password.length==0){
                 $('#password').css('border-color', 'red');
                 $("#passwordcheck").html("***Password is missing");
                 $('#passwordcheck').show();
                 stat=0;
             }else{
                 if(password.length < 8){
                     stat=0;
                     $("#passwordcheck").html("***Password length must be grater then 8 characters");
                     $('#passwordcheck').show();
                 }
             }
             if(c_password.length==0){
                $('#c_password').css('border-color', 'red');
                 $("#cpasswordcheck").html("***Confrm Password is missing");
                 $('#cpasswordcheck').show();
                  stat=0;
             }
             if(password.length!=0 && c_password.length!=0 && c_password!=password){
                     $("#passwordcheck").html("***Password and confirm Password must be same!");
                     $('#passwordcheck').show();
                     $('#cpasswordcheck').hide();
                     stat=0;
             }

             if(stat==0){
                 console.log('aaa'+stat);
                 return false;
             }
             $('#name').keyup(function(){
             alert('dd');
             });

         }
