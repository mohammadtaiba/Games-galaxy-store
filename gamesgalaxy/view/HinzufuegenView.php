<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class HinzufuegenView extends View
{
    static function show()
    {
        echo <<<HINZUFUEGEN
        
            <form class="AddGame-container" method="post" enctype="multipart/form-data">
                <div id="form-AddGame-h1">
                    <h1>Spiel hinzufügen</h1>
                </div>
                
                <div class="form-AddGame-group">
                    <label for="AddGame-title" class="AddGame-label">Spieltitel</label>
                        <input type="text" id="AddGame-title" class="AddGame-input" placeholder="Titel eingeben (z.B. Guilty Gear Strive)" required>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-category" class="AddGame-label">Kategorie <span class="form-AddGame-span">(Halte STRG-Taste für Mehrauswahl)</span> </label>
                        <select id="AddGame-category" class="AddGame-input" multiple required>
                            <option class="AddGame-distance" value="Battle Royale"> Battle Royale </option>
                            <option class="AddGame-distance" value="fighting">      Kampf         </option>
                            <option class="AddGame-distance" value="Strategy">      Strategie     </option>
                            <option class="AddGame-distance" value="Action">        Action        </option>
                            <option class="AddGame-distance" value="Shooter">       Shooter       </option>
                            <option class="AddGame-distance" value="RPG">           RPG           </option>
                            <option class="AddGame-distance" value="Simulation">    Simulation    </option>
                            <option class="AddGame-distance" value="Abenteuer">     Abenteuer     </option>
                        </select>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-platform" class="AddGame-label">Plattformen <span class="form-AddGame-span">(Halte STRG-Taste für Mehrauswahl)</span></label>
                        <select id="AddGame-platform" class="AddGame-input" multiple required>
                            <option class="AddGame-distance" value="steam">      steam      </option>
                            <option class="AddGame-distance" value="battle.net"> Battle.net </option>
                            <option class="AddGame-distance" value="epic games"> Epic Games </option>
                        </select>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-key" class="AddGame-label">Spiel-Schlüssel</label>
                        <input type="text" id="AddGame-key" class="AddGame-input" placeholder="Spiel-Schlüssel" required>
                </div>
                
                <div class="form-AddGame-group">
                    <label for="AddGame-price" class="AddGame-label">Preis</label>
                        <input type="text" id="AddGame-price" class="AddGame-input" placeholder="Preis in € eingeben (z.B. 19,99)" pattern="^\d+(,\d{2})?$" required>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-description" class="AddGame-label">Beschreibung</label>
                        <textarea id="AddGame-description" class="AddGame-textarea" placeholder="Beschreibung hinzufügen" required></textarea>
                </div>

                <div class="form-AddGame-group">
                    <label for="AddGame-image" class="AddGame-label">Bild des Spiels</label>
                        <input type="file" id="AddGame-image" class="AddGame-input" required>
                </div>

                <button type="submit" id="AddGame-submit">Spiel hinzufügen</button>
            </form>
        </body>
HINZUFUEGEN;
    }
}