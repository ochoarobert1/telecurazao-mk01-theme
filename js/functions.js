jQuery(document).ready(function ($) {
    "use strict";
    var date = new Date();
    date.setDate(date.getDate());
    jQuery("body").niceScroll();
    jQuery('#ads_start_date').datepicker({
        todayBtn: true,
        startView: 0,
        startDate: date
    });
}); /* end of as page load scripts */

jQuery('.btn-menu').on('click touchstart', function () {
    "use strict";
    jQuery('.header-mobile-content').toggleClass('header-mobile-content-hidden');
});

jQuery("input[name='advertisement_type']").change(function () {
    if (jQuery(this).val() == 'ads_upload') {
        jQuery('#checkout_url_file_wrapper').removeClass('checkout-hidden');
        jQuery('#commercial_request_production').addClass('checkout-hidden');
        jQuery('body').trigger('update_checkout');
    }
    if (jQuery(this).val() == 'ads_file') {
        jQuery('#checkout_url_file_wrapper').addClass('checkout-hidden');
        jQuery('#commercial_request_production').addClass('checkout-hidden');
        jQuery('body').trigger('update_checkout');
    }
    if (jQuery(this).val() == 'ads_production') {
        jQuery('#commercial_request_production').removeClass('checkout-hidden');
        jQuery('#checkout_url_file_wrapper').addClass('checkout-hidden');
        jQuery('body').trigger('update_checkout');
    }
    jQuery("body").getNiceScroll().resize();
});

jQuery(document).on('click', '.checkout-support', function (e) {
    //    var querytype = jQuery('.support-query').val();
    var file_data = jQuery('#sortpicture').prop('files')[0];

    var form_data = new FormData();
    //    if (supporttitle == '') {
    //        jQuery('.support-title').css({"border": "1px solid red"})
    //        return false;
    //    } else {
    //        jQuery('.support-title').css({"border": "1px solid #e3ecf0"})
    //    }

    form_data.append('file', file_data);
    form_data.append('action', 'md_support_save');

    var ext = jQuery('#sortpicture').val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['mp4', 'avi', 'mkv', 'mpg', 'mov']) == -1) {
        jQuery('.checkout_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> You have used an invalid file extension');
        return;
    }

    jQuery.ajax({
        url: admin_url.ajax_url,
        type: 'post',
        contentType: false,
        processData: false,
        data: form_data,
        xhr: function () {
            var myXhr = jQuery.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', progress, false);
            }
            return myXhr;

        },
        beforeSend: function () {
            jQuery('.checkout_url_file_handler_progress').addClass('checkout_url_file_handler_progress_shown');
        },
        success: function (response) {
            jQuery('.checkout_url_file_handler_progress').removeClass('checkout_url_file_handler_progress_shown');
            jQuery('#checkout_url_progress_bar').css('width', '0%');
            jQuery('.video_upload_url_file_handler_success').html('<i class="fa fa-check-circle"></i> File submitted successfully');
            jQuery('#checkout_url_file').val(response);
        },
        error: function (response) {
            jQuery('.video_upload_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> File not submitted');
        }
    });
});

jQuery(document).on('click', '.audio-support', function (e) {
    //    var querytype = jQuery('.support-query').val();
    var file_data = jQuery('#audio_sortpicture').prop('files')[0];

    var form_data = new FormData();
    //    if (supporttitle == '') {
    //        jQuery('.support-title').css({"border": "1px solid red"})
    //        return false;
    //    } else {
    //        jQuery('.support-title').css({"border": "1px solid #e3ecf0"})
    //    }

    form_data.append('file', file_data);
    form_data.append('action', 'md_support_save');

    var ext = jQuery('#audio_sortpicture').val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['mp3', 'wav', 'aac']) == -1) {
        jQuery('.audio_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> You have used an invalid file extension');
        return;
    }

    jQuery.ajax({
        url: admin_url.ajax_url,
        type: 'post',
        contentType: false,
        processData: false,
        data: form_data,
        xhr: function () {
            var myXhr = jQuery.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', progress, false);
            }
            return myXhr;

        },
        beforeSend: function () {
            jQuery('.audio_url_file_handler_progress').addClass('checkout_url_file_handler_progress_shown');
        },
        success: function (response) {
            jQuery('.audio_url_file_handler_progress').removeClass('checkout_url_file_handler_progress_shown');
            jQuery('#audio_url_progress_bar').css('width', '0%');
            jQuery('.audio_url_file_handler_success').html('<i class="fa fa-check-circle"></i> File submitted successfully');
            jQuery('#audio_url_file').val(response);
        },
        error: function (response) {
            jQuery('.audio_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> File not submitted');
        }
    });
});

