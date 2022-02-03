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
}

function getNumber(string) {
    return parseInt(string.replace(/[^\d]/g, ''));
}

function isMobile() {
    var check = false;
    (function (a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
}

function saveSettings() {
    setCookie('chat-settings', JSON.stringify(chatSettings), 120);
}

function initChat() {
    if (getCookie('chat-settings')) {
        chatSettings = JSON.parse(getCookie('chat-settings'));
        dockChat(chatSettings.dock);
    } else {
        chatSettings = {
            props: {
                left: {
                    w: 400,
                    h: -1,
                    x: -1,
                    y: -1
                },
                right: {
                    w: 400,
                    h: -1,
                    x: -1,
                    y: -1
                },
                bottom: {
                    w: -1,
                    h: 300,
                    x: -1,
                    y: -1
                },
                floating: {
                    w: 400,
                    h: 300,
                    x: 75,
                    y: 125
                }
            }
        };
        if ($(window).width() < 1382) {
            chatSettings.dock = 'bottom';
            saveSettings();
            dockChat('bottom');
        } else {
            chatSettings.dock = 'left';
            saveSettings();
            dockChat('left');
        }
    }
    $('.channel-select').html("<i class = 'fa fa-flag'></i> English");
}

function dockChat(dock) {
    $('.chat, body > .container-fluid').removeClass('chat-left chat-right chat-bottom chat-floating');
    $('.chat, .chat-holder, body > .container-fluid, body > .container-fluid .navbar, body > .container-fluid .open-chat').removeAttr('style');
    if ($('.chat').hasClass('ui-draggable')) {
        $('.chat').draggable('destroy');
    }
    if ($('.chat').hasClass('ui-resizable')) {
        $('.chat').resizable('destroy');
    } else {
        $('.chat .ui-resizable').resizable('destroy');
    }
    if (isMobile()) {
        dock = 'bottom';
        $('.chat .chat-dock').hide();
    }
    switch (dock) {
        case 'left':
            chatSettings.dock = 'left';
            $('.chat, body > .container-fluid').addClass('chat-left');
            $('.chat-holder').width((isMobile() ? $(window).width() - 100 : chatSettings.props.left.w));
            if (!$('.chat').hasClass('chat-hidden')) {
                console.log('d');
                $('body > .container-fluid, body > .container-fluid .navbar').css('width', 'calc(100% - ' + (chatSettings.props.left.w + 2) + 'px)');
                $('body > .container-fluid .open-chat').css('left', (chatSettings.props.left.w + 2));
            }
            if (!isMobile()) {
                $('.chat-holder').resizable({
                    handles: 'e',
                    maxWidth: 600,
                    minWidth: 300,
                    disabled: ($('.chat').hasClass('chat-hidden') ? true : false),
                    resize: function () {
                        $('body > .container-fluid, body > .container-fluid .navbar').css('width', 'calc(100% - ' + ($('.chat-holder').width() + 2) + 'px)');
                        $('body > .container-fluid .open-chat').css('left', ($('.chat-holder').width() + 2));
                    },
                    stop: function () {
                        chatSettings.props.left.w = $('.chat-holder').width();
                        saveSettings();
                    }
                });
            }
            break;
        case 'right':
            chatSettings.dock = 'right';
            $('.chat, body > .container-fluid').addClass('chat-right');
            $('.chat-holder').width((isMobile() ? $(window).width() - 100 : chatSettings.props.right.w));
            if (!$('.chat').hasClass('chat-hidden')) {
                $('body > .container-fluid, body > .container-fluid .navbar').css('width', 'calc(100% - ' + (chatSettings.props.right.w + 2) + 'px)');
                $('body > .container-fluid .open-chat').css('right', (chatSettings.props.left.w + 2));
            }
            if (!isMobile()) {
                $('.chat-holder').resizable({
                    handles: 'w',
                    maxWidth: 600,
                    minWidth: 300,
                    disabled: ($('.chat').hasClass('chat-hidden') ? true : false),
                    resize: function () {
                        $('body > .container-fluid, body > .container-fluid .navbar').css('width', 'calc(100% - ' + ($('.chat-holder').width() + 2) + 'px)');
                        $('body > .container-fluid .open-chat').css('right', ($('.chat-holder').width() + 2));
                    },
                    stop: function () {
                        chatSettings.props.right.w = $('.chat-holder').width();
                        saveSettings();
                    }
                });
            }
            break;
        case 'bottom':
            chatSettings.dock = 'bottom';
            $('.chat, body > .container-fluid').addClass('chat-bottom');
            $('.chat').height((isMobile() ? 300 : chatSettings.props.bottom.h));
            $('.chat').prepend("<div class = 'chat-bottom-handle ui-resizable-handle ui-resizable-n'></div>");
            if (!isMobile()) {
                $('.chat').resizable({
                    handles: {
                        'n': '.chat-bottom-handle'
                    },
                    minHeight: 250,
                    maxHeight: 400,
                    disabled: ($('.chat').hasClass('chat-hidden') ? true : false),
                    stop: function () {
                        chatSettings.props.bottom.h = $('.chat').height();
                        saveSettings();
                    }
                });
            }
            break;
        case 'floating':
            chatSettings.dock = 'floating';
            $('.chat, body > .container-fluid').addClass('chat-floating');
            $('.chat').css({
                width: chatSettings.props.floating.w,
                height: chatSettings.props.floating.h,
                top: chatSettings.props.floating.y,
                left: chatSettings.props.floating.x
            });
            $('.chat').draggable({
                handle: '.chat-controls',
                containment: 'body',
                stop: function () {
                    chatSettings.props.floating.x = getNumber($('.chat').css('left'));
                    chatSettings.props.floating.y = getNumber($('.chat').css('top'));
                    saveSettings();
                }
            });
            $('.chat').resizable({
                handles: 'all',
                minWidth: 350,
                minHeight: 250,
                disabled: ($('.chat').hasClass('chat-hidden') ? true : false),
                containment: 'body',
                stop: function () {
                    chatSettings.props.floating.w = $('.chat').width();
                    chatSettings.props.floating.h = $('.chat').height();
                    saveSettings();
                }
            });
            break;
    }
    saveSettings();
}

function expandChat() {
    $("#divChatAll").show();
    $(".caption_messages").html('');
    if ($('.chat').hasClass('ui-resizable')) {
        $('.chat').resizable('enable');
    } else {
        $('.chat .ui-resizable').resizable('enable');
    }
    $('.chat, body > .container-fluid, body > .container-fluid .navbar, body > .container-fluid .open-chat').removeClass('no-transition');
    $('.chat').removeClass('chat-hidden');
    setTimeout(function () {
        $('.chat, body > .container-fluid, body > .container-fluid .navbar, body > .container-fluid .open-chat').addClass('no-transition');
    }, 500);
    if ($('.chat').hasClass('chat-left') || $('.chat').hasClass('chat-right')) {
        var chatWidth = parseInt($('.chat-holder').width()) + 2;
        $('body > .container-fluid, body > .container-fluid .navbar').css('width', 'calc(100% - ' + chatWidth + 'px)');
        if ($('.chat').hasClass('chat-left')) {
            $('body > .container-fluid .open-chat').css('left', chatWidth);
        } else {
            $('body > .container-fluid .open-chat').css('right', chatWidth);
        }
    }
}

function hideChat() {
    NewMessages = 0;
    if ($('.chat').hasClass('ui-resizable')) {
        $('.chat').resizable('disable');
    } else {
        $('.chat .ui-resizable').resizable('disable');
    }
    $('.chat, body > .container-fluid, body > .container-fluid .navbar, body > .container-fluid .open-chat').removeClass('no-transition');
    $('.chat').addClass('chat-hidden');
    setTimeout(function () {
        $('.chat, body > .container-fluid, body > .container-fluid .navbar, body > .container-fluid .open-chat').addClass('no-transition');
    }, 500);
    if ($('body > .container-fluid').attr('style') || $('body > .container-fluid .navbar').attr('style')) {
        $('body > .container-fluid, body > .container-fluid .navbar').removeAttr('style');
        $('body > .container-fluid .open-chat').removeAttr('style');
    }
}

function closeChatPopups() {
    $('.chat-channels').toggleClass('popup-hidden popup-shown');
}
$(document).ready(function () {
    var chatSettings = {};
    initChat();
    $('.open-chat').click(function () {
        if ($('.chat').hasClass('chat-hidden')) {
            expandChat();
        } else {
            hideChat();
        }
    });
    $('.channel-select').click(function () {
        $('.chat-channels').toggleClass('popup-hidden popup-shown');
    });
    $('.chat-channels button').click(function () {
        if ($(this).data('channel') != '30') {
            var channel = $(this).data('channel');
            var name = $(this).data('name');
            var fullname = $(this).data('fullname');
            var icon = $(this).data('icon');

            $('.chat iframe').attr('src', '/chat/chat.aspx?channel=' + channel);
            $('.channel-select').html("<i class='fa " + icon + "'></i> " + fullname);
            $('.chat').attr('data-channel', channel);
            $(this).attr('title', fullname);
        } else {
            $('.chat iframe').attr('src', '/chat/usersonline.aspx');
            $('.channel-select').html("<i class = 'fa fa-user'></i> Online Users");
        }
    });
    $('.chat').click(function (e) {
        if (!$(e.target).hasClass('channel-select')) {
            $('.chat-channels.popup-shown').toggleClass('popup-hidden popup-shown');
        }
    });
    $('.chat-dock-button').click(function () {
        dockChat($(this).data('dock'));
    });
});