Hallo <?php echo $firstName ?>,

hier ist die Rechnung fuer Deinen HEK-Telefonanschluss. 
Rechnungszeitraum: <?php echo $start ?> bis <?php echo $end ?> 
Rechnungsnummer  : <?php echo $billId?> 
Bitte bei Rueckfragen angeben.

************************
Gesamtbetrag: <?php echo $amount ?> Euro
************************  

Dieser Betrag wird in den naechsten Tagen von deinem
Konto <?php echo $accountNumber?>, BLZ: <?php echo $bankNumber?> abgebucht.
Bitte sorge fuer ausreichende Deckung. Bei zurueckgewiesenen
Lastschriften entstehen zusaetzlich mindestens 10,- Euro
Gebuehren.

Diese Rechnung wurde maschinell erstellt und ist ohne Unterschrift gueltig.

Einzelverbindungsnachweis:

<?php echo $itemizedBill?>