jQuery(document).on('click', '.raw-support', function (e) {
    //    var querytype = jQuery('.support-query').val();
    var file_data = jQuery('#raw_sortpicture').prop('files')[0];

    var form_data = new FormData();
    //    if (supporttitle == '') {
    //        jQuery('.support-title').css({"border": "1px solid red"})
    //        return false;
    //    } else {
    //        jQuery('.support-title').css({"border": "1px solid #e3ecf0"})
    //    }

    form_data.append('file', file_data);
    form_data.append('action', 'md_support_save');

    var ext = jQuery('#raw_sortpicture').val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['mp4', 'avi', 'mkv', 'mpg', 'mov']) == -1) {
        jQuery('.raw_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> You have used an invalid file extension');
        return;
    }

    jQuery.ajax({
        url: admin_url.ajax_url,
        type: 'post',
        contentType: false,
        processData: false,
        data: form_data,
        xhr: function () {
            var myXhr = jQuery.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', progress, false);
            }
            return myXhr;

        },
        beforeSend: function () {
            jQuery('.raw_url_file_handler_progress').addClass('checkout_url_file_handler_progress_shown');
        },
        success: function (response) {
            jQuery('.raw_url_file_handler_progress').removeClass('checkout_url_file_handler_progress_shown');
            jQuery('#raw_url_progress_bar').css('width', '0%');
            jQuery('.raw_url_file_handler_success').html('<i class="fa fa-check-circle"></i> File submitted successfully');
            jQuery('#raw_url_file').val(response);
        },
        error: function (response) {
            jQuery('.raw_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> File not submitted');
        }
    });
});

jQuery(document).on('click', '.logo-support', function (e) {
    //    var querytype = jQuery('.support-query').val();
    var file_data = jQuery('#logo_sortpicture').prop('files')[0];

    var form_data = new FormData();
    //    if (supporttitle == '') {
    //        jQuery('.support-title').css({"border": "1px solid red"})
    //        return false;
    //    } else {
    //        jQuery('.support-title').css({"border": "1px solid #e3ecf0"})
    //    }

    form_data.append('file', file_data);
    form_data.append('action', 'md_support_save');

    var ext = jQuery('#logo_sortpicture').val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['jpg', 'png', 'gif', 'psd']) == -1) {
        jQuery('.raw_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> You have used an invalid file extension');
        return;
    }

    jQuery.ajax({
        url: admin_url.ajax_url,
        type: 'post',
        contentType: false,
        processData: false,
        data: form_data,
        xhr: function () {
            var myXhr = jQuery.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', progress, false);
            }
            return myXhr;

        },
        beforeSend: function () {
            jQuery('.logo_url_file_handler_progress').addClass('checkout_url_file_handler_progress_shown');
        },
        success: function (response) {
            jQuery('.logo_url_file_handler_progress').removeClass('checkout_url_file_handler_progress_shown');
            jQuery('#logo_url_progress_bar').css('width', '0%');
            jQuery('.logo_url_file_handler_success').html('<i class="fa fa-check-circle"></i> File submitted successfully');
            jQuery('#logo_url_file').val(response);
        },
        error: function (response) {
            jQuery('.logo_url_file_handler_success').html('<i class="fa fa-times-circle error"></i> File not submitted');
        }
    });
});


function progress(e) {

    if (e.lengthComputable) {
        var max = e.total;
        var current = e.loaded;

        var Percentage = (current * 100) / max;

        jQuery('#checkout_url_progress_bar').css('width', Percentage + '%');
    }
}

jQuery('.btn-navbar').on('click touchstart', function (event) {
    "use strict";
    jQuery('.cart-content').toggleClass('cart-hidden');
});
