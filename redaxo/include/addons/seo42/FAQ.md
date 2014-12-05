SEO42 - FAQ
===========

Mein Webserver meldet einen 500 Server Error?!
----------------------------------------------

Vermutlich liegt es an der Zeile `Options -Indexes` in der .htaccess Datei. Einfach diese Zeile auskommentieren.


Warum wird meine Website umgeleitet auf eine andere URL?
--------------------------------------------------------

Standardmäßig ist ein Redirect auf die im Setup angegebene URL der Website eingestellt um Double Content zu vermeiden. Prüfen Sie diesen Wert auf Richtigkeit oder schalten Sie die No Double Content Redirects auf einen anderen Wert um.


Meine CSS Dateien werden nicht geladen?!
----------------------------------------

Stellen Sie sicher, dass der Base-Tag sich an oberster Stelle in Head-Bereich Ihrer Website befindet. Bei REDAXO-Unterordner-Installationen zusätzlich drauf achten, die URLs nicht mit / zu beginnen bzw. einfach Codebeispiele 2 nutzen!


Warum hat das Umschalten von $REX['MOD_REWRITE'] keine Wirkung?
---------------------------------------------------------------

SEO42 funktioniert mittlerweile unabhängig von dieser REDAXO Variable. Will man den Rewriter ausschalten gibt es da eine Einstellung "URLs umschreiben" unter "Rewriter" die man nutzen kann.


Warum funktioniert nach Installation von SEO42 die Suche mittels RexSearch nicht mehr?
--------------------------------------------------------------------------------------

Vermutlich weil hartcodierte `index.php?article_id=x` Urls verwendet werden. Bitte Urls nur noch per `rex_getUrl()` ausgeben lassen. Beispiel: `<form action="<?php echo rex_getUrl(42);?>" method="post">`


Gibts was bestimmtes zu beachten wenn ich REDAXO in einem Unterordner installiert habe?
---------------------------------------------------------------------------------------

Im SEO42 Setup (URL der Website) und in der .htaccess den Unterordner mit angeben: `RewriteBase /unterordner`
Desweiteren sollten Ihre URLs nicht mit / beginnen. Nutzen Sie die PHP-Methoden aus Codebeispiel 1!


Warum bekomme ich einen Fehler bei der Einbindung von Bootstrap?
----------------------------------------------------------------

Bootstrap nutzt einige speziellen Funktionen die lesphp von leafo nicht versteht. Um das Problem zu Lösen muss das Plugin [lessdotphp](https://github.com/DanielWeitenauer/lessdotphp) installiert werden


Wie werden die Standardeinstellungen von SEO42 wiederhergestellt?
------------------------------------------------------------------

Bitte die Datei `/include/data/addons/seo42/settings.inc.php` löschen und das REDAXO Backend aufrufen. Achtung: alle geänderten Einstellungen gehen dabei verloren.


Warum soll man mit seo42::getCSSFile() und seo42::getJSFile() seine CSS/JS Dateien ausgeben lassen?
---------------------------------------------------------------------------------------------------

Weil in der .htaccess Datei standardmäßig ein Caching von 4 Wochen eingestellt ist und durch das Anhängen eines Versionsstrings an die Dateien dann diese automatisch neu heruntergeladen werden bei einem Update.


Wie muss die URL der Website im Setup genau angegeben werden?
-------------------------------------------------------------

Die URL der Website muss mit `http://` beginnen und mit einem `/` enden.


Gibt es ein Tutorial zu SEO42 und/oder weitere Informationen zu den Features des Addons?
----------------------------------------------------------------------

Ja :) [REDAXO Tutorial: SEO-AddOns - URL-Umschreibung und mehr](http://www.redaxo.org/de/doku/tutorials/seo-addons---urls-und-mehr/)


Wenn ich Links mit Anchors nutze, lande ich immer auf der Startseite?
---------------------------------------------------------------------

Entweder vollständige Links inkl. vorangestelltem Artikel benutzen, z.B. `redaxo://13#anker`. Oder Base-Tag (der eigentliche Grund warum die Anker nicht mehr funktionieren) weglassen und auf einheitliche URLs achten, siehe Codebeispiel 1.


Wo legt SEO42 die Backups für die .htaccess Dateien an?
-------------------------------------------------------

Im Data-Ordner von REDAXO: `/redaxo/include/data/addons/seo42/backup/`


Warum kann kann man keine globalen Descriptions und Keywords eintragen, die dann für alle Seiten gültig sind?
------------------------------------------------------------------------------------------------------------

Weil doppelte Descriptions und Keywords von den Google Webmaster Tools als Problem dargestellt werden. Es ist also kein gutes SEO. Entweder man lässt die Felder leer oder füllt diese von Hand aus (für alle oder auch nur einige Seiten).


SEO42 läuft nicht mehr rund. Was tun?
-------------------------------------

Cache löschen, AddOn reinstallieren und evtl. das Setup neu durchlaufen sind hier zuerstmal Ihre Freunde ;)


