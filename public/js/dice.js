function newSeed() {
    getProvablyFair(coin);
    generateNewClientSeed();
}

$(document).ready(function () {
    let calculate_maximum_payout = function (under, current) {
        return Math.floor(((100 - Edge) / (100 * (under / 100))));
    }

    var Idc = idc;
    var Longid = getCookie("LongId");
    var Minbid = parseFloat(minbid);
    var Maxwin = parseFloat(maxwin);
    var Edge = parseFloat(edge);
    var Minratio = 1.02;
    var Maxratio = calculate_maximum_payout(0.010);
    var MyBets = [];
    var AllBets = [];
    var AllBetsId = [];
    var Wait = false; //bet runing
    var Wait1 = false; //mouse over
    var Runing = false;
    var Interval = null;
    var CurrentBet = 0;
    var BaseBet = Minbid;
    var BetCount = 1000000;
    var Active_tab = "All bets";
    var TabChange = true;
    var MyBetIdMax = 0;
    var MyBetCount = 1;
    var AllBetIdMax = 0;
    var AllBetCount = 1;
    var AllBetsAdded = 0;
    var HighRoll = 0;
    var Profit = 0;
    var Time = 1000;
    var HighLow = true;
    var Effects = effects;
    var AllBetsTime;
    var MyBetsTime;
    var Style = style;
    var AutoBet;
    var ConfirmAmount = parseFloat(highrollamount);
    var TypeClick = "1";
    var Width = $(window).width();
    var timer1;
    var timer2;
    var FirstTime = true;
    var diceAutobetCookieName = Idc + 'dice_autobet';

    var AllBetsSize = Cookies.get("dicesize"); // all bets filtering
    if (AllBetsSize != undefined) {
        if (AllBetsSize == "high") {
            $("#btnHighBets").addClass("active");
        }
        else if (AllBetsSize == "all") {
            $("#btnAllBets").addClass("active");
        }
        else {
            AllBetsSize = "medium";
            $("#btnMediumBets").addClass("active");
        }
    }
    else {
        if (isMobile()) {
            Cookies.set("dicesize", "high", { expires: 60000 });
            AllBetsSize = "high";
            $("#btnHighBets").addClass("active");
        }
        else {
            Cookies.set("dicesize", "medium", { expires: 60000 });
            AllBetsSize = "medium";
            $("#btnMediumBets").addClass("active");
        }
    };

    $("#btnHighBets").click(function () {
        AllBetsSize = "high";
        $("#btnHighBets").addClass("active");
        $("#btnMediumBets").removeClass("active");
        $("#btnAllBets").removeClass("active");
        Cookies.set("dicesize", "high", { expires: 60000 });
    });

    $("#btnMediumBets").click(function () {
        AllBetsSize = "medium";
        $("#btnHighBets").removeClass("active");
        $("#btnMediumBets").addClass("active");
        $("#btnAllBets").removeClass("active");
        Cookies.set("dicesize", "medium", { expires: 60000 });
    });

    $("#btnAllBets").click(function () {
        AllBetsSize = "all";
        $("#btnHighBets").removeClass("active");
        $("#btnMediumBets").removeClass("active");
        $("#btnAllBets").addClass("active");
        Cookies.set("dicesize", "all", { expires: 60000 });
    });

    $("#txtManualResultNumber").hide();
    $("#txtAutoResultNumber").hide();
    $("#divManualMessage").hide();
    $("#divAutoMessage").hide();
    $("#manual_line_loading").hide();
    $("#auto_line_loading").hide();
    $("#profit_group").hide();
    $("#allbets_pause").hide();
    $("#yourbets_pause").hide();



    $(".number").focusout(function () {
        var val = $(this).val();
        var x = val;
        try {
            //x = parseFloat(val);
            $(this).removeClass("red_font");
        }
        catch (e) {
            $(this).addClass("red_font");
            x = 0;
        }
        if (isNaN(x)) {
            x = 0;
        }
        $(this).val(x);
    });


    $("#btnConfirmBet").click(function () {
        showConfirmManual();
        ConfirmAmount = parseFloat($("#txtBet").val());

        if ($('#chkConfirmBetAsk').prop("checked")) {
            setCookie("confirmbet", "true", 1000);
            var temp = getCookie("confirmbet");
        }

        if (TypeClick == "1") {
            $("#btnRollOver").click();
        }
        else {
            $("#btnRollUnder").click();
        }
        return false;
    });

    $("#last_bets").mouseover(function () {
        $("#allbets_pause").show();
        Wait1 = true;
    });
    $("#last_bets").mouseout(function () {
        $("#allbets_pause").hide();
        Wait1 = false;
    });
    //$("#my_bets").mouseover(function () {
    //    $("#yourbets_pause").show();
    //    Wait1 = true;
    //});
    //$("#my_bets").mouseout(function () {
    //    $("#yourbets_pause").hide();
    //    Wait1 = false;
    //});

    const manual_validate = function () { // manual validations
        var msg = "";
        var result = true;
        var bid = $("#txtBet").val();
        var multiplier = $("#txtMultiplier").val();
        var chance = $("#txtChance").val();

        $("#txtBet").removeClass("red_font");
        $("#txtMultiplier").removeClass("red_font");
        $("#txtWinAmount").removeClass("red_font");
        $("#txtChance").removeClass("red_font");

        if (bid < Minbid) {
            $("#txtBet").addClass("red_font");
            msg = msg + " Ставка слишком низкая. Минимальная ставка: " + Minbid.toFixed(2) + " " + coinname + ".";
            result = false;
        }
        if (bid > Balance) {
            $("#txtBet").addClass("red_font");
            msg = msg + " Ставка больше вашего баланса.";
            result = false;
        }
        if (multiplier < Minratio) {
            $("#txtMultiplier").addClass("red_font");
            $("#txtChance").addClass("red_font");
            msg = msg + " Коэффициент выплат слишком мал. Минимальное соотношение: " + Minratio + "x.";
            result = false;
        }
        if (multiplier > Maxratio) {
            $("#txtMultiplier").addClass("red_font");
            $("#txtChance").addClass("red_font");
            msg = msg + " Коэффициент выплат слишком велик. Максимальное соотношение: " + Maxratio + "x.";
            result = false;
        }
        if (((multiplier * bid) - bid).toFixed(2) > Maxwin) {
            $("#txtWinAmount").addClass("red_font");
            msg = msg + " Измените ставку или выплату. Максимальный выигрыш установлен на: " + Maxwin + " " + coinname + ".";
            result = false;
        }
        showMessageManual(msg);
        return result;
    };

    const auto_validate = function (type) { // auto validations
        var msg = "";
        var result = true;
        var bid = $("#txtAutoBet").val();
        var multiplier = $("#txtAutoMultiplier").val();

        $("#txtAutoBet").removeClass("red_font");
        $("#txtAutoMultiplier").removeClass("red_font");
        $("#txtWinInc").removeClass("red_font");
        $("#txtLossInc").removeClass("red_font");
        $("#txtMaxRolls").removeClass("red_font");
        $("#txtRollSec").removeClass("red_font");
        $("#txtLossDec").removeClass("red_font");
        $("#txtWinDec").removeClass("red_font");
        $("#txtLargerThan").removeClass("red_font");
        $("#txtSmallerThan").removeClass("red_font");
        $("#txtMinBet").removeClass("red_font");
        $("#txtMaxBet").removeClass("red_font");

        if (type == "1" || type == "") {
            if (bid < Minbid) {
                $("#txtAutoBet").addClass("red_font");
                msg = msg + " Ставка слишком низкая. Минимальная ставка: " + Minbid.toFixed(2) + " " + coinname + ".";
                result = false;
            }
            if (bid > Balance) {
                $("#txtAutoBet").addClass("red_font");
                msg = msg + " Ставка больше вашего баланса.";
                result = false;
            }
            if (multiplier < Minratio) {
                $("#txtAutoMultiplier").addClass("red_font");
                msg = msg + " Коэффициент выплат слишком мал. Минимальное соотношение: " + Minratio + "x.";
                result = false;
            }
            if (multiplier > Maxratio) {
                $("#txtAutoMultiplier").addClass("red_font");
                msg = msg + " Коэффициент выплат слишком велик. Максимальное соотношение: " + Maxratio + "x.";
                result = false;
            }
            if (((multiplier * bid) - bid).toFixed(2) > Maxwin) {
                msg = msg + " Измените ставку или выплату. Максимальный выигрыш установлен на: " + Maxwin + " " + coinname + ".";
                result = false;
            }
        }
        if (type == "2" || type == "") {
            var temp = $("#txtWinInc").val();
            if (temp < 0 || temp > 10000) {
                $("#txtWinInc").addClass("red_font");
                msg = msg + " Введите значение от 0 до 10000.";
                result = false;
            }

            var temp = $("#txtWinDec").val();
            if (temp < 0 || temp > 10000) {
                $("#txtWinDec").addClass("red_font");
                msg = msg + " Введите значение от 0 до 10000.";
                result = false;
            }

            var temp = $("#txtLossInc").val();
            if (temp < 0 || temp > 10000) {
                $("#txtLossInc").addClass("red_font");
                msg = msg + " Введите значение от 0 до 10000.";
                result = false;
            }

            var temp = $("#txtLossDec").val();
            if (temp < 0 || temp > 10000) {
                $("#txtLossDec").addClass("red_font");
                msg = msg + " Введите значение от 0 до 10000.";
                result = false;
            }

            var temp = $("#txtMaxRolls").val();
            if (temp < 1 || temp > BetCount) {
                $("#txtMaxRolls").addClass("red_font");
                msg = msg + " Введите значение от 1 до " + BetCount + ".";
                result = false;
            }

            var temp = $("#txtRollSec").val();
            if (temp < 10 || temp > 5000) {
                $("#txtRollSec").addClass("red_font");
                msg = msg + " Введите значение от 10 до 5000 мс";
                result = false;
            }

            if ($("#txtWinInc").val() == "" || $("#txtLossInc").val() == "") {
                msg = msg + " Неверная сумма увеличения ставки.";
                result = false;
            }

            if ($("#txtWinDec").val() == "" || $("#txtLossDec").val() == "") {
                msg = msg + " Неверная сумма увеличения ставки.";
                result = false;
            }

            var temp = parseFloat($("#txtMaxBet").val());
            if (bid > temp && temp > 0) {
                $("#txtMaxBet").addClass("red_font");
                $("#txtAutoBet").addClass("red_font");
                msg = msg + " Ставка больше установленной максимальной ставки.";
                result = false;
            }

            var temp = parseFloat($("#txtMinBet").val());
            if (bid < temp && temp > 0) {
                $("#txtMinBet").addClass("red_font");
                $("#txtAutoBet").addClass("red_font");
                msg = msg + " Ставка меньше установленной минимальной ставки.";
                result = false;
            }
        }
        if (type == "3") {
            if (bid < Minbid) {
                msg = msg + " Ставка слишком мала. Минимальная ставка: " + Minbid.toFixed(2) + " " + coinname + ".";
                result = false;
            }

            if (bid > Balance) {
                msg = msg + " Ставка была больше вашего баланса.";
                result = false;
            }

            if (bid <= 0) {
                msg = msg + " Ставка была слишком маленькой.";
                result = false;
            }

            if (Math.round(((multiplier * bid) - bid), 2) > Maxwin) {
                msg = msg + " Ставка была больше максимально допустимой. Максимальный выигрыш установлен на: " + Maxwin + " " + coinname + ".";
                result = false;
            }

            var temp = $("#txtSmallerThan").val();
            if (Balance < temp) {
                msg = msg + " Баланс меньше лимита.";
                result = false;
            }

            var temp = $("#txtLargerThan").val();
            if (temp != 0 && Balance > temp) {
                msg = msg + " Баланс превысил лимит.";
                result = false;
            }
        }

        if (result) {
            updateDiceCookie();
        }

        showMessageAuto(msg);
        return result;
    };

    showMessageManual = function (msg) {
        $("#divConfirmBet").hide();
        if (msg.length > 0) {
            $("#divManualMessage p").html(msg);
            $("#divManualMessage").delay(500).show();
        }
        else {
            $("#divManualMessage").delay(500).hide();
        }
    };

    showConfirmManual = function () {
        $("#divManualMessage").hide();
        $("#divConfirmBet").delay(500).show();
    };

    showMessageAuto = function (msg) {
        $("#divAutoTimeout").hide();
        if (msg.length > 0) {
            $("#divAutoMessage p").html(msg);
            $("#divAutoMessage").delay(500).show();
        }
        else {
            $("#divAutoMessage").delay(500).hide();
        }
    };

    showTimeoutAuto = function (msg) {
        $("#divAutoMessage").hide();
        $("#divAutoTimeout").delay(500).show();
    };

    convert_number = function (number, fixed) {
        if (fixed == 0) {
            var result = number.toLocaleString('en-US');
        }
        else {
            var result = number.toFixed(fixed).toLocaleString('en-US');
        }

        return result;
    };

    showLoadingManual = function () {
        Wait = true;
        $("#txtManualResultNumber").hide();
        $("#manual_line_loading").show();
    }

    hideLoadingManual = function (time_before, balance, type) {
        var time = new Date();
        var time_after = time.getTime();
        var diff = time_after - time_before;

        //if (diff < 800) {
        //    setTimeout(
        //      function () {
        Wait = false;
        $("#manual_line_loading").hide();
        if (type == 1) {
            $("#txtManualResultNumber").fadeIn("slow");
        }
        showBalance(balance, idc);
        getBets();
        Runing = false;
        //      }, 800 - diff);
        //}
        //else {
        //    Wait = false;
        //    $("#manual_line_loading").hide();
        //    if (type == 1) {
        //        $("#txtManualResultNumber").fadeIn("slow");
        //    }
        //    showBalance(balance, coinname);
        //    getBets();
        //    Runing = false;
        //}
    }

    reCalc = function (type) {
        if (type == "1") // bid
        {
            var bid = parseFloat($("#txtBet").val());
            var multiplier = parseFloat($("#txtMultiplier").val());
            if (bid > 0) {
                var temp = ((bid * multiplier) - bid).toFixed(2);
                $("#txtWinAmount").val(temp);
            }
            else {
                $("#txtWinAmount").val(0);
            }
        }
        else if (type == "2") // multiplier
        {
            var bid = parseFloat($("#txtBet").val());
            var multiplier = parseFloat($("#txtMultiplier").val());

            var temp = ((100.000 - Edge) / multiplier);
            temp = (Math.floor(temp * 1000) / 1000).toFixed(3);

            if (multiplier > 0) {
                $("#txtChance").val(temp);
                $("#btnRollUnder span").html("Меньше<br />" + temp);
                var temp2 = (99.999 - temp).toFixed(3);
                $("#btnRollOver span").html("Больше<br />" + temp2);
                var temp1 = ((bid * multiplier) - bid).toFixed(2);
                if (temp1 < 0.00000001) {
                    temp1 = 0;
                }
                $("#txtWinAmount").val(temp1);
            }
            else {
                $("#txtChance").val(0);
                $("#txtWinAmount").val(0);
                $("#btnRollUnder span").html("Меньше<br /> 0.000");
                $("#btnRollOver span").html("Больше<br /> 100.000");
            }
        }
        else if (type == "3") // chance %
        {
            var bid = parseFloat($("#txtBet").val());
            var chance = parseFloat($("#txtChance").val());

            var multiplier = (parseFloat((100.000 - Edge) / chance)).toFixed(4);
            $("#txtMultiplier").val(multiplier);
            var temp = ((bid * multiplier) - bid).toFixed(2);
            if (temp < 0.00000001) {
                temp = 0;
            }
            $("#txtWinAmount").val(temp);
            var temp1 = ((100.000 - Edge) / multiplier);
            temp1 = (Math.ceil(temp1 * 1000) / 1000).toFixed(3);
            $("#btnRollUnder span").html("Меньше<br />" + temp1);
            var temp2 = (99.999 - temp1).toFixed(3);
            $("#btnRollOver span").html("Больше<br />" + temp2);
        }
        else if (type == "4") // multiplier new
        {
            var bid = parseFloat($("#txtBet").val());
            var multiplier = parseFloat($("#txtMultiplier").val());

            var temp = $("#txtChance").val();

            if (multiplier > 0) {
                //$("#txtChance").val(temp);
                $("#btnRollUnder span").html("Меньше<br />" + temp);
                var temp2 = (99.999 - temp).toFixed(3);
                $("#btnRollOver span").html("Больше<br />" + temp2);
                var temp1 = ((bid * multiplier) - bid).toFixed(2);
                if (temp1 < 0.00000001) {
                    temp1 = 0;
                }
                $("#txtWinAmount").val(temp1);
            }
            else {
                $("#txtChance").val(0);
                $("#txtWinAmount").val(0);
                $("#btnRollUnder span").html("Меньше<br /> 0.000");
                $("#btnRollOver span").html("Больше<br /> 100.000");
            }
        }
    };

    reCalcAuto = function (type) {
        var bid = parseFloat($("#txtAutoBet").val());
        var multiplier = parseFloat($("#txtAutoMultiplier").val());

        var temp = ((100.000 - Edge) / multiplier);
        temp = (Math.floor(temp * 1000) / 1000).toFixed(3);

        if (multiplier > 0) {
            $("#txtAutoRollUnder").val(temp);
            var temp2 = (99.999 - temp).toFixed(3);
            $("#txtAutoRollOver").val(temp2);
        }
        else {
            $("#txtAutoRollUnder").val(0);
            $("#txtAutoRollOver").val(0);
        }
    };

    updateDiceCookie = function () {
        let fieldsArr = { name: {}, id: {} };

        let skipSettings = "txtAutoRollOver,txtAutoRollUnder";

        $('#auto_bet .well').eq(0).find('input:radio:checked').each(function () {
            if (skipSettings.indexOf($(this)[0].name) < 0) {
                fieldsArr.name[$(this)[0].name] = $(this).val();
            }
        });
        $('#auto_bet .well').eq(0).find('input.form-control[id]').each(function () {
            if (skipSettings.indexOf($(this)[0].id) < 0) {
                fieldsArr.id[$(this)[0].id] = $(this).val();
            }
        });

        setCookie(diceAutobetCookieName, JSON.stringify(fieldsArr), 30);
    }

    getBets = function () {
        if (Active_tab == "All bets") {
            getAllBets();
        }

        //if (Active_tab == "Your bets") {
        //    getLastBets(Longid, "2");
        //}
    }

    const getAllBets = () => {
        if (Wait === true) return;

        $.ajax({
            type: 'POST',
            url: '/dice/getAllLastBets',
            contentType: "application/json",
            success: function (msg) {
                if (msg.length > 0) {
                    addToTable(msg, "2");
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    };


    const getLastBets = (longid, type) => {
        if (Wait == true) return;

        $.ajax({
            type: 'POST',
            url: '/dice/getLastBets',
            dataType: 'json',
            success: function (msg) {
                if (msg.d.length > 0) {
                    addToTable(msg.d, "1");
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    getLastBets(Longid, "1");

    getProvablyFair = function (longid, coin) {
        $.ajax(
            {
                type: 'POST',
                url: '/stats.asmx/GetFairDice',
                data: '{idc:"' + coin + '"}',
                contentType: "application/json",
                success: function (msg) {
                    if (msg.d.length > 0) {
                        var content = JSON.parse(msg.d);
                        $("#txtLastServerSeed256").val(content.PreviousServerSeedSHA256);
                        $("#txtNextServerSeed256").val(content.NextServerSeedSHA256);
                        $("#txtLastServerSeed").val(content.PreviousServerSeed);
                        $("#txtLastClientSeed").val(content.PreviousClientSeed);
                    }
                },
                error: function (msg) {
                    console.log("not ok....");
                }
            });
    };

    provably_fair_reload = function () {
        generateNewClientSeed(); // generate new client seed
    }
    provably_fair_reload();

    getBalance(Idc);
    getBets();
    getProvablyFair(Longid, Idc);

    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        var str = e.target.text;
        str = str.trim();
        //if (str == "Provably fair") {
        //    getProvablyFair(Longid, Idc);
        //}
        TabChange = true;
        var active = "Active_tab";

        if (str == "All bets") {
            Active_tab = "All bets";
        }
        if (str == "Your bets") {
            Active_tab = "Your bets";
        }
    })

    activate_user_bets = function () {
        $('.nav-tabs a[href="#my_bets"]').tab('show');
    }

    refreshBets = function () {
        getBets();
        setTimeout(function () { refreshBets(); }, 2000);
    }
    refreshBets();

    setDefault = function () {

        $("#txtBet").val(Minbid.toFixed(2));
        $("#txtMultiplier").val((2).toFixed(4));

        let currentCookie = getCookie(diceAutobetCookieName);

        if (currentCookie != '') {
            currentCookie = JSON.parse(currentCookie);

            let nKeys = Object.keys(currentCookie.name);
            let iKeys = Object.keys(currentCookie.id);

            for (let i = 0; i < nKeys.length; i++) {
                $('#auto_bet .well').eq(0).find('input:radio[name=' + nKeys[i] + '][value=' + currentCookie.name[nKeys[i]] + ']').attr('checked', true);
            }
            for (let j = 0; j < iKeys.length; j++) {
                $('#auto_bet .well').eq(0).find('input#' + iKeys[j]).val(currentCookie.id[iKeys[j]]);
            }
        }
        else {
            $("#txtAutoBet").val(Minbid.toFixed(2));
            $("#txtAutoMultiplier").val((2).toFixed(4));
            $("#txtWinInc").val(100);
            $("#txtLossInc").val(100);
            $("#txtWinDec").val(20);
            $("#txtLossDec").val(20);
            $("#txtMaxRolls").val(BetCount);
            $("#txtRollSec").val(100);
            $("#txtSmallerThan").val(0);
            $("#txtLargerThan").val(0);
            $("#txtMaxBet").val(0);
            $("#txtMinBet").val(Minbid.toFixed(2));

            $('input:radio[name="rdWin"]').filter('[value="return"]').attr('checked', true);
            $('input:radio[name="rdLoss"]').filter('[value="return"]').attr('checked', true);
            $('input:radio[name="rdRoll"]').filter('[value="over"]').attr('checked', true);
        }

        reCalc("2");
        reCalcAuto();
    };
    setDefault();

    $("#table_last_bets tbody").on("click", "tr", function () {
        $(this).toggleClass("active_row");
    });
    $("#table_my_bets tbody").on("click", "tr", function () {
        $(this).toggleClass("active_row");
    });

    $("#btnRollUnder").click(function (evt) {
        manual_bet("2");
    });

    $("#btnRollOver").click(function (evt) {
        manual_bet("1");
    });

    manual_bet = function (type) {
        if (Runing == true) {
            return;
        }

        var confirmbet = false; // user can disable high amount confirmation
        if (getCookie("confirmbet") == "true") {
            confirmbet = true;
        }

        if (parseFloat($("#txtBet").val()) > ConfirmAmount && !confirmbet) {
            TypeClick = type;
            showConfirmManual();
            return;
        }

        Runing = true;
        activate_user_bets();
        var bet = $("#txtBet").val();
        var multiplier = $("#txtMultiplier").val();
        if (manual_validate() == true) {
            var clientseed = getClientSeed();
            getResultManual(Longid, Idc, bet, multiplier, type, clientseed);
        }
        else {
            Runing = false;
        }
    }

    start_click = function () {
        if (Runing) {
            return;
        }
        Profit = 0;
        Runing = true;
        CurrentBet = parseFloat($("#txtAutoBet").val()).toFixed(2);
        BaseBet = parseFloat($("#txtAutoBet").val()).toFixed(2);
        if (auto_validate("") == false) {
            auto_stop();
            return;
        }
        $("#auto_bet_left *").prop('disabled', true);
        $("#auto_bet_right *").prop('disabled', true);
        $("#auto_line_loading").show();
        Time = $("#txtRollSec").val();
        activate_user_bets();
        auto_bet();
    }

    $("#btnStart").on("click", function (e) {
        $(this).prop("disabled", true);
        start_click();
    });

    auto_bet = function () {
        if (Runing == false) {
            auto_stop();
        }
        else {
            $("#txtAutoBet").val(parseFloat(CurrentBet).toFixed(2));
            var multiplier = parseFloat($("#txtAutoMultiplier").val()).toFixed(4);

            if (auto_validate("3") == true) {
                var rdroll = $('input:radio[name=rdRoll]:checked').val();
                if (rdroll == "over") {
                    var type = "1";
                }
                else if (rdroll == "under") {
                    var type = "2";
                }
                else {
                    if (HighLow) {
                        var type = "1";
                    }
                    else {
                        var type = "2";
                    }
                }
                var clientseed = getClientSeed();
                getResultAuto(Longid, Idc, CurrentBet, multiplier, type, clientseed);
                Wait = false;
                getBets();
                Wait = true;
            }
            else {
                Runing = false;
                Wait = false;
                auto_stop();
            }
        }
    };

    auto_stop = function () {
        window.clearTimeout(AutoBet);
        $("window").clearQueue();
        Runing = false;
        Wait = false;
        CurrentBet = 0;
        $("#auto_bet_left *").prop('disabled', false);
        $("#auto_bet_right *").prop('disabled', false);

        $("#btnStop").prop('disabled', true);
        $("#btnStart").prop('disabled', true)
        timer1 = setTimeout(function () {
            $("#btnStart").prop('disabled', false);
            $("#btnStop").prop('disabled', false);
        }, 2000); // some users had issue if starting to soon

        $("#auto_line_loading").hide();
        $("#txtAutoBet").val(parseFloat(BaseBet).toFixed(2));
        getBets();
    }


    $("#btnStop").click(function () {
        $("#btnStop").prop('disabled', true);
        $("#btnStart").prop('disabled', true)
        auto_stop();
    });

    $("#txtBet").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        manual_validate();
        reCalc("1");
    });

    $("#txtMultiplier").keyup(function () {

        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);

        manual_validate();
        reCalc("2");
    });

    $("#txtMultiplier").focusout(function () {
        var chance = $("#txtChance").val();
        if (this.value > 300) {
            this.value = calculate_maximum_payout(chance, this.value);
        }
        this.value = parseFloat(this.value).toFixed(4);
        reCalc("1");
    });

    $("#txtAutoBet").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("1");
        reCalcAuto();
    });

    $("#txtAutoMultiplier").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("1");
        reCalcAuto("2");
    });

    $("#txtAutoMultiplier").focusout(function () {
        var chance = $("#txtAutoRollUnder").val();
        if (this.value > 300) {
            this.value = calculate_maximum_payout(chance, this.value);
        }
        this.value = parseFloat(this.value).toFixed(4);
    });

    $("#txtWinInc").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });

    $("#txtLossInc").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });


    $("#txtMaxRolls").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });


    $("#txtRollSec").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });

    $("#txtWinDec").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });

    $("#txtLossDec").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });

    $("#txtChance").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        manual_validate();
        reCalc("3");
    });

    $("#txtSmallerThan").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });

    $("#txtLargerThan").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        auto_validate("2");
    });

    $("#txtMaxBet").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
    });

    $("#txtMinBet").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
    });

    $("#btnBet1").click(function () { //min bid
        $("#txtBet").val(Minbid.toFixed(2));
        manual_validate();
        reCalc("1");
    });

    $("#btnBet2").click(function () { // bid / 2
        var bet = $("#txtBet").val();
        $("#txtBet").val((bet / 2).toFixed(2));
        if ((bet / 2) < Minbid) {
            $("#txtBet").val(Minbid.toFixed(2));
        }
        manual_validate();
        reCalc("1");
    });

    $("#btnBet3").click(function () { // bid * 2
        var bet = parseFloat($("#txtBet").val());
        var multiplier = parseFloat($("#txtMultiplier").val());
        $("#txtBet").val((bet * 2).toFixed(2));

        if ((bet * 2) > (Balance)) {
            $("#txtBet").val((Balance).toFixed(2));
        }
        manual_validate();
        reCalc("1");
    });

    $("#btnBet4").click(function () { //max bid
        var multiplier = parseFloat($("#txtMultiplier").val());

        $("#txtBet").val((Balance).toFixed(2));
        manual_validate();
        reCalc("1");
    });

    $("#btnPay1").click(function () { //min ratio
        $("#txtMultiplier").val(Minratio.toFixed(4));
        manual_validate();
        reCalc("2");
    });

    $("#btnPay2").click(function () { //-1 ratio
        var ratio = parseFloat($("#txtMultiplier").val());
        var chance = parseFloat($("#txtChance").val());
        if (((ratio - 1) < Minratio) || chance < 0.01) {
            $("#txtMultiplier").val(Minratio.toFixed(4));
        }
        else {
            if (ratio > 300) {
                chance = (chance + 0.001).toFixed(3);
                $("#txtChance").val(chance);
            }
            else {
                $("#txtMultiplier").val((ratio - 1).toFixed(4));
            }
        }
        manual_validate();
        if (ratio > 300) {
            $("#txtMultiplier").focusout();
            reCalc("4");
        }
        else {
            reCalc("2");
        }
    });

    $("#btnPay3").click(function () { //+1 ratio
        var ratio = parseFloat($("#txtMultiplier").val());
        if ((ratio + 1) > Maxratio) {
            $("#txtMultiplier").val((Maxratio).toFixed(4));
        }
        else {
            $("#txtMultiplier").val((ratio + 1).toFixed(4));
        }
        manual_validate();

        if (ratio > 300) {
            reCalc("2");
            $("#txtMultiplier").focusout();
        }
        else {
            reCalc("2");
        }

    });

    $("#btnPay4").click(function () { //max ratio
        $("#txtMultiplier").val(Maxratio.toFixed(4));
        manual_validate();
        reCalc("2");
    });

    $("#btnAutoBet1").click(function () { //min bid
        $("#txtAutoBet").val(Minbid.toFixed(2));
        auto_validate("1");
        reCalcAuto();
    });

    $("#btnAutoBet2").click(function () { // bid / 2
        var bet = $("#txtAutoBet").val();
        $("#txtAutoBet").val((bet / 2).toFixed(2));
        if ((bet / 2) < Minbid) {
            $("#txtAutoBet").val(Minbid.toFixed(2));
        }
        auto_validate("1");
        reCalcAuto();
    });

    $("#btnAutoBet3").click(function () { // bid * 2
        var bet = parseFloat($("#txtAutoBet").val());
        var multiplier = parseFloat($("#txtAutoMultiplier").val());
        $("#txtAutoBet").val((bet * 2).toFixed(2));

        if ((bet * 2) > (Balance)) {
            $("#txtAutoBet").val((Balance).toFixed(2));
        }
        auto_validate("1");
        reCalcAuto();
    });

    $("#btnAutoBet4").click(function () { //max bid
        var multiplier = parseFloat($("#txtAutoMultiplier").val());

        $("#txtAutoBet").val((Balance).toFixed(2));

        auto_validate("1");
        reCalcAuto();
    });

    $("#btnAutoPay1").click(function () { //min ratio
        $("#txtAutoMultiplier").val(Minratio.toFixed(4));
        auto_validate("1");
        reCalcAuto();
    });

    $("#btnAutoPay2").click(function () { //-1 ratio
        var ratio = parseFloat($("#txtAutoMultiplier").val());
        var chance = parseFloat($("#txtAutoRollUnder").val());
        if (((ratio - 1) < Minratio) || (chance < 0.01)) {
            $("#txtAutoMultiplier").val(Minratio.toFixed(4));
        }
        else {
            if (ratio > 300) {
                chance = (chance + 0.002).toFixed(3);
                $("#txtAutoRollUnder").val(chance);
            }
            else {
                $("#txtAutoMultiplier").val((ratio - 1).toFixed(4));
            }
        }
        auto_validate("1");
        if (ratio > 300) {
            $("#txtAutoMultiplier").focusout();
        }
        reCalcAuto();
    });

    $("#btnAutoPay3").click(function () { //+1 ratio
        var ratio = parseFloat($("#txtAutoMultiplier").val());
        if ((ratio + 1) > Maxratio) {
            $("#txtAutoMultiplier").val((Maxratio).toFixed(4));
        }
        else {
            $("#txtAutoMultiplier").val((ratio + 1).toFixed(4));
        }
        auto_validate("1");
        reCalcAuto();

        console.log($("#txtAutoMultiplier").val());

        $("#txtAutoMultiplier").focusout();
    });

    $("#btnAutoPay4").click(function () { //max ratio
        $("#txtAutoMultiplier").val(Maxratio.toFixed(4));
        auto_validate("1");
        reCalcAuto();
    });

    $(window).keyup(function (evt) {
        if (hotkeys == "False") {
            return;
        }
        var key = evt.which;
        if ($("#manual_bet").hasClass("active")) {
            if (key == "72") {
                $("#btnRollOver").click();
            }
            else if (key == "76") {
                $("#btnRollUnder").click();
            }
            else if (key == "81") {
                $("#btnBet1").click();
            }
            else if (key == "87") {
                $("#btnBet2").click();
            }
            else if (key == "69") {
                $("#btnBet3").click();
            }
            else if (key == "82") {
                $("#btnBet4").click();
            }
            else if (key == "65") {
                $("#btnPay1").click();
            }
            else if (key == "83") {
                $("#btnPay2").click();
            }
            else if (key == "68") {
                $("#btnPay3").click();
            }
            else if (key == "70") {
                $("#btnPay4").click();
            }
        }
    });

    getStatistic = function (longid, idc) {
        $.ajax(
            {
                type: 'GET',
                url: '/api/DiceStatistics/' + idc + '/' + longid,
                contentType: "application/json",
                success: function (msg) {
                    //var content = JSON.parse(msg.d);
                    $("#global_stats").html(msg.Stats);
                    $("#user_stats").html(msg.StatsUser);
                    $("#all_global_stats").html(msg.StatsAll);
                },
                error: function (msg) {
                    console.log("not ok....");
                }
            });
    };
    getStatistic(Longid, Idc);

    getTopPlayersAll = function (longid, idc) {
        getTopPlayers(Longid, Idc, "wagered");
        getTopPlayers(Longid, Idc, "bids");
        getTopPlayers(Longid, Idc, "profit");
        getTopPlayers(Longid, Idc, "tips");
        getTopPlayers(Longid, "All", "chat");
    };

    getTopPlayers = function (longid, idc, type) {
        $.ajax(
            {
                type: 'POST',
                url: '/stats.asmx/GetDiceTopPlayers',
                data: '{idc:"' + idc + '",style:"' + Style + '",type:"' + type + '"}',
                contentType: "application/json",
                success: function (msg) {
                    if (msg.d.length > 0) {
                        $("#most" + type + "_table").html(msg.d);
                    }
                },
                error: function (msg) {
                    console.log("not ok....");
                }
            });
    };
    getTopPlayersAll(Longid, Idc);

    setInterval(function () {
        getTopPlayersAll(Longid, Idc);
        getStatistic(Longid, Idc);
    }, 600000);


    getResultManual = function (longid, idc, bet, multiplier, under_over, clientseed) {
        var time = new Date();
        var time_before = time.getTime();
        var type = 1;
        showLoadingManual();
        $.ajax(
            {
                type: 'POST',
                url: '/dice/getDiceResult',
                data: {idc: idc, bet: bet, multiplier: multiplier, under_over: under_over, clientseed: clientseed},
                dataType: 'json',
                success: function (msg) {
                    // var content = JSON.parse(msg.d);
                    var content = msg.d;
                    if (content.result) {

                        provably_fair_reload();

                        $("#txtLastServerSeed256").val(content.PreviousServerSeedSHA256);
                        $("#txtNextServerSeed256").val(content.NextServerSeedSHA256);
                        $("#txtLastServerSeed").val(content.PreviousServerSeed);
                        $("#txtLastClientSeed").val(content.PreviousClientSeed);

                        var win = parseFloat(content.win);
                        if (win > 0) {
                            var temp = (content.roll).toFixed(3);
                            $("#txtManualResultNumber span").text(temp);
                            $("#txtManualResultNumber").attr("class", "alert alert-success alert-fit");
                        }
                        else {
                            var temp = (content.roll).toFixed(3);
                            $("#txtManualResultNumber span").text(temp);
                            $("#txtManualResultNumber").attr("class", "alert alert-danger alert-fit");
                        }

                        addToTable(content.BetData, "1");
                    } else {
                        if (content.comment.indexOf("client seed") > -1) { // we randomise client seed in case of client seed error
                            $("#btnRandomSeed").click();
                        }
                        type = 2;
                        showMessageManual(content.comment);
                    }
                    hideLoadingManual(time_before, content.balance, type);
                },
                error: function (msg) {
                    showMessageManual("Ошибка связи с сервером.");
                    $("#txtManualResultNumber").hide();
                    hideLoadingManual(time_before, 0, 2);
                }
            });
    };


    getResultAuto = function (longid, idc, bet, multiplier, under_over, clientseed) {
        if (Runing == false) return;
        var start = new Date().getTime();
        if (Runing == false) {
            return;
        }
        $.ajax(
            {
                type: 'POST',
                url: '/dice/getDiceResult',
                data: {idc: idc, bet: bet, multiplier: multiplier, under_over: under_over, clientseed: clientseed},
                dataType: 'json',
                success: function (msg) {
                    // var content = JSON.parse(msg.d);
                    var content = msg.d;
                    if (content.result) {

                        provably_fair_reload();

                        $("#txtLastServerSeed256").val(content.PreviousServerSeedSHA256);
                        $("#txtNextServerSeed256").val(content.NextServerSeedSHA256);
                        $("#txtLastServerSeed").val(content.PreviousServerSeed);
                        $("#txtLastClientSeed").val(content.PreviousClientSeed);

                        var win = parseFloat(content.win);
                        var rdroll = $('input:radio[name=rdRoll]:checked').val();
                        if (rdroll == "swapall") {
                            HighLow = !HighLow;
                        }
                        Profit = Profit + win;
                        bet = parseFloat(bet);
                        if (win > 0) {
                            if (rdroll == "swapwin") {
                                HighLow = !HighLow;
                            }
                            var val = $('input:radio[name=rdWin]:checked').val();
                            if (val == "return") {
                                CurrentBet = BaseBet;
                            }
                            else if (val == "inc") {
                                var val = parseFloat($("#txtWinInc").val());
                                var max = parseFloat($("#txtMaxBet").val());
                                CurrentBet = (bet + (bet * (val / 100)));
                                if (parseFloat(CurrentBet) > max && max > 0) {
                                    CurrentBet = max.toFixed(2)
                                }
                            }
                            else if (val == "dec") {
                                var val = parseFloat($("#txtWinDec").val());
                                var min = parseFloat($("#txtMinBet").val());
                                CurrentBet = (bet - (bet * (val / 100)));
                                if (CurrentBet < min) {
                                    CurrentBet = min;
                                }
                            }
                        }
                        else {
                            if (rdroll == "swaploss") {
                                HighLow = !HighLow;
                            }
                            var val = $('input:radio[name=rdLoss]:checked').val();
                            if (val == "return") {
                                CurrentBet = BaseBet;
                            }
                            else if (val == "inc") {
                                var val = parseFloat($("#txtLossInc").val());
                                var max = parseFloat($("#txtMaxBet").val());
                                CurrentBet = (bet + (bet * (val / 100)));
                                if (parseFloat(CurrentBet) > max && max > 0) {
                                    CurrentBet = max.toFixed(2)
                                }
                            }
                            else if (val == "dec") {
                                var val = parseFloat($("#txtLossDec").val());
                                var min = parseFloat($("#txtMinBet").val());
                                CurrentBet = (bet - (bet * (val / 100)));
                                if (CurrentBet < min) {
                                    CurrentBet = min;
                                }
                            }
                        }
                        CurrentBet = parseFloat(CurrentBet).toFixed(2);
                        showBalance(content.balance, idc);
                        Balance = content.balance;
                        var count = $("#txtMaxRolls").val() - 1;
                        $("#txtMaxRolls").val(count);
                        if (count <= 0) {
                            Runing = false;
                            $("#txtMaxRolls").val(0);
                        }

                        var stop = new Date().getTime();
                        var time = Time - (stop - start);
                        if (time < 0) {
                            time = 0;
                        }

                        $("#txtProfit").val(Profit.toFixed(2));
                        $("#profit_group").show();

                        addToTable(content.BetData, "1");

                        window.clearTimeout(AutoBet);
                        AutoBet = setTimeout(function () { auto_bet(); }, time);
                    } else {
                        auto_stop();

                        if (content.comment.indexOf("client seed") > -1) { // we randomise client seed in case of client seed error
                            $("#btnRandom").click();
                        }

                        type = 2;
                        if (content.comment.indexOf("Timeout") > -1) { // in case of timeout
                            showTimeoutAuto();
                        }
                        else {
                            showMessageAuto(content.comment);
                        }
                        Runing = false;


                    }
                },
                error: function (msg) {
                    //showMessageAuto("Error communicating with server.");
                    //Runing = false;
                    window.clearTimeout(AutoBet);
                    AutoBet = setTimeout(function () { auto_bet(); }, 10000);
                }
            });
    };


    addToGridAll = function () {
        if (Wait1 == true) return;
        var append = AllBets.shift();

        var id = append.slice(15, append.indexOf("'", 10));

        AllBetsAdded = AllBetsAdded + 1;

        if (AllBetsAdded % 2 == 0) {
            append = append.replace("$1", "row_one");
        }
        else {
            append = append.replace("$1", "row_two");
        }

        var row = $(append);
        $("#table_all_bets_head").after(row);

        AllBetsId.push(id);

        while (AllBets.length >= 50) {
            AllBets.pop();
        }

        while (AllBetsId.length >= 100) {
            var id = AllBetsId.shift();
            $("#allrow_" + id).removeData();
            $("#allrow_" + id).detach();
        }
    }

    addToTable = function (data, type) {
        var found = false;
        var timeout = 0;
        if (type == "2") // all users
        {
            $.each(data, function (i, v) {
                if (v == null) return;

                var id = v.id;
                if (id > AllBetIdMax) {
                    AllBetIdMax = id;
                    found = false;
                }
                else {
                    found = true;
                }

                if (found !== true) {
                    AllBetCount = AllBetCount + 1;

                    var append = "<tr id='allrow_" + AllBetCount + "' class='$1'>";

                    id = convert_number(id, 0);
                    var date = getTime(new Date(v.time));

                    append = append + "<td><a class='a_bwindow' href='/dice/getBet/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                        "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                        "<td>" + v.coinname + "</td>" +
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.multiplier, 4) + "</td>" +
                        "<td>" + v.target.replace(/\s/g, "") + "</td><td>" + convert_number(v.roll, 3) + "</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    append = append + "<td class='coin_column'><img class='result_coin' src='/assets/currency/" + v.idc.trim() + ".png' height='25' width='25'></td></tr>"

                    AllBets.push(append);

                }
            });

            var i = AllBets.length;
            var timeout = 4000 / i;
            clearInterval(AllBetsTime);
            AllBetsTime = setInterval(function () {
                i = AllBets.length;
                if (i > 0) {
                    addToGridAll();
                }
            }, timeout);


        }
        if (type == "1") { // this user
            if (Wait1 == true) return;
            $.each(data, function (i, v) {
                if (v == null) return;

                var id = v.id;
                if (id > MyBetIdMax) {
                    MyBetIdMax = id;
                    found = false;
                }
                else {
                    found = true;
                }

                if (found != true) {
                    MyBetCount = MyBetCount + 1;

                    if (MyBetCount % 2 == 0) {
                        var append = "<tr id='myrow_" + MyBetCount + "' class='row_one'>";
                    }
                    else {
                        var append = "<tr id='myrow_" + MyBetCount + "' class='row_two'>";
                    }


                    id = convert_number(id, 0);
                    var date = getTime(new Date(v.time));

                    append = append + "<td><a class='a_bwindow' href='/dice/getBet/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                        "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                        "<td>" + v.coinname + "</td>" +
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.multiplier, 4) + "</td>" +
                        "<td>" + v.target.replace(/\s/g, "") + "</td><td>" + convert_number(v.roll, 3) + "</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    append = append + "<td><img class='result_coin' src='/assets/currency/" + v.idc.trim() + ".png' height='25' width='25'></td></tr>";

                    var row = $(append);
                    $("#table_my_bets_head").after(row);

                    $("#myrow_" + (MyBetCount - 200)).removeData();
                    $("#myrow_" + (MyBetCount - 200)).detach();
                }
            });
        }

        if (type == "3") // high rollers
        {
            $.each(data, function (i, v) {
                if (v == null) return;

                var id = v.id;
                if (id > HRBetIdMax) {
                    HRBetIdMax = id;
                    found = false;
                }
                else {
                    found = true;
                }

                if (found != true) {
                    HRBetCount = HRBetCount + 1;

                    var append = "<tr id='highrow_" + HRBetCount + "'>";

                    id = convert_number(id, 0);
                    var date = getTime(new Date(v.time));

                    append = append + "<td><a class='a_bwindow' href='/dice/getBet/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                        "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                        "<td>" + v.coinname + "</td>" +
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.multiplier, 4) + "</td>" +
                        "<td>" + v.target.replace(/\s/g, "") + "</td><td>" + convert_number(v.roll, 3) + "</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    append = append + "<td><img class='result_coin' src='/assets/currency/" + v.idc.trim() + ".png' height='25' width='25'></td></tr>";

                    var row = $(append);
                    $("#table_high_rollers_head").after(row);


                    //$("#highrow_" + (HRBetCount - 200)).removeData();
                    //$("#highrow_" + (HRBetCount - 200)).detach();

                    if (Active_tab != "High rolls" && HRBetCount > 30) {
                        var temp = HRBetCount - HighRoll;
                        if (temp > 99) {
                            temp = 99;
                        }
                        $("#badge_high_roller").text(temp);
                    }
                    else {
                        HighRoll = HRBetCount;
                    }

                    $("#highrow_" + (HRBetCount - 200)).removeData();
                    $("#highrow_" + (HRBetCount - 200)).detach();
                }
            });
        }
    }

});

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
};
