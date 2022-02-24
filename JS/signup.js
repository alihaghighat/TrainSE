function usernameValidation(el){

    res = <?php echo json_encode(select(QUERY_ALL_USERNAMES, "", [])); ?>;
    var usernames = [];

    for(var i in res)
        usernames.push(res[i][0]);



    if(usernames.includes(el.value)){
        $(el).removeClass('is-valid');
        $(el).addClass('is-invalid');
    }else{
        $(el).removeClass('is-invalid');
        $(el).addClass('is-valid');

    }

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
    res = <?php echo json_encode(select(QUERY_ALL_EMAILS, "", [])); ?>;
    var emails = [];

    for(var i in res)
        emails.push(res[i][0]);
        if( !validateEmail(el.value) ){
        $("#emailvalidationFeedbackUser").text( "<?php echo ERR_INVALID_EMAIL; ?>");
        $(el).removeClass('is-valid');
        $(el).addClass('is-invalid');
    }

    else if(emails.includes(el.value)){

        $("#emailvalidationFeedbackUser").text("<?php echo ERR_TAKEN_EMAIL; ?>");
        $(el).removeClass('is-valid');
        $(el).addClass('is-invalid');

    }else{
        $(el).removeClass('is-invalid');
        $(el).addClass('is-valid');
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