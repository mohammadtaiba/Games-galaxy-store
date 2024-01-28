<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class UeberunsView extends View
{
    static function show()
    {
        echo <<<UEBERUNS
    
            <div class="content">
                <div id="uberuns">
                    <h1>Über Uns</h1>
                    <div id="uberunstext">
                        <p>Wilkommen bei Games Galaxy, Ihrem himmlischen Ziel für ein herausragendes Spielerlebis!<br>
                            Bei Games Galaxy sind wir leidenschaftlich darum bemüht, uneingeschränkte Freude für Spieler aller Art zu bieten.<br>
                            Als Mit-Gaming-Enthusiasten verstehen wir die Bedeutung des bequemen Zugangs zu den neusten und besten Spielen in der Gaming-Welt.<br>
                            Unsere Mission besteht darin, eine vielfältige Sammlung von Videospielen im Angebot zu haben, um sicherzustellen, dass jeder Spieler sein aktuelles oder sein neues Lieblingsspiel findet.<br>
                            Egal, ob Sie ein erfahrener Spieler sind oder gerade erst Ihre Gaming-Reise beginnen, Games Galaxy ist ihre Anlaufstelle für Videspiele.<br>
                            Erkunden Sie mit uns das Universum der Gaming-Möglichkeiten, und lassen Sie das Abenteuer beginnen!</p>
                    </div>
	                    <div id="uberunsliste">
	                        <h2>Warum Sie Games Galaxy nutzen sollten:</h2>
	                        <p><span class="bulletpoints">&bull; Große Auswahl:</span> Entdecken Sie eine umfangreiche und vielfältige Sammlung von Videspielen die auf jede Spielpräferenz und Plattform auf dem PC zugeschnitten ist.</p>
	                        <p><span class="bulletpoints">&bull; Neueste Veröffentlichungen:</span> Bleiben Sie mit Zugang zu den neusten und heißesten Spielveröffentlichungen an vorderster Front des Gamings, um sicherzustellen, dass Sie nie die neuesten Trends und Innovationen verpassen.</p>
	                        <p><span class="bulletpoints">&bull; Wettbewerbsfähige Preise:</span> Genießen Sie wettbewerbsfähige und erschwingliche Preise für alle unsere Spiele, sodass Spiele für jeden zugänglich sind, ohne das Budget zu strapazieren.</p>
	                        <p><span class="bulletpoints">&bull; Benutzerfreundliche Oberfläche:</span> Navigieren Sie mühelos durch unsere benutzerfreundliche Website und genießen Sie ein reibungsloses und angenehmes Einkaufserlebnis vom Stöbern bis zum Checkout.</p>
	                        <p><span class="bulletpoints">&bull; Schneller Versand:</span> Erhalten Sie ihre Spiele schnell und zuverlässig per Mail in Form eines Produkt-Codes, welchen Sie bei der Platform ihrer Wahl einlösen können, um sofort in Ihre neuen Spiele eintauchen zu können, ohne unnötige Verzögerunen.</p>
	                    </div>
           			</div>
            </div>
UEBERUNS;
	    if (!isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'])
	    {
		    echo '<div id="neuregistrieren">';
            echo '    <h2 id="neuregistrieren_h2">Sie besitzen noch keinen Account?</h2>';
            echo '    <a id="ueber_uns_link" href="/dwp_ws2324_rkt/gamesgalaxy/Registrieren/Show"><div class="ueber_uns_button">Jetzt Registrieren!</div></a>';
            echo '</div>';
	    }


    }
}