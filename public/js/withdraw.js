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
});
