
$(document).ready(function () {
    let calculate_maximum_payout = function (under, current) {
        return Math.floor(((100 - Edge) / (100 * (under / 100))));
    }

    var Code = code;
    var Accuracy = accuracy;
    var Longid = getCookie("LongId");
    var Minbid = parseFloat(minbid);
    var Maxwin = parseFloat(maxwin);
    var Edge = parseFloat(edge);
    var Maxratio = calculate_maximum_payout(0.010);
    var MyBets = [];
    var AllBets = [];
    var AllBetsId = [];
    var Wait = false; //bet runing
    var Wait1 = false; //mouse over
    var Runing = false;
    var Active_tab = "All bets";
    var TabChange = true;
    var MyBetIdMax = 0;
    var MyBetCount = 1;
    var AllBetIdMax = 0;
    var AllBetCount = 1;
    var AllBetsAdded = 0;
    var HighRoll = 0;
    var AllBetsTime;
    var diceAutobetCookieName = Code + 'dice_autobet';

    var selectedNumbers = [];
    var kenoRates = [];
    var changeType = 1;

    $("#allbets_pause").hide();
    $("#yourbets_pause").hide();



    $("#last_bets").mouseover(function () {
        $("#allbets_pause").show();
        Wait1 = true;
    });
    $("#last_bets").mouseout(function () {
        $("#allbets_pause").hide();
        Wait1 = false;
    });

    const manual_validate = function () { // manual validations
        var msg = "";
        var result = true;
        var bid = parseFloat($("#txtKenoBet").val());

        $("#txtKenoBet").removeClass("red_font");

        if (bid < Minbid) {
            $("#txtKenoBet").addClass("red_font");
            msg = msg + " Ставка слишком низкая. Минимальная ставка: " + Minbid.toFixed(2) + " " + coinname + ".";
            result = false;
        }
        if (bid > Balance) {
            $("#txtKenoBet").addClass("red_font");
            msg = msg + " Ставка больше вашего баланса.";
            result = false;
        }
        if ((bid).toFixed(2) > Maxwin) {
            msg = msg + " Измените ставку или выплату. Максимальный выигрыш установлен на: " + Maxwin + " " + coinname + ".";
            result = false;
        }

        showMessageManual(msg);
        return result;
    };

    showMessageManual = function (msg) {
        if (msg.length > 0) {
            $("#divManualMessage p").html(msg);
            $("#divManualMessage").delay(500).show();
        }
        else {
            $("#divManualMessage").delay(500).hide();
        }
    };

    convert_number = function (number, fixed) {
        if (fixed == 0) {
            var result = parseInt(number).toLocaleString('en-US');
        } else {
            var result = parseFloat(number).toFixed(fixed).toLocaleString('en-US');
        }

        return result;
    };

    getBets = function () {
        if (Active_tab === "All bets") {
            getAllBets();
        }

        //if (Active_tab == "Your bets") {
        //    getLastBets(Longid, "2");
        //}
    }

    getAllBets = function () {
        if (Wait === true) return;

        $.ajax({
            type: 'POST',
            url: '/keno/getAllLastBets',
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


    getLastBets = function (longid, type) {
        if (Wait === true) return;

        $.ajax({
            type: 'POST',
            url: '/keno/getLastBets',
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
    };
    getLastBets(Longid, "1");

    getBalance(Code, Accuracy);
    getBets();

    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        var str = e.target.text;
        str = str.trim();
        //if (str == "Provably fair") {
        //    getProvablyFair(Longid, Code);
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

    const activateUserBets = () => {
        $('.nav-tabs a[href="#my_bets"]').tab('show');
    }

    refreshBets = function () {
        getBets();
        setTimeout(function () { refreshBets(); }, 2000);
    }
    refreshBets();

    const setDefault = () => {
        $("#txtKenoBet").val(Minbid.toFixed(2));
    }
    setDefault();

    $("#table_last_bets tbody").on("click", "tr", function () {
        $(this).toggleClass("active_row");
    });
    $("#table_my_bets tbody").on("click", "tr", function () {
        $(this).toggleClass("active_row");
    });

    manualBet = function () {
        if (Runing === true) {
            return;
        }

        Runing = true;
        activateUserBets();
        let bet = $("#txtKenoBet").val();
        if (manual_validate() === true) {
            let clientseed = getClientSeed();
            getResultManual(Longid, Code, bet, selectedNumbers, clientseed);
        } else {
            Runing = false;
        }
    }

    $("#txtKenoBet").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        manual_validate();
    });

    $('#btnAutoNumber').on('click', function () {
        if (Runing === true) {
            return;
        }

        closeKenoWin();
        clearKenoNumbers()
        while (selectedNumbers.length < 10) {
            let n = Math.floor(Math.random() * 40) + 1;
            if (selectedNumbers.indexOf(n) === -1) {
                selectedNumbers.push(n);
            }
        }

        let i = 0;
        $.each(selectedNumbers, function(index, value){
            i++
            setData(value, i);
        });

        function setData(n, i){
            setTimeout(function(){
                $(".game-keno__numbers-item[data-number="+n+"]").addClass('game-keno__numbers-item_selected');
            }, 50 * i);
        }

        htmlRatesNumber(selectedNumbers.length);
        $('.game-keno__button').removeClass('disabled').removeAttr('disabled');
    });

    $('#btnClearNumber').on('click', function () {
        if (Runing === true) {
            return;
        }

        closeKenoWin();
        clearKenoNumbers();
    });

    $('.game-keno__numbers-item').on('click', function () {
        let number = $(this).data('number');

        $('.game-keno__numbers-item').removeClass('game-keno__numbers-item_opened');

        if (selectedNumbers.indexOf(number) === -1) {
            if (selectedNumbers.length < 10) {
                $(this).addClass('game-keno__numbers-item_selected')
                selectedNumbers.push(number);
            }
        } else {
            $(this).removeClass('game-keno__numbers-item_selected');
            selectedNumbers.splice(selectedNumbers.indexOf(number),1);
        }

        if (selectedNumbers.length === 0) {
            htmlRatesNotNumber();
            $('#btnKenoStart').addClass('disabled').attr('disabled');
        } else {
            htmlRatesNumber(selectedNumbers.length);
            $('#btnKenoStart').removeClass('disabled').removeAttr('disabled');
        }
    });

    const htmlRatesNumber = (countNumbers) => {
        let html = '';
        $.each(kenoRates[changeType], function(index, value) {
            if (value.number === countNumbers) {
                html += `<div class="game-keno__rates-item">
                            <div class="game-keno__rates-item-step">${value.count_win}</div>
                            <div class="game-keno__rates-item-rate">${value.coeff}x</div>
                        </div>`;
            }
        });

        $('.game-keno__rates').html(html);
    }

    const htmlRatesNotNumber = () => {
        let html = `<div class="game-keno__rates-item game-keno__rates-item_text">Выберите от 1 до 10 номеров.</div>`;
        $('.game-keno__rates').html(html);
    }

    $('#btnKenoStart').on('click', function () {
        if (!Runing) {
            closeKenoWin();
            $('.game-keno__numbers-item').removeClass('game-keno__numbers-item_opened');
            $('.game-keno__rates-item').removeClass('game-keno__rates-item_active');
            manualBet();
        }
    });

    $(".change_type").on('click', function () {
        if (Runing === true) {
            return;
        }
        $(".change_type").removeClass('active');
        $(this).addClass('active');
        changeType = $(this).attr('data-type');

        if (selectedNumbers.length) {
            htmlRatesNumber(selectedNumbers.length);
        } else {
            htmlRatesNotNumber();
        }
    });

    $('.game-keno__winning-close').on('click', function () {
        closeKenoWin();
    });

    let clearKenoNumbers = () => {
        htmlRatesNotNumber();
        $('.game-keno__numbers-item').attr('class', 'game-keno__numbers-item');
        $('#btnKenoStart').addClass('disabled').attr('disabled', 'disabled');
        selectedNumbers = [];
    }

    let closeKenoWin = () => {
        $('.game-keno__winning').removeClass('game-keno__winning_active');
    }

    $("#btnBet1").click(function () { // bid + 1
        var bet = parseFloat($("#txtKenoBet").val());
        $("#txtKenoBet").val((bet + 1).toFixed(2));
        if ((bet + 1) > (Balance)) {
            $("#txtKenoBet").val((Balance).toFixed(2));
        }
        manual_validate();
    });

    $("#btnBet2").click(function () { // bid + 10
        var bet = parseFloat($("#txtKenoBet").val());
        $("#txtKenoBet").val((bet + 10).toFixed(2));
        if ((bet + 10) > (Balance)) {
            $("#txtKenoBet").val((Balance).toFixed(2));
        }
        manual_validate();
    });

    $("#btnBet3").click(function () { // bid + 50
        var bet = parseFloat($("#txtKenoBet").val());
        $("#txtKenoBet").val((bet + 50).toFixed(2));

        if ((bet + 50) > (Balance)) {
            $("#txtKenoBet").val((Balance).toFixed(2));
        }
        manual_validate();
    });

    $("#btnBet4").click(function () { // bid + 100
        var bet = parseFloat($("#txtKenoBet").val());
        $("#txtKenoBet").val((bet + 100).toFixed(2));

        if ((bet + 100) > (Balance)) {
            $("#txtKenoBet").val((Balance).toFixed(2));
        }
        manual_validate();
    });

    $("#btnBet5").click(function () { // bid + 250
        var bet = parseFloat($("#txtKenoBet").val());
        $("#txtKenoBet").val((bet + 250).toFixed(2));

        if ((bet + 250) > (Balance)) {
            $("#txtKenoBet").val((Balance).toFixed(2));
        }
        manual_validate();
    });

    $("#btnDivBet").on('click', function () { // bid / 2
        var bet = parseFloat($("#txtKenoBet").val());
        $("#txtKenoBet").val((bet / 2).toFixed(2));
        if ((bet / 2) < Minbid) {
            $("#txtKenoBet").val(Minbid.toFixed(2));
        }
        manual_validate();
    });

    $("#btnX2Bet").click(function () { // bid * 2
        var bet = parseFloat($("#txtKenoBet").val());
        $("#txtKenoBet").val((bet * 2).toFixed(2));
        if ((bet * 2) > (Balance)) {
            $("#txtKenoBet").val((Balance).toFixed(2));
        }
        manual_validate();
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

    let getKenoRates = () => {
        $.ajax({
            type: 'POST',
            url: '/keno/getRates',
            contentType: "application/json",
            success: function (res) {
                kenoRates = res;
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    };
    getKenoRates();


    const getResultManual = (longid, code, bet, selectedNumbers, clientseed) => {

        $('#txtCoinBet, #btnKenoStart, #btnDivBet, #btnX2Bet, #btnAutoNumber, #btnClearNumber, .change_type, .btnSetBet')
            .addClass('disabled').attr('disabled', 'disabled');

        $.ajax({
            type: 'POST',
            url: '/keno/getKenoResult',
            data: {code: code, bet: bet, type: changeType, numbers: selectedNumbers, clientseed: clientseed},
            dataType: 'json',
            success: function (msg) {
                var content = msg.d;
                if (content.result) {

                    let i = 0;
                    $.each(content.win, function(index, value) {
                        i++
                        setData(value, i, 'game-keno__numbers-item_opened');
                    });

                    let k = 0;
                    $.each($('.game-keno__rates-item'), function() {
                        k++;
                        if (k <= (content.win.length + 1)) {
                            $(this).addClass('game-keno__rates-item_active');
                        }
                    });

                    let j = 0;
                    $.each(content.drop, function(index, value){
                        j++
                        setData(value, j, 'game-keno__numbers-item_opened');
                    });

                    function setData(n, i, el){
                        setTimeout(function(){
                            $(".game-keno__numbers-item[data-number="+n+"]").addClass(el);
                        }, 50 * i);
                    }

                    let win_amount = parseFloat(content.win_amount);

                    setTimeout(function(){
                        if (win_amount > 0) {
                            $('.game-keno__winning').addClass('game-keno__winning_active');
                            $("#winKenoAmount").text(win_amount);
                            $("#kenoCoeff").text(content.coeff);
                        }

                        $('#txtCoinBet, #btnKenoStart, #btnDivBet, #btnX2Bet, #btnAutoNumber, #btnClearNumber, .change_type, .btnSetBet')
                            .removeClass('disabled').removeAttr('disabled');

                        Wait = false;
                        Runing = false;
                        addToTable(content.BetData, "1");
                    }, 700);
                }
            },
            error: function (msg) {
                showMessageManual("Ошибка связи с сервером.");
                $("#txtManualResultNumber").hide();
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

    const addToTable = (data, type) => {
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
                } else {
                    found = true;
                }

                if (found !== true) {
                    AllBetCount = AllBetCount + 1;

                    var append = "<tr id='allrow_" + AllBetCount + "' class='$1'>";

                    id = convert_number(id, 0);
                    var date = getTime(new Date(v.time));

                    append = append + "<td><a class='a_bwindow' href='/keno/getBet/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                        "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                        "<td>" + v.coinname + "</td>" +
                        "<td>" + v.type + "</td>" +
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, Accuracy) + "</td>"
                    } else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, Accuracy) + "</td>"
                    }
                    append = append + "<td class='coin_column'><img class='result_coin' src='" + v.icon.trim() + "' height='25' width='25'></td></tr>"

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
                } else {
                    found = true;
                }

                if (found != true) {
                    MyBetCount = MyBetCount + 1;

                    if (MyBetCount % 2 == 0) {
                        var append = "<tr id='myrow_" + MyBetCount + "' class='row_one'>";
                    } else {
                        var append = "<tr id='myrow_" + MyBetCount + "' class='row_two'>";
                    }


                    id = convert_number(id, 0);
                    var date = getTime(new Date(v.time));

                    append = append + "<td><a class='a_bwindow' href='/keno/getBet/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                        "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                        "<td>" + v.coinname + "</td>" +
                        "<td>" + v.type + "</td>" +
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, Accuracy) + "</td>"
                    }
                    else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, Accuracy) + "</td>"
                    }
                    append = append + "<td><img class='result_coin' src='" + v.icon.trim() + "' height='25' width='25'></td></tr>";

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

                    append = append + "<td><a class='a_bwindow' href='/keno/getBet/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                        "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                        "<td>" + v.coinname + "</td>" +
                        "<td>" + v.type + "</td>" +
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, Accuracy) + "</td>"
                    } else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, Accuracy) + "</td>"
                    }
                    append = append + "<td><img class='result_coin' src='" + v.icon.trim() + "' height='25' width='25'></td></tr>";

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
