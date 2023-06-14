
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
    var DefaultStep = 0;
    var DefaultCoeff = 0;
    var Step = 0;
    var DisabledGame = true;
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
        var bid = parseFloat($("#txtCoinBet").val());

        $("#txtCoinBet").removeClass("red_font");

        if (bid < Minbid) {
            $("#txtCoinBet").addClass("red_font");
            msg = msg + " Ставка слишком низкая. Минимальная ставка: " + Minbid.toFixed(2) + " " + coinname + ".";
            result = false;
        }
        if (bid > Balance) {
            $("#txtCoinBet").addClass("red_font");
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
        } else {
            $("#divManualMessage").delay(500).hide();
        }
    };

    showMessageSuccess = function (msg) {
        if (msg.length > 0) {
            $("#divSuccessMessage p").html(msg);
            $("#divSuccessMessage").delay(500).show();
        } else {
            $("#divSuccessMessage").delay(500).hide();
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
            url: '/coinflip/getAllLastBets',
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
            url: '/coinflip/getLastBets',
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

    getProvablyFair = function (longid, coin) {
        $.ajax({
            type: 'POST',
            url: '/stats.asmx/GetFairDice',
            data: '{code:"' + coin + '"}',
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

    getBalance(Code, Accuracy);
    getBets();
    // getProvablyFair(Longid, Code);

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

    const loadGame = () => {
        $.ajax({
            type: 'POST',
            url: '/coinflip/load',
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    DisabledGame = false;
                    Step = res.step;

                    $('#txtCoinBet, #btnDivBet, #btnX2Bet, .btnSetBet').attr('disabled', 'disabled');
                    $('#btnCoinFlipStart').remove();
                    renderCoinFlip();

                    $('#coinStep').text(res.step);
                    $('#coinCoeff').text('x' + res.coeff);

                    $('#possibleWin').text((res.possibleWin).toFixed(Accuracy));

                    $.each(res.revealed, function(index, value) {
                        var step = index + 1;

                        $(".steps__step[data-step="+step+"]").addClass('steps__step_active');
                        let htmlCoin = $(".steps__step[data-step="+step+"]").find('.steps__step-img');
                        if (res.finish) {
                            $('.section__title, .coinflip-section__row').empty();
                        }
                        if (parseInt(value) === 0) {
                            htmlCoin.addClass('steps__step-img_tail');
                        } else {
                            htmlCoin.addClass('steps__step-img_eagle');
                        }
                    });

                    activateUserBets();
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const setDefault = () => {
        $("#txtCoinBet").val(Minbid.toFixed(Accuracy));

        loadGame();
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
        let bet = $("#txtCoinBet").val();
        if (manual_validate() === true) {
            let clientseed = getClientSeed();
            getResultManual(Longid, Code, bet, selectedNumbers, clientseed);
        } else {
            Runing = false;
        }
    }

    $("#txtCoinBet").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        manual_validate();
    });

    $("#btnDivBet").on('click', function () { // bid / 2
        var bet = parseFloat($("#txtCoinBet").val());
        $("#txtCoinBet").val((bet / 2).toFixed(Accuracy));
        if ((bet / 2) < Minbid) {
            $("#txtCoinBet").val(Minbid.toFixed(Accuracy));
        }
        manual_validate();
    });

    $("#btnX2Bet").click(function () { // bid * 2
        var bet = parseFloat($("#txtCoinBet").val());
        $("#txtCoinBet").val((bet * 2).toFixed(Accuracy));
        if ((bet * 2) > (Balance)) {
            $("#txtCoinBet").val((Balance).toFixed(Accuracy));
        }
        manual_validate();
    });

    //
    $('.coin-btn_buttons').on('click', '#btnEagle', function () {
        let bet = $("#txtCoinBet").val();
        if (!DisabledGame) {
            play(1, bet);
        }
    });

    $('.coin-btn_buttons').on('click', '#btnTail', function () {
        let bet = $("#txtCoinBet").val();
        if (!DisabledGame) {
            play(0, bet);
        }
    });

    $(document).on('click', '#btnCoinFlipStart', function () {
        if (manual_validate() === true) {
            startGame();
        }
    });

    $(document).on('click', '#btnPossibleWin', function () {
        if (Step > 0 && !DisabledGame) {
            collect();
        }
    })

    $('.game-coinflip__winning-close').on('click', function () {
        closeCoinflipWin();
    });

    let closeCoinflipWin = () => {
        $('.game-coinflip__winning').removeClass('game-coinflip__winning_active');
    }

    let showWinCoinflip = (amount, coeff) => {
        $('.game-coinflip__winning').addClass('game-coinflip__winning_active');
        $("#winСoinflipAmount").text(amount);
        $("#coinflipCoeff").text(coeff);
    }

    const startGame = () => {
        let bet = parseFloat($("#txtCoinBet").val());

        $('.mines-coeff').removeClass('active');
        $('#coinStep').text(DefaultStep);
        $('#coinCoeff').text(DefaultCoeff);
        $('#txtCoinBet, #btnDivBet, #btnX2Bet, .btnSetBet').attr('disabled', 'disabled');

        closeCoinflipWin();
        // showMessageSuccess('');

        $.ajax({
            type: 'POST',
            url: '/coinflip/create',
            data: {code: Code, bet: bet},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    $('#btnCoinFlipStart').remove();
                    renderCoinFlip();
                    DisabledGame = false;

                    Balance = res.balance;
                    showBalance(res.balance, Code, Accuracy);
                    $('.steps__step').attr('class', 'steps__step');
                    $('.steps__step-img').attr('class', 'steps__step-img');
                    // renderBtnPossibleWin(bet);
                    activateUserBets();
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const play = (coin, bet) => {

        $('#btnEagle, #btnTail').addClass('disabled');
        $('#btnPossibleWin').addClass('disabled').attr('disabled');
        DisabledGame = true;

        $.ajax({
            type: 'POST',
            url: '/coinflip/play',
            data: {code: Code, bet: bet, coin: coin },
            dataType: 'json',
            success: function (res) {

                if (res.status === 'success') {
                    let step = res.step;
                    Step = step;

                    let flipResult = res.coin;
                    $('#coin').removeClass();
                    setTimeout(function () {
                        if (flipResult === 0) {
                            $('#coin').addClass('tails');
                        } else {
                            $('#coin').addClass('heads');
                        }
                    }, 100);

                    if (res.lose === true) {
                        let countRevealed = res.revealed.length;
                        setTimeout(function () {
                            Balance = res.balance;
                            showBalance(res.balance, Code, Accuracy);
                            renderBtnStart();
                            $('#txtCoinBet, #btnDivBet, #btnX2Bet, .btnSetBet').removeAttr('disabled');
                            $.each(res.coins, function(index, value) {
                                let step = ++index;
                                if (step => countRevealed) {
                                    let htmlCoin = $(".steps__step[data-step="+step+"]").find('.steps__step-img');
                                    if (value === 0) {
                                        htmlCoin.addClass('steps__step-img_tail');
                                    } else {
                                        htmlCoin.addClass('steps__step-img_eagle');
                                    }
                                }
                            });

                            addToTable(res.BetData, "1");
                        }, 1600);
                    } else {
                        setTimeout(function () {
                            $('#coinStep').text(res.step);
                            $('#coinCoeff').text('x' + res.coeff);
                            $('#possibleWin').text((res.possibleWin).toFixed(Accuracy));
                            $('#btnPossibleText').text('Забрать');

                            DisabledGame = false;
                            $('#btnEagle, #btnTail').removeClass('disabled');
                            $('#btnPossibleWin').removeClass('disabled').removeAttr('disabled');

                            $(".steps__step[data-step="+step+"]").addClass('steps__step_active');
                            let htmlCoin = $(".steps__step[data-step="+step+"]").find('.steps__step-img');
                            if (coin === 0) {
                                htmlCoin.addClass('steps__step-img_tail');
                            } else {
                                htmlCoin.addClass('steps__step-img_eagle');
                            }

                            if (res.finish) {
                                Step = 0;
                                showWinCoinflip(convert_number(res.won_sum, Accuracy), res.coeff);

                                $('.section__title, .coinflip-section__row').empty();

                                Balance = res.balance;
                                showBalance(res.balance, Code, Accuracy);
                                $('#btnPossibleWin').remove();
                                renderBtnStart();

                                $('#txtCoinBet, #btnDivBet, #btnX2Bet, .btnSetBet').removeAttr('disabled');

                                addToTable(res.BetData, "1");
                            }
                        }, 1600);
                    }
                }
            },
            error: function (msg) {
                showMessageManual("Ошибка связи с сервером.");
                $("#txtManualResultNumber").hide();
            }
        });
    }

    const collect = () => {
        $.ajax({
            type: 'POST',
            url: '/coinflip/collect',
            data: {code: Code},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    Step = 0;
                    showWinCoinflip(convert_number(res.won_sum, Accuracy), res.coeff);
                    // showMessageSuccess('Вы выиграли ' + convert_number(res.won_sum, Accuracy));
                    Balance = res.balance;
                    showBalance(res.balance, Code, Accuracy);
                    $('#btnPossibleWin').remove();
                    renderBtnStart();

                    $('#txtCoinBet, #btnDivBet, #btnX2Bet, .btnSetBet').removeAttr('disabled');

                    let countRevealed = res.revealed.length;

                    $.each(res.coins, function(index, value) {
                        let step = ++index;
                        if (step => countRevealed) {
                            let htmlCoin = $(".steps__step[data-step="+step+"]").find('.steps__step-img');
                            if (value === 0) {
                                htmlCoin.addClass('steps__step-img_tail');
                            } else {
                                htmlCoin.addClass('steps__step-img_eagle');
                            }
                        }
                    });

                    addToTable(res.BetData, "1");
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const renderBtnStart = () => {
        let html = `<button class="game-coinflip__button" id="btnCoinFlipStart"><span>Играть</span></button>`;
        $('.coin-btn_buttons').html(html);
    }

    const renderCoinFlip = () => {
        let disabled = (Step > 0) ? '' : 'disabled';
        let btnText =  (Step > 0) ? 'Забрать' : 'Сделайте ход';
        let html = `<h3 class="section__title">Выберите исход раунда</h3>
                    <div class="coinflip-section__row ">
                        <div class="section__item buttons__eagle" id="btnEagle">
                            <div class="buttons__text">Орел</div>
                        </div>
                        <div class="section__item buttons__tail" id="btnTail">
                            <div class="buttons__text">Решка</div>
                        </div>
                    </div>
                    <button class="game-coinflip__button" id="btnPossibleWin" ${disabled}><span id="btnPossibleText">${btnText}</span>&nbsp;<span id="possibleWin"></span></button>
                `;
        $('.coin-btn_buttons').html(html);
    }

    $("#btnBet1").click(function () { // bid + 1
        var bet = parseFloat($("#txtCoinBet").val());
        $("#txtCoinBet").val((bet + 1).toFixed(Accuracy));
        if ((bet + 1) > (Balance)) {
            $("#txtCoinBet").val((Balance).toFixed(Accuracy));
        }
        manual_validate();
    });

    $("#btnBet2").click(function () { // bid + 10
        var bet = parseFloat($("#txtCoinBet").val());
        $("#txtCoinBet").val((bet + 10).toFixed(Accuracy));
        if ((bet + 10) > (Balance)) {
            $("#txtCoinBet").val((Balance).toFixed(Accuracy));
        }
        manual_validate();
    });

    $("#btnBet3").click(function () { // bid + 50
        var bet = parseFloat($("#txtCoinBet").val());
        $("#txtCoinBet").val((bet + 50).toFixed(Accuracy));

        if ((bet + 50) > (Balance)) {
            $("#txtCoinBet").val((Balance).toFixed(Accuracy));
        }
        manual_validate();
    });

    $("#btnBet4").click(function () { // bid + 100
        var bet = parseFloat($("#txtCoinBet").val());
        $("#txtCoinBet").val((bet + 100).toFixed(Accuracy));

        if ((bet + 100) > (Balance)) {
            $("#txtCoinBet").val((Balance).toFixed(Accuracy));
        }
        manual_validate();
    });

    $("#btnBet5").click(function () { // bid + 250
        var bet = parseFloat($("#txtCoinBet").val());
        $("#txtCoinBet").val((bet + 250).toFixed(Accuracy));

        if ((bet + 250) > (Balance)) {
            $("#txtCoinBet").val((Balance).toFixed(Accuracy));
        }
        manual_validate();
    });

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
                        "<td>" + convert_number(v.bet, Accuracy) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

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
                        "<td>" + convert_number(v.bet, Accuracy) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, Accuracy) + "</td>"
                    } else {
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
                        "<td>" + convert_number(v.bet, Accuracy) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

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
