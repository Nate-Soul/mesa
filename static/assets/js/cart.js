$(function(){


    $("#addToCartBtn").on("click", function(){
        var product     = $(this);
        var product_id  = parseInt(product.data("index"));
        var product_qty = $("#selectQty option:selected").val();
        addItemsToCart(product_id, product_qty);
    });



    if($(".add-to-cart-btn").length > 0){
        $(".add-to-cart-btn").each(function(){
            $(this).on("click", function(){
                var product     = $(this);
                var product_id  = parseInt(product.data("index"));
                var product_qty = 1;
                addItemsToCart(product_id, product_qty);
            });
        });
    }


    function addItemsToCart(id, qty){
        var product_id  = parseInt(id);
        var product_qty = parseInt(qty);
        $.ajax({
            type: "POST",
            url: "http://127.0.0.1/mesa/modules/cart.php",
            data: {
                id: product_id,
                qty: product_qty,
                action: "add"
            },
            cache: false,
            success: function(data){
                data = JSON.parse(data);
                if(data.error_2){
                    alert(data.error_2);
                } else if(data.error_1){
                    alert(data.error_1);
                } else if(data.items){
                    $("#cartItems span").text(data.items);
                    alert("Items added to cart");
                }
            },
            error: function(xhr, msg, error){
                alert(xhr + ": " + msg + ": " + error);
            }
        });
    }

    if($(".delete-from-cart-btn").length > 0){
        $(".delete-from-cart-btn").each(function(){
            $(this).on("click", function(){
                var product    = $(this);
                var product_id = parseInt(product.data("index"));
                deleteItemsFromCart(product_id);
            });
        });
    }
    
    function deleteItemsFromCart(id){
        product_id = parseInt(id);
        $.ajax({
            type: "POST",
            url: "http://127.0.0.1/mesa/modules/cart.php",
            data: {
                id: product_id,
                action: "remove"
            },
            cache: false,
            success: function(data){
                data = JSON.parse(data);
                if(data.error_1){
                    alert(data.error_1);
                } else if(data.error_2){
                    alert(data.error_2);
                } else {
                    $("#cartRow"+product_id).remove();
                    $("#cartItems span").text(data.items);
                    $("#subTotal span").text(parseFloat(data.subtotal).toFixed(2));
                    alert("Item removed from cart");
                }
            },
            error: function(xhr, msg, error){
                alert(xhr + ": " + msg + ": " + error);
            }
        });
    }

});