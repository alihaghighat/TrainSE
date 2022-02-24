<script type="text/javascript">


function usernameValidation(el){

let username_exist = true;

var xmlhttp = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        username_exist = (this.responseText == "true");
        if(username_exist){
        $(el).removeClass('is-valid');
        $(el).addClass('is-invalid');
    }else{
        $(el).removeClass('is-invalid');
        $(el).addClass('is-valid');

    }
    }
};

xmlhttp.open("GET", "check_uniqueness.php?username=" +el.value.trim(), true);
xmlhttp.send();




}

function nameValidation(el){

if( !/^[A-Z]+$/i.test(el.value) ){
    $(el).removeClass('is-valid');
    $(el).addClass('is-invalid');
}else{
    $(el).removeClass('is-invalid');
    $(el).addClass('is-valid');

}
}

const validateEmail = (email) => {
return String(email)
.toLowerCase()
.match(
  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
);
};
function emailValidation(el){
    let email_exist;
    if( !validateEmail(el.value) ){
    $("#emailvalidationFeedbackUser").text( "<?php echo ERR_INVALID_EMAIL; ?>");
    $(el).removeClass('is-valid');
    $(el).addClass('is-invalid');
    }
    else{
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                email_exist = (this.responseText == "true");
                if( email_exist){

                    $("#emailvalidationFeedbackUser").text("<?php echo ERR_TAKEN_EMAIL; ?>");
                    $(el).removeClass('is-valid');
                    $(el).addClass('is-invalid');

                }else{
                    $(el).removeClass('is-invalid');
                    $(el).addClass('is-valid');
                }
            }
        };

        xmlhttp.open("GET", "check_uniqueness.php?email=" +el.value.trim(), true);
        xmlhttp.send();

    }
}

function CheckPassword(inputtxt)
{
var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
if(inputtxt.value.match(passw))
{
return true;
}
else
{
return false;
}
}

function passwordValidation(el){

if(!CheckPassword(el)){
    $(el).removeClass('is-valid');
    $(el).addClass('is-invalid');
    $(el).parent().removeClass('mb-4');
    $(el).parent().addClass('mb-2');
}else{
    $(el).removeClass('is-invalid');
    $(el).addClass('is-valid');
}
}

function confirmPassValidation(el){
if($('#Tpassword').val().localeCompare(String(el.value)) != 0){
    $(el).removeClass('is-valid');
    $(el).addClass('is-invalid');
}else{
    $(el).removeClass('is-invalid');
    $(el).addClass('is-valid');
}
}

function formValidate(){
var err_coutner = 0;

if($('#Tusername').hasClass("is-invalid")){
err_coutner += 1;
}

if($('#Tfirstname').hasClass("is-invalid")){
err_coutner += 1;
}

if($('#Tlastname').hasClass("is-invalid")){
err_coutner += 1;
}

if($('#Temail').hasClass("is-invalid")){
err_coutner += 1;
}

if($('#Tpassword').hasClass("is-invalid")){
err_coutner += 1;
}

if($('#Tconfirm_password').hasClass("is-invalid")){
err_coutner += 1;
}
if(err_coutner == 0)
$("#submit_form_btn").click();


}
</script>