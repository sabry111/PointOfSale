$(document).ready(function () {
    // add product btn
    // $(".add-product-btn").on("click", function (e) {
    //     e.preventDefault();

    //     var name = $(this).data("name");
    //     var id = $(this).data("id");
    //     var price = $.number($(this).data("price"), 2);

    //     $(this).removeClass("btn-success").addClass("btn-default disabled");

    //     let html = `
    //                 <tr>
    //                 <td>${name}</td>
    //                 <td><input type = 'number'  name= 'product_ids[${id}][quantity]' data-price='${price}' class='form-control product-quantity' min='1' value='1'></td>
    //                 <td class='product-price'>${price}</td>
    //                 <td> <button class='btn btn-danger remove-product-btn' data-id='${id}'><i class='fa fa-trash'></i></button></td>
    //                 </tr>`;

    //     $(".order-list").append(html);
    //     calculateTotal();
    // }); // end of add product btn

    $("body").on("click", ".disabled", function (e) {
        e.preventDefault();
    });
    // remove product btn
    $("body").on("click", ".remove-product-btn", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        $(this).closest("tr").remove();
        $("#product-" + id)
            .removeClass("btn-default disabled")
            .addClass("btn-success add-product-btn");
        calculateTotal();
    }); //end of remove btn

    // change product quantity
    $("body").on("keyup change", ".product-quantity", function () {
        var quantity = Number($(this).val());
        var unitPrice = parseFloat(
            $.number($(this).data("price"), 2).replace(/,/g, "")
        );
        $(this)
            .closest("tr")
            .find(".product-price")
            .html($.number(quantity * unitPrice, 2));
        calculateTotal();
    }); //end of change product quantity

    // show order products
    $(".order-products").on("click", function (e) {
        e.preventDefault();
        $("#loading").css("display", "flex");
        var url = $(this).data("url");
        var method = $(this).data("method");

        $.ajax({
            url: url,
            method: method,

            success: function (data) {
                $("#loading").css("display", "none");
                $("#order-product-list").empty();
                $("#order-product-list").append(data);
            },
        });
    }); //end of show order

    $(document).on("click", ".print-btn", function () {
        $("#print-area").printThis();
    });
}); // end of document ready

// calculate total function
function calculateTotal() {
    var price = 0;
    $(".order-list .product-price").each(function (index) {
        price += parseFloat($(this).html().replace(/,/g, ""));
    }); //end of product price

    $(".total-price").html($.number(price, 2));

    // check if price > 0
    if (price > 0) {
        $("#add-order-form-btn").removeClass("disabled");
    } else {
        $("#add-order-form-btn").addClass("disabled");
    } //end of else

    if (price > 0) {
        $("#edit-order-form-btn").removeClass("disabled");
    } else {
        $("#edit-order-form-btn").addClass("disabled");
    } //end of else
} //end of calculateTotal

function addProduct(id, name, price) {
    $("#product-" + id)
        .removeClass("btn-success")
        .addClass("btn-default disabled");

    let html = `
                <tr>
                <td>${name}</td>
                <td><input type = 'number'  name= 'product_ids[${id}][quantity]' data-price='${price}' class='form-control product-quantity' min='1' value='1'></td>
                <td class='product-price'>${price}</td>
                <td> <button class='btn btn-danger remove-product-btn' data-id='${id}'><i class='fa fa-trash'></i></button></td>
                </tr>`;

    $(".order-list").append(html);
    calculateTotal();
}
