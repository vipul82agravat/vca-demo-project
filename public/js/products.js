
    $(document).ready(function(){

        $('#search_pro_data').focusout(function(){
            var search_text = $(this).val();

            $.ajax({
                method:"POST",
                url: "http://vca.demoproject.aum/Controller/Products/ProductsController.php",
                data:{search_text:search_text, type:'serach'},
                success: function(data){
                    $('#search_messge').html('Serach Data');
                    $('.product_list').hide();
                    $('#hr_id').css("display","none");
                    $('.product_add').html(data);
                }
            });
        });



        $('#product_img').change(function(){
        var memberImgfl = $("#product_img");
        var lg = memberImgfl[0].files.length; // get Files length
        var memberProfiles = memberImgfl[0].files;
        var totalflsize = 0;
        var ext = $('#product_img').val().split('.').pop().toLowerCase();
        var validFileExtensions = ['jpeg', 'jpg', 'png'];
        $('#img_messge').hide();
        if ($.inArray(ext, validFileExtensions) == -1) {
            $("#img_messge").html("Ony allow this Extensions 'jpeg', 'jpg', 'png'!");
            $('#img_messge').show();
            $(':input[type="submit"]').prop('disabled', true);
        }
        if (lg > 0) {

            var picsize = (this.files[0].size);

            $(':input[type="submit"]').prop('disabled', false);
            if (picsize > 50768){
                $("#img_messge").html("Sorry!! Max allowed image size is 32 kb");
                $('#img_messge').show();
                $(':input[type="submit"]').prop('disabled', true);
            }

        }
        });
    });
        function checkLength(el) {
            if (el.value.length != 6) {
                alert("length must be exactly 6 characters")
            }
        }
        function getstate(val) {

            $.ajax({
                type: "POST",
                url: "http://vca.demoproject.aum/Controller/GetStateCityController.php",
                data:'coutry_id='+val,
                success: function(data){
                    $("#statelist").html(data);
                }
            });
        }
        function getcity(val) {

            $.ajax({
                type: "POST",
                url: "http://vca.demoproject.aum/Controller/GetStateCityController.php?type=city",
                data:'state_id='+val,
                success: function(data){
                    $("#city").html(data);
                }
            });
        }
        function Validation(){

            stat=1;
            var product_category=$('#product_category').val();
            var title=$('#title').val();
            var location=$('#location').val();
            var state=$('#statelist').val();
            var city=$('#city').val();
            var address=$('#address').val();
            var status=$('#status').val();
            var product_img=$('#product_img').val();


            $('#title_messge').hide();
            $('#location_messge').hide();
            $('#state_messge').hide();
            $('#city_messge').hide();
            $('#address_messge').hide();
            $('#status_messge').hide();

            $('#title').css('border-color', 'green');
            $('#product_category').css('border-color', 'green');
            $('#location').css('border-color', 'green');
            $('#statelist').css('border-color', 'green');;
            $('#city').css('border-color', 'green');;
            $('#addres').css('border-color', 'green');
            $('#status').css('border-color', 'green');;


            if(product_category==""){
                $('#product_category').css('border-color', 'red');
                $("#category_messge").html("***Category is missing");
                $('#category_messge').show();
                stat=0;

            }

            if(title==""){
                $('#title').css('border-color', 'red');
                $("#title_messge").html("***Title is missing");
                $('#title_messge').show();
                stat=0;

            }
            if(location==""){
                $('#location').css('border-color', 'red');
                $("#location_messge").html("***Location is missing");
                $('#location_messge').show();
                stat=0;

            }
            if(state==""){
                $('#statelist').css('border-color', 'red');
                $("#state_messge").html("***State is missing");
                $('#state_messge').show();
                stat=0;

            }
            if(city==""){
                $('#city').css('border-color', 'red');
                $("#city_messge").html("***City is missing");
                $('#city_messge').show();
                stat=0;

            }
            if(address==""){
                $('#name').css('border-color', 'red');
                $("#usercheck").html("***Address is missing");
                $('#usercheck').show();
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
            if(product_img!=""){
                console.log(product_img);
            }

        }
