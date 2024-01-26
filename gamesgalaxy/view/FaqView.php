<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class FaqView extends View
{
    static function show()
    {
        echo <<<FAQ
        
<form class="faq-container">

    <h1 id="faq-h1">FAQ</h1>

    <div class="faq">
        <input type="checkbox" id="faq1">
        <label for="faq1" class="faq-question">Wie kann ich ein Spiel kaufen, das noch nicht veröffentlicht wurde?</label>
        <div class="faq-answer">
            <p>Sie können Spiele vorbestellen, die noch nicht veröffentlicht wurden. Wählen Sie einfach das gewünschte Spiel aus und fügen Sie es Ihrem Warenkorb hinzu.
                faSobald das Spiel veröffentlicht wird, wird es automatisch Ihrer Bibliothek hinzugefügt und zum Download bereitstehen.</p>
        </div>
    </div>

    <div class="faq">
        <input type="checkbox" id="faq2">
        <label for="faq2" class="faq-question">Welche Zahlungsmethoden akzeptieren Sie?</label>
        <div class="faq-answer">
            <p>ir akzeptieren eine Vielzahl von Zahlungsmethoden, darunter Kreditkarten, PayPal, Sofortüberweisung, und einige Kryptowährungen.
                Die vollständige Liste der unterstützten Zahlungsmethoden finden Sie auf unserer Zahlungsseite.</p>
        </div>
    </div>

    <div class="faq">
        <input type="checkbox" id="faq3">
        <label for="faq3" class="faq-question">Kann ich ein Spiel zurückgeben, wenn es mir nicht gefällt?</label>
        <div class="faq-answer">
            <p>Ja, wir bieten eine Rückgabefrist von 14 Tagen nach dem Kauf für Spiele, die weniger als 2 Stunden gespielt wurden.
                Wenn das Spiel technische Probleme aufweist oder
                nicht Ihren Erwartungen entspricht, können Sie eine Rückerstattung über Ihr Konto anfordern.</p>
        </div>
    </div>

    <div class="faq">
        <input type="checkbox" id="faq4">
        <label for="faq4" class="faq-question">Wie kann ich Support erhalten, wenn ich bei einem Spiel auf technische Probleme stoße?</label>
        <div class="faq-answer">
            <p>Wir bieten technischen Support für alle Spiele in unserem Shop. Besuchen Sie bitte unsere Support-Seite und reichen Sie ein
                Ticket mit einer genauen Beschreibung Ihres Problems ein.
                Unser Support-Team wird sich dann so schnell wie möglich mit einer Lösung bei Ihnen melden.</p>
        </div>
    </div>

    <div class="faq">
        <input type="checkbox" id="faq5">
        <label for="faq5" class="faq-question">Wie kann ich meine Spiele auf einem anderen PC installieren?</label>
        <div class="faq-answer">
            <p>Um Ihre Spiele auf einem anderen PC zu installieren, melden Sie sich einfach mit Ihrem Benutzerkonto
                auf dem neuen Gerät an. Unter "Meine Bibliothek" finden
                Sie alle Ihre gekauften Spiele, die Sie herunterladen und installieren können.</p>
        </div>
    </div>

    <div class="faq">
        <input type="checkbox" id="faq6">
        <label for="faq6" class="faq-question">Unterstützt Ihr Shop auch Mac- oder Linux-Spiele?</label>
        <div class="faq-answer">
            <p>Ja, unser Shop bietet eine Auswahl an Spielen für verschiedene Betriebssysteme. Sie können die verfügbaren
                Plattformen auf der jeweiligen Produktseite des Spiels einsehen. Filtern Sie einfach
                die Suche nach dem gewünschten Betriebssystem, um alle kompatiblen Spiele anzuzeigen.</p>
        </div>
    </div>

    <div class="faq">
        <input type="checkbox" id="faq7">
        <label for="faq7" class="faq-question">Meine Frage ist nicht dabei.</label>
        <div class="faq-answer">
            <p>Wenn Ihre Frage nicht aufgelistet ist, zögern Sie nicht, unseren Kundenservice zu kontaktieren.</p>
        </div>
    </div>
</form>



FAQ;
    }
}

