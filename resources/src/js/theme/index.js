/* -----------------------------------------------------------------------------
 *
 * Component: Alert
 *
 * ----------------------------------------------------------------------------- */

/**
 * @function showAlert
 * @description Check if alert ID is saved in local storage, if not show the alert
 */

const showAlert = ( alert ) => {
	const storage = JSON.parse( localStorage.getItem( `tribe-alert-closed` ) );

	if( storage && storage.includes( alert.dataset.alertId ) ) {
		return;
	}

	alert.classList.add( 'tribe-alert-visible' );
};

/**
 * @function closeAlert
 * @description Add Alert ID to local storage and remove visible class on container
 */

const closeAlert = ( e ) => {
	const alert = e.target.closest('#tribe-alerts');
	const alertID = alert.dataset.alertId;
	const closedAlerts = localStorage.getItem( 'tribe-alert-closed' ) ? JSON.parse( localStorage.getItem( 'tribe-alert-closed' ) ) : [];

	closedAlerts.push( alertID );

	localStorage.setItem( 'tribe-alert-closed', JSON.stringify( closedAlerts ) );
	alert.classList.remove( 'tribe-alert-visible' );
};

/**
 * @function bindEvents
 * @description Alert close click event
 */

const bindEvents = ( alert ) => {

	const closeBtn = alert.querySelector('[ data-alert-btn ]');

	closeBtn.addEventListener('click', closeAlert, true );
};

/**
 * @function init
 * @description Kick off this module's functions
 */

const init = ( alert ) => {
	if ( ! alert ) {
		return;
	}

	bindEvents( alert );
	showAlert( alert );

	console.info( 'Tribe Alerts FE: Initialized Alert component scripts.' );

};

/**
 * @function eventListener
 * @description Make sure page has loaded before looking for the alert container.
 */

document.addEventListener('DOMContentLoaded', function () {

	const alert = document.getElementById('tribe-alerts');

	init( alert );

});
