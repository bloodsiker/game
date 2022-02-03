$(document).ready(function () {

	$('#btnConvert').hide();
	$('#txtCoinConvert').hide();
	$('#history_table').dataTable({
		bFilter: false,
		bLengthChange: false,
		iDisplayLength: 10,
		order: [[0, "desc"]]
	});
	$('#other_history_table').dataTable({
		bFilter: false,
		bLengthChange: false,
		iDisplayLength: 10,
		order: [[0, "desc"]]
	});

	$('#range-slider').on('input change', function () { // MODIFIED

		var rangeOutput = $('#range-output');

		// Reveal Output
		rangeOutput.show(0);

		// Update Output
		var value = $(this).val();
		$(rangeOutput).val(value + "%");
		$(rangeOutput).html(value + "%");  // ADDED

		// Reposition Output
		var offset = $(this).offset();
		var posX = offset.left;
		var posY = offset.top;

		var width = $(this).width();
		var min = $(this).attr('min');
		var max = $(this).attr('max');

		// Calculate Position
		var targetX = ((value - min) / (max - min)) * width + posX;
		var targetY = posY - 35;

		$(rangeOutput).css('top', targetY + 'px');
		$(rangeOutput).css('left', targetX + 'px');

	});

	$("#range-slider").on("input change", function () {

		var t = $("#range-output");
		t.show(0);
		var i = $(this).val();
		$(t).val(parseFloat(i).toFixed(8) + " " + Coin);
		$(t).html(parseFloat(i).toFixed(8) + " " + Coin);
		var s = $(this).offset(),
			a = s.left,
			n = s.top,
			e = $(this).width(),
			r = $(this).attr("min"),
			o = $(this).attr("max"),
			u = (i - r) / (o - r) * e + a,
			h = n - 35;

		$(t).css("top", h + "px"), $(t).css("left", u + "px")
		CalculateFee();
	});

	$("#range-slider").bind("mouseup touchend", function () { var t = $("#range-output"); t.hide(0) });


	$("#range-slider").val(NormalFee);

	CalculateFee = function () {
		var fee = parseFloat($("#range-slider").val());
		var amount = parseFloat($('#txtAmount').val());

		if (fee < NormalFee) {
			$("#pnlFeeWarning").fadeIn("fast");
		}
		else {
			$("#pnlFeeWarning").fadeOut("fast");
		}

		var x = 0;
		if (amount - fee > 0) {
			x = amount - fee;
		}

		$('#txtFee').val(fee.toFixed(8));
		$('#fee-excluding-amount').text(x.toFixed(8) + " " + Coin);


	};
	CalculateFee();


	$("#txtAmount").keyup(function () {
		CalculateFee();
	});



});