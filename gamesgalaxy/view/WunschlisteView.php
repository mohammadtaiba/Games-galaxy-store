<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class WunschlisteView extends View
{
    static function show()
    {
        echo <<<WUNSCHLISTE
      
            <div id="titel-einkaufe">
                <p>Meine Wunschliste</p>
            </div>
            <div id="einkaufe-grid">
                <div class="flex-grid">
                    <div class="wunschliste-grid-inhalt">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift">Elden Ring</p>
                                <p>34,99€</p>
                                <p>Steam</p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <button class="remove-element"><i class="fa-solid fa-trash fa-xl"></i></button>
                        </div>
                    </div>
                </div>
                <div class="flex-grid">
                    <div class="wunschliste-grid-inhalt">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift">Elden Ring</p>
                                <p>34,99€</p>
                                <p>Steam</p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <button class="remove-element"><i class="fa-solid fa-trash fa-xl"></i></button>
                        </div>
                    </div>
                </div>
                <div class="flex-grid">
                    <div class="wunschliste-grid-inhalt">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift">Elden Ring</p>
                                <p>34,99€</p>
                                <p>Steam</p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <button class="remove-element"><i class="fa-solid fa-trash fa-xl"></i></button>
                        </div>
                    </div>
                </div>
                <div class="flex-grid">
                    <div class="wunschliste-grid-inhalt">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift">Elden Ring</p>
                                <p>34,99€</p>
                                <p>Steam</p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <button class="remove-element"><i class="fa-solid fa-trash fa-xl"></i></button>
                        </div>
                    </div>
                </div>
                <div class="flex-grid">
                    <div class="wunschliste-grid-inhalt">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift">Elden Ring</p>
                                <p>34,99€</p>
                                <p>Steam</p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <button class="remove-element"><i class="fa-solid fa-trash fa-xl"></i></button>
                        </div>
                    </div>
                </div>
                <div class="flex-grid">
                    <div class="wunschliste-grid-inhalt">
                        <div class="wunschliste-daten">
                            <div class="wunschliste-daten-inhalt">
                                <p class="wunschliste-uberschrift">Elden Ring</p>
                                <p>34,99€</p>
                                <p>Steam</p>
                            </div>
                        </div>
                        <div class="spiele-entfernen">
                            <button class="remove-element"><i class="fa-solid fa-trash fa-xl"></i></button>
                        </div>
                    </div>
                </div>
            </div>          
        </body>
WUNSCHLISTE;
    }
}
