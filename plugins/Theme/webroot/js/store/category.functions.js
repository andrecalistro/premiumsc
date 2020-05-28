$(document).on('click', '.lista-filtros input[type=checkbox]', function (e) {
    loading();
    let url = prepareUrl();

    // verifica se é página de busca (se foi buscado algo)
    let urlObj = new URL(location.href);
    let p = urlObj.searchParams.get("p");
    if (p != null) {
        url = URL_add_parameter(url, 'p', p);
    }

    let checkboxes = $(".lista-filtros input[type=checkbox]:checked");
    if (checkboxes) {
        checkboxes.each(function (index, input) {
            url = URL_add_parameter(url, $(input).data('type'), $(input).val(), true);
        });
    }

    window.location.href = url;
});

$(document).on('change', '.sort', function (e) {
    let option = $(this). children("option:selected");

    if (option.val() === '') {
        return;
    }

    loading();
    let url = prepareUrl();

    // verifica se é página de busca (se foi buscado algo)
    let urlObj = new URL(location.href);
    let p = urlObj.searchParams.get("p");
    if (p !== null) {
        url = URL_add_parameter(url, 'p', p);
    }

    let sort = option.data('sort');
    let direction = option.data('direction');
    url = URL_add_parameter(url, 'sort', sort, false);
    url = URL_add_parameter(url, 'direction', direction, false);

    window.location.href = url;
});

$(document).on('keyup', '.search-filter', function (e) {
    var type = $(this).data('type');
    var name = $(this).val();
    if (name) {
        $("#" + type + " li").css('display', 'none');
        $("#" + type + " li[class*=" + name + "]").css('display', 'block');
    } else {
        $("#" + type + " li").css('display', 'block');
    }
});

function URL_add_parameter(url, param, value, group) {
    let hash = {};
    let parser = document.createElement('a');
    if (group === undefined) {
        group = false;
    }

    parser.href = url;

    let parameters = parser.search.split(/\?|&/);
    console.log(parameters);

    for (let i = 0; i < parameters.length; i++) {
        if (!parameters[i])
            continue;

        let ary = parameters[i].split('=');
        hash[ary[0]] = ary[1];
    }

    if (hash[param] && group) {
        hash[param] = hash[param] + ',' + value;
    } else {
        hash[param] = value;
    }

    let list = [];
    Object.keys(hash).forEach(function (key) {
        list.push(key + '=' + hash[key]);
    });

    parser.search = '?' + list.join('&');
    return parser.href;
}

function prepareUrl() {
    let url = location.origin + location.pathname;

    if (location.search.length > 0) {
        url += location.search;
    }

    return url;
}

var paginatorLimit = function (input) {
    if (input.val() > 0) {
        var url = location.origin + location.pathname + location.search;
        url = URL_add_parameter(url, 'limit', input.val());
        window.location.href = url;
    }
};