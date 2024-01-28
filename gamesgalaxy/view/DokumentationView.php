<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class DokumentationView extends View
{
    static function show()
    {
        echo <<<DOKUMENTATION
	<form id="Dokumentation">
        <h1>Dokumentation der Website Games Galaxy (GG)</h1>
        <br>
        
        <ul>Teammitglieder:</ul>
        <li>Mohammad Taiba</li>
		<li>Falko Kühn</li>
		<li>Dennis Rink</li>
        <br>
        
		<ul>Einleitung</ul>
		<p>In dieser Dokumentation wird der Entwicklungsprozess von Games Galaxy, einem spezialisierten Online-Shop für PC-Spiele, detailliert beschrieben. Unser Ziel ist es, einen umfassenden Überblick über die verschiedenen Phasen der Planung, Entwicklung und Verwaltung der Plattform zu bieten. Diese Dokumentation ist als ein zentraler Leitfaden konzipiert, der es Entwicklern, Projektmanagern und Stakeholdern ermöglicht, die zugrundeliegenden Entscheidungen und Prozesse, die zur Realisierung von Games Galaxy geführt haben, nachzuvollziehen und zu bewerten. Durch die Schaffung dieses Dokuments streben wir nicht nur eine transparente Darlegung des Projektverlaufs an, sondern auch die Etablierung einer Wissensbasis für zukünftige Erweiterungen und Optimierungen der Website.</p>
        <br>
        
		<ul>Entwicklungs- und Aufbaudokumentation</ul> <br>
		<h3>Projektübersicht</h3>
		<h4>Kunde: </h4>
		<p>Games Galaxy GmbH, ein innovatives Unternehmen, das eine Nische im Markt für digitale PC-Spiele besetzen möchte. Games Galaxy strebt danach, eine Plattform zu schaffen, die nicht nur Verkäufe fördert, sondern auch eine Gemeinschaft für Gamer aufbaut.</p>
        <br>
        
		<h4>Ziele des Kunden:</h4>
		<li>Große Auswahl: Entdecken Sie eine umfangreiche und vielfältige Sammlung von Videspielen die auf jede Spielpräferenz und Plattform auf dem PC zugeschnitten ist.                                                                                      </li>
		<li>Neueste Veröffentlichungen: Bleiben Sie mit Zugang zu den neusten und heißesten Spielveröffentlichungen an vorderster Front des Gamings, um sicherzustellen, dass Sie nie die neuesten Trends und Innovationen verpassen.                            </li>
		<li>Wettbewerbsfähige Preise: Genießen Sie wettbewerbsfähige und erschwingliche Preise für alle unsere Spiele, sodass Spiele für jeden zugänglich sind, ohne das Budget zu strapazieren.                                                                 </li>
		<li>Benutzerfreundliche Oberfläche: Navigieren Sie mühelos durch unsere benutzerfreundliche Website und genießen Sie ein reibungsloses und angenehmes Einkaufserlebnis vom Stöbern bis zum Checkout.                                                     </li>
		<li>Schneller Versand: Erhalten Sie ihre Spiele schnell und zuverlässig per Mail in Form eines Produkt-Codes, welchen Sie bei der Plattform ihrer Wahl einlösen können, um sofort in Ihre neuen Spiele eintauchen zu können, ohne unnötige Verzögerungen.</li>
		<br>

		<h4>Zielgruppe:</h4>
		<li>PC-Gamer aller Altersgruppen und Interessen, mit einem Fokus auf Spieler, die Wert auf eine einfache, sichere und schnelle Möglichkeit zum Kauf ihrer Spiele legen.                               </li>
		<li>Kunden, die auf der Suche nach einer Plattform sind, die mehr bietet als nur Transaktionen – einen Ort, an dem sie sich über ihre Interessen austauschen und mit Gleichgesinnten verbinden können.</li>
		<li>Spieler, die eine vertrauenswürdige Quelle für Spiele und zuverlässigen Kundenservice schätzen.                                                                                                   </li>
		<br>																																													  </li>

		<h2>Recherche und Analyse </h2>
		<p>Unsere Analyse umfasste eine gründliche Untersuchung des aktuellen Marktes für Online-PC-Spiele-Vertriebe. Wir haben zahlreiche Plattformen betrachtet und analysiert, darunter große Akteure wie Steam(https://store.steampowered.com/) , Battle.net (https://eu.shop.battle.net/en-us?from=root) , Epic Games Store(https://store.epicgames.com/de/)  und EA(https://www.ea.com/de-de/ea-app) , um ein tiefes Verständnis für ihre Stärken, Schwächen und die angebotenen Funktionen zu entwickeln. Diese Analyse beinhaltete:</p>
		<li> Benutzererlebnis: Wir verglichen die Benutzerfreundlichkeit, insbesondere die Effizienz und Intuitivität der Such- und Filterfunktionen, sowie die Benutzerführung während des Checkout-Prozesses.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         </li>
		<li> Spielekatalog: Wir bewerteten das Angebot an Spielen, von Blockbustern bis hin zu Indie-Titeln, und betrachteten die Vielfalt sowie Exklusivangebote.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      </li>
		<li> Kundensupport: Unser Ansatz für den Kundenservice basiert auf der Bereitstellung umfangreicher Ressourcen, die es den Kunden ermöglichen, sich selbst zu helfen. Statt traditionelle Support-Kanäle zu nutzen, haben wir in eine intuitive FAQ-Sektion und detaillierte Leitfäden zur Problembehandlung investiert. Diese Ressourcen sind darauf ausgerichtet, die gängigsten Fragen und Probleme zu adressieren, die beim Einkaufsprozess auftreten können. Zudem bieten wir klare Anleitungen und Informationen zu jedem Spiel, um sicherzustellen, dass Kunden alle notwendigen Details haben, bevor sie einen Kauf tätigen. Durch diese Maßnahmen streben wir danach, den Bedarf an direktem Support zu minimieren und unseren Kunden ein reibungsloses und autonomes Einkaufserlebnis zu ermöglichen. </li>
		<br>

		<h2>Design und Layout</h2>
		<h3>Wireframe und Sitemap: </h3>
		<h4>Wireframe:</h4>
		<img src="../images/Dokumentation/Wireframe.jpg" alt="Wireframe.jpg">
		<h4>Sitemap: </h4>
		<img src="../images/Dokumentation/Sitemap.jpg" alt="Sitemap.jpg">
		<br><br>
		
		<h3>Design-Entscheidungen: </h3>
		<p>Die visuelle Identität von Games Galaxy wurde sorgfältig geplant, um eine ansprechende Benutzererfahrung zu gewährleisten, die die Welt des Gamings reflektiert:</p>
		<li> Logo & Farbgebung: Wir starteten mit dem Logo, das als Inspiration für die Farbauswahl der Website diente. Die ausgewählten Farben harmonieren mit dem Logo und schaffen ein benutzerfreundliches Ambiente.</li>
		<li> Schriftarten: "Roboto" sorgt für klare Texte, während "Press Start 2P" das Gaming-Flair betont, besonders in Überschriften.                                                                                </li>
		<li> Layouts: Die Website ist intuitiv navigierbar, mit einem klaren Fokus auf eine strukturierte Präsentation von Inhalten.                                                                                    </li>
		<li> Responsivität: Das Design ist responsiv, um eine optimale Darstellung auf verschiedenen Geräten sicherzustellen.                                                                                           </li>
		<p>Diese Elemente bilden zusammen ein kohärentes Design, das sowohl funktionell als auch visuell ansprechend ist und die Besucher direkt anspricht.</p>
		<br>
		
		<h2>Funktionalitäten</h2>
		<h3>Seitenfunktionen: </h3>
		<img src="../images/Dokumentation/Seitenfunktionen_1.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_2.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_3.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_4.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_5.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_6.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_7.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_8.jpg" alt="Seitenfunktionen.jpg">
		<img src="../images/Dokumentation/Seitenfunktionen_9.jpg" alt="Seitenfunktionen.jpg">
		<br><br>
		
		<h3>ER-Modell:</h3>
		<img src="../images/Dokumentation/Gesamtarchitektur.jpg" alt="Gesamtarchitektur.jpg">
		<br><br>
		
		<h3>Relationales Modell:</h3>
		<img src="../images/Dokumentation/Datenbankmodell.jpg" alt="Datenbankmodell.jpg">
		<br><br>
		
		<h3>Rollenmodell: </h3>
		<h4>Admin</h4>
			<li>Kann neue Benutzer erstellen.           </li>
			<li>Kann Benutzerdaten ändern.              </li>
			<li>Kann Benutzer löschen.                  </li>
			<li>Kann neue Spiele ins System einpflegen. </li>
			<li>Kann Spieledaten ändern.                </li>
			<li>Kann Spiele aus dem System löschen.     </li>
		<h4>Registrierter Benutzer</h4>
			<li>Kann die eigene Adresse ändern.</li>
			<li>Kann Bestellungen ausführen.   </li>
		<h4>Besucher</h4>
			<li>Kann das Produktangebot einsehen.</li>
		<h4>Rechte:</h4>
			<li> create_user: Erlaubt das Erstellen eines neuen Benutzerkontos.     </li>
			<li> change_user: Erlaubt das Ändern von Benutzerdaten.                 </li>
			<li> delete_user: Erlaubt das Löschen eines Benutzerkontos.             </li>
			<li> create_game: Erlaubt das Hinzufügen eines neuen Spiels zum Katalog.</li>
			<li> change_game: Erlaubt das Aktualisieren von Spieledaten.            </li>
			<li> delete_game: Erlaubt das Entfernen eines Spiels aus dem Katalog.   </li>
		<br>
		
		<h2>Technische Umsetzung</h2>
		<h3>Flussdiagramm: </h3>
		<img src="../images/Dokumentation/Aktivitätsdiagramm.drawio.png" alt="Aktivitätsdiagramm.png">
		
		<ul>Reflexion</ul>
		<h2>Herausforderungen und Lösungen</h2>
		<p>[Diskussion über technische Schwierigkeiten]</p>
		<br>
		
		<h2>Besonderheiten und Known-Bugs</h2>
			<h3>Feature-Highlights: </h3>
				<p>[Hinweise auf besondere technische Features oder "versteckte" Zusatzfeatures]</p>
			<h3>Known-Bugs: </h3>
				<p>[Liste bekannter Fehler und unvollständiger Implementierungen]</p>
				<br>
		<h2>Projektmanagement</h2>
			<h3>Übersicht über Projektmanagement-Aktivitäten</h3>
				<img src="../images/Dokumentation/Projektmanagement-Aktivitäten_1.jpg" alt="Projektmanagement-Aktivitäten_1.jpg">
				<img src="../images/Dokumentation/Projektmanagement-Aktivitäten_2.jpg" alt="Projektmanagement-Aktivitäten_2.jpg">
				<img src="../images/Dokumentation/Projektmanagement-Aktivitäten_3.jpg" alt="Projektmanagement-Aktivitäten_3.jpg">
				<img src="../images/Dokumentation/Projektmanagement-Aktivitäten_4.jpg" alt="Projektmanagement-Aktivitäten_4.jpg">
				
			<h3>[Zuständigkeiten und Ressourcenaufwand]</h3>
			<br>
						
		<ul>Installationshinweise</ul>
		<h2>Installationsanleitung</h2>
			<p>Um die Website "Games Galaxy" zu installieren und einzurichten, folgen Sie bitte dieser Schritt-für-Schritt-Anleitung:</p>
			<li>Herunterladen der Daten: Laden Sie die neueste Version der Website-Daten von unserem Repository(https://git.ai.fh-erfurt.de/ma4163sp1/dwp/dwp_ws2324/dwp_ws2324_rkt) herunter.                                                                                                                                                                                                                                                                                                                                                                      </li>
			<li>Entpacken der Dateien: Extrahieren Sie die heruntergeladenen Dateien in den Zielordner auf Ihrem Server oder lokalen Computer.                                                                                                                                                                                                                                                                                                                                                                                                                      </li>
			<li>Installation der Software: Installieren Sie die notwendige Server-Software. Dies umfasst typischerweise einen Webserver (z.B. Apache oder Nginx), eine Datenbank (z.B. MySQL) und PHP. Wir empfehlen (https://www.apachefriends.org/download.html), eine beliebte Apache-Distribution, die alle erforderlichen Komponenten enthält und auf Windows, Linux und macOS lauffähig ist. Für die Entwicklung und das Debugging können Sie zusätzlich eine integrierte Entwicklungsumgebung (IDE) wie IntelliJ (https://www.jetbrains.com/idea) verwenden. </li>
			<li>Konfiguration des Webservers: Konfigurieren Sie Ihren Webserver so, dass er auf das Verzeichnis verweist, in das Sie die Website-Dateien extrahiert haben. Stellen Sie sicher, dass das Verzeichnis korrekt auf C:\xampp\htdocs gesetzt ist, falls Sie XAMPP verwenden.                                                                                                                                                                                                                                                                             </li>
			<li>Einrichtung der Datenbank: Importieren Sie die mitgelieferte Datenbank-Datei (GG_DBMS.sql) in Ihre Datenbank über ein Verwaltungstool wie phpMyAdmin oder die Kommandozeile.                                                                                                                                                                                                                                                                                                                                                                        </li>
			<li>Konfiguration der Website: Aktualisieren Sie die Konfigurationsdateien der Website, um die Verbindungseinstellungen zur Datenbank und andere wichtige Konfigurationen wie Basis-URL und E-Mail-Einstellungen festzulegen.                                                                                                                                                                                                                                                                                                                           </li>
			<li>Finaler Test: Überprüfen Sie die Funktionalität der Website, indem Sie alle Hauptfunktionen wie Anmeldung, Produktsuche, Warenkorb und Checkout-Prozess testen.                                                                                                                                                                                                                                                                                                                                                                                     </li>
			<li>Sicherheitsrichtlinien: Implementieren Sie gute Sicherheitspraktiken, wie regelmäßige Backups und das sofortige Anwenden von Sicherheitsupdates.
			<p>Bei Fragen oder Unterstützung kontaktieren Sie bitte unser Support-Team.</p>
			<br>
			
		<h2>Zugangsdaten</h2>
		<h3>Für den Admin-Role:</h3>
			<li> Benutzername: Admin User     </li>
			<li> Email: admin@example.com    </li>
			<li> Passwort: adminpass         </li>
		<h3>Für den Benutzer-Role:</h3>
			<li>Benutzername: Regular User </li>
			<li>Email: user@example.com   </li>
			<li>Passwort: userpass        </li>

	</form></body>
DOKUMENTATION;
    }
}

