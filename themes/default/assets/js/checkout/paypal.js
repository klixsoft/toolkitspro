$(function () {
    function processPaypalPayment(data) {
        return new Promise(function (resolve, reject) {
            let formobj = {};
            $(document).find("form.checkout").serializeArray().map((item) => {
                formobj[item.name] = item.value;
            });

            return $.ajax({
                type: "POST",
                url: allsmarttools.ajaxurl,
                data: {
                    action: "update_paypal_payments",
                    order: data,
                    form: formobj
                },
                dataType: "json",
                success: function (response) {
                    if( response.success ){
                        window.location.href = response.url;
                    }else{
                        alertMessage("error", response.message);
                    }
                    resolve(response);
                },
                error: function (xhr, status, error) {
                    alertMessage("error", "Unable to proceed to payment!!!");
                    reject(error);
                }
            });
        });
    }

    function renderPaypalBtn() {
        if ($(document).find("#paypal-button-container").length > 0) {
            paypal.Buttons({
                style: {
                    layout: 'vertical',
                    shape: 'rect',
                    color: 'gold'
                },
                createSubscription: (data, actions) => {
                    return actions.subscription.create({
                        plan_id: $(document).find("#paypalPlanID").val()
                    });
                },
                onError: function (err) {
                    alertMessage("error", "An error occurred during payment processing. Please try again later.");
                },
                onApprove: async (data, actions) => {
                    return processPaypalPayment(data);
                },
            }).render("#paypal-button-container");
        }
    };

    $(document).on("setup_payment_options", function () {
        renderPaypalBtn();
    });

    renderPaypalBtn();
});