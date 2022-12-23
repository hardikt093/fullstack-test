// functions for form validation and submission
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery.validator.setDefaults({
        debug: false,
        onsubmit: true,
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        invalidHandler: invalidHandler,
        highlight: highlightElement,
        unhighlight: unhighlightElement,
        submitHandler: submitHandler
    });


    $.validator.prototype.checkForm = function() {
        $(".form-group.has-error .error").remove();
        $(".form-group").removeClass('has-error');
        //overriden in a specific page
        this.prepareForm();
        for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
            if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
                for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                    this.check(this.findByName(elements[i].name)[cnt]);
                }
            } else {
                this.check(elements[i]);
            }
        }
        return this.valid();
    };

});

function invalidHandler(event, validator) {
    if (validator.errorList.length == 0) return;
    // showError('One or more invalid inputs found.', validator.errorList);
}

function highlightElement(element) {
    $(element).addClass('is-invalid');
}

function unhighlightElement(element) {
    $(element).removeClass('is-invalid');
}

function highlightInvalidFields(form, fieldnames) {
    $(form).find('input, select, textarea').each(function() {
        var fieldname = $(this).attr('name');
        var index = $.inArray(fieldname, fieldnames);
        if (index == -1) {
            unhighlightElement($(this));
        } else {
            highlightElement($(this));
        }
    });
}

function submitHandler(form) {
    disableFormButton(form);
    showLoader();

    $(form).ajaxSubmit({
        dataType: 'json',
        success: formResponse,
        error: formResponseError
    });
}

function formResponseError(XMLHttpRequest, textStatus, errorThrown) {
    hideLoader();
    // showError('Server error. Please try again.');
    enableFormButton($('form'));
    console.log('ERROR: ' + XMLHttpRequest.statusText);
    console.log('ERROR: ' + XMLHttpRequest.errorThrown);
}

function disableFormButton(form) {
    $(form).find('input[type="submit"]').attr('disabled', 'disabled');
    $(form).find('button[type="submit"]').attr('disabled', 'disabled');
}

function enableFormButton(form) {
    $(form).find('input[type="submit"]').removeAttr('disabled');
    $(form).find('button[type="submit"]').removeAttr('disabled');
}

function showSuccess(caption, successList, callback) {

    $('.log-msg-wrapper').removeClass('successlist');
    $('.log-msg-wrapper').html('');
    var successListMsgs = '';
    if (caption) {
        successListMsgs += '<h4 class="success-msg-caption">' + caption + '</h4>';
    }

    if (successList && successList.length > 0) {
        successListMsgs += '<ul class="success-msg-ul">';
        for (var i = 0; i < successList.length; i++) {
            successListMsgs += '<li class="success-msg-li">' + successList[i] + '</li>';
        }
        successListMsgs += '</ul>';
    } else if (successList && jQuery.type(successList) == 'string') {
        successListMsgs += '<ul class="success-msg-ul"><li class="success-msg-li">' + successList + '</li></ul>';
    }

    $('.log-msg-wrapper').addClass('successlist').removeClass('errorlist').html(successListMsgs);

    if (callback && typeof callback == 'function') {
        setTimeout(function() {
            callback();
        }, 3000);
    }
}

function showError(caption, errorList, selector) {

    $('.log-msg-wrapper').removeClass('errorlist');
    $('.log-msg-wrapper').html('');
    var errorListMsgs = '';
    if (caption) {
        errorListMsgs += '<h4 class="error-msg-caption">' + caption + '</h4>';
    }

    if (errorList && errorList.length > 0) {
        errorListMsgs += '<ul class="error-msg-ul">';
        for (var i = 0; i < errorList.length; i++) {
            errorListMsgs += '<li class="error-msg-li">' + errorList[i] + '</li>';
        }
        errorListMsgs += '</ul>';
    } else if (errorList && jQuery.type(errorList) == 'string') {
        errorListMsgs += '<ul class="error-msg-ul"><li class="error-msg-li">' + errorList + '</li></ul>';
    }

    if (selector !== undefined && selector != "") {
        selector.addClass('errorlist').removeClass('successlist').html(errorListMsgs);
    } else {
        $('.log-msg-wrapper').addClass('errorlist').removeClass('successlist').html(errorListMsgs);
    }


    $([document.documentElement, document.body]).animate({
        scrollTop: $(".log-msg-wrapper").offset().top - 50
    }, 500);
}

function resetForm(form) {
    $(form).get(0).reset();
}

function refreshPage() {
    window.location.href = '';
}

function showLoader(loadingtext) {
    $('#loader').stop().show();
}

function hideLoader() {
    $('#loader').stop().hide();
}

function ajaxUpdate(Url, data, callBack, noLoader) {
    if (!noLoader) {
        showLoader();
    }
    $.ajax({
        type: 'POST',
        url: Url,
        cache: false,
        data: data,
        dataType: 'json',
        success: callBack,
        error: formResponseError
    });
}

function ajaxFetch(Url, data, callBack, noLoader) {
    //showLoader();
    if (!noLoader) {
        showLoader();
    }
    $.ajax({
        type: 'POST',
        url: Url,
        data: data,
        dataType: 'html',
        success: callBack,
        error: formResponseError
    });
}

function baseurl() {
    return $.trim($('meta[name="base-url"]').attr('content'));
}

function dd($val) {
    console.log($val);
}