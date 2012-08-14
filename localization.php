<?php
/**
 * This script adds two arrays (for client and server side) with the correct locale for the current call to the global namespace,
 * determined by the session. Defaults to English.
 *
 * @package main
 */

$all_messages = array(
    'english' => array(
        'server' => array(
            
            // banner.php
            
            'banner.logo.hsma.alt' => 'Logo of the Hochschule Mannheim',
            'banner.logo.hsma.title' => 'Visit the Hochschule Mannheim',
            'banner.logo.uwa.alt' => 'Logo of the University of Western Australia',
            'banner.logo.uwa.title' => 'Visit the University of Western Australia',
            'banner.title' => 'WebSense: Sensor Network Viewer',
            'banner.navigation.home' => 'Home',
            'banner.navigation.administration' => 'Administration',
            'banner.navigation.publications' => 'Publications',
            'banner.navigation.downloads' => 'Downloads',
            'banner.navigation.contact' => 'Contact',
            
            // contact.php
            
            'contact.title' => 'Websense3 - Contact',
            'contact.paragraph.1' => 'This application is based on
						a Java-based WebSense application developed at the
						Hochschule Mannheim, Germany.',
            'contact.paragraph.2' => 'The following people have contributed
						to versions of
						this system and its database.',
            'contact.feedback.paragraph.1' => 'Please send us a',
            'contact.feedback.mail' => 'feedback email',
            'contact.feedback.paragraph.2' => 'if you have any comments, notice
						a bug or would like a copy of this software.',
            
            // downloads.php
            
            'downloads.title' => 'Websense3 - Downloads and Documentation',
            'downloads.used.software' => 'Used 3rd Party Software',
            'downloads.apache.web.server' => 'Apache Web Server',
            'downloads.postgresql' => 'PostgreSQL Database',
            'downloads.jquery' => 'jQuery',
            'downloads.jqueryui' => 'jQuery UI',
            'downloads.jpgraph' => 'JpGraph',
            'downloads.installation' => 'Installation Instructions',
            'downloads.link' => 'Link',
            'downloads.database.skeleton' => 'Database Skeleton',
            'downloads.webapp.code' => 'Web Application Code',
            'downloads.tba' => 'TBA',
            
            // index.php
            'index.title' => 'Websense3',
            'index.tabs.overview' => 'Overview',
            'index.tabs.event.history' => 'Event History',
            'index.tabs.phenomena' => 'Phenomena',
            'index.tabs.sensors' => 'Sensors',
            'index.tabs.graphs' => 'Graphs',
            'index.tabs.sensor.health' => 'Sensor Health',
            'index.tabs.heat.map' => 'Heat Map',
            
            //help.php
		'help.title' => 'Help Documentation for WebSense',
		'help.help.title' => 'Help Documentation for WebSense',
		'help.online.help.en' => 'Online Help for WebSense',
		'help.online.help.ger' => 'Online-Hilfe für WebSense',
		'help.user.guide.ger' => 'Benutzerhandbuch im PDF-Format',
		'help.user.guide.en' => 'User Guide as PDF',
		'help.intro' => 'You can either open the Online-Help in your Browser or download
				 a PDF. Both are available in English and German.',
		'help.intro.2' => 'The PDF contains the complete documentation including the 
				installation instructions.',
		'help.list.german' => 'German',
		'help.list.english' => 'English',
            
            // menu.php
            'menu.no.trials' => 'There are no trials (yet) to select.',
            'menu.info.paragraph.1' => 'Select one or more trials of the list below and click "Change Location".',
            'menu.info.paragraph.2' => 'These trials can then be queried through the tabs.',
            'menu.buttons.checkall' => 'Check all',
            'menu.buttons.uncheckall' => 'Uncheck all',
            'menu.buttons.submit' => 'Change Location',
            
            // opendb.php
            'opendb.error' => 'Cannot connect to test database. Try editing opendb.php to set the real database.',
            
            // publications.php
            'publications.title' => 'Websense3 - Publications',
            'publications.overview' => 'Websense Overview',
            'publications.deployments' => 'Sensor Network Deployments',
            
            // create_graph.php
            'create.graph.error.generic' => 'Please select one or more Sensor Nodes to display and select output format.',
            'create.graph.error.query.enddate' => 'Error performing enddate query.',
            'create.graph.error.query.startdate' => 'Error performing startdate query.',
            'create.graph.error.date.interval.missing' => 'Please specify date interval.',
            'create.graph.error.query.num.days' => 'Error performing num days query.',
            'create.graph.error.query.name' => 'Error performing name query.',
            'create.graph.error.query.csv' => 'Error performing csv query.',
            'create.graph.graph.title' => 'Sensor data for {trialname} from {startdate} to {enddate}',
            'create.graph.error.query.time.wert' => 'Error performing time,wert graph query',
            
            // create_heat_map.php
            'create.heat.map.error.query.main' => 'Error performing heat map query.',
            'create.heat.map.error.query.phenomenon' => 'Error performing phenomenon bounds query.',
            
            // event_history.php
            'event.history.multiple.trials.selected' => 'View individual networks for further information.',
            'event.history.error.query.blog' => 'Error performing blog query.',
            'event.history.no.events' => 'There are no events recorded for this trial.',
            
            // get_params.php
            'get.params.missing.params' => 'Invalid GET request. "trials" or "trials[]" must be set.',
            
            // graphs.php
            'graphs.error.query.dates' => 'Error performing dates query.',
            'graphs.no.measurements' => 'No measurements are recorded yet.',
            'graphs.form.time.interval' => 'Select Time Interval',
            'graphs.form.last.24h' => 'Last 24 Hours',
            'graphs.form.last.7d' => 'Last 7 Days',
            'graphs.form.last' => 'Last',
            'graphs.form.hours' => 'Hours',
            'graphs.form.days' => 'Days',
            'graphs.form.all' => 'Everything',
            'graphs.form.fixed.interval' => 'Fixed Date Interval...',
            'graphs.form.date.start' => 'Start Date:',
            'graphs.form.date.end' => 'End Date:',
            'graphs.form.by.type' => 'Select Sensor Time Series by Type',
            'graphs.form.output' => 'Choose output format',
            'graphs.form.output.graph' => 'Graph (Opens in new window)',
            'graphs.form.output.csv' => 'Download CSV file',
            'graphs.form.submit' => 'Submit Query',
            'graphs.form.reset' => 'Reset Form',
            
            // heat_map.php
            'heat.map.error.query.date' => 'Error performing dates query.',
            'heat.map.error.query.no.measurements' => 'No measurements are recorded yet.',
            'heat.map.error.query.phenomena' => 'Error performing phenomena query.',
            'heat.map.error.query.depth' => 'Error performing depth query.',
            'heat.map.form.time.of.measurement' => 'Select Time of Measurement',
            'heat.map.form.date' => 'Date',
            'heat.map.form.hour.of.day' => 'Hour of Day (0-23, format: "HH"):',
            'heat.map.form.include.minutes' => 'Include following Minutes:',
            'heat.map.form.select.phenomenon' => 'Select Phenomenon',
            'heat.map.form.depth.in.centimeters' => 'Select Depth in Centimeters',
            'heat.map.form.submit' => 'Submit Query',
            'heat.map.form.reset' => 'Reset Form',
            'heat.map.scale.toggle.popup' => 'Toggle relative scale (sensor values relative to each other) on/off',
            'heat.map.spectrum.alt' => 'Color range of the heat map from minimum to maximum.',
            
            // overview.php
            'overview.error.query.node' => 'Error performing node id query.',
            'overview.error.query.count' => 'Error performing number of nodes query.',
            'overview.error.query.trial.info' => 'Error performing trial info query.',
            'overview.num.nodes' => 'Number of nodes',
            'overview.total.measurements' => 'Total measurements',
            'overview.observation.first' => 'First observation',
            'overview.observation.last' => 'Last observation',
            'overview.contact.address' => 'Contact address',
            
            // phenomena.php
            'phenomena.error.query.phenomena' => 'Error performing phenomena query.',
            'phenomena.no.phenomena' => 'No phenomena are observed at this trial yet.',
            'phenomena.table.phenomenon' => 'Phenomenon',
            'phenomena.table.unit' => 'Unit',
            
            'phenomena.table.minimum' => 'Min. Constraint',
            'phenomena.table.maximum' => 'Max. Constraint',
            
            'phenomena.table.calibration' => 'Calibration',
            
            // sensor_health.php
            'sensor.health.error.query.main' => 'Error performing sensor health query.',
            'sensor.health.no.data' => 'None of the sensors collected data yet.',
            'sensor.health.table.sensor' => 'Sensor',
            'sensor.health.table.measurement' => 'Measurement',
            'sensor.health.table.value' => 'Value',
            'sensor.health.table.unit' => 'Unit',
            'sensor.health.table.measurement.last' => 'Last Measurement',
            'sensor.health.table.popup.last.h' => 'Last hour',
            'sensor.health.table.popup.last.24h' => 'Last 24 hours',
            
            // sensors.php
            'sensors.error.query.sensordevice' => 'Error performing sensordevice query.',
            'sensors.error.no.sensor.types' => 'No known type of sensor is used at this trial.',
            'sensors.table.description' => 'Description',
            'sensors.table.calibration' => 'Calibration',
            'sensors.table.measurement.method' => 'Measurement Method',
            'sensors.table.datasheet' => 'Datasheet',
            
            // testgraph.php
            'testgraph.title' => 'Graph to test that jpgraph library and links are working correctly',
            'testgraph.pressure' => 'Pressure '
        ),
        
        'client' => array(
            
            'key' => 'englishvalue'
        )
        
    ),
    
    'german' => array(
        'server' => array(
            
            // banner.php
           
           'banner.logo.hsma.alt' => 'Logo der Hochschule Mannheim',
		'banner.logo.hsma.title' => 'Besuchen Sie die Hochschule Mannheim',
		'banner.logo.uwa.alt' => 'Logo der University of Western Australia',
		'banner.logo.uwa.title' => 'Besuchen Sie die University of Western Australia',
		'banner.title' => 'WebSense: Eine Anwendung zur Betrachtung von Sensornetzwerken',
		'banner.navigation.home' => 'Home',
		'banner.navigation.administration' => 'Administration',
		'banner.navigation.publications' => 'Veröffentlichungen',
		'banner.navigation.downloads' => 'Downloads',
		'banner.navigation.contact' => 'Kontakt',
		'banner.navigation.help' => 'Hilfe',
            
            // contact.php
            
           'contact.title' => 'Websense3 - Kontakt',
		'contact.paragraph.1' => 'Grundlage der Anwendung ist eine Java-basierte Websense-Anwendung, 
		die an der Hochschule Mannheim entwickelt wurde.',
		'contact.paragraph.2' => 'Folgende Personen haben an den Versionen des Systems und der
		Datenbank mitgewirkt:',
		'contact.feedback.paragraph.1' => 'Bitte senden Sie uns eine',
		'contact.feedback.mail' => 'E-Mail, ',
		'contact.feedback.paragraph.2' => 'wenn Sie Anmerkungen haben, Fehler in der Anwendung entdecken oder eine Kopie dieser Software erhalten möchten.',
            
            // downloads.php
            
            'downloads.title' => 'Websense3 - Download und Dokumentation',
		'downloads.used.software' => 'Zusätzlich benutzte Software',
		'downloads.apache.web.server' => 'Apache-Webserver',
		'downloads.postgresql' => 'PostgreSQL-Datenbank',
		'downloads.jquery' => 'jQuery',
		'downloads.jqueryui' => 'jQuery UI',
		'downloads.jpgraph' => 'JpGraph',
		'downloads.installation' => 'Installationsanleitung',
		'downloads.link' => 'Link',
		'downloads.database.skeleton' => 'Datenbankstruktur',
		'downloads.webapp.code' => 'Quellode der Webanwendung',
		'downloads.tba' => 'TBA',
		
		//help.php
		
		'help.title' => 'Benutzerdokumentation für WebSense',
		'help.help.title' => 'Benutzerdokumentation für WebSense',
		'help.intro' => 'Hier finden Sie eine Online-Hilfe sowie ein
				 Benutzerhandbuch im PDF-Format',
		'help.intro.2' => 'Die komplette Dokumentation inklusive der Installationsanleitung 
				ist nur in der PDf enthalten. Beide Hilfedokumentationen werden in 
				deutscher und englischer Sprache angeboten. ',
		'help.online.help.en' => 'Online Help for WebSense',
		'help.online.help.ger' => 'Online-Hilfe für WebSense',
		'help.user.guide.ger' => 'Benutzerhandbuch im PDF-Format',
		'help.user.guide.en' => 'User Guide as PDF',
		'help.list.german' => 'Deutsch',
		'help.list.english' => 'Englisch',
            
            // index.php
           'index.title' => 'Websense3',
		'index.tabs.overview' => 'Überblick',
		'index.tabs.event.history' => 'Verlaufsdaten',
		'index.tabs.phenomena' => 'Messdaten',
		'index.tabs.sensors' => 'Sensoren',
		'index.tabs.graphs' => 'Graphen',
		'index.tabs.sensor.health' => 'Sensorzustand',
		'index.tabs.heat.map' => 'Heatmap',
            
            // menu.php
           'menu.no.trials' => 'Es sind (noch) keine Messdaten zur Auswahl vorhanden.',
		'menu.info.paragraph.1' => 'Wählen Sie einen oder mehrere Standorte aus der unteren Liste und klicken Sie auf "Standort ändern".',
		'menu.info.paragraph.2' => 'Die Messdaten können dann durch die Reiter des mittleren Menüs abgefragt werden.',
		'menu.buttons.checkall' => 'Alle',
		'menu.buttons.uncheckall' => 'Keiner',
		'menu.buttons.submit' => 'Standort ändern',
            
            // opendb.php
            'opendb.error' => 'Verbindung zur Datenbank ist nicht möglich. 
            Öffnen Sie die Datei "opendb.php", um die richtige Datenbank einzutragen.',
            
            // publications.php
            'publications.title' => 'Websense3 - Veröffentlichungen',
		'publications.overview' => 'Websense-Überblick',
		'publications.deployments' => 'Einsätze des Sensor-Netzwerkes',
            
            // create_graph.php
           'create.graph.error.generic' => 'Wählen Sie einen oder mehrere Sensoren zur Betrachtung aus und wählen Sie das Ausgabeformat.',
		'create.graph.error.query.enddate' => 'Fehler beim Ausführen der Abfrage "Enddatum".',
		'create.graph.error.query.startdate' => 'Fehler beim Ausführen der Abfrage "Startdatum".',
		'create.graph.error.date.interval.missing' => 'Bitte geben Sie das genaue Datumsintervall an.',
		'create.graph.error.query.num.days' => 'Fehler beim Ausführen der Abfrage "numday".',
		'create.graph.error.query.name' => 'Fehler beim Ausführen der Abfrage "Name".',
		'create.graph.error.query.csv' => 'Fehler beim Ausführen der Abfrage "csv".',
		'create.graph.graph.title' => 'Sensordaten für {trialname} von {startdate} bis {enddate}',
		'create.graph.error.query.time.wert' => 'Fehler beim Ausführen der Abfrage "Zeit-Wert-Graph".',
            
            // create_heat_map.php
            'create.heat.map.error.query.main' => 'Fehler beim Ausführen der Abfrage "Heatmap".',
		'create.heat.map.error.query.phenomenon' => 'Fehler beim Auführen der Abfrage "Messdaten".',
            
            // event_history.php
           'event.history.multiple.trials.selected' => 'Für weitere Informationen betrachten Sie die einzelnen Netzwerke.',
		'event.history.error.query.blog' => 'Fehler beim Ausführen der Abfrage "Blog".',
		'event.history.no.events' => 'Für diese Testdaten sind keine Ereignisse aufgezeichnet.',
            
            // get_params.php
            'get.params.missing.params' => 'Ungültige Anfrage für "GET". "Testdaten" oder "Testdaten[]" müssen festgelegt sein.',
            
            // graphs.php
            'graphs.error.query.dates' => 'Fehler beim Ausführen der Abfrage "Datum".',
		'graphs.no.measurements' => 'Es sind noch keine Messdaten vorhanden.',
		'graphs.form.time.interval' => 'Wählen Sie das Zeitintervall',
		'graphs.form.last.24h' => 'Letzten 24 Stunden',
		'graphs.form.last.7d' => 'Letzten 7 Tage',
		'graphs.form.last' => 'Letzten',
		'graphs.form.hours' => 'Stunden',
		'graphs.form.days' => 'Tage',
		'graphs.form.all' => 'Alles',
		'graphs.form.fixed.interval' => 'Festes Datumsintervall...',
		'graphs.form.date.start' => 'Startdatum:',
		'graphs.form.date.end' => 'Enddatum:',
		'graphs.form.by.type' => 'Wählen Sie die Sensoren nach Typ',
		'graphs.form.output' => 'Wählen Sie das Ausgabeformat',
		'graphs.form.output.graph' => 'Graph (öffnet sich in einem neuen Fenster)',
		'graphs.form.output.csv' => 'Als CSV-Datei',
		'graphs.form.submit' => 'Abfragen',
		'graphs.form.reset' => 'Zurücksetzen',
            
            // heat_map.php
            'heat.map.error.query.date' => 'Fehler beim Ausführen der Abfrage "Datum".',
		'heat.map.error.query.no.measurements' => 'Es sind noch keine Messdaten vorhanden.',
		'heat.map.error.query.phenomena' => 'Fehler beim Ausführen der Abfrage "Messdaten".',
		'heat.map.error.query.depth' => 'Fehler beim Ausführen der Abfrage "Tiefe".',
		'heat.map.form.time.of.measurement' => 'Wählen Sie die Zeit der Messung',
		'heat.map.form.date' => 'Datum',
		'heat.map.form.hour.of.day' => 'Stunde des Tages (0-23, Format: "HH"):',
		'heat.map.form.include.minutes' => 'inklusive folgender Minuten:',
		'heat.map.form.select.phenomenon' => 'Wählen Sie die Art der Messung',
		'heat.map.form.depth.in.centimeters' => 'Wählen Sie die Tiefe in Zentimeter',
		'heat.map.form.submit' => 'Abfragen',
		'heat.map.form.reset' => 'Zurücksetzen',
		'heat.map.scale.toggle.popup' => 'Umschalten der relativen Skala (Sensorwerte relativ zueinander gesehen) an/aus',
		'heat.map.spectrum.alt' => 'Farbreichweite der Heatmap von minimum bis maximum.',
            
            // overview.php
            'overview.error.query.node' => 'Fehler beim Ausführen der Abfrage "Sensor-ID".',
		'overview.error.query.count' => 'Fehler beim Ausführen der Abfrage "Anzahl der Sensoren".',
		'overview.error.query.trial.info' => 'Fehler beim Ausführen der Abfrage "Informationen zu Messdaten".',
		'overview.num.nodes' => 'Anzahl der Sensoren',
		'overview.total.measurements' => 'Messung gesamt',
		'overview.observation.first' => 'Erste Messung',
		'overview.observation.last' => 'Letzte Messung',
		'overview.contact.address' => 'Kontaktadresse',
            
            // phenomena.php
            	'phenomena.error.query.phenomena' => 'Fehler beim Ausführen der Abfrage "Messdaten".',
		'phenomena.no.phenomena' => 'Bisher sind keine Messdaten von den Sensoren erfasst worden.',
		'phenomena.table.phenomenon' => 'Art der Messung',
		'phenomena.table.unit' => 'Einheit',
            
            'phenomena.table.minimum' => 'Min. Einschränkung',
            'phenomena.table.maximum' => 'Max. Einschränkung',
            
            'phenomena.table.calibration' => 'Kalibrierung',
            
            // sensor_health.php
           'sensor.health.error.query.main' => 'Fehler beim Ausführen Abfrage "Sensorzustand".',
		'sensor.health.no.data' => 'Bisher sind keine Daten von den Sensoren erfasst worden.',
		'sensor.health.table.sensor' => 'Sensor',
		'sensor.health.table.measurement' => 'Messung',
		'sensor.health.table.value' => 'Wert',
		'sensor.health.table.unit' => 'Einheit',
		'sensor.health.table.measurement.last' => 'Letzte Messung',
		'sensor.health.table.popup.last.h' => 'Letzte Stunde',
		'sensor.health.table.popup.last.24h' => 'Letzten 24 Stunden',
            
            // sensors.php
           'sensors.error.query.sensordevice' => 'Fehler beim Ausführen der Abfrage "Sensortyp".',
		'sensors.error.no.sensor.types' => 'Kein bekannter Sensor wird für diese(n) Standort(e) verwendet.',
		'sensors.table.description' => 'Beschreibung',
		'sensors.table.calibration' => 'Kalibrierung',
		'sensors.table.measurement.method' => 'Messmethode',
		'sensors.table.datasheet' => 'Datenblatt',
            
            // testgraph.php
            'testgraph.title' => 'Graph zur Überprüfung der jpgraph-Bibliothek und der Links.',
		'testgraph.pressure' => 'Druck '
        ),
        
        'client' => array(
            
            'key' => 'germanvalue'
        )
    )
);

session_start();

if (array_key_exists('locale', $_SESSION) && array_key_exists($_SESSION['locale'], $all_messages)) {
    $messages = $all_messages[$_SESSION['locale']]['server'];
    $client_messages = $all_messages[$_SESSION['locale']]['client'];
} else {
    // Default to English.
    $messages = $all_messages['english']['server'];
    $client_messages = $all_messages['english']['client'];
}
?>