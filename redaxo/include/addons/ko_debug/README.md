ko_debug
========

Fork des Redaxo Addons ko_debug mit folgenden Erweiterungen:

- ghost_echo($string) 
Gibt beliebige Strings aus, zB um im Live-Betrieb Frontend-Änderungen als Admin zu testen

- kint($object)
Weiterentwicklung von krumo mit erwiterten Features, zB unmittelbarem die(); nach Aufruf: 
http://raveren.github.io/kint/
Achtung, die Advanced features können ggf Probleme bereiten, siehe http://raveren.github.io/kint/#advanced

usage
=====

Try this in your REDAXO modules:

d($REX,$_GET);
s($REX,$_GET);

or, advanced:
dd($REX,$_GET);
sd($REX,$_GET);

or use it anywhere else: templates, php in addons, anywhere php is parsed.

Check the Addon settings page if no output can be seen on the page.


changelog
=========

v1.3
- bugfixes on settings page
- examples in readme added

v1.2
- kint added
