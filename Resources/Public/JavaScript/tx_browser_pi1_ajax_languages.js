/*
 * Language initialisation for AJAX methods of the TYPO3 extension Browser
 * powered by jQuery (http://www.jquery.com)
 * powered by TYPO3 (http://www.typo3.org)
 *
 * written by Frank Sander (http://www.wilder-jaeger.de)
 * Browser main development by Dirk Wildt (http://wildt.at.die-netzmacher.de)
 *
 * for more info visit http://typo3-browser-forum.de/
 *
 * status: 19 Dec 2010
 */

var lang_returnToList = new Array;
var lang_ajaxErrorMsg = new Array;

lang_returnToList.en = 'Show list again';
lang_ajaxErrorMsg.en = 'Error connecting to the server. <br />If error occurs frequently, please disable AJAX by the plugin of the Broser - TYPO3 without PHP.<br />Investigate the error: Firefox console <F12>: console > network.<br />Server error prompt:';

lang_returnToList.de = 'Liste wieder einblenden';
lang_ajaxErrorMsg.de = 'Fehler bei der Verbindung zum Server. <br />Wenn der Fehler häufiger auftaucht, deaktiviere AJAX im Plugin des Browsers - TYPO3 ohne PHP.<br />Fehler genauer untersuchen? Firefox Konsole <F12>: Konsole > Netz.<br />Fehler-Meldung des Servers:';

lang_returnToList.fr = 'Afficher la liste';
lang_ajaxErrorMsg.fr = 'Erreur de connexion au serveur:';

lang_returnToList.es = 'Mostrar la lista de nuevo';
lang_ajaxErrorMsg.es = 'Error al conectar con el servidor:';

lang_returnToList[''] = lang_returnToList.en;
lang_ajaxErrorMsg[''] = lang_ajaxErrorMsg.en;
