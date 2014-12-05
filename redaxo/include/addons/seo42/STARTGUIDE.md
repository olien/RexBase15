SEO42 - The Hitchhiker's Guide to SEO42
=======================================

Diese Hinweise richten sich primär an User die zum ersten mal SEO42 nutzen oder noch Anfänger auf dem Gebiet REDAXO und SEO(42) sind.

- Nach Installation und Aktivierung des AddOns SEO42 sollte als nächstes das SEO42 Setup durchgeführt werden.
- Nach durchführen des Setups sollte unbedingt die Spracheinstellungen kontrolliert und ggf. angepasst werden ja nach eingesetzter Sprachen.
- Ein No Double Content Redirect sollte in den Einstellungen ausgewählt werden nachdem das Setup durchgeführt wurde. Empfohlen: One Domain Only
- Hartcodierte Urls wie `index.php?article_id=42` sind nicht mehr zulässig. Alle Urls müssen über `rex_getUrl(42)` ausgegeben werden. Siehe Hilfe > Codebeispiele 1.
- Für ein bestmögliches SEO sollte man sich an das SEO42 Boilerplate im Setup und an die Codebeispiele in der Hilfe (z.b. suchmaschinenfreundliche Image Manager Urls) orientieren. 
- In der `.htaccess` Datei ist eine Cachingdauer für CSS/JS Dateien von 4 Wochen eingestellt. Bitte reduzieren (z.B. auf 1 Woche) wenn die Dateien nicht wie vorgeschlagen per `seo42::getCSSFile()` / `seo42::getJSFile()` eingebunden werden sollten.
- Der Fehlerartikel unter REDAXO > System sollte nicht gleich dem Startartikel der Website entsprechen. Es sollte aufjedenfall ein eigener Fehlerartikel angelegt werden.
- Einen kurze Einführung zu SEO42 findet man hier: [REDAXO Tutorial: SEO-AddOns - URL-Umschreibung und mehr](http://www.redaxo.org/de/doku/tutorials/seo-addons---urls-und-mehr/)
