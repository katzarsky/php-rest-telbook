$.delete = function (url, data, callback, type) {
	if ($.isFunction(data)) {
		type = type || (callback, callback = data, data = {});
	}

	return $.ajax({
		url: url,
		type: 'DELETE',
		success: callback,
		data: data,
		contentType: type
	});
};

$.postJSON = function (url, data) {
	return $.ajax({
		url: url,
		type : 'POST',
		data : JSON.stringify(data),
		contentType : 'application/json'
	});
};

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