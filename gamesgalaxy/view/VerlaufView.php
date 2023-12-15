<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class VerlaufView extends View
{
    static function show()
    {
        echo <<<VERLAUF
        <body>
<div id="titel-einkaufe">
    <p>Meine Einkäufe</p>
</div>
<div id="einkaufe-grid">
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-ausstehend">
                    Ausstehened
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-abgeschlossen">
                    Abgeschlossen
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-ausstehend">
                    Ausstehened
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-abgeschlossen">
                    Abgeschlossen
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-ausstehend">
                    Ausstehened
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-abgeschlossen">
                    Abgeschlossen
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-ausstehend">
                    Ausstehened
                </div>
            </div>
        </div>
    </div>
    <div class="flex-grid">
        <div class="einkaufe-grid-inhalt">
            <div class="spiele-daten">
                <p>Elden Ring<br>34,00€<br>Steam<br>06.12.2023</p>
            </div>
            <div class="spiele-status">
                <div class="spiele-status-inhalt-abgeschlossen">
                    Abgeschlossen
                </div>
            </div>
        </div>
    </div>
</div>
</body>
VERLAUF;
    }
}

