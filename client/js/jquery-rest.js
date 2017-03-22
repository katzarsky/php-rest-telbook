// Shorthand for SELETE AJAX requests.
$.delete = function (url) {
	return $.ajax({
		url: url,
		type: 'DELETE'
	});
};

// Shorthand for POST AJAX requests with JSON.
// Same as $.post but with object-to-JSON conversion.
$.postJSON = function (url, data) {
	return $.ajax({
		url: url,
		type : 'POST',
		data : JSON.stringify(data),
		contentType : 'application/json'
	});
};

// Usage: $('form.person-edit').serializeObject();
// Goes through all fields in the form, and collects their values.
// returns object with variables and values that correspond to the form fields.
$.fn.serializeObject = function () {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function () {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
	});
	return o;
};