Ich möchte das Trennzeichen im Titel umstellen. Wo kann ich das machen?
-----------------------------------------------------------------------

Unter Einstellungen wird dies vorgenommen. Option heißt `title_delimiter`.


Wie kann ich den Titel sonst noch beinflussen?
----------------------------------------------

Auf der SEO-Seite eines Artikels kann man einen individuellen Titel eintragen. Über "Kein Prefix" (wenn aktiv) wird dieser ohne Zusatz angezeigt. Man kann außerdem die Methode `seo42::getTitle()` überschreiben, siehe dazu Codebeispiel 8.


Warum wird der Titel für die Startseite "andersherum" ausgegeben wie für die Folgeseiten?
-----------------------------------------------------------------------------------------

Dies wurde im nachfolgenden PDF von Google abgeguckt (siehe nächste Frage).


Wo bekomme ich eigentlich eine gute verständliche Einführung in das Thema "Suchmaschinenoptimierung"?
-----------------------------------------------------------------------------------------------------

Zum Beispiel hier: <http://www.google.de/webmasters/docs/einfuehrung-in-suchmaschinenoptimierung.pdf>


Wie kann ich suchmaschinenfreundliche URLs für Bilder erhalten, die über den Image Manager generiert wurden?
------------------------------------------------------------------------------------------------------------

Zum Beispiel über die Methode `seo42::getImageManagerFile()`. Siehe dazu Codebeispiel 3 in der Hilfe.


Ich möchte nicht-www Anfragen auf die www Variante umleiten lassen. Soll doch SEO-technisch gut sein, oder?
-----------------------------------------------------------------------------------------------------------

Yup. Dafür gibt es mittlerweile die No Double Content Redirects die sich über die Einstellungen-Seite aktivieren lassen.


Meine URLs haben sich geändert. Wie kann ich saubere Weiterleitungen hinbekommen?
---------------------------------------------------------------------------------

Dies ist mittlerweile über die Redirects-Seite möglich. Bitte Urls immer mit einem Slash beginnen, die Ziel Url kann aber auch mit http:// beginnen. Schauen Sie sich auch die weiteren Redirects Möglichkeiten in den Einstellungen an.


Habe gehört das es SEO-technisch gut wäre wenn Bilder ein Alt-Attribut zugewiesen bekommen?
-------------------------------------------------------------------------------------------

Dafür kann man die Methode `seo42::getImageTag()` nutzen, die dann einen kompletten Image-Tag inkl. Alt-Attribut ausspuckt (siehe Codebeispiel 3). Und im Medienpool wird dieser dann im Titel-Feld gesetzt.


Wie installiere ich ein (SEO42) Plugin?
---------------------------------------

Das Plugin nach `/seo42/plugins/` kopieren. Danach im Redaxo-Backend zum Menu-Punkt "AddOn", dort nach dem Plugin suchen und installieren sowie aktivieren.


Mir gefällt SEO42 nicht! Wie bekomme ich das AddOn wieder entfernt?
-------------------------------------------------------------------

Kein Problem ;) Einfach das Setup von hinten nach vorne durchlaufen und das AddOn deinstallieren.


Wie lautet die Antwort auf die Frage aller Fragen nach dem Leben, dem Universum und dem ganzen Rest?
----------------------------------------------------------------------------------------------------

42


