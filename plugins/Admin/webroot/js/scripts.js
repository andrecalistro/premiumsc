(function () {
    this.uniqid = function (pr, en) {
        var pr = pr || '', en = en || false, result

        this.seed = function (s, w) {
            s = parseInt(s, 10).toString(16)
            return w < s.length ? s.slice(s.length - w) : (w > s.length) ? new Array(1 + (w - s.length)).join('0') + s : s
        }

        result = pr + this.seed(parseInt(new Date().getTime() / 1000, 10), 8) + this.seed(Math.floor(Math.random() * 0x75bcd15) + 1, 5)

        if (en) result += (Math.random() * 10).toFixed(8).toString()

        return result
    }
})()

$(document).ready(function () {
    setTimeout(function () {
        $(".alert").addClass("in").fadeOut(4500, function () {
            $(this).remove();
        });
    }, 4000)


    $("aside.sidebar-nav a.menu-dropdown").on('click', function () {
        if (!$(this).parent().hasClass('opened')) {
            var $opened = $('.opened');
            $opened.find('ul.nav-stacked').slideToggle(200);
            $opened.find('i.pull-right').toggleClass('fa-angle-down fa-angle-up');
            $opened.removeClass('opened');
        }

        $(this).parent().toggleClass('opened');
        $(this).parent().find('ul.nav-stacked').slideToggle(200);
        //$(this).parent().find('ul.nav-stacked').toggleClass('collapse')
        $(this).find('i.pull-right').toggleClass('fa-angle-down fa-angle-up');
    });

    $("aside.sidebar-min li.menu-drop-down").on('click', function () {
        $("aside.sidebar-min").find('ul.child-submenu').slideUp(50)
        if ($(this).find('ul.child-submenu').css('display') == 'none') {
            $(this).find('ul.child-submenu').slideDown(50)
        }
    })

    $(".minimize-sidebar").on('click', function () {
        $("aside").toggleClass('sidebar-min sidebar-nav')
        localStorage.setItem('classMenu', $("aside").attr('class'))
    })

    var classMenu = localStorage.getItem('classMenu')
    if (classMenu === null) {
        classMenu = 'sidebar-nav affix'
    }
    $("aside").attr('class', classMenu)

    /**
     * main menu mobile
     */
    $('.toggle-main-menu').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('menu-opened');
        $("aside").animate({width: 'toggle'});
    });

    /**
     * mask
     */
    $('.input-price').mask("#.##0,00", {reverse: true});
    $('.input-height, .input-width, .input-length').mask("###0,00", {reverse: true});
    $('.input-weight').mask("###0,000", {reverse: true});
    $('.input-zipcode').mask('00000-000');
    $('.input-date').mask('00/00/0000');
    $('.input-date-time').mask('00/00/0000 00:00');
    $('.input-cnpj').mask('00.000.000/0000-00');
    $('.input-cpf').mask('000.000.000-00');

    var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009'
        },
        spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options)
            }
        };

    $(".input-phone").mask(SPMaskBehavior, spOptions);

    /**
     * select2
     */
    $("#input-select2-filters").select2({
        theme: "bootstrap",
        width: null,
        ajax: {
            url: base_url + "filters-groups/items.json",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item, key) {
                        return {
                            text: item,
                            id: key
                        }
                    })
                }
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup
        }, // let our custom formatter work
        minimumInputLength: 1
    });

    $("#input-select2-filters").select2({
        theme: "bootstrap",
        width: null,
        ajax: {
            url: base_url + "filters-groups/items.json",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data.items, function (item, key) {
                        return {
                            text: item,
                            id: key
                        }
                    })
                }
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup
        }, // let our custom formatter work
        minimumInputLength: 1
    });

    $(".input-select2-filters-dynamic").select2({
        theme: "bootstrap",
        width: null,
        tags: true
    });

    $(".input-select2").select2({
        theme: "bootstrap",
        width: null,
        templateResult: function (state) {
            if (!state.id || $(state.element).attr('data-image') === undefined || !$(state.element).attr('data-image')) {
                return state.text;
            }

            return $('<span><img src="' + $(state.element).attr('data-image') + '" class="dropdown-image" /> ' + state.text + '</span>');
        }
    });

    /**
     * Bootstrap Datepicker
     */
    if ($.fn.datepicker.dates) {
        $.fn.datepicker.dates['pt-BR'] = {
            days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            daysMin: ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa"],
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            today: "Hoje",
            monthsTitle: "Meses",
            clear: "Limpar",
            format: "dd/mm/yyyy"
        };
    }

    $('.input-datepicker').datepicker({
        language: 'pt-BR',
        autoclose: true
    });

    if ($('.input-editor').length > 0) {
        tinymce.init({
            selector: '.input-editor',
            height: 500,
            theme: 'modern',
            convert_urls: false,
            menubar: false,
            entity_encoding: 'raw',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
            block_formats: 'Paragraph=p; Header 2=h2; Header 3=h3; Header 4=h4',
            style_formats_merge: true,
            toolbar: 'undo redo | formatselect forecolor bold italic strikethrough underline bullist numlist | alignleft aligncenter alignright alignjustify | outdent indent | link unlink | image preview media removeformat hr code',
            image_advtab: true,
            setup: function (editor) {
                editor.on('change', function (e) {
                    editor.save();
                });
            }
        });
    }

    if ($('.input-editor-small').length > 0) {

        tinymce.init({
            selector: '.input-editor-small',
            height: 500,
            theme: 'modern',
            convert_urls: false,
            menubar: false,
            entity_encoding: 'raw',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
            ],
            block_formats: 'Paragraph=p',
            style_formats_merge: true,
            toolbar: 'undo redo | fontsizeselect forecolor bold italic strikethrough underline bullist numlist | alignleft aligncenter alignright alignjustify | link unlink | image preview media removeformat hr code',
            fontsize_formats: '8px 9px 10px 11px 12px 13px 14pt 15px 16px 17px 18px 20px 22px 24px 28px 30px 32px 34px 36px 40px 44px 48px 52px',
            image_advtab: true,
            setup: function (editor) {
                editor.on('change', function (e) {
                    editor.save();
                });
            }
        });
    }
});

