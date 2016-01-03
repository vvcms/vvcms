<?php
/*
This file is part of VCMS.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

class LibConfig{
	/**
	* MySQL-Datenbank
	*/
	var $mysqlServer = "datenbankservername"; //häufig localhost
	var $mysqlUser = "username";
	var $mysqlPass = "password";
	var $mysqlDb = "datenbankname";
	var $mysqlPort = ""; //optional

	/**
	* Dateisystem und Domains
	*/
	var $sitePath = "www.example.net"; //Domainname

	/**
	* Verbindungsdaten
	*/
	var $verbindungName = "K.St.V. Example"; //Name des Vereins
	var $verbindungZusatz = "";
	var $verbindungStrasse = "Musterstr. 20";
	var $verbindungPlz = "12345";
	var $verbindungOrt = "Musterstadt";
	var $verbindungLand = "";
	var $verbindungTelefon = "0251 123456789";

	var $seiteBeschreibung = "Aktuelles/Vergangenes/Staendiges ueber den Katholischen Studentenverein Example im Kartellverband katholischer deutscher Studentenvereine (KV) zu Muenster (Westf.)"; //Wird in Google unter dem Link angezeigt
	var $seiteKeywords = "Studentenverbindung, Universitaet, Verbindung, Studentenverein, Student"; //beschreibende Sichworte
	var $emailInfo = "info@example.net";
	var $emailWebmaster = "webmaster@example.net";

	var $chargenSenior = "x"; //Chargenkürzel des Seniors
	var $emailSenior = "senior@example.net";
	var $chargenJubelSenior = "x";
	var $emailJubelSenior = "jubelsenior@example.net";
	var $chargenConsenior = "vx";
	var $emailConsenior = "consenior@example.net";
	var $chargenScriptor = "xx";
	var $emailScriptor = "scriptor@example.net";
	var $chargenQuaestor = "xxx";
	var $emailQuaestor = "quaestor@example.net";
	var $chargenFuchsmajor = "FM";
	var $emailFuchsmajor = "fuchsmajor@example.net";
	var $chargenFuchsmajor2 = "FM 2";
	var $emailFuchsmajor2 = "fuchsmajor2@example.net";
	var $chargenAHVSenior = "AH-x";
	var $emailAHVSenior = "";
	var $chargenAHVConsenior = "AH-vx";
	var $emailAHVConsenior = "";
	var $chargenAHVKeilbeauftragter = "K";
	var $emailAHVKeilbeauftragter = "";
	var $chargenAHVScriptor = "AH-xx";
	var $emailAHVScriptor = "";
	var $chargenAHVQuaestor = "AH-xxx";
	var $emailAHVQuaestor = "";
	var $chargenHVVorsitzender = "";
	var $emailHVVorsitzender = "";
	var $chargenHVKassierer = "";
	var $emailHVKassierer = "";
	var $chargenArchivar = "";
	var $emailArchivar = "";
	var $chargenRedaktionswart = "Red.";
	var $emailRedaktionswart = "";
	var $chargenVOP = "VOP";
	var $chargenVVOP = "VVOP";
	var $chargenVOPxx = "VOPxx";
	var $chargenVOPxxx = "VOPxxx";
	var $chargenVOPxxxx = "VOPxxxx";

	/**
	* Zeitzone, normalerweise unverändert
	* Valide Werte unter http://www.php.net/manual/de/timezones.php
	*/
	var $timezone = "Europe/Berlin";

	/**
	* optionale Anpassungen
	*/
	var $defaultHome = "home";
	var $defaultLoginPid = "login_login";

	/*
	* Standardmäßig liegt das Wintersemester im System von Oktober bis März und das Sommersemester von April bis Oktober.
	* Normalerweise sind Anpassungen nicht nötig, sodass die weitere Beschreibung nur für folgenden Spezialfälle gilt:
	* NUR FALLS SEMESTER IN ANDEREN MONATEN LIEGEN SOLLEN ODER ANDERE SEMESTER ALS WS & SS GEWÜNSCHT SIND,
	* kann durch Entfernen der folgenden // konfiguriert werden, welche Semester in welchen Monaten liegen:
	*
	* Im Beispiel liegt seit dem Jahr 0 das Sommersemester (SS) von Monat 4 (April) bis Monat 9 (September) und
	* das Wintersemester (WS) von Monat 10 (Oktober) bis Monat 3 (März), sowie seit dem Jahr 2008 der first term (FT)
	* von Monat 1 (Januar) bis Monat 6 (Juni) und der second term (ST) von Monat 7 (Juli) bis Monat 12 (Dezember).
	*
	* Das Beispiel kann abgeändert werden: Weitere Jahre können hinzugefügt werden;
	* Semesterpräfixe (SS, WS, FT, ST, ...) können geändert werden, dürfen aber nur aus GENAU 2 Zeichen aus a-z und A-Z
	* bestehen. Jedes Jahr muss zudem GENAU 12 Monate bzw. 12 Semesterpräfixe enthalten! Das Jahr 0 muss vorhanden sein.
	*/
	//var $semestersConfig = array(
	//	0 		=> array('WS', 'WS', 'WS', 'SS', 'SS', 'SS', 'SS', 'SS', 'SS', 'WS', 'WS', 'WS'),
	//	2008 	=> array('FT', 'FT', 'FT', 'FT', 'FT', 'FT', 'ST', 'ST', 'ST', 'ST', 'ST', 'ST')
	//);
}
?>