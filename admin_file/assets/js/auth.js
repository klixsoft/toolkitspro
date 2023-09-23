$(document).ready(function(){

    const CUSTOM_ERRROR_MESSAGE = {
        login : 'Unable to login. Please try again later',
        register : 'Unable to register. Please try again later',
        resetpassword : 'Unable to send reset password. Please try again later',
        setpassword : 'Unable to reset password. Please try again later',
        verifyemail : 'Unable to verify your email. Please try again later'
    };

    init({
        fade_in: 500,
        fade_out: 500,
        position: 'top-right'
    });
    
    window.alertMessage = (type, message, title = "Alert", timeout = 4000) => {
        toast({
            title: title,
            description: message,
            type: type,
            timeout: timeout,
            title: title
        });
    }

    $(document).on("submit", ".ast_login_form", function(e){
        const form = $(this);
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: allsmarttools.ajaxurl,
            data: form.serializeArray(),
            dataType: "json",
            beforeSend : function(){
                form.find(".loginbtn").attr("disabled", true).html("Login . . .");
            },
            error : function( error ){
                alertMessage("error", CUSTOM_ERRROR_MESSAGE[form.find(".loginbtn").attr("data-type")]);
                form.find(".loginbtn").attr("disabled", false).html("Sign In");
            },
            success : function( response ){
                if( response.success ){
                    alertMessage("success", response.message);
                    if( response.url ){
                        setTimeout(() => {
                            window.location.href = response.url;
                        }, parseInt(response?.timeout || 1000));
                    }
                }else{
                    alertMessage("error", response.message);
                    form.find(".loginbtn").attr("disabled", false).html("Sign In");
                }
            }
        });
    });
});