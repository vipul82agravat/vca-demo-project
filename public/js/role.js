 function Validation(){

            stat=1;
            var name=$('#name').val();
            var status=$('#status').val();

            $('#name_messge').hide();
            $('#status_messge').hide();

            $('#name').css('border-color', 'green');
            $('#status').css('border-color', 'green');;


            if(name==""){
                $('#name').css('border-color', 'red');
                $("#name_messge").html("***Name is missing");
                $('#name_messge').show();
                stat=0;

            }

            if(status==""){
                $('#status').css('border-color', 'red');
                $("#status_messge").html("***Status is missing");
                $('#status_messge').show();
                stat=0;

            }

            if(stat==0){
                console.log('aaa'+stat);
                return false;
            }

        }
