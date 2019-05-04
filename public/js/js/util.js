$(".money").maskMoney({"thousands": " ", "prefix": "R$ ", "allowZero": true });
$(".cnpj").on("focusout", function () {
    let $self = $(this);
    if ($self.val().length > 0 && ! isCNPJValid($self.val())) {
        alertWithCall("CNPJ inválido", function () {
            $self.val("").focus()
        });
    }
}).mask("99.999.999/9999-99", {placeholder: ""});
$(".cpf").on("focusout", function () {
    let $self = $(this);
    if ($self.val().length > 0 && ! isCPFValid($self.val())) {
        alertWithCall("CPF inválido", function () {
            $self.val("").focus()
        });
    }
}).mask("999.999.999-99", {placeholder: " "});
$(".cep").mask("99999-999", {placeholder: ""});

$(document).on("shown.bs.modal", ".bootbox.modal", function () {
    setTimeout(function () {
        $(".modal-footer").find("button").first().focus();
    }, 250);
});

function onlyNumbers(value) {
    if (typeof value === "string") {
        return value.replace(/\D/g, '');
    } else {
        bootbox.alert("Erro ao validar valor: o campo nào é uma string válida");
        return "0";
    }
}

function isCNPJValid(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g,'');

    if(cnpj == '') return false;

    if (cnpj.length != 14)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" ||
        cnpj == "11111111111111" ||
        cnpj == "22222222222222" ||
        cnpj == "33333333333333" ||
        cnpj == "44444444444444" ||
        cnpj == "55555555555555" ||
        cnpj == "66666666666666" ||
        cnpj == "77777777777777" ||
        cnpj == "88888888888888" ||
        cnpj == "99999999999999")
        return false;

    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return false;

    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
        return false;

    return true;
}

function isCPFValid(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');

    if(cpf == '') return false;

    if (cpf.length != 11)
        return false;

    // Elimina CNPJs invalidos conhecidos
    if (cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;


    var Soma;
    var Resto;
    Soma = 0;

    for (i=1; i<=9; i++) Soma = Soma + parseInt(cpf.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(cpf.substring(9, 10)) ) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(cpf.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(cpf.substring(10, 11) ) ) return false;
    return true;
}

function alertWithCall(message, callback) {
    bootbox.alert(message, () => {
        setTimeout(callback, 200);
    });
}

function moneyToFloat(value) {
    let split = value.split(".");
    let bef = onlyNumbers(split[0] ? split[0] : "");
    let aft = onlyNumbers(split[1] ? split[1] : "");
    if (! aft) {
        aft = "00";
    }
    let finalValue = parseFloat(bef + "." + aft);
    return finalValue ? finalValue : 0.00;
}

function floatToMoney(value, decimals, prefix = "R$ ") {
    let n = value;
    let c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
    let d = ".";
    let t = " ";
    let s = n < 0 ? "-" : "";
    let i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "";
    let j;
    j = (j = i.length) > 3 ? j % 3 : 0;
    return prefix + s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}