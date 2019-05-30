/* global urlLoading, $ */
//window.onerror = function () {
//    return true;
//};
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function preview(that, id) {
    var file = that.files[0];
    var reader = new FileReader();
    reader.addEventListener("load", function () {
        $('#' + id).html($('<img />').css('max-width', '100%').attr('src', reader.result));
    }, false);
    if (file) {
        reader.readAsDataURL(file);
    }
}
function toggleMenuCookie() {
    var hasClass = $('.sidebar,.navbar-header,#page-wrapper').toggleClass('h').hasClass('h');
    if (hasClass)
        $.cookie('cls', 'h', {path: '/'});
    else
        $.removeCookie('cls', {path: '/'});
    setTimeout(chartUpdateSize, 500);
}
function LoadCities(that, cityId, content, url) {
    var province_id = parseInt($(that).val());
    $(cityId).html('<option value="">' + content + '</option>');
    if (province_id) {
        ajaxpost(url, {province_id}, function (result) {
            var cities = '<option value="">' + content + '</option>';
            if (result) {
                for (var id in result) {
                    var title = result[id];
                    cities += '<option value="' + id + '">' + title + '</option>';
                }
            }
            $(cityId).html(cities);
        });
    }
}
function log() {
    console.log.apply(null, arguments);
}
function toInt(val) {
    return parseInt(val) ? parseInt(val) : 0;
}
function toFloat(val) {
    return parseFloat(val) ? parseFloat(val) : 0;
}
//------------------------------------------------------------------------------
// Ajax
//------------------------------------------------------------------------------
var ajaxDoAjax = true;
function ajax(inUrl, inType, inData, inSuccess, inDataType, inError, inComplete) {
    if (ajaxDoAjax) {
        ajaxDoAjax = false;
        showloading();
        $.ajax({
            url: inUrl,
            type: inType,
            data: inData,
            dataType: inDataType ? inDataType : 'json',
            success: function () {
                ajaxDoAjax = true;
                if (typeof inSuccess === 'function') {
                    inSuccess.apply(this, arguments);
                }
            },
            error: function () {
                showmessage('خطا در ارسال اطلاعات', 'red', 'خطا');
                if (typeof inError === 'function') {
                    inError.apply(this, arguments);
                }
            },
            complete: function () {
                ajaxDoAjax = true;
                hideloading();
                if (typeof inComplete === 'function') {
                    inComplete.apply(this, arguments);
                }
            }
        });
    }
}
function ajaxpost(url, data, success, dataType, error, complete) {
    ajax(url, 'post', data, success, dataType, error, complete);
}
function ajaxget(url, data, success, dataType, error, complete) {
    ajax(url, 'get', data, success, dataType, error, complete);
}
function validResult(result) {
    var message = '';
    if (result.messages) {
        for (var i in result.messages) {
            message += result.messages[i] + '<br/>';
        }
        if (message !== '') {
            if (result.saved === true) {
                showmessage(message, 'green');
            } else {
                showmessage(message, 'red', 'خطا');
            }
        }
    }
    return result.saved === true;
}
function showmessage(message, type, title) {
    $.alert({
        title: title ? title : '',
        content: message,
        type: type,
        buttons: {
            ok: {
                text: 'باشه'
            }
        }
    });
}
function showConfirm(message, action, title, type) {
    $.confirm({
        title: title ? title : '',
        content: message,
        type: type ? type : 'blue',
        buttons: {
            ok: {text: 'بله', action},
            no: {text: 'خیر'}
        }
    });
}
function showloading() {

}
function hideloading() {

}
//------------------------------------------------------------------------------
// Datatable
//------------------------------------------------------------------------------
$.fn.dataTableExt.oStdClasses.sFilterInput = 'form-control input-sm';
$.fn.dataTableExt.oStdClasses.sLengthSelect = 'form-control input-sm';
$.fn.DataTable.Buttons.defaults.dom.button.className = '';
$.fn.DataTable.ext.buttons.print.className = 'btn btn-sm btn-default';
$.fn.DataTable.ext.buttons.print.text = '<i class="fa fa-fw fa-print"></i>';
$.fn.DataTable.ext.buttons.pdfHtml5.className = 'btn btn-sm btn-default';
$.fn.DataTable.ext.buttons.pdfHtml5.text = '<i class="fa fa-fw fa-file-pdf"></i>';
$.fn.DataTable.ext.buttons.excelHtml5.className = 'btn btn-sm btn-default';
$.fn.DataTable.ext.buttons.excelHtml5.text = '<i class="fa fa-fw fa-file-excel"></i>';
Boolean.prototype.reloadDatatable = function (api, callback) {
    if (this.valueOf()) {
        reloadDatatableAjax(api, callback);
    }
};
function datatable(id, btn, ajax, columns, drawCallback, createdRow) {
    var pageLength = localStorage.getItem(id);
    pageLength = isNaN(parseInt(pageLength)) ? 1 : parseInt(pageLength);
    var aLengthMenu = [[1, 5, 10, 50, 100], /* -1 */[1, 5, 10, 50, 100]/* 'همه' */];
    if (!aLengthMenu[0].includes(pageLength)) {
        pageLength = aLengthMenu[0][0];
    }
    var buttons = [];
    if (btn) {
        if (Array.isArray(btn)) {
            $.each(btn, function (index, row) {
                buttons[buttons.length] = row;
            });
        } else {
            buttons[buttons.length] = btn;
        }
    }
    buttons[buttons.length] = 'print';
    buttons[buttons.length] = 'pdfHtml5';
    buttons[buttons.length] = 'excelHtml5';
    var options = {
        aLengthMenu,
        pageLength,
        buttons,
        info: false,
        dom: 'Blfrtip',
        order: [[0, 'desc']],
        language: {
            "lengthMenu": "&nbsp;تعداد نمایش&nbsp;:&nbsp;_MENU_ ",
            search: 'جستجو&nbsp;:&nbsp;',
            emptyTable: '<span style="color: #888">موردی یافت نشد</span>',
            zeroRecords: '<span style="color: #888">موردی یافت نشد</span>',
            processing: 'دریافت اطلاعات از سرور ...'
                    //aria: {sortAscending: 'فعال شده برای مرتب سازی صعودی ستون :', sortDescending: 'فعال شده برای مرتب سازی نزولی ستون :'},
                    //paginate: {previous: 'قبلی', next: 'بعدی', last: 'آخرین', first: 'اولین'},
                    //lengthMenu: 'تعداد نمایش _MENU_',
                    //infoEmpty: '<span style="color: #888">موردی یافت نشد</span>',
                    //info: '<span style="color: #888">نمایش _START_ تا _END_ از _TOTAL_ مورد</span>',
                    //infoFiltered: '<span style="color: #888">(جستجو بین _MAX_ مورد)</span>',
        }
        //sort: false,
        //searching: false,
        //buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'print'],
        //paging: false,
        //searchable: false,
        //createdRow: function (row, data, index) {
        //    $(row).addClass('success');
        //},
    };
    if (ajax) {
        options.ajax = ajax;
        options.processing = true;
        options.serverSide = true;
        options.sServerMethod = 'POST';
        if (columns) {
            options.columns = columns;
        }
    }
    options.drawCallback = function () {
        var api = this.api();
        localStorage.setItem(id, api.page.len());
        var json = getJsonFromApi(api);
        var isValid = validResult(json);
        if (drawCallback && isValid) {
            drawCallback.apply(this, [api, json]);
        }
    };
    if (createdRow) {
        options.createdRow = createdRow;
    }
    return $(id).DataTable(options);
}
function getDatatableRowData(api, that) {
    var tr = $(that).closest('tr');
    return api.row(tr).data();
}
function getJsonFromApi(api) {
    return api.ajax.json();
}
function reloadDatatableAjax(api, callback) {
    api.table().ajax.reload(callback);
}
//------------------------------------------------------------------------------
// Form
//------------------------------------------------------------------------------
$.fn.getData = function () {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function () {
        var n = this.name;
        var v = this.value;
        if (o[n]) {
            if (!o[n].push) {
                o[n] = [o[n]];
            }
            o[n].push(v || '');
        } else {
            o[n] = v || '';
        }
    });
    //$(this).find(':checkbox').each(function () {
    //    o[$(this).attr('name')] = $(this).prop('checked') ? 1 : 0;
    //});
    return o;
};
$.fn.getData2 = function () {
    var o = {};
    var data = this.serializeArray();
    for (var i in data) {
        var row = data[i];
        o[row.name] = row.value;
    }
    return o;
};
$.fn.disableAll = function () {
    return $(this).each(function () {
        var $items = $(this).find(':input:not(:disabled)');
        $(this).data('disabledItems', $items);
        $items.each(function () {
            $(this).prop('disabled', true);
        });
    });
};
$.fn.enableAll = function () {
    return $(this).each(function () {
        var items = $(this).data('disabledItems');
        if (typeof items === 'object') {
            $(items).each(function () {
                $(this).prop('disabled', false);
            });
        }

    });
};
//------------------------------------------------------------------------------
// Prototype
//------------------------------------------------------------------------------
String.prototype.toInt = function () {
    return toInt(this.valueOf());
};
Number.prototype.toInt = function () {
    return toInt(this.valueOf());
};
String.prototype.toFloat = function () {
    return toFloat(this.valueOf());
};
Number.prototype.toFloat = function () {
    return toFloat(this.valueOf());
};
String.prototype.replaceAll = function (search, replacement) {
    return this.valueOf().replace(new RegExp(search, 'g'), replacement);
};
//------------------------------------------------------------------------------
// on ready
//------------------------------------------------------------------------------
(function (win, doc, $) {
    $('.btn-search-panel').click(function (e) {
        e.preventDefault();
        $("[class$='-index'] [class$='-search']").slideToggle();
    });
    $('.datePicker')
    .each(function () {
        $(this).data('isEmpty', $(this).val() === '');
    })
    .persianDatepicker({format: 'YYYY/MM/DD', autoClose: true})
    .each(function () {
        if ($(this).data('isEmpty')) {
            $(this).val('');
        }
    });
    $(doc).keyup(function (e) {
        if (e.ctrlKey && !e.shiftKey && e.keyCode === 37) {
            $('.sidebar,.navbar-header,#page-wrapper').removeClass('h');
            $.removeCookie('cls', {path: '/'});
        } else if (e.ctrlKey && !e.shiftKey && e.keyCode === 39) {
            $('.sidebar,.navbar-header,#page-wrapper').addClass('h');
            $.cookie('cls', 'h', {path: '/'});
        }
    });
    $(doc).on('click', '[view]', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var title = ($(this).attr('title') ? $(this).attr('title') : ($(this).text() ? $(this).text() : 'بدون عنوان'));
        $('#modelIndex0 .modal-header span').text(title);
        $('#modelIndex0 .modal-body').html(`<p class="text-center"><img src="${urlLoading}"/></p>`);
        $('#modelIndex0').modal('show');
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'html',
            success: function (result) {
                $('#modelIndex0 .modal-body').html(result);
            }
        });
    });
    
    var modal_log = [];
    $('#modelIndex0').on('hidden.bs.modal', function () {
        modal_log = [];
        $('#modelIndex0 .back').hide();
    }).find('.back').on('click', function (e) {
        e.preventDefault();
        modal_log.pop();
        var last = modal_log[modal_log.length - 1];
        showModal(last);
    });
    $(doc).on('click', 'a.view', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var title = $(this).html();
        var title_txt = $(this).text();
        var title_atr = $(this).attr('title');
        var withBtn = $(this).hasClass('with-btn');
        var isInModal = $(this).parents('#modelIndex0').length > 0;
        modal_log[modal_log.length] = {isInModal, url, title, title_txt, title_atr, withBtn};
        showModal({isInModal, url, title, title_txt, title_atr, withBtn});
    });
    function showModal(data) {
        var modal = $('#modelIndex0');
        if (data.isInModal) {
            modal.find('.back').show();
        }
        else {
            modal.find('.back').hide();
        }
        modal.find('.modal-header span').html(data.title + (data.title_txt ? '' : ' ' + data.title_atr));
        modal.find('.modal-body').html(`<p class="text-center"><img src="${urlLoading}"/></p>`);
        modal.modal('show');
        ajaxget(data.url, {}, function (result) {
            var content = $(result);
            content.removeClass('box');
            content.find('.box-header').remove();
            if (!data.withBtn) {
                content.find('p:has(.btn)').remove();
                content.find('.box-footer').remove();
            }
            content.find('.box').removeClass('box');
            modal.find('.modal-body').html(content);
        }, 'html');
    }
    $(doc).on('click', '#modelIndex0 .btn-return', function (e) {
        e.preventDefault();
        if ($('#modelIndex0 .back').css('display') === 'block') {
            $('#modelIndex0 .back').trigger('click');
        }
        else {
            var modal = $('#modelIndex0');
            modal.modal('hide');
        }
    });


    var date = new Date();
    var seconds = date.getSeconds();
    var minutes = date.getMinutes();
    var hours = date.getHours();
    $("#hours").html((hours < 10 ? "0" : "") + hours);
    $("#min").html((minutes < 10 ? "0" : "") + minutes);
    $("#sec").html((seconds < 10 ? "0" : "") + seconds);
    setInterval(function () {
        date = new Date();
        hours = date.getHours();
        minutes = date.getMinutes();
        seconds = date.getSeconds();
        $("#hours").html((hours < 10 ? "0" : "") + hours);
        $("#min").html((minutes < 10 ? "0" : "") + minutes);
        $("#sec").html((seconds < 10 ? "0" : "") + seconds);
    }, 1000);


})(window, document, $);
//------------------------------------------------------------------------------
// End
//------------------------------------------------------------------------------