$(document).on('keyup', '.input-cep', function () {
    var zipcode = $(this).val().replace("-", "");
    if (zipcode.length == 8) {
        openModalLoading();
        $.getJSON("//viacep.com.br/ws/" + zipcode + "/json/?callback=?", function (dados) {
            if (!("erro" in dados)) {
                //Atualiza os campos com os valores da consulta.
                $(".input-address").val(dados.logradouro);
                $(".input-neighborhood").val(dados.bairro);
                $(".input-city").val(dados.localidade);
                $(".input-state").val(dados.uf);
                $(".input-number").focus()
            } //end if.
            else {
                alert("CEP não encontrado.")
            }
        });
        closeModalLoading()
    }
});

$("span.glyphicon-question-sign").tooltip()

function openModalLoading() {
    $("#processing-modal").modal('show')
}

function closeModalLoading() {
    $("#processing-modal").modal('hide')
}

$(document).on('click', '.btn-file p.icon-upload-file img', function () {
    var input = $(this).parent().parent().find('input[type=file]')
    input.val().replace(/\\/g, '/').replace(/.*\//, '')
    input.trigger('click')
})

function readURL(input, element) {
    if (input.files && input.files[0]) {
        var reader = new FileReader()
        reader.onload = function (e) {
            var preview = element.parent().parent().find('img.img-upload')
            preview.attr('src', e.target.result)
            element.parent().parent().find('p.icon-upload-file').hide('fast')
            preview.show('fast')
            element.parent().parent().find('p.btn-del-file').show('fast')
        }
        reader.readAsDataURL(input.files[0])
    }
}

$(".img-upload-input").change(function () {
    readURL(this, $(this))
})

$(document).on('click', 'p.btn-del-file button', function (e) {
    e.preventDefault()

    var parent = $(this).parent().parent()

    parent.find('.img-upload').hide('fast')
    parent.find('.img-upload').attr('src', '')
    parent.find('p.btn-del-file').hide('fast')
    parent.find('.img-upload-input').val('')
    parent.find('.input-text-file').attr('disabled', true)
    parent.find('.img-upload-input').attr('disabled', false)

    parent.find('p.icon-upload-file').show('fast')
})

$(document).on('click', '.add-filter-item', function (e) {
    e.preventDefault()

    var html = '<tr>'
    html += '<td><div class="input text required"><input type="text" name="filters[][name]" class="form-control" required="required" maxlength="255" id="filters-name"></div></td>'
    html += '<td align="right"><a href="javascript:void(0)" class="btn btn-sm btn-danger remove-filter-item" title="Excluir Filtro"><i class="fa fa-trash-o"></i></a></td>'
    html += '</tr>'

    $("#list-filters tbody").append(html)
})

$(document).on('click', '.remove-filter-item', function (e) {
    e.preventDefault()

    var id = $(this).parent().parent().find('input[type=hidden]')
    var input = $(this)

    if (id.length > 0) {
        $.ajax({
            url: base_url + 'filters-groups/delete-filter/' + id.val() + '.json',
            type: "post",
            success: function (data) {
                if (data.response.status) {
                    input.parent().parent().remove()
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            }
        })
    } else {
        input.parent().parent().remove()
    }
});

$(document).on('click', '#attributes .add-attribute-item', function (e) {
    e.preventDefault();

    $.ajax({
        url: base_url + 'attributes.json',
        type: "post",
        beforeSend: function () {
            openModalLoading()
        },
        success: function (data) {
            var html_list_attributes = '';
            if (data.attributes) {
                for (var i in data.attributes) {
                    html_list_attributes += '<option value="' + data.attributes[i].id + '">' + data.attributes[i].name + '</option>'
                }
            }
            var id = uniqid();

            var html = '<tr>';
            html += '<td><div class="input select"><select name="products_attributes[' + id + '][attributes_id]" class="form-control" id="attributes-' + id + '-attributes-id">' + html_list_attributes + '</select></div></td>';
            html += '<td><div class="input text"><input type="text" name="products_attributes[' + id + '][value]" class="form-control" id="attributes-' + id + '-value"></div></td>';
            html += '<td align="right"><a href="#" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove()"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
            html += '</tr>';

            $("#attributes table tbody").append(html);
            closeModalLoading()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown)
        }
    })
});

$(document).on('click', '.remove-attribute', function (e) {
    e.preventDefault();
    var dad = $(this).closest("tr");
    var attributes_id = $(this).attr('attributes-id');
    $.ajax({
        url: base_url + 'products/remove-attribute/' + attributes_id + '.json',
        type: "post",
        beforeSend: function () {
            openModalLoading()
        },
        success: function (data) {
            if (data.json.status) {
                dad.remove()
            } else {
                alert(data.json.message)
            }
            closeModalLoading()
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown)
        }
    })
});

