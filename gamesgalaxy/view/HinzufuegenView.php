<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class HinzufuegenView extends View
{
    static function show()
    {
        echo <<<HINZUFUEGEN
        
            <form class="AddGame-container" method="post" enctype="multipart/form-data" action="/dwp_ws2324_rkt/gamesgalaxy/Hinzufuegen/Submit">
                <div id="form-AddGame-h1">
                    <h1>Spiel hinzufügen</h1>
                </div>
                
                <div class="form-AddGame-group">
                    <label for="AddGame-title" class="AddGame-label">Spieltitel</label>
                        <input type="text" id="AddGame-title" name="addgame-title" class="AddGame-input" placeholder="Titel eingeben (z.B. Guilty Gear Strive)" required>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-category" class="AddGame-label">Kategorie <span class="form-AddGame-span">(Halte STRG-Taste für Mehrauswahl)</span> </label>
                        <select id="AddGame-category" name="addgame-category[]" class="AddGame-input" multiple required>
                            <option class="AddGame-distance" value="Strategy">      Strategie     </option>
                            <option class="AddGame-distance" value="Action">        Action        </option>
                            <option class="AddGame-distance" value="Shooter">       Shooter       </option>
                            <option class="AddGame-distance" value="RPG">           RPG           </option>
                            <option class="AddGame-distance" value="Simulation">    Simulation    </option>
                        </select>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-platform" class="AddGame-label">Plattformen <span class="form-AddGame-span"></span></label>
                        <select id="AddGame-platform" name="addgame-platform" class="AddGame-input" required>
                            <option class="AddGame-distance" value="Steam">      Steam      </option>
                            <option class="AddGame-distance" value="Battle.net"> Battle.net </option>
                            <option class="AddGame-distance" value="Epic Games"> Epic Games </option>
                        </select>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-key" class="AddGame-label">Spiel-Schlüssel</label>
                        <input type="text" id="AddGame-key" name="addgame-key" class="AddGame-input" placeholder="Spiel-Schlüssel" required>
                </div>
                
                <div class="form-AddGame-group">
                    <label for="AddGame-price" class="AddGame-label">Preis</label>
                        <input type="text" id="AddGame-price" name="addgame-price" class="AddGame-input" placeholder="Preis in € eingeben (z.B. 19,99)" pattern="^\d+(,\d{2})?$" required>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-description" class="AddGame-label">Beschreibung</label>
                        <textarea id="AddGame-description" name="addgame-description" class="AddGame-textarea" placeholder="Beschreibung hinzufügen" required></textarea>
                </div>

                <button type="submit" id="AddGame-submit" name="addgame-submit">Spiel hinzufügen</button>
            </form>
HINZUFUEGEN;
    }
}