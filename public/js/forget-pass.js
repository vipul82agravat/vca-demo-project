
        $( document ).ready(function() {
         $('#email').focusout(function(){
                 var email = $(this).val();

                 if(email==""){
                     $('#email').css('border-color', 'red');
                     $("#emailcheck").html("***Email is missing");
                     $('#emailcheck').show();
                     $(':input[type="submit"]').prop('disabled', true);
                     return false;

                 }else{
                     var regEmail=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/g;
                     if(!regEmail.test(email)){
                         $('#email').css('border-color', 'red');
                         $("#emailcheck").html("***Please enter a valid e-mail address");
                         $('#emailcheck').show();
                         $(':input[type="submit"]').prop('disabled', true);
                     }else{
                         $('#email').css('border-color', 'green');
                         $('#emailcheck').hide();
                         checkEmail(email);
                     }
                 }
         });
        });
         function checkEmail(email){
             $.ajax({
                 method:"POST",
                 url: "http://vca.demoproject.aum/Controller/UserRegisterController.php",
                 data:{emailId:email, type:'emailcheck'},
                 success: function(data){

                     if(data=="0"){
                         $('#emailcheck').html('Email is  Not Exists');
                         $('#emailcheck').show();
                         $(':input[type="submit"]').prop('disabled', true);
                     }else{
                         $(':input[type="submit"]').prop('disabled', false);

                     }

                 }
             });
         }
