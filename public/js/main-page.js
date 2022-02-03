



// -------------------------- Game popup --------------------------
function openPopup(game) {
    if (game == undefined) {
        game = "dice";
    }
    $('#game-popup-' + game).show();
    $('#game-popup-' + game).addClass("animate__fadeInDown");
    $('#game-popup-' + game).removeClass("animate__fadeOutDown");
    $('#game-popup-' + game + " .game-popup-overlay").addClass("animate__fadeIn");
    $('#game-popup-' + game + " .game-popup-overlay").removeClass("animate__fadeOut");
}

function closePopup(game) {
    $('#game-popup-' + game).removeClass("animate__fadeInDown");
    $('#game-popup-' + game).addClass("animate__fadeOutDown");
    $('#game-popup-' + game + " .game-popup-overlay").removeClass("animate__fadeIn");
    $('#game-popup-' + game + " .game-popup-overlay").addClass("animate__fadeOut");
    setTimeout(function () {
        $('#game-popup-' + game).hide();
    }, 300);
}

$(document).ready(function () {

    var rows, jackpots;

    getWinners = function () {
        $.ajax(
            {
                type: 'GET',
                url: '/api/winnersfeed/',
                contentType: "application/json",
                success: function (msg) {
                    rows = msg;
                    var i = 0;
                    for (i = 0; i < 7; i++) {
                        createRow(rows[Math.floor(Math.random() * rows.length)]);                        
                    }

                    setInterval(() => {
                        createRow(rows[Math.floor(Math.random() * rows.length)]);
                        var tableBody = $("#results-table-body");
                        var tableRows = tableBody.find("tr");
                        tableRows.last().remove();
                    }, 1000);
                },
                error: function (msg) {
                }
            });
    };
    getWinners();

    getJackpots = function () {
        $.ajax(
            {
                type: 'GET',
                url: '/api/jackpots/',
                contentType: "application/json",
                success: function (msg) {
                    jackpots = msg;
                    jackpots.forEach(jackpot => {

                        var jackpots1 = $(".jackpots");
                        var div = document.createElement("div");
                        div.className = "jackpot";
                        div.innerHTML = "<img class='jackpot-icon' src='/index/assets/icons/progressive-jackpots-big.png' />" +
                            "<div class='jackpot-message'>Current jackpot for <span class='jackpot-game'>DICE <img src='/index/assets/games/dice.png' /></span> and <span class='jackpot-game'>ROULETTE <img src='/index/assets/games/roulette.png' /></span> is</div>" +
                            "<div class='jackpot-amount' data-amount='" + jackpot.Jackpot.toFixed(8) + "' data-change='" + jackpot.JackpotChange.toFixed(8) + "'>" + jackpot.Jackpot.toFixed(8) + " " + jackpot.Coin + "</div>" +
                            "<div class='jackpot-coin'>" + jackpot.Coin + "</div>" +
                            "<button class='btn btn-primary' onclick='openPopup()'>Play now!</button>";
                        jackpots1.append(div);
                    });

                    if ($('.jackpots').length) {
                        $('.jackpots').slick({
                            dots: true,
                            infinite: true,
                            speed: 300,
                            slidesToShow: 1,
                            adaptiveHeight: true,
                            arrows: false,
                            autoplay: true,
                            autoplaySpeed: 5000
                        });
                    }
                },
                error: function (msg) {
                }
            });
    };
    getJackpots();

    setInterval(function () {
        $(".jackpot").each(function () {
            var AmountText = $(this).children(".jackpot-amount");
            var Jackpot = parseFloat($(AmountText).data("amount"));
            var JackpotChange = parseFloat($(AmountText).data("change"));
            var Decimals = 8;
            var TempChange = 0;

            if (JackpotChange > 0) {
                TempChange = JackpotChange / 3480 / 10; // that is average change in a second
            }
            else {
                TempChange = 0;
            }

            if (TempChange < 0.0000001) {
                Decimals = 8;
            }
            else if (TempChange < 0.000001) {
                Decimals = 7;
            }
            else if (TempChange < 0.00001) {
                Decimals = 6;
            }
            else if (TempChange < 0.0001) {
                Decimals = 5;
            }
            else if (TempChange < 0.001) {
                Decimals = 4;
            }
            else if (TempChange < 0.01) {
                Decimals = 3;
            }
            else if (TempChange < 0.1) {
                Decimals = 2;
            }
            else if (TempChange < 1) {
                Decimals = 1;
            }
            else {
                Decimals = 0;
            }


            var NewJackpot = Jackpot + TempChange; 
            AmountText.data("amount", NewJackpot);
            AmountText.text(NewJackpot.toFixed(Decimals));
        })
    }, 100);


    function createRow(data) {
        var tableBody = $("#results-table-body");
        var tr = document.createElement("tr");

        var td = document.createElement("td");
        td.className = "result-game";
        td.innerHTML = "<img src='/index/assets/games/" + data.game.toLowerCase().replace(" ", "") + ".png'/>" + data.game;
        tr.append(td);

        td = document.createElement("td");
        td.className = "result-user";
        if (data.userHidden) td.className += " hidden";
        td.innerHTML = data.user_id;
        tr.append(td);

        td = document.createElement("td");
        td.className = "result-bet";
        td.innerHTML = "<img src='/index/assets/coins/" + data.idc.trim() + ".png'/>" + data.bet.toFixed(data.decimals);
        tr.append(td);

        td = document.createElement("td");
        td.className = "result-payout";
        data.profit >= 0 ? td.className += " positive" : td.className += " negative";
        td.innerHTML = "<img src='/index/assets/coins/" + data.idc.trim() + ".png'/>" + data.profit.toFixed(data.decimals);
        tr.append(td);

        tableBody.prepend(tr);
    }

    var cookieString = decodeURIComponent(document.cookie);

    if (cookieString.indexOf('cookieBanner=1') == -1) {
        var cookieBanner = '<div id="cookieBanner" style="opacity: 0.8;background:#151515;padding:10px 0;position:fixed;bottom:0;left:0;right:0;">\
                                <div class="container">\
                                    <div class="row small" style="display:flex;align-items:center; ">\
                                        <div class="col-9" style="color:white; ">\
                                            This website uses cookies to improve functionality and tailor your browsing experience.<br>\
                                            By pressing \'OK\' you accept the cookie policy listed in our <a href="/privacy" target="_blank" style="color:white;">Privacy Policy</a>.\
                                        </div>\
                                        <div class="col-2 text-right" style="margin: 5px;">\
                                            <button class="btn cookie-accept">OK</button>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>';

        $('body').append(cookieBanner);

        $('body').on('click', '.cookie-accept', function () {
            $('#cookieBanner').remove();
            document.cookie = 'cookieBanner=1';
        });

    }
    $("<img/>")[0].src = "/index/assets/loading.gif"; // caching loading animation
});


