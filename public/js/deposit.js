$(document).ready(function () {

    $('#history_table').dataTable({
        bFilter: false,
        bLengthChange: false,
        iDisplayLength: 9,
        order: [[0, "desc"]]
    });

    $('#exchange_table').dataTable({
        bFilter: false,
        bLengthChange: false,
        iDisplayLength: 7,
        order: [[0, "desc"]]
    });

    $("#btnCopy").click(function (e) {
        $("#txtAddress").select();
        document.execCommand("copy");
    });

    $("#btnCopy1").click(function (e) {
        $("#txtPaymentRequest").select();
        document.execCommand("copy");
    });

    $("#btnGenerate").click(function (e) {
        $("#loading").show();
        $("#btnGenerate").hide();
    });


    $(".onCLickDisable").click(function (e) {
        $(this).addClass('disabled');
    });

    RefreshExchangeCoin = function (to) {
        $.ajax(
            {
                type: 'GET',
                url: 'https://api.crypto.games/v1/ChangeNowPairs/' + Idc,
                contentType: "application/json",
                success: function (msg) {
                    if (msg.length > 0) {
                        var result = "";
                        for (var x in msg) {
                            result = result + "<li><a href='#' data-type='to' data-coin='" + msg[x].idc + "' data-name='" + msg[x].name + "'><span>  " + msg[x].name + "</span></a></li>";
                        }
                        $("#dropTo1").html(result);
                    }
                    else {
                        $("#ContentPlaceHolder1_pnlExchange1").html(Idc+" exchange is currently unavailable.");
                    }
                },
                error: function (msg) {
                    $("#ContentPlaceHolder1_pnlExchange1").html(Idc + " exchange is currently unavailable.");
                }
            });
    };
    RefreshExchangeCoin();

    $(this).on('click', '.dropdown-menu li a', function () {
        var coin = $(this).data("coin");
        var name = $(this).data("name");
        var type = $(this).data("type");
        if (type != undefined) {
            if (type == "to") {
                $('#txtToCoin').val(coin);
                $('#btnTo1').html(coin + " <span class='caret'>");
            }
        }
    });

    RefreshOrderStatus1 = function () {
        var orderid = $('.cOrderId').val();

        $.ajax(
            {
                type: 'GET',
                url: 'https://api.crypto.games/v1/ChangeNowOrderStatus/' + orderid,
                contentType: "text/plain",
                success: function (msg) {
                    if (msg.length > 0) {
                        $('#spanChangenowStatus').text(msg + ".");
                    }
                }
            });
             
    };

});
