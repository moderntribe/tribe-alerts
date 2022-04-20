/* -----------------------------------------------------------------------------
 *
 * Component: Alert
 *
 * ----------------------------------------------------------------------------- */

let alert;
const alertVisible = 'tribe-alert-visible';

/**
 * @function showAlert
 * @description Check if alert ID is saved in local storage, if not show the alert
 */

const showAlert = () => {
	const storage = JSON.parse(localStorage.getItem(`tribe-alert-closed`));

	if (storage && storage.includes(alert.dataset.alertId)) {
		return;
	}

	alert.classList.add(alertVisible);
};

/**
 * @function closeAlert
 * @description Add Alert ID to local storage and remove visible class on container
 */

const closeAlert = () => {
	const alertID = alert.dataset.alertId;
	const closedAlerts = localStorage.getItem('tribe-alert-closed')
		? JSON.parse(localStorage.getItem('tribe-alert-closed'))
		: [];

	closedAlerts.push(alertID);

	localStorage.setItem('tribe-alert-closed', JSON.stringify(closedAlerts));
	alert.classList.remove(alertVisible);
};

/**
 * @function bindEvents
 * @description Alert close click event
 */

const bindEvents = () => {
	const closeBtn = alert.querySelector('[ data-alert-btn ]');

	closeBtn.addEventListener('click', closeAlert, true);
};

/**
 * @function init
 * @description Kick off this module's functions
 */

const init = () => {
	if (!alert) {
		return;
	}

	bindEvents();
	showAlert();

	console.info('Tribe Alerts FE: Initialized Alert component scripts.');
};

/**
 * @function eventListener
 * @description Make sure page has loaded before looking for the alert container.
 */

document.addEventListener('DOMContentLoaded', function () {
	alert = document.getElementById('tribe-alerts');

	init();
});
