#	Module Kundenerinnerung mit Opt-in

*Getestet mit den Shopversionen 2.0.7.2, 3.0.2 und 3.1.0*


## Beschreibung

#### Neuerung:  Der Kunde muss ein Opt-in-Verfahren durchlaufen bevor er Warenverfügbarkeitsnachrichten erhalten kann. Das Verfahren ist analog zum Opt-in-System für Newsletter.

Dieses Systemmodul bietet Ihren Kunden die Möglichkeit, sich eine Erinnerungs-E-Mail schicken zu lassen, sobald ein Artikel wieder auf Lager ist.
<br>
Sobald ein Artikel nicht mehr auf Lager ist, erscheint auf der Produktdetail-Seite ein Button, womit der Kunde sich in die Erinnerungsliste eintragen kann.
<br>
Ist ein Artikel (in ausreichender Anzahl) wieder auf Lager, bekommt der Kunde automatisch eine Erinnerungsmail mit einem Link, der direkt zum Produkt im Shop führt.

Anmerkung: Der Mailversand wird angestoßen, sobald eine Seite im Shop neu geladen wird.
<br>Aus Performance-Gründen werden Erinnerungsmails nur einmal täglich versandt.
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

#### Nicht vergessen - Datenschutzhinweise anpassen!


## Update

1. Dateien aus dem Ordner **new_files/** in den Shop kopieren (vorhandene Dateien überschreiben)
   <br>*Hinweis: Der Name des Ordners "admin" muss an den des Shops angepasst werden!*

2. Im Adminbereich unter "Module->System Module" den Eintrag "Kundenerinnerung bei ausverkauften Artikeln" auswählen.

3. Dann den grünen Button "Update" klicken (Button wird nur angezeigt, wenn die gespeicherte Modulversion nicht der Aktuellen entspricht).
   <br>*Hinweis: Backup, Deinstallieren, Installieren und Wiederherstellen sind nicht nötig.*


## Deinstallation

1. Im Adminbereich unter "Module->System Module" den Eintrag "Kundenerinnerung bei ausverkauften Artikeln" auswählen.

2. Modul deinstallieren
   Hinweis: Damit werden alle Datenbankeinträge, keine Dateien, gelöscht.

3. Wer auch die Dateien entfernen möchte kann den roten Button "Moduldateien löschen" klicken.


<br /><br />

## Tipps

#### Eigener CSS-Button
*Gilt nur, wenn im Systemmodul Button-Bild "remind.gif" und als Shoptemplate "tpl_modified_nova" oder "tpl_modified_responsive" gewählt worden ist.*

In der Templatedatei */source/inc/css_button.inc.php* fügen wir z.B. hinter

```php
    // color 3
    'button_quick_find' => array(
      'class' => 'cssButtonColor3',
    ),
```

diese Zeilen ein

```php
    'remind' => array(
      'class' => 'cssButtonColor3',
    ),
```

Um ein Icon zu erhalten fügen wir in der Templatedatei */lang/buttons_german.php* z.B. diese Zeilen ein

```php
define('CSS_IMAGE_REMIND_ICON_RIGHT', '<i class="fa-regular fa-circle-right"></i>');
define('CSS_IMAGE_REMIND_ICON_LEFT', '');
```

<br /><br />

### ${Sollten\ Sie\ mit\ einem\ Problem\ nicht\ weiter\ kommen,\ finden\ sich\ bestimmt\ Helfer\ im\ {\color{red}Mod}}ified-Forum$

### [Thema: MODUL: Produkterinnerung für modified eCommerce Shopsoftware](https://www.modified-shop.org/forum/index.php?topic=12813.0)

<br /><br />

Viel Spaß!<br />
Karl
<br /><br /><br />


## Würdigungen - Credits

Ich möchte mich bei<br />
**noRiddle(revilonetz)**<br />
für die stetige Unterstützung und Hilfe bedanken.<br />
Besonders bedanken darf ich mich für die intensive Mitwirkung an diesem Modul, vor allem für den Abschnitt *"simulated cron job"*.