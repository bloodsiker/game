$(".a_window").fancybox({
    autoscale: true,
    transitionIn: 'none',
    transitionOut: 'none',
    type: 'iframe',
});
$(".a_swindow").fancybox({
    minHeight: 700,
    minwidth: 800,
    transitionIn: 'none',
    transitionOut: 'none',
    type: 'iframe',
});
$(".a_bwindow").fancybox({
    autoscale: true,
    transitionIn: 'none',
    transitionOut: 'none',
    type: 'iframe',
});
$(".a_fwindow").fancybox({
    maxHeight: 600,
    minwidth: 800,
    transitionIn: 'none',
    transitionOut: 'none',
    type: 'iframe',
});
$(".a_gwindow").fancybox({
    autoscale: false,
    autoDimensions: false,
    width: 600,
    transitionIn: 'none',
    transitionOut: 'none',
    type: 'iframe'
});
$(".a_iwindow").fancybox({
    autoscale: true,
    //autoDimensions: false,
    width: 600,
    transitionIn: 'none',
    transitionOut: 'none',
    type: 'image'
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// (function (i, s, o, g, r, a, m) {
//     i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
//         (i[r].q = i[r].q || []).push(arguments)
//     }, i[r].l = 1 * new Date(); a = s.createElement(o),
//         m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
// })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
//
// ga('create', 'UA-53690490-1', 'auto');
// ga('send', 'pageview');

function ShowUser(nick) {
    var href = "/player/" + nick;
    $.fancybox.open({
        href: href,
        autoscale: false,
        autoDimensions: false,
        width: 800,
        transitionIn: 'none',
        transitionOut: 'none',
        type: 'iframe'
    });
}

function ShowBet(id, type) {
    if (type == 1) {
        var href = "/bet/dice/" + id;
    }
    else if (type == 2) {
        var href = "/bet/slot/" + id;
    }
    else if (type == 3) {
        var href = "/bet/blackjack/" + id;
    }
    else if (type == 4) {
        var href = "/bet/roulette/" + id;
    }
    else if (type == 5) {
        var href = "/bet/videopoker/" + id;
    }
    else if (type == 6) {
        var href = "/bet/plinko/" + id;
    }
    else if (type == 7) {
        var href = "/bet/minesweeper/" + id;
    }
    $.fancybox.open({
        href: href,
        autoscale: false,
        autoDimensions: false,
        width: 800,
        transitionIn: 'none',
        transitionOut: 'none',
        type: 'iframe'
    });
}

function ShowFaq() {
    var href = "/faq"
    $.fancybox.open({
        href: href,
        autoscale: false,
        autoDimensions: false,
        width: 800,
        transitionIn: 'none',
        transitionOut: 'none',
        type: 'iframe'
    });
}

function ShowAbout() {
    var href = "/aboutus"
    $.fancybox.open({
        href: href,
        autoscale: false,
        autoDimensions: false,
        width: 800,
        transitionIn: 'none',
        transitionOut: 'none',
        type: 'iframe'
    });
}

function ShowRules() {
    var href = "/chatrules"
    $.fancybox.open({
        href: href,
        autoscale: false,
        autoDimensions: false,
        width: 800,
        transitionIn: 'none',
        transitionOut: 'none',
        type: 'iframe'
    });
}

function ShowTos() {
    var href = "/terms"
    $.fancybox.open({
        href: href,
        autoscale: false,
        autoDimensions: false,
        width: 800,
        transitionIn: 'none',
        transitionOut: 'none',
        type: 'iframe'
    });
}

var balancerefresh = true;
function RefreshBalance(x) {
    if (x) {
        balancerefresh = true;
        getBalance(coin);
    } else {
        balancerefresh = false;
    }
}


var NewMessages = 0;
var ActiveChannel = "1";
var Chat = 0; // chat open
var d = new Date();
var diff = (parseInt(serverTime) - d.getTime()); // time difference between server and client time

function IncreaseMessageCount(channel) {
    if (channel == $('.chat').data('channel') && $('.chat').hasClass('chat-hidden')) {
        NewMessages = NewMessages + 1;

        $(".caption_messages").text((NewMessages < 100 ? '(' + NewMessages + ')' : '(99+)'));
    }
};

function UsersOnline(users) {
    $(".caption_users").text('Users online: ' + users);
}


function Connected(status) {
    if (status) {
        $(".caption_status").removeClass("glyphicon-red");
        $(".caption_status").addClass("glyphicon-green");
    }
    else {
        $(".caption_status").addClass("glyphicon-red");
        $(".caption_status").removeClass("glyphicon-green");
    }
}

function Reload() {
    location.reload();
}


getDate = function (datetime) {
    var d = datetime.getDate();
    var m = datetime.getMonth() + 1;
    var y = datetime.getFullYear();

    if (d < 10) d = '0' + d;
    if (m < 10) m = '0' + m;

    var result = d + "/" + m + "/" + y;

    return result;
};

getTime = function (datetime) {
    var h = datetime.getHours();
    var m = datetime.getMinutes();
    var s = datetime.getSeconds();
    if (h < 10) h = '0' + h;
    if (m < 10) m = '0' + m;
    if (s < 10) s = '0' + s;

    var result = h + ":" + m + ":" + s;

    return result;
}

const numberWithSpaces = (x) => {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

const numberWithSpacesDouble = (x) => {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    return parts.join(".");
}


$(document).ready(function () {
    Connected(false);
    UsersOnline("0");

    var HRBetIdMax = 0;
    var HRBetCount = 0;
    var Active_tab = "";
    var JackpotIdMax = 0;
    var JackpotCount = 0;
    var Jackpot = 0;
    var FirstTime = true;

     showBalance = function (balance, idc) {
        if (balance >= 0) {
            $("#lblBalance").html("Баланс: " + numberWithSpacesDouble(convert_number(balance, 2)));
            $("#lblCoinName").html(idc);
        }
    }


    $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
        var str = e.target.text;
        str = str.trim();
        TabChange = true;
        var active = "Active_tab";

        if (str.indexOf("High rolls") >= 0) {
            Active_tab = "High rolls";
            $("#badge_high_roller").text("");
            HighRoll = HRBetCount;
        }

        if (str.indexOf("Jackpots") >= 0) {
            Active_tab = "Jackpots";
            $("#badge_jackpot").text("");
        }
    })

    getJackpots = function () {
        $.ajax(
            {
                type: 'GET',
                url: '/api/dicejackpots/',
                contentType: "application/json",
                success: function (msg) {
                    if (msg.length > 0) {
                        addToTableJackpots(msg);
                    }
                },
                error: function (msg) {
                    console.log("not ok....")
                }
            });
    };

    refreshJackpots1 = function () {
        getJackpots();
        setTimeout(function () { refreshJackpots1(); }, 5000);
    }
    refreshJackpots1();

    addToTableJackpots = function (text) {
        var data = text;
        var found = false;
        var timeout = 0;
        $.each(data, function (i, v) {
            if (v == null) return;

            var id = v.idj;
            if (id > JackpotIdMax) {
                JackpotIdMax = id;
                found = false;
            }
            else {
                found = true;
            }

            id = v.id;

            if (found != true) {
                JackpotCount = JackpotCount + 1;

                var append = "<tr id='jackrow_" + JackpotCount + "'>";
                id = convert_number(id, 0);
                date = getDate(new Date(v.time));

                append = append + "<td>" + v.game + "</td><td><a class='a_bwindow' href='/bet/" + v.game.toLowerCase() + "/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                    "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                    "<td><a href='" + v.link + "' target='_blank'>" + v.coinname + "</a></td>" +
                    "<td>" + convert_number(v.portion, 4) + "%</td>" +
                    "<td class='green_font text-right'>" + convert_number(v.reward, 8) + "</td>";

                append = append + "<td><a href='" + v.link + "' target='_blank'><img class='result_coin' src='/index/assets/coins/" + v.idc.trim() + ".png' height='25' width='25'></a></td></tr>";

                var row = $(append);
                $("#table_jackpots_head_2").after(row);

                if (Active_tab != "Jackpots") {
                    $("#badge_jackpot").text(JackpotCount - Jackpot);
                }
                else {
                    Jackpot = JackpotCount;
                }
            }
        });
        if (FirstTime) { // we reset jackpot first time
            FirstTime = false;
            $("#badge_jackpot").text("");
        }
    };

    getHighRolls = function () {
        $.ajax(
            {
                type: 'GET',
                url: '/api/allhighrolls/',
                contentType: "application/json",
                success: function (msg) {
                    if (msg.length > 0) {
                        addToTableHighRolls(msg);
                    }
                },
                error: function (msg) {
                    console.log("not ok....")
                }
            });
    };

    refreshHighRollers1 = function () {
        getHighRolls();
        setTimeout(function () { refreshHighRollers1(); }, 5000);
    }
    refreshHighRollers1();

    $(document).click(function (event) {
        var clickover = $(event.target);
        var $navbar = $(".navbar-collapse");
        var _opened = $navbar.hasClass("in");
        if (_opened === true && !clickover.hasClass("navbar-toggle")) {
            $navbar.collapse('hide');
        }
    });

    addToTableHighRolls = function (text) {
        var data = text;
        var found = false;
        var timeout = 0;
        $.each(data, function (i, v) {
            if (v == null) return;

            var id = v.id;
            if (v.idhigh > HRBetIdMax) {
                HRBetIdMax = v.idhigh;
                found = false;
            }
            else {
                found = true;
            }

            if (found != true) {
                HRBetCount = HRBetCount + 1;

                var append = "<tr id='highrow_" + HRBetCount + "'>";

                id = convert_number(id, 0);
                var date = v.time;
                date = date.substr(date.length - 8);;

                append = append + "<td>" + v.game + "</td><td><a class='a_bwindow' href='/bet/" + v.game.toLowerCase().replace(" ", "") + "/" + v.id + "'>" + id + "</a></td><td class='hidden-xs'>" + date + "</td>" +
                    "<td><a class='a_swindow' href='/player/" + v.user_id + "'>" + v.user_id + "</a></td>" +
                    "<td><a href='" + v.link + "' target='_blank'>" + v.coinname + "</a></td>" +
                    "<td>" + convert_number(v.bet, 8) + "</td>";
                if (v.profit >= 0) {
                    append = append + "<td class='green_font text-right'>" + convert_number(v.profit, 8) + "</td>"
                }
                else {
                    append = append + "<td class='red_font text-right'>" + convert_number(v.profit, 8) + "</td>"
                }
                append = append + "<td><a href='" + v.link + "' target='_blank'><img class='result_coin' src='/index/assets/coins/" + v.idc.trim() + ".png' height='25' width='25'></a></td></tr>";

                var row = $(append);
                $("#table_high_rollers_head").after(row);


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
    };

    var Nonce = 1;
    var AddNonce = false;
    var RandomSeed = true;
    var Seed = "";

    $("#txtNextClientSeed").on("input", function () {
        Seed = $("#txtNextClientSeed").val();
        if (Seed.length > 34) {
            Seed = Seed.substring(0, 34);
        }
        $("#txtNextClientSeed").val(Seed);
    });


    $("#txtNextClientSeed").on("change", function () {
        Nonce = 1;
        generateNewClientSeed();
    });

    $("#btnRandomSeed").click(function () {
        Nonce = 1;
        RandomSeed = true;
        $("#chkManualSeed").attr('checked', false);
        $("#divManualSeedNonce").hide();
        generateNewClientSeed();
        return false;
    });

    $("#chkManualSeed").click(function () {
        var c = $("#chkManualSeed").is(':checked');
        if (c) {
            $("#txtNextClientSeed").val("");
            $("#txtNextClientSeed").attr('readonly', false);
            $("#divManualSeedNonce").show();
            RandomSeed = false;
            sessionStorage.clientseed = "";
        }
        else {
            $("#txtNextClientSeed").attr('readonly', true);
            $("#divManualSeedNonce").hide();
            $("#btnRandomSeed").click();
        }
        Seed = $("#txtNextClientSeed").val();
        return true;
    });

    $("#chkManualSeedNonce").click(function () {
        var c = $("#chkManualSeedNonce").is(':checked');
        Nonce = 1;
        if (c) {
            AddNonce = true;
        }
        else {
            AddNonce = false;
        }
        if (Seed.length > 0) {
            generateNewClientSeed();
        }
        return true;
    });

    generateNewClientSeed = function () {
        let seed = clientSeed();
        sessionStorage.clientseed = seed;
        $("#txtNextClientSeed").val(seed);
    }

    getClientSeed = function () {
        return sessionStorage.clientseed;
    }

    clientSeed = function () {
        var result = "";

        if (RandomSeed) {
            var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
            var crypto = null;
            try {
                crypto = new Uint8Array(40);
                window.crypto.getRandomValues(crypto);
            }
            catch (e) {
            }

            if (crypto === undefined || (crypto[0] == 0 && crypto[1] == 0 && crypto[2] == 0)) // we replace it with null in such cases (iOS issues and new IE issue)
            {
                crypto = null;
            }

            for (var i = 0; i < 40; i++) {
                if (crypto != null) { // if browser supports window.crypto library then we use it
                    var rnum = crypto[i] % chars.length;
                }
                else {
                    var rnum = Math.floor(Math.random() * chars.length);
                }
                result += chars.substring(rnum, rnum + 1);
            }
        }
        else { // client set seed
            if (AddNonce) {
                result = Seed + "-" + Nonce;
                Nonce = Nonce + 1;
            }
            else {
                result = Seed;
            }
        }

        return result;
    };


    timer2 = setInterval(function () {
        var now = new Date(Date.now() + diff);
        var now_utc = new Date(now.getTime() + now.getTimezoneOffset() * 60000);
        $("#txtServerTime").text(now_utc.toLocaleString("en-GB"));
    }, 1000);

    var idc = coin;
    var loop = 3;
    var timer1;
    var logedin = false;
    var notice = "";
    var timestamp = null;


    $("a[href=#switchcolor]").click(function (e) {
        e.preventDefault();
        var color = $(this).data("color");
        $.ajax(
            {
                type: 'POST',
                url: '/account.aspx/ChangeColor',
                data: '{color:"' + color + '"}',
                contentType: "application/json",
                success: function (msg) {
                    Reload();
                },
            });
    });

    $("#chat_frame").resizable({
        handles: {
            'n': '#ngrip',
            'ne': '#negrip',
            'e': '#egrip'
        },
        start: function (event, ui) {
            $("#mask").css("display", "block");
        },
        stop: function (event, ui) {
            $("#mask").css("display", "none");
        }
    });

    $("#chat_frame").on("resize", function (event, ui) {
        for (i = 0; i < 20; i++) {
            try {
                var chat_iframe = document.getElementById("chat_iframe_" + i);
                if (chat_iframe != null) {
                    chat_iframe.contentWindow.scrollDown();
                }
            }
            catch (e) {

            }
        }
    });

    $("#chat_iframe_1").show();

    //$("[data-toggle='popover']").popover();

    // $("#lblUsdBalance").tooltip();

    $(".tooltipLink").tooltip();

    $('.dropdown-toggle').dropdown();

    var lottoCoins = ["bitcoin", "dogecoin", "ethereum", "litecoin"];

    $(".dropdown-menu li a").click(function () {
        var game = $(this).data("game");
        var coin = $(this).data("coin");
        var channel = $(this).data("channel");
        var name = $(this).data("name");

        var filtercoin = $(this).data("filtercoin");

        if (filtercoin != null) {

            var $target = $(this),
                val = $target.attr('data-filtercoin'),
                $inp = $target.find('input'),
                idx;

            if ((idx = coinslist.indexOf(val)) > -1) {
                coinslist.splice(idx, 1);
                setTimeout(function () { $inp.prop('checked', false) }, 0);
            } else {
                coinslist.push(val);
                setTimeout(function () { $inp.prop('checked', true) }, 0);
            }

            $(this).blur();

            return false;
        }

        var type = $(this).data("type");
        if (type != null && (type == "game" || type == "coin")) {
            if (game == null) {
                game = gamename;
            }
            if (name == null) {
                name = coinname;
            }
            var url = "/" + game + "/" + name;
            $(location).attr("href", url);
        }


        if (channel != null) {

            if (channel == 20) {
                document.getElementById("chat_iframe_" + channel).src = "/chat/usersonline.aspx";
            }

            for (i = 1; i <= 20; i++) {
                if (i != channel) {
                    $("#chat_iframe_" + i).hide();
                }
            }
            $("#span-channel").text(name);
            $("#chat_iframe_" + channel).show();

            document.getElementById("chat_iframe_" + channel).contentWindow.scrollDown();

            ActiveChannel = channel;
            NewMessages = 0;

        }

    });

    convert_number = function (number, fixed) {
        if (fixed == 0) {
            var result = number.toLocaleString('en-US');
        }
        else {
            var result = number.toFixed(fixed).toLocaleString('en-US');
        }

        return result;
    };

    getBalance = function (idc) {
        if (balancerefresh) {
            $.ajax({
                type: 'POST',
                url: '/getBalance',
                data: {idc: idc},
                dataType: 'json',
                success: function (msg) {
                    let balance = parseFloat(msg.d);
                    if (balance >= 0) {
                        showBalance(balance, idc);
                        Balance = balance;
                        BalanceCredits = balance * parseFloat(ratio);
                        try {
                            window.updateBalance(Math.floor(BalanceCredits));
                        }
                            catch (e) {
                        }
                    }
                },
                error: function (msg) {

                }
            });
        }
    };

    var OldJackpot = 0;
    var NewJackpot = 0;
    var TempBalance = 0;
    var TempChange = 0;

    var JackpotTimer = setInterval(function () {
        TempBalance = TempBalance + TempChange;
        JackpotObject.text("Jackpot balance: " + TempBalance.toFixed(8) + " " + coin);
    }, 100);




    var JackpotObject = $("#txtJackpotBalance");
    getUsersOnline = function () {
        $.ajax(
            {
                type: 'POST',
                url: '/stats.asmx/GetUsersOnline',
                data: '{idc:"' + coin + '"}',
                contentType: "application/json",
                success: function (msg) {
                    if (msg.d.length > 0) {
                        var content = JSON.parse(msg.d);
                        //$("#caption_users").text("Online users: " + content.Online);

                        NewJackpot = parseFloat(content.Jackpot) - parseFloat(content.JackpotChange);
                        if (NewJackpot < 0) {
                            NewJacpot = 0;
                        }

                        if (TempBalance == 0) {
                            TempBalance = NewJackpot;
                        }

                        if (parseFloat(content.JackpotChange) > 0) {
                            TempChange = parseFloat(content.JackpotChange) / 3480 / 10; // that is average change in a second
                        }
                        else {
                            TempChange = 0;
                        }

                        if (TempChange <= 0) {
                            JackpotObject.text("Jackpot balance: " + NewJackpot.toFixed(8) + " " + coin);
                        }


                        if (parseFloat(content.PendingDeposits) > 0) {
                            $("#lblPending").html("[Pending " + parseFloat(content.PendingDeposits).toFixed(8) + " " + coin + "]");
                        }
                        else {
                            $("#lblPending").html("");
                        }


                        if (content.Timestamp != getCookie("timestamp")) { // timestamp changed, we have new notice
                            notice = content.Notice;

                            timestamp = content.Timestamp;

                            if (notice != "") {
                                showNotice(notice);
                            }
                            else {
                                hideNotice();
                            }
                        }
                    }
                },
            });
    };

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    };

    refreshData = function () {
        getBalance(idc);
        if (loop % 5 == 0) {
            getUsersOnline();
        }
        loop++;
        setTimeout(function () { refreshData(); }, 2000);
    };
    refreshData();

    $("#upper-alert .close").click(function (e) {
        $("#upper-alert").slideUp("slow");
        setCookie("timestamp", timestamp, 1);
    });

    showNotice = function (text) {
        if (LoggedIn == "False" && ShowLogIn == "False") { // users without security set have different notice
            text = "As you have not done so yet, we strongly encourage you to protect your account with a unique password under <a class='a_swindow' href='/account/settings/btc'>Your account > Settings > Security</a>.";
        }
        $("#upper-alert .text").html(text);
        $("#upper-alert").slideDown("slow");
    };

    hideNotice = function () {
        $("#upper-alert .text").html("");
        $("#upper-alert").slideUp("slow");
    }

    setTimeout(function () { $(".load").fadeOut(); }, 3000);

    console.warn("Do not copy anything in it if somebody claims they can help you win. They can steal your coins.");
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
