$(document).ready(function () {


    var height = 430;
    $("#pnlFail2").hide();
    $("#pnlSuccess2").hide();

    $("#btnQuestion").click(function () {
        return false;
    });

    $(".dropdown-toggle").dropdown();

    $("[name='special-effects']").bootstrapSwitch();
    $("input[name='special-effects']").on('switchChange.bootstrapSwitch', function (event, state) {
        $("#txtEffects").val(state);
    });

    $("[name='privacy_profit']").bootstrapSwitch();
    $("input[name='privacy_profit']").on('switchChange.bootstrapSwitch', function (event, state) {
        $("#txtPrivacyProfit").val(state);
    });

    $("[name='privacy_high']").bootstrapSwitch();
    $("input[name='privacy_high']").on('switchChange.bootstrapSwitch', function (event, state) {
        $("#txtPrivacyHigh").val(state);
    });

    $("[name='privacy_bets']").bootstrapSwitch();
    $("input[name='privacy_bets']").on('switchChange.bootstrapSwitch', function (event, state) {
        $("#txtPrivacyBets").val(state);
    });

    $("[name='privacy_stats']").bootstrapSwitch();
    $("input[name='privacy_stats']").on('switchChange.bootstrapSwitch', function (event, state) {
        $("#txtPrivacyStats").val(state);
    });

    $("[name='hotkeys']").bootstrapSwitch();
    $("input[name='hotkeys']").on('switchChange.bootstrapSwitch', function (event, state) {
        $("#txtHotKeys").val(state);
    });

    //$("[name='mailing-check']").bootstrapSwitch();
    //$("input[name='mailing-check']").on('change click', function (event, state) {
    //    $("#txtPassMailing").val(state);
    //    console.log(state);
    //});


    $("input[name='mailing-check']").change(function () {
        $('#txtPassMailing').val($(this).is(':checked'));
    });

    $("[name='twofactor-check']").bootstrapSwitch();
    $("input[name='twofactor-check']").on('switchChange.bootstrapSwitch', function (event, state) {
        if (state == true) {
            $("#twofactor").show("slow");
        }
        else {
            $("#txtTwoFactor1").val("");
            $("#twofactor").hide("slow");
        }
    });

    //$("#btnTwoFactor").click(function () {
    //    $("#btnTwoFactor").hide();
    //    $("#twofactor2").slideDown("slow");
    //    return false;
    //});

    $(".dropdown-menu li a").click(function () {
        var style1 = $(this).data("style");
        var name = $(this).data("name");
        var coin = $(this).data("coin");
        var currency = $(this).data("currency");
        var timeout = $(this).data("timeout");
        var exclude = $(this).data("exclude");

        if (style1 != null) {
            $("#txtStyle").val(style1);
            $("#style_name").html(name + "  ");
        }

        if (currency != null) {
            $("#txtCurrency").val(currency);
            $("#currency_name").html(currency + "  ");
        }

        if (coin != null) {
            $("#txtInvCoin").show();
            $("#txtInvCoin").text(coin);
        }

        if (timeout != null) {
            $("#txtTimeout").val(timeout);
            $("#timeout_name").html(name + "  ");
        }

        if (exclude != null) {
            $("#txtExclude").val(exclude);
            $("#exclude_name").html(name + "  ");
        }
    });

    $("#btnPass1").text("Reset");

    $("#txtInvCoin").hide();

});