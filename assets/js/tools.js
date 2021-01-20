
function numberFormat(text, digit) {

	var tt = (text).toFixed(digit).replace(/\d(?=(\d{3})+\.)/g, '$&,');
	return tt;
}

function format(text) {
	var formatter = new Intl.NumberFormat();
	//'en-US', {
	//   style: 'currency',
	//   currency: ' ',
	// });

	return formatter.format(text);
}