$(document).on('click', '.add-tab-content', function (e) {
    openModalLoading();
    e.preventDefault();

    var id = uniqid();
    var html = '';

    // html += '<div class="form-group">'
    // html += '<hr>'
    // html += '<div class="input textarea">'
    // html += '<label><div class="input-group">'
    // html += '<input type="text" name="products_tabs[' + id + '][name]" placeholder="Nome da aba de conteudo" class="form-control" required>'
    // html += '<span class="input-group-btn">'
    // html += '<button class="btn btn-danger" type="button" onclick="if(confirm(\'Tem certeza que deseja excluir esse item?\')){$(this).closest(\'.form-group\').remove()}"><i class="fa fa-trash" aria-hidden="true"></i></button>'
    // html += '</span>'
    // html += '</div></label>'
    // html += '<textarea name=products_tabs[' + id + '][content] class="form-control input-editor" rows="8"></textarea>'
    // html += '</div>'
    // html += '<hr>'
    // html += '</div>'
    html += '<div class="item-content">'
    html += '<hr>'
    html += '<div class="row">'
    html += '<div class="col-md-3 form-group">'
    html += '<div class="input text"><label>Nome da aba de conteudo</label><input type="text" name="products_tabs[' + id + '][name]" class="form-control" required="required" maxlength="255"></div></div>'
    html += '<div class="col-md-3 form-group">'
    html += '<div class="input number"><label>Ordem de exibição</label><input type="number" name="products_tabs[' + id + '][order_show]" class="form-control"></div></div>'
    html += '<div class="col-md-3 form-group">'
    html += '<div class="input select"><label>Status</label><select name="products_tabs[' + id + '][status]" class="form-control"><option value="0">Desabilitado</option><option value="1" selected>Habilitado</option></select></div></div>'
    html += '<div class="col-md-3 form-group">'
    html += '<button class="btn btn-danger" type="button" onclick="if(confirm(\'Tem certeza que deseja excluir esse item?\')){$(this).closest(\'.item-content\').remove()}"><i class="fa fa-trash" aria-hidden="true"></i> Excluir aba</button>'
    html += '</div>'
    html += '</div>'
    html += '<div class="row">'
    html += '<div class="col-md-12">'
    html += '<textarea name="products_tabs[' + id + '][content]" class="form-control input-editor" rows="8"></textarea>'
    html += '</div>'
    html += '</div>'
    html += '<hr>'
    html += '</div>'

    $("#content").append(html)

    tinymce.init({
        selector: '.input-editor',
        height: 500,
        theme: 'modern',
        convert_urls: false,
        menubar: false,
        entity_encoding: 'raw',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
        ],
        block_formats: 'Paragraph=p; Header 2=h2; Header 3=h3; Header 4=h4',
        style_formats_merge: true,
        toolbar: 'undo redo | formatselect forecolor bold italic strikethrough underline bullist numlist | alignleft aligncenter alignright alignjustify | outdent indent | link unlink | image preview media removeformat hr code',
        image_advtab: true,
        valid_elements: '+*[*]',
        setup: function (editor) {
            editor.on('change', function (e) {
                editor.save();
            });
        }
    });

    closeModalLoading()
});

