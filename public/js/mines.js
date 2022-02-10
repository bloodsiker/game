
$(document).ready(function () {
    let calculate_maximum_payout = function (under, current) {
        return Math.floor(((100 - Edge) / (100 * (under / 100))));
    }

    var Idc = idc;
    var Longid = getCookie("LongId");
    var Minbid = parseFloat(minbid);
    var Maxwin = parseFloat(maxwin);
    var Edge = parseFloat(edge);
    var MinMines = parseInt(minmines);
    var MaxMines = parseInt(maxmines);
    var MinAutoMines = 1;
    var MaxAutoMines = 24;
    var DefaultMines = 3;
    var WinMinesInFields = 3;
    var SelectedCell = [];
    var Step = 0;
    var Maxratio = calculate_maximum_payout(0.010);
    var MyBets = [];
    var AllBets = [];
    var AllBetsId = [];
    var Wait = false; //bet runing
    var Wait1 = false; //mouse over
    var DisabledGame = true;
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
    var diceAutobetCookieName = Idc + 'dice_autobet';

    var selectedNumbers = [];
    var mineRates = [];

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
        var bid = parseFloat($("#txtMineBet").val());

        $("#txtMines").removeClass("red_font");
        $("#txtMineBet").removeClass("red_font");

        if (bid < Minbid) {
            $("#txtMineBet").addClass("red_font");
            msg = msg + " Ставка слишком низкая. Минимальная ставка: " + Minbid.toFixed(2) + " " + coinname + ".";
            result = false;
        }
        if (bid > Balance) {
            $("#txtMineBet").addClass("red_font");
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
            var result = number.toLocaleString('en-US');
        } else {
            var result = number.toFixed(fixed).toLocaleString('en-US');
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

    getProvablyFair = function (longid, coin) {
        $.ajax({
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

    getBalance(Idc);
    getBets();
    // getProvablyFair(Longid, Idc);

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

    const activateUserBets = () => {
        $('.nav-tabs a[href="#my_bets"]').tab('show');
    }

    refreshBets = function () {
        getBets();
        setTimeout(function () { refreshBets(); }, 2000);
    }
    refreshBets();

    const getMinesRates = () => {
        $.ajax({
            type: 'POST',
            url: '/mines/getRates',
            contentType: "application/json",
            success: function (res) {
                mineRates = res;
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    };

    const setDefault = () => {
        getMinesRates();
        $("#txtMines").val(DefaultMines);
        $("#txtMineBet").val(Minbid);
        setTimeout(function () {
            renderHtmlRates(DefaultMines);
        }, 1000)

    }
    setDefault();

    $("#table_last_bets tbody").on("click", "tr", function () {
        $(this).toggleClass("active_row");
    });
    $("#table_my_bets tbody").on("click", "tr", function () {
        $(this).toggleClass("active_row");
    });

    $("#txtMines").keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        if (this.value > MaxMines) {
            this.value = MaxMines;
        }
        if (this.value < MinMines) {
            this.value = MinMines;
        }
        this.setSelectionRange(start, end);
        renderHtmlRates(this.value);
        manual_validate();
    });

    $('#txtMineBet').keyup(function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        this.setSelectionRange(start, end);
        manual_validate();
    });

    $(document).on('keyup', '#countAutoMine', function () {
        var start = this.selectionStart;
        var end = this.selectionEnd;
        this.value = this.value.replace(/[^0-9\.]/g, '');
        if (this.value < MinAutoMines) {
            this.value = MinAutoMines;
        }

        if (this.value > WinMinesInFields) {
            this.value = WinMinesInFields;
        }

        this.setSelectionRange(start, end);
        manual_validate();
    });

    const setPlaceholderMines = (mine) => {
        let win = 25 - mine;
        WinMinesInFields = win;
        $('#countWinMines').text(win);
        $('#countLossMines').text(mine);
    }

    const renderHtmlRates = (countMine) => {
        let html = '';
        $.each(mineRates, function(index, value) {
            if (parseInt(index) === parseInt(countMine)) {
                $.each(value, function(key, rate) {
                    html += `<div class="slick-container" data-step="${rate.step}">
                                <div class="mines-coeff mines-coeff-${rate.step}">
                                    <div class="coeff-square">
                                        <div class="mines_step">Шаг <span
                                                class="coeff-step">${rate.step}</span></div>
                                        <div class="coeff-number-wrapper"><span
                                                class="coeff-x">x</span><span class="coeff-number">${rate.coeff}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
            }
        });

        $('.mines-coeffs-slider').slick('unslick');
        $('.slick-container').remove();
        $('.mines-coeffs-slider').html(html);

        $('.mines-coeffs-slider').slick({
            dots: false,
            infinite: false,
            arrows: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
        });
        setPlaceholderMines(countMine);
    }

    $(".btnSetMine").on('click', function () { // set mines
        let mines = parseInt($(this).data('mine'));
        $("#txtMines").val(mines);
        renderHtmlRates(mines);
        manual_validate();
    });

    $("#btnMaxBet").on('click', function () { // max bid
        $("#txtMineBet").val((Balance).toFixed(2));
        manual_validate();
    });

    $("#btnMinBet").on('click', function () { // max bid
        $("#txtMineBet").val((Minbid).toFixed(2));
        manual_validate();
    });

    $("#btnDivBet").on('click', function () { // bid / 2
        var bet = parseFloat($("#txtMineBet").val());
        $("#txtMineBet").val((bet / 2).toFixed(2));
        if ((bet / 2) < Minbid) {
            $("#txtMineBet").val(Minbid.toFixed(2));
        }
        manual_validate();
    });

    $("#btnX2Bet").click(function () { // bid * 2
        var bet = parseFloat($("#txtMineBet").val());
        $("#txtMineBet").val((bet * 2).toFixed(2));
        if ((bet * 2) > (Balance)) {
            $("#txtMineBet").val((Balance).toFixed(2));
        }
        manual_validate();
    });

    $(document).on('click', '#btnMineAuto', function () {
        while (SelectedCell.length < 24) {
            let n = Math.floor(Math.random() * 25) + 1;
            if (SelectedCell.indexOf(n) === -1) {
                play(n);
                SelectedCell.push(n);
                return true;
            }
        }
    });

    $('.game-mine__numbers-item').on('click', function () {
        if (DisabledGame) {
            return false;
        }

        let cell = $(this).data('number');

        if (SelectedCell.indexOf(cell) === -1) {
            play(cell);
            SelectedCell.push(cell);
        }
    });

    // Start game
    $(document).on('click', '#btnMineStart', function () {
        if (manual_validate() === true) {
            startGame();
        }
    });

    $(document).on('click', '#btnPossibleWin', function () {
        if (Step > 0) {
            collect();
        }
    })

    const startGame = () => {
        let bet = parseFloat($("#txtMineBet").val());
        let mines = parseInt( $("#txtMines").val());
        let clientseed = getClientSeed();

        $('#countWinMines').text(WinMinesInFields);
        $('.btnSetMine').attr('disabled', 'disabled');
        $('.btnOperations').attr('disabled', 'disabled');
        $('#txtMineBet').attr('disabled', 'disabled');
        $('#txtMines').attr('disabled', 'disabled');
        showMessageManual('');
        showMessageSuccess('');

        $('.mines-coeff').removeClass('active');
        let slickSlider = $('.mines-coeffs-slider').slick('init');
        slickSlider.slick('slickGoTo', 0);

        $.ajax({
            type: 'POST',
            url: '/mines/create',
            data: {idc: Idc, sum: bet, mines_count: mines, clientseed: clientseed},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    DisabledGame = false;
                    Balance = res.balance;
                    showBalance(res.balance, idc);
                    $('#btnMineStart').remove();
                    $('.game-mine__numbers-item').attr('class', 'game-mine__numbers-item');
                    $('.mine-img').remove();
                    renderBtnPossibleWin(bet);
                    activateUserBets();
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const play = (cell) => {
        $.ajax({
            type: 'POST',
            url: '/mines/play',
            data: {idc: Idc, cell: cell},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    if (res.lose === true) {
                        Balance = res.balance;
                        showBalance(res.balance, idc);
                        renderLossCell(cell, res.mines, res.revealed);
                        renderBtnStart();
                        $('.btnSetMine').removeAttr('disabled');
                        $('.btnOperations').removeAttr('disabled');
                        $('#txtMineBet').removeAttr('disabled');
                        $('#txtMines').removeAttr('disabled');

                        SelectedCell = [];
                        DisabledGame = true;

                        // addToTable(content.BetData, "1");
                    } else {
                        let step = res.step;
                        Step = step;

                        renderWinCell(cell);

                        let winMines = parseInt($('#countWinMines').text());
                        $('#countWinMines').text(--winMines);
                        $('#possibleWin').text((res.possibleWin).toFixed(2));
                        $('#btnPossibleWin').removeAttr('disabled');

                        $('.mines-coeff').removeClass('active');
                        let slickSlider = $('.mines-coeffs-slider').slick('init');

                        let slide = $('.mines-coeffs-slider').find('.slick-container[data-step=' + step + ']');
                        if (slide) {
                            slide.find('.mines-coeff').addClass('active');
                            let indexSlick = slide.data('slick-index');
                            slickSlider.slick('slickGoTo', parseInt(indexSlick));
                        }
                    }
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
            url: '/mines/collect',
            data: {idc: Idc},
            dataType: 'json',
            success: function (res) {
                if (res.status === 'success') {
                    DisabledGame = true;
                    Step = 0;
                    showMessageSuccess('Вы выиграли ' + (res.won_sum).toFixed(2));
                    Balance = res.balance;
                    showBalance(res.balance, idc);
                    $('#btnPossibleWin').remove();
                    renderBtnStart();
                    SelectedCell = [];

                    $('.btnSetMine').removeAttr('disabled');
                    $('.btnOperations').removeAttr('disabled');
                    $('#txtMineBet').removeAttr('disabled');
                    $('#txtMines').removeAttr('disabled');

                    // addToTable(content.BetData, "1");

                    $.each($('.game-mine__numbers-item'), function() {
                        let number = $(this).data('number');

                        if (res.mines.indexOf(number) !== -1) {
                            let html = `<img class="mine-img" src="/assets/icons/mine-loss.png" alt="Неудача"><i class="mines-reveal-animation"></i>`;
                            $(this).addClass('gameDanger is_opacity').html(html);
                        } else {
                            if (res.revealed.indexOf(number) === -1) {
                                let html = `<img class="mine-img" src="/assets/icons/mine_win.png" alt="Успешно"><i class="mines-reveal-animation"></i>`;
                                $(this).addClass('gameSuccess is_opacity').html(html);
                            }
                        }
                    });
                }
            },
            error: function (msg) {
                console.log("not ok....");
            }
        });
    }

    const renderWinCell = (cell) => {
        let cellField = $('.game').find(".game-mine__numbers-item[data-number='" + cell + "']");
        let html = `<img class="mine-img" src="/assets/icons/mine_win.png" alt="Успешно"><i class="mines-reveal-animation"></i>`;
        cellField.addClass('gameSuccess').html(html);
    }

    const renderLossCell = (cell, mines, revealed) => {
        let cellField = $('.game').find(".game-mine__numbers-item[data-number='" + cell + "']");
        let html = `<img class="mine-img" src="/assets/icons/mine-loss.png" alt="Неудача">`;
        cellField.addClass('gameDanger').html(html);

        $.each($('.game-mine__numbers-item'), function() {
            let number = $(this).data('number');

            if (mines.indexOf(number) !== -1) {
                if (number !== cell) {
                    $(this).addClass('gameDanger is_opacity').html(html);
                }
            } else {
                if (revealed.indexOf(number) === -1) {
                    let html = `<img class="mine-img" src="/assets/icons/mine_win.png" alt="Успешно">`;
                    $(this).addClass('gameSuccess is_opacity').html(html);
                }
            }
        });
    }

    const renderBtnStart = () => {
        let html = '<button class="game-mine__button" id="btnMineStart">Играть</button>';
        $('.game-mine_buttons').html(html);
    }

    const renderBtnPossibleWin = (bet) => {
        let disabled = (Step > 0) ? '' : 'disabled';
        let html = `
<!--                <div class="auto_section_row">-->
<!--                    <input type="text" class="form-control text-center" value="1" id="countAutoMine">-->
<!--                    <div class="fz-12 text-center auto-count-desc">Количество ячеек</div>-->
<!--                    <button class="game-mine__button game-mine__button_small" id="btnMineAuto">Автовыбор</button>-->
<!--                </div>-->
                 <button class="game-mine__button game-mine__button_small" id="btnMineAuto">Автовыбор</button>
                <button class="game-mine__button" id="btnPossibleWin" ${disabled}><span>Забрать</span>&nbsp;<span id="possibleWin">${bet}</span></button>
            `;
        $('.game-mine_buttons').html(html);
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
                        "<td>" + convert_number(v.bet, 2) + "</td><td>" + convert_number(v.coeff, 2) + "x</td>";

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
                    append = append + "<td><img class='result_coin' src='/assets/currency/" + v.idc.trim() + ".png' height='25' width='25'></td></tr>";

                    var row = $(append);
                    $("#table_my_bets_head").after(row);

                    $("#myrow_" + (MyBetCount - 200)).removeData();
                    $("#myrow_" + (MyBetCount - 200)).detach();
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
