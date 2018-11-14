function isValidDate(dateString) {
    //simple date validator - https://stackoverflow.com/a/35413963
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    if(!dateString.match(regEx)) return false;  // Invalid format
    var d = new Date(dateString);
    if(Number.isNaN(d.getTime())) return false; // Invalid date
    return d.toISOString().slice(0,10) === dateString;
}

function dateValidator(value, messages, options) {
    if (!isValidDate(value)) {
        messages.push(options['message']);
    }
}

function fakeAsyncValidator(value, messages, options, deferredList) {
    var deferred = $.Deferred();
    setTimeout(function () {
        if (value !== "pass") {
            messages.push(options['message']);
        }
        deferred.resolve();
    }, 1000);
    deferredList.push(deferred);
}