$(document).on('click', '.remove-tab-content', function (e) {
    e.preventDefault();
    if (confirm('Tem certeza que deseja remover esse item?')) {
        var dad = $(this).closest(".item-content");
        var products_tabs_id = $(this).attr('data-products-tabs-id');
        $.ajax({
            url: base_url + 'products/remove-tab-content/' + products_tabs_id + '.json',
            type: "post",
            beforeSend: function () {
                openModalLoading()
            },
            success: function (data) {
                if (data.json.status) {
                    dad.remove()
                } else {
                    alert(data.json.message)
                }
                closeModalLoading()
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            }
        })
    }
});

$(document).on('change', '#attributes select', function(){
    var input = $(this).closest('tr').find('input');
    input.val('');
    $.ajax({
        type: "GET",
        url: base_url + "attributes/view/"+$(this).val()+".json",
        dataType: 'json',
        async: true,
        beforeSend: function () {
            openModalLoading();
        },
        success: function (result) {
            if(result){
                input.attr('type', result.attribute.type);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        },
        complete: function () {
            closeModalLoading();
        }
    });
});

var showalert = function (message, type) {
    var className = type;

    if (type == 'error') {
        className = 'warning';
    }

    var html = '<div class="alert alert-' + className + ' alert-dismissible in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span aria-hidden="true">×</span></button>' + message + '</div>';

    $('body').append(html);

    setTimeout(function () {
        $(".alert").addClass("in").fadeOut(4500, function () {
            $(this).remove();
        });
    }, 4000)
};


$(document).on('change', '#js-change-menu-type', function () {
    var menu_type = $(this).val();
    var current = $(this).data('current');

    $.ajax({
        type: "POST",
        url: base_url + "stores-menus-items/get-menu-type-html.json",
        data: {menu_type: menu_type, current: current},
        dataType: 'json',
        async: true,
        beforeSend: function () {
            $("#js-menu-type-html").slideUp();
            openModalLoading();
        },
        success: function (result) {
            $("#js-menu-type-html").html(result.content).slideDown();

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        },
        complete: function () {
            closeModalLoading();
        }
    });
});