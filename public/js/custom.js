let onSubmit;
let submitted = false;
let preventDefault = false;
let disablePreventAfterSubmit = true;
let onAjaxError = (data) => {
    if (typeof (data) === 'object') {
        let msg = '';
        let responseText = '';
        for (let key in data) {
            if (key === 'responseJSON') {
                for (let key1 in data['responseJSON']) {
                    if (data['responseJSON'].hasOwnProperty(key1)) {
                        msg += '<br />' + data['responseJSON'][key1];
                    }
                }
            }
            if (key === 'responseText') {
                responseText = data['responseText'];
            }
        }
        if (msg !== '') {
            bootbox.alert("Erro ao executar a ação: " + msg);
        } else {
            bootbox.alert("Erro ao executar a ação: " + responseText);
        }
    } else if (typeof (data) === 'string') {
        bootbox.alert("Erro ao executar a ação: " + data);
    } else {
        bootbox.alert("Erro ao executar a ação!");
    }
};

ajaxCall = (url, onSuccess, method = "POST", data = {}) => {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: method,
        data: data,
        cache: false,
        success: onSuccess,
        error: onAjaxError,
        contentType: false,
        processData: false
    });
};

$(".grid-index").bootstrapTable({});

function setOnSubmitValidation(fun, prevent = false) {
    onSubmit = fun;
    preventDefault = prevent;
}

function setPreventDefault(prevent = false) {
    preventDefault = prevent;
}

function init() {
    let $form = $("#formSave");
    $form.on("submit", function (e) {
        submitted = true;
        if (typeof onSubmit === "function") {
            try {
                onSubmit(e);
            } catch (e) {
                console.log(e);
                submitted = false;
                alert("Erro desconhecido, entre em contato com o suporte");
                e.preventDefault();
            }
        }
        let $attr = $("#active");
        if (typeof $attr !== "undefined" && $attr.is(":checked")) {
            $attr.val(1);
        } else {
            $attr.val(0);
        }
        if (preventDefault) {
            submitted = false;
            e.preventDefault();
            if (disablePreventAfterSubmit) {
                preventDefault = false;
            }
        }
    });
    let urlSearch = window.location.href.toString();
    if (urlSearch.indexOf("/create") === -1 && urlSearch.indexOf("/edit") === -1) {
        $form.find("input, select").prop("disabled", true);
    }
}

init();