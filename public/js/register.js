var verifyCallback = function (response) {

};
var widgetId1;
var widgetId2;
var onloadCallback = function () {

    var correctCaptcha_login = function (response) {
        $("#txtRecaptcha1").val(response);
    };
    var correctCaptcha_register = function (response) {
        $("#txtRecaptcha2").val(response);
    };

    widgetId1 = grecaptcha.render('recaptcha1', {
        'sitekey': '6LfGZQMTAAAAAFLsy0d1IHi4zzhsow0F95Y2vUOz',
        'theme': 'light',
        'callback': correctCaptcha_login
    });

    widgetId2 = grecaptcha.render('recaptcha2', {
        'sitekey': '6LfGZQMTAAAAAFLsy0d1IHi4zzhsow0F95Y2vUOz',
        'theme': 'light',
        'callback': correctCaptcha_register
    });

};

$(document).ready(function () {


    $("input[name='terms-check']").change(function () {
        $('#txtRegisterTerms').val($(this).is(':checked'));
    });
    $("input[name='privacy-check']").change(function () {
        $('#txtRegisterPrivacy').val($(this).is(':checked'));
    });

    $("input[name='aml-check']").change(function () {
        $('#txtRegisterAML').val($(this).is(':checked'));
    });


});
