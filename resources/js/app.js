require('./bootstrap');

let moment = require('moment');

document.querySelectorAll('[data-timestamp-to-local][data-datetime-format]').forEach(element => {
    let timestampString = element.getAttribute('data-timestamp-to-local');
    let dateTimeFormat = element.getAttribute('data-datetime-format');
    element.textContent = moment.utc(timestampString).local().format(dateTimeFormat);
});