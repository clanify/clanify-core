# Clanify

[![Build Status](https://travis-ci.org/Clanify/Clanify.svg?branch=master)](https://travis-ci.org/Clanify/Clanify)

Clanify ist eine Plattform zur Organisation von Clans, eSport-Teams und
Gaming-Communities. Das Projekt befindet sich momentan noch in der Entwicklung.
Sie haben jedoch die Möglichkeit ihre Ideen und Erfahrungen mit der Organisation
von Clans, eSport-Teams oder Gaming-Communities mitzuteilen und damit aktiv die
Entwicklung von Clanify zu unterstützen.

Weitere Informationen finden unter: http://clanify.rocks

Sollten Sie Ideen oder Fragen zu Clanify haben, schreiben Sie einfach an:
[hello@clanify.rocks](mailto:hello@clanify.rocks?subject=Hello)

## Installation

Clanify hat momentan keinen eigenen Installer so dass die Installation
manuell vorgenommen werden muss. Für die Installation der Datenbank-Tabellen ist
eine Installation vorhanden. Zuvor muss jedoch die Konfigurationsdatei eingerichtet
werden. Dazu bearbeiten Sie die Datei `config.sample.php` und geben dort die
Datenbank-Informationen an. Nachdem die Konfigurationsdatei bearbeitet wurde, muss
diese noch in `config.php` umbenannt werden. Nun kann die Installation der Tabellen durch
die URL `http://clanifyurl.rocks/install/install` aufgerufen werden. Sollte dies nicht
funktionieren haben Sie auch die Möglichkeit die `install.sql` im Verzeichnis `resource`
manuell in phpMyAdmin auszuführen.

Hinweis: Sollte Clanify in einem Unterverzeichnis installiert werden, muss dies entsprechend
in der Konfigurationsdatei (`URL`) sowie in der .htaccess-Datei (`RewriteBase`) angegeben werden.

Nach der erfolgreichen Installation sollten Sie die Möglichkeit haben sich an der
Plattform zu registrieren und die Funktionen zu verwenden.

## Install

At the moment Clanify has no automatic installation and must be made manually. For
the installation of the database tables a installation routine is available. First
of all the configuration must be set up. You have to set up the database information
on the file `config.sample.php`. After this edit you have to rename this file to
`config.php`. Now you have the possibility to install the database tables with the
following url: `http: // clanifyurl.rocks / install / install`. If the installation
of the database tables was not successful you could import the file `resource/install.sql`
directly into phpMyAdmin.

**Hint:** If you install Clanify into a subfolder you specify this into the configuration
file (`URL`) and the .htaccess file (`RewriteBase`).

After a successful installation you can register yourself on Clanify to use the actual
features.

**THIS IS NOT A STABLE VERSION! THIS IS A DEVELOPMENT VERSION!**