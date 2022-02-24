<script>





    function showeReportform(){
        $('#report-form').show();
    }


    $("#search").keyup(function(event) {
        key_input = $(this).val();
        var li='';


        if(key_input.length > 0){
           if(key_input[0]=='#'){
              // TODO: request to tag

               var xmlhttp = new XMLHttpRequest();
               xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {

                       const suggests = JSON.parse(this.responseText);

                       if(suggests != null){
                           for (var i = 0; i < suggests.length && i<8; i++) {
                               li=li+'<li><a href="courses.php?tag='+suggests[i][0] +'">#'+ suggests[i][2] +'</a></li> <hr>';
                           }
                           document.getElementById("suggest").innerHTML = li;
                       }else{
                           document.getElementById("suggest").innerHTML = "";
                       }

                   }
               };
               xmlhttp.open("GET", "get_resources.php?tag=" + key_input.substr( 1,key_input.length - 1), true);
               xmlhttp.send();


               $('#suggest-div').show();
               $i=0;
           }else {
               var xmlhttp = new XMLHttpRequest();
               xmlhttp.onreadystatechange = function() {
                   if (this.readyState == 4 && this.status == 200) {

                       const suggests = JSON.parse(this.responseText);

                       if(suggests != null){
                           for (var i = 0; i < suggests.length && i<8; i++) {
                               li=li+'<li><a href="course_details.php?resource='+suggests[i][0] +'">'+ suggests[i][1] +'</a></li> <hr>';
                           }
                           document.getElementById("suggest").innerHTML = li;
                       }else{
                           document.getElementById("suggest").innerHTML = "";
                       }

                   }
               };
               xmlhttp.open("GET", "get_resources.php?q=" + key_input, true);
               xmlhttp.send();


               $('#suggest-div').show();
               $i=0;
           }





        }else{
            $('#suggest-div').hide();
        }


    });

    </script>
