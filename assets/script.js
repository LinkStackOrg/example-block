(function() {
	for (var tags = ['div', 'figure', 'figcaption'], i = 0; i < tags.length; i++) {
		document.createElement(tags[i]);
	}
})();

(function() {
	//filter IE8 and earlier which don't support the generated content
	if (typeof(window.getComputedStyle) == 'undefined') {
		return;
	}

	//get the collection of PRE elements
	var pre = document.getElementsByTagName('pre');
	//now iterate through the collection
	for (var len = pre.length, i = 0; i < len; i++) {
		//get the CODE or SAMP element inside it, 
		//or just in case there isn't one, continue to the next PRE
		var code = pre[i].getElementsByTagName('code').item(0);
		if (!code) {
			code = pre[i].getElementsByTagName('samp').item(0);
			if (!code) {
				continue;
			}
		}

		//create a containing DIV column (but don't append it yet)
		//including aria-hidden so that ATs don't read the numbers
		var column = document.createElement('div');
		column.setAttribute('aria-hidden', 'true');
		column.setAttribute('class', 'numbers');

		//split the code by line-breaks to count the number of lines
		//then for each line, add an empty span inside the column
		for (var n = 0; n < code.innerHTML.split(/[\n\r]/g).length; n++) {
			column.appendChild(document.createElement('span'));
		}

		//now append the populated column before the code element
		pre[i].insertBefore(column, code);

		//finally add an identifying class to the PRE to trigger the extra CSS
		pre[i].className = 'line-numbers';
	}

})();

function csCopyButton(id) {
	// Select the existing input element by ID
	var codeElement = document.getElementById(id);
    var copyText = codeElement.innerText || codeElement.textContent;

	// Try to use the Clipboard API
	if (navigator.clipboard && navigator.clipboard.writeText) {
		navigator.clipboard.writeText(copyText);
	} else {
		// Fallback to the old method
		var tempInput = $('<input>');
		$('body').append(tempInput);
		tempInput.val(copyText).select();
		document.execCommand('copy');
		tempInput.remove();
	}

	// Show SweetAlert popup on success
	Swal.fire({
		icon: 'success',
		title: csCopyTitle,
		text: csCopyMessage,
		timer: 1000,
		showConfirmButton: false
	});
}

function csDownloadButton(id, filename) {
	// Select the existing input element by ID
	var codeElement = document.getElementById(id);
    var content = codeElement.innerText || codeElement.textContent;

	// Create a Blob with the content
	var blob = new Blob([content], {
		type: 'text/plain'
	});

	// Create a temporary anchor element
	var tempLink = document.createElement('a');
	tempLink.href = window.URL.createObjectURL(blob);
	tempLink.download = filename;

	// Programmatically click the anchor to trigger the download
	document.body.appendChild(tempLink);
	tempLink.click();

	// Remove the temporary anchor element
	document.body.removeChild(tempLink);
}