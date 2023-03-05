
$(document).ready(function () {
    let calculate_maximum_payout = function (under, current) {
        return Math.floor(((100 - Edge) / (100 * (under / 100))));
    }

    var Code = code;
    var Coinname = coinname;
    var Accuracy = accuracy;
    var Longid = getCookie("LongId");
    var Minbid = parseFloat(minbid);
    var Maxwin = parseFloat(maxwin);
    var Edge = parseFloat(edge);
    var Maxratio = calculate_maximum_payout(0.010);
    var Attempts = 3;
    var Step = 0;
    var DisabledGame = true;
    var SelectedCell = [];
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
        var bid = parseFloat($("#txtCardsBet").val());
        var possibleMaxWon = parseFloat($('#txtMaxWon').val());

        $("#txtCardsBet, #txtMaxWon").removeClass("red_font");

        if (bid < Minbid) {
            $("#txtCardsBet").addClass("red_font");
            msg = msg + " Ставка слишком низкая. Минимальная ставка: " + Minbid.toFixed(Accuracy) + " " + coinname + ".";
            result = false;
        }
        if (bid > Balance) {
            $("#txtCardsBet").addClass("red_font");
            msg = msg + " Ставка больше вашего баланса.";
            result = false;
        }
        if ((bid).toFixed(Accuracy) > Maxwin) {
            msg = msg + " Измените ставку или выплату. Максимальный выигрыш установлен на: " + Maxwin + " " + coinname + ".";
            result = false;
        }

        if ((possibleMaxWon).toFixed(Accuracy) > Maxwin) {
            $("#txtMaxWon").addClass("red_font");
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

    const loadGame = () => {
        $.ajax({
            type: 'POST',
            url: '/cards/load',
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    DisabledGame = false;

                    $('#btnCardsStart').remove();
                    renderBtnStarted();
                    clearModal();

                    Attempts = res.attempts;

                    $('#txtCardsBet').val(convert_number(res.sum, Accuracy));
                    setPossibleWin(convert_number(res.sum, Accuracy));
                    $('#btnCardsStart, #txtCardsBet, .btnSetBet').attr('disabled', 'disabled');

                    $('.game-skycard__cards-item').attr('class', 'game-skycard__cards-item game-skycard__cards-item_active');
                    $('.game-skycard__cards-item-image_opened').attr('src', '/assets/icons/card-closed.png');
                    $('.cards_possible_win').text(0);

                    $.each(res.cards, function(index, value) {
                        SelectedCell.push(parseInt(index));
                        renderCardCell(index, value.type, value.win);
                    });

                    if (res.offer_extra) {
                        setTimeout(function () {
                            renderModalExtra(res.min_won_sum, res.extra_sum, res.max_open);
                        }, 100);
                    }

                    activateUserBets();
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

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

    const setPossibleWin = (bid) => {
        $("#txtMinWon").val((bid * 2).toFixed(Accuracy));
        $("#txtMaxWon").val((bid * 15).toFixed(Accuracy));
    }

    const setDefault = () => {
        $("#txtCardsBet").val(Minbid.toFixed(Accuracy));
        setPossibleWin(Minbid);

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
        let bet = $("#txtCardsBet").val();
        if (manual_validate() === true) {
            let clientseed = getClientSeed();
            getResultManual(Longid, Code, bet, selectedNumbers, clientseed);
        } else {
            Runing = false;
        }
    }

    $('#txtCardsBet').on('keyup', function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.value = convert_number(this.value, Accuracy);
        this.setSelectionRange(start, end);
        setPossibleWin(this.value);
        $("#startAgainSum").text(this.value);
        manual_validate();
    });

    $('#btnDivBet').on('click', function () { // bid / 2
        var bet = parseFloat($("#txtCardsBet").val());
        var calc = (bet / 2).toFixed(Accuracy);
        if (calc < Minbid) {
            $("#txtCardsBet").val(Minbid.toFixed(Accuracy));
            $("#startAgainSum").text(Minbid.toFixed(Accuracy));
            setPossibleWin(Minbid.toFixed(Accuracy));
        } else {
            $("#txtCardsBet").val(calc);
            $("#startAgainSum").text(calc);
            setPossibleWin(calc);
        }

        manual_validate();
    });

    $('#btnX2Bet').on('click',function () { // bid * 2
        var bet = parseFloat($("#txtCardsBet").val());
        var calc = (bet * 2).toFixed(Accuracy);
        if (calc > (Balance)) {
            $("#txtCardsBet").val((Balance).toFixed(Accuracy));
            $("#startAgainSum").text((Balance.toFixed(Accuracy)));
            setPossibleWin((Balance).toFixed(Accuracy));
        } else {
            $("#txtCardsBet").val(calc);
            $("#startAgainSum").text(calc);
            setPossibleWin(calc);
        }
        manual_validate();
    });

    $('#btnMaxBet').on('click', function () { //max bid
        $("#txtCardsBet").val((Balance).toFixed(Accuracy));
        setPossibleWin((Balance).toFixed(Accuracy));
        $("#startAgainSum").text((Balance.toFixed(Accuracy)));
        manual_validate();
    });

    $(document).on('click', '#btnMinBet', function () { //min ratio
        $("#txtCardsBet").val(Minbid.toFixed(Accuracy));
        setPossibleWin(Minbid.toFixed(Accuracy));
        $("#startAgainSum").text(Minbid.toFixed(Accuracy));
        manual_validate();
    });

    //
    $('.game-skycard__cards').on('click', '.game-skycard__cards-item_active', function () {
        if (DisabledGame) {
            return false;
        }

        let cell = $(this).data('number');

        if (SelectedCell.indexOf(cell) === -1 && SelectedCell.length <= Attempts) {
            play(cell);
            SelectedCell.push(cell);
        }
    });

    $(document).on('click', '#btnCardsStart, #startAgain', function () {
        if (manual_validate() === true) {
            clearModal();
            startGame();
        }
    });

    $(document).on('click', '#extraCard', function () {
        if (DisabledGame) {
            return false;
        }

        extraCard();
    })

    $(document).on('click', '#takeMinWonSum', function () {
        if (DisabledGame) {
            return false;
        }

        collect();
    })

    $(document).on('click', '.game-skycard__cards-modal-close',  function () {
        clearModal();
    });

    const startGame = () => {
        let sum = parseFloat($("#txtCardsBet").val());

        $('#btnCardsStart, #txtCardsBet, .btnSetBet').attr('disabled', 'disabled');
        clearModal();
        // showMessageSuccess('');

        $.ajax({
            type: 'POST',
            url: '/cards/create',
            data: {code: Code, sum: sum},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    $('#btnCardsStart').remove();
                    renderBtnStarted();
                    DisabledGame = false;

                    Attempts = res.attempts;

                    $('.game-skycard__cards-item').attr('class', 'game-skycard__cards-item game-skycard__cards-item_active');
                    $('.game-skycard__cards-item-image_opened').attr('src', '/assets/icons/card-closed.png');
                    $('.cards_possible_win').text(0);

                    Balance = res.balance;
                    showBalance(res.balance, Code, Accuracy);
                    $('.game-skycard__cards-item').removeClass('disabled').addClass('game-skycard__cards-item_active')
                    activateUserBets();
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const play = (cell) => {
        DisabledGame = true;

        $.ajax({
            type: 'POST',
            url: '/cards/play',
            data: {code: Code, cell: cell},
            dataType: 'json',
            success: function (res) {

                if (res.status === 'success') {
                    if (res.lose === true) {

                        Balance = res.balance;
                        showBalance(res.balance, Code, Accuracy);
                        renderBtnStart();

                        SelectedCell = [];

                        $('#btnCardsStart, #txtCardsBet, .btnSetBet').removeAttr('disabled');

                        clearModal();

                        displayAllCards(res.cards, res.revealed);

                        setTimeout(function () {
                            renderModalLose(res.won_sum, res.sum);
                        }, 800);

                        // addToTable(res.BetData, "1");

                    } else {
                        DisabledGame = false;
                        renderCardCell(cell, res.cell_result.type, res.cell_result.win);

                        Attempts = res.attempts;

                        if (res.offer_extra) {
                            setTimeout(function () {
                                renderModalExtra(res.min_won_sum, res.extra_sum, res.max_open);
                            }, 300);
                        }

                        if (res.win) {
                            DisabledGame = true;

                            $('#btnCardsStart, #txtCardsBet, .btnSetBet').removeAttr('disabled');
                            SelectedCell = [];

                            displayAllCards(res.cards, res.revealed);

                            setTimeout(function () {
                                renderModalWin(res.won_sum, res.sum);
                            }, 1000);

                            renderBtnStart();
                        }
                    }
                } else if (res.status === 'continue') {
                    DisabledGame = false;
                }
            },
            error: function (msg) {
                showMessageManual("Ошибка связи с сервером.");
            }
        });
    }

    const extraCard = () => {
        $.ajax({
            type: 'POST',
            url: '/cards/extraCard',
            data: {code: Code},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    DisabledGame = false;

                    Attempts = res.attempts;
                    Balance = res.balance;
                    showBalance(res.balance, Code, Accuracy);
                    clearModal();
                    activateUserBets();
                } else if (res.status === 'error') {
                    showMessageManual(res.message);
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const collect = () => {
        $.ajax({
            type: 'POST',
            url: '/cards/collect',
            data: {code: Code},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    // showMessageSuccess('Вы выиграли ' + convert_number(res.won_sum, Accuracy));
                    Balance = res.balance;
                    showBalance(res.balance, Code, Accuracy);
                    renderBtnStart();

                    SelectedCell = [];

                    $('#btnCardsStart, #txtCardsBet, .btnSetBet').removeAttr('disabled');

                    clearModal();

                    displayAllCards(res.cards, res.revealed);

                    // addToTable(res.BetData, "1");
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const renderCardCell = (cell, type, win, is_opacity = false) => {
        let img = '';
        if (type == 1) {
            img = '/assets/icons/card-blue.png'
        } else if (type == 2) {
            img = '/assets/icons/card-green.png'
        } else if (type == 3) {
            img = '/assets/icons/card-red.png'
        }

        let cellField = $('.game-skycard__cards').find(".game-skycard__cards-item[data-number='" + cell + "']");
        cellField.find('span').css('visibility', 'visibility').text(win);
        cellField.find('.game-skycard__cards-item-image_opened').attr('src', img);
        cellField.addClass('game-skycard__cards-item_opened game-skycard__cards-item_selected');
        if (is_opacity) {
            cellField.addClass('is_opacity');
        }
    }

    const displayAllCards = (cards, revealed) => {
        $.each(cards, function(index, value) {
            if (revealed.includes(parseInt(index)) === true) {
                renderCardCell(index, value.type, value.win);
            } else {
                renderCardCell(index, value.type, value.win, true);
            }
        });
    }

    const renderModalExtra = (minWonSum, extraSum, maxOpen) => {
        let countCards = `${maxOpen} карточки`;
        if (maxOpen == 1) {
            countCards = `${maxOpen} карточку`;
        }

        let html = `
            <div>
                <div class="game-skycard__cards-modal-body">
                    <div class="game-skycard__cards-modal-title">
                        Вы угадали ${countCards} из 3
                    </div>
                    <div class="game-skycard__cards-modal-text">
                        Можете забрать гарантированный выигрыш прямо сейчас:
                    </div>
                    <div class="game-skycard__cards-modal-button game-skycard__cards-modal-button_default" id="takeMinWonSum">
                        <span>Забрать <strong id="minWonSum">${convert_number(minWonSum, Accuracy)} ${Coinname}</strong></span>
                        <small>Гарантированный приз</small>
                    </div>
                    <div class="game-skycard__cards-modal-text">
                        Или испытать удачу и открыть дополнительную карточку:
                    </div>
                    <div class="game-skycard__cards-modal-button" id="extraCard">
                        <span>Продолжить за <strong id="extraSum">${convert_number(extraSum, Accuracy)} ${Coinname}</strong></span>
                        <small>Дополнительная карточка</small>
                    </div>
                </div>
            </div>
        `;

        $('.game-skycard__cards-modal').addClass('active').html(html);
        $('.game-skycard__cards-modal-wrapper').addClass('active');
    }

    const renderModalLose = (minWonSum, bet) => {
        let html = `
            <div>
                <div class="game-skycard__cards-modal-close"></div>
                <div class="game-skycard__cards-modal-body">
                    <div class="game-skycard__cards-modal-title">Увы, не угадали...</div>
                    <div class="game-skycard__cards-modal-text loose">Вам начислен гарантированный выигрыш:</div>
                    <div class="game-skycard__cards-modal-text loose"><strong>${convert_number(minWonSum, Accuracy)} ${Coinname}</strong></div>
                </div>
                <div class="game-skycard__cards-modal-footer">
                    <div class="game-skycard__cards-modal-button" id="startAgain">
                        <span>Сыграть еще за <strong id="startAgainSum">${convert_number(bet, Accuracy)}</strong> <strong>${Coinname}</strong></span>
                    </div>
                </div>
            </div>
        `;

        $('.game-skycard__cards-modal').addClass('active').html(html);
        $('.game-skycard__cards-modal-wrapper').addClass('active');
    }

    const renderModalWin = (wonSum, bet) => {
        let html = `
            <div>
                <div class="game-skycard__cards-modal-close"></div>
                <div class="game-skycard__cards-modal-body">
                    <div class="game-skycard__cards-modal-title">Поздравляем!!!</div>
                    <div class="game-skycard__cards-modal-text loose">Вы выиграли:</div>
                    <div class="game-skycard__cards-modal-text loose"><strong>${convert_number(wonSum, Accuracy)} ${Coinname}</strong></div>
                </div>
                <div class="game-skycard__cards-modal-footer">
                    <div class="game-skycard__cards-modal-button" id="startAgain">
                        <span>Сыграть еще за <strong id="startAgainSum">${convert_number(bet, Accuracy)}</strong> <strong>${Coinname}</strong></span>
                    </div>
                </div>
            </div>
        `;

        $('.game-skycard__cards-modal').addClass('active').html(html);
        $('.game-skycard__cards-modal-wrapper').addClass('active');
    }

    const clearModal = () => {
        $('.game-skycard__cards-modal').removeClass('active').html('');
        $('.game-skycard__cards-modal-wrapper').removeClass('active');
    }

    const renderBtnStart = () => {
        let html = `<button class="game-cards__button" id="btnCardsStart"><span>Играть</span></button>`;
        $('.cards-btn_buttons').html(html);
    }

    const renderBtnStarted = () => {
        let html = `<button class="game-cards__button" disabled><span>Идет игра...</span></button>`;
        $('.cards-btn_buttons').html(html);
    }

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
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.coeff, Accuracy) + "x</td>";

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
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, 2) + "</td>"
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
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

                    if (v.profit >= 0) {
                        append = append + "<td class='green_font text-right'>" + convert_number(v.profit, 2) + "</td>"
                    }
                    else {
                        append = append + "<td class='red_font text-right'>" + convert_number(v.profit, 2) + "</td>"
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
