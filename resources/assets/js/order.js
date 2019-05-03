let btnActionItem = '<button type="button" class="btn btn-danger btn-sm btnRemove" ' + (action === "show" ? "disabled" : "") + '>Remover</button>';
let totalPriceOrder = 0;
let hasFocusBarcode = true;

$(document).ready(function () {
    initOrder();
    setOldProducts();
    setPriceAndQtde();

    $("#product_id").on("change", setPriceAndQtde);
});

function setPriceAndQtde(changeCount = true) {
    let $product = $("#product_id");
    let price;
    let product;
    if ($product.isEmpty()) return;

    product = productsList.where("id", $product.intVal()).first();
    if (! product) {
        price = 0;
    } else {
        price = product.price;
    }
    $("#product_price").val(floatToMoney(price));
    if (changeCount) {
        $("#product_count").val(1);
    }
}

function setOldProducts() {
    let arrayProducts;
    try {
        arrayProducts = JSON.parse($("#products_list").val());
    } catch (e) {
        if (hasErrors) {
            bootbox.alert("Erro ao inserir produtos na grid");
        }
        arrayProducts = [];
    }

    for (let i = 0; i < arrayProducts.length; i++) {
        let prod = arrayProducts[i];
        appendProd(prod.product_id, prod.product_description, prod.count, prod.price, prod.total_price)
    }

}

let $barcode = $("#barcode");
$barcode.on("focusin", () => {
    hasFocusBarcode = true;
}).on("blur", () => {
    hasFocusBarcode = false;
});
function initOrder() {
    let $clientType = $("#client_type");
    $clientType.on("change", changeCpfCnpj);
    changeCpfCnpj(false);
    setOnSubmitValidation(function () {
        if (hasFocusBarcode) {
            setPreventDefault(true);
            let product = productsList.where("barcode", $barcode.intVal()).first();

            if (! product) {
                $("#product_id").val("");
                alertWithCall("Nenhum produto encontrado!", function () {
                    $barcode.focus();
                });
                return;
            } else {
                $("#product_id").val(product.id);
            }
            setPriceAndQtde(false);
            addProd();
            return;
        }
        let $attr = $("#print_client");
        if (typeof $attr !== "undefined" && $attr.is(":checked")) {
            $attr.val(1);
        } else {
            $attr.val(0);
        }
        $attr = $("#canceled");
        if (typeof $attr !== "undefined" && $attr.is(":checked")) {
            $attr.val(1);
        } else {
            $attr.val(0);
        }
        let arrayProducts = [];

        $("#order-list tbody").find("tr").each(function (i, el) {
            let $el = $(el);
            let rows = $el.find("td");
            arrayProducts.push({
                "product_id": $(rows[0]).text(),
                "product_description": $(rows[1]).text(),
                "count": $(rows[2]).text(),
                "price": $(rows[3]).text(),
                "total_price": $(rows[4]).text()
            });
        });
        $("#products_list").val(JSON.stringify(arrayProducts));
        if (arrayProducts.length === 0) {
            setPreventDefault(true);
            alertWithCall("Informe um produto!", () => $barcode.focus());
            setTimeout(function () {

            });
            submitted = false;
            return;
        }
        $("#total_price").prop("disabled", false);
    });
    $("#order-list").on("click", ".btnRemove", function () {
        let $tr = $(this).closest("tr");
        updatePrice($($tr.find("td")[4]).text(), true);
        $tr.remove();
        $barcode.focus();
    });
    $("#btnAddProd").on("click", addProd);
}

function addProd() {
    let $product = $("#product_id");
    let $price = $("#product_price");
    let $count = $("#product_count");
    let product_id = $product.val();
    let price = moneyToFloat($price.val());
    let count = $count.val();
    if (! product_id) {
        alertWithCall("Informe um produto!", function () {
            $barcode.focus();
        });
    } else if (! price) {
        alertWithCall("Informe o preço do produto!", function () {
            $price.focus();
        });
    } else if (! count) {
        alertWithCall("Informe a quantidade do produto!", function () {
            $count.focus();
        });
    } else {
        appendProd(
            product_id,
            $product.find("option:selected").text(),
            count,
            $price.val(),
            floatToMoney(price * count)
        ).then(() => {
            $barcode.focus();
            $barcode.val("");
        });
    }
}

function appendProd(product_id, description, count, price, totalPrice) {
    return new Promise(resolve => {
        let $rows = $("#order-list tbody").find("tr");
        let has = false;
        $rows.each(function (_, el) {
            let $el = $(el);
            let rows = $el.find("td");
            if (parseInt($(rows[0]).text()) === parseInt(product_id)) {
                let newCount = parseInt($(rows[2]).text()) + parseInt(count);
                $(rows[2]).text(newCount);
                $(rows[3]).text(price);
                $(rows[4]).text(floatToMoney(moneyToFloat(price) * newCount));
                has = true;
            }
        });
        updatePrice(totalPrice);
        if (has) {
            resolve();
            return;
        }

        let index = $rows.length;
        let newRow = $("<tr id='product-index-" + index + "'>");
        let cols = "";

        cols += '<td>' + product_id + '</td>';
        cols += '<td>' + description  + '</td>';
        cols += '<td>' + count + '</td>';
        cols += '<td>' + price + '</td>';
        cols += '<td>' + totalPrice + '</td>';

        cols += '<td>' + btnActionItem + '</td>';
        newRow.append(cols);
        $("#order-list").append(newRow);
        resolve();
    });
}

function updatePrice(value, remove = false) {
    if (remove) {
        totalPriceOrder -= moneyToFloat(value);
    } else {
        totalPriceOrder += moneyToFloat(value);
    }

    $("#total_price").val(floatToMoney(totalPriceOrder));
}

function changeCpfCnpj(changedByUser = true) {
    if ($("#client_type").val() === "F") {
        $(".div-cpf").show();
        if (typeof changedByUser === "boolean" && changedByUser) {
            $("client_cnpj").val("");
        }
        $(".div-cnpj").hide();
    } else {
        $(".div-cpf").hide();
        if (typeof changedByUser === "boolean" && changedByUser) {
            $("client_cpf").val("");
        }
        $(".div-cnpj").show();
    }
}