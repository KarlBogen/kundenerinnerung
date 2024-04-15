#	Module Kundenerinnerung mit Opt-in


## Beschreibung

#### Neuerung:  Der Kunde muss ein Opt-in-Verfahren durchlaufen bevor er Warenverfügbarkeitsnachrichten erhalten kann. Das Verfahren ist analog zum Opt-in-System für Newsletter.

Dieses Systemmodul bietet Ihren Kunden die Möglichkeit, sich eine Erinnerungs-E-Mail schicken zu lassen, sobald ein Artikel wieder auf Lager ist.
<br>
Sobald ein Artikel nicht mehr auf Lager ist, erscheint auf der Produktdetail-Seite ein Button, womit der Kunde sich in die Erinnerungsliste eintragen kann.
<br>
Ist ein Artikel (in ausreichender Anzahl) wieder auf Lager, bekommt der Kunde automatisch eine Erinnerungsmail mit einem Link, der direkt zum Produkt im Shop führt.

Anmerkung: Der Mailversand wird angestoßen, sobald eine Seite im Shop neu geladen wird.
<br>Aus Performance-Gründen werden Erinnerungsmails nur einmal täglich versandt.
<br>Wer den Versand sofort testen möchte, muss (z.B. mit phpMyAdmin) in der Datenbanktabelle "simulated_cron_records" nach der Zeile "customers_remind" suchen und das Datum in der Spalte "last_executed" zurücksetzen - anschließend eine Seite im Shop neu laden.
<br>
<br>Soll bei jedem Seitenaufruf die Tabelle "Kundenerinnerung" mit dem "Lagerbestand" abgeglichen werden und der Mailversand gestartet werden,
<br>dann die Datei /includes/modules/customers_remind.php mit einem Editor öffnen und in Zeile 19 den Wert ändern in
<br>$sendmail_asap = true;
<br>
<br>Wenn das Modul installiert und aktiviert ist, wird der Warenkorb-Button überschrieben, sobald der Hauptartikel nicht mehr auf Lager ist.
<br>Weil der Warenkorb-Button nur überschrieben wird, sind keine Änderungen im Template erforderlich.

Im Paket enthalten sind Dateien für die Templates
- tpl_modified_nova
- tpl_modified_modified
- tpl_modified


## Installation

#### Wenn das Modul vorher schon installiert war, wegen des neu hinzugekommenen Opt-in-Verfahrens erforderlich, das alte Systemmodul zu deinstallieren.

1. BACKUP MACHEN!!!

2. Dateien aus dem Ordner **new_files/** in den Shop kopieren (es wird nichts überschrieben)
   <br>Hinweis: Der Name des Ordners "admin" muss an den des Shops angepasst werden!

3. Im Adminbereich unter "Module->System Module" findet man jetzt den Eintrag "Kundenerinnerung bei ausverkauften Artikeln".
   Dieses Modul auswählen und installieren.

   Das Modul ist nun installiert und aktiviert.

   Wichtig: Durch Klick auf "Bearbeiten" die Einstellungen überprüfen!

   Der Schalter "Erinnerung nur für angemeldete Kunden?" steht auf "Nein".
   Wer diesen Dienst nur für angemeldete Kunden erlauben möchte, stellt diesen Schalter auf "Ja".


## Deinstallation

1. Im Adminbereich unter "Module->System Module" den Eintrag "Kundenerinnerung bei ausverkauften Artikeln" auswählen.

2. Modul deinstallieren
   Hinweis: Damit werden alle Datenbankeinträge, keine Dateien, gelöscht.

3. Wer auch die Dateien entfernen möchte kann den roten Button "Moduldateien löschen" klicken.


<br /><br />

### Sollten Sie mit einem Problem nicht weiter kommen, finden sich bestimmt Helfer im Modified-Forum

### [Thema: MODUL: Produkterinnerung für modified eCommerce Shopsoftware](https://www.modified-shop.org/forum/index.php?topic=12813.0)

<br /><br />

Viel Spaß!<br />
Karl<br />

