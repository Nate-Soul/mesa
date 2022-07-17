$(function(){
    $("input[type=radio][name=delivery_option]").on("change", function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "http://127.0.0.1/mesa/modules/delivery.php",
            data: {
                delivery_option: parseInt($(this).val()),
                action: "post",
            },
            success: function(json){
                json = JSON.parse(json);
                $("#total").text(json.final_price.toFixed(2));
                $("#deliveryFee").text(json.delivery_fee.toFixed(2));
            },
            error: function(xhr, msg, error){
                alert(msg +': '+error);
            }
        });
    });
});