/**
 * This script merely contains utility functions.
 */

// Removes the value val from the array.
Array.prototype.remove = function(val) {
	for(var i = this.length - 1; i >= 0; i--) {
		if(this[i] === val) {
			this.splice(i, 1);
			break;
		}
	}
}
// Returns a valid Date instance or null on failure.
// Relies on jQuery-ui. So include it first before including this file.
function parseToDate(dateString) {
	try {
		return $.datepicker.parseDate('yy-mm-dd', dateString);
	} catch(error) {
		return null;
	}
}

// Checks the validity of the given date-strings in format YYYY-MM-DD.
// On failure, informs the user and returns false.
function checkDates(startDate, endDate, lowerBound, upperBound) {
	startDate = parseToDate(startDate);
	endDate = parseToDate(endDate);
	if(startDate === null || endDate === null) {
		alert('Dates must be valid and of format "YYYY-MM-DD".');
		return false;
	}

	if(endDate < startDate) {
		alert('The start date must precede the end date.');
		return false;
	}
	lowerBound = parseToDate(lowerBound);
	upperBound = parseToDate(upperBound);

	if(startDate < lowerBound) {
		alert('The start date must not be before ' + lowerBound + '.');
		return false;
	}
	if(endDate > upperBound) {
		alert('The end date must not be after ' + upperBound + '.');
		return false;
	}
	return true;
}

// Aborts an AJAX-call if it in non-null. Returns null for convenience.
function abortIfExists(request) {
	if(request) {
		request.abort();
	}
	return null;
}

// Taken from:
// http://stackoverflow.com/questions/18082/validate-numbers-in-javascript-isnumeric
function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}