<?php

namespace gamesgalaxy\View;

require_once __DIR__."/../view/View.php";
class StartseiteView extends View
{

    static function show()
    {
        echo <<<STARTSEITE
        <body>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Angebote</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/elden-ring-logo.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Elden Ring</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/Diablo4-logo.jpg" class="game-images"  alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Diablo 4</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/Satisfactory-cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Satisfactory</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Bestseller</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/elden-ring-logo.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Elden Ring</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/Diablo4-logo.jpg" class="game-images" alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Diablo 4</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/Satisfactory-cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Satisfactory</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
            <div class="StartseiteGrids">
                <div class="grid-kategorie">Trends</div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-left fa-xl"></i></button></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/elden-ring-logo.jpg" class="game-images" alt="Cover für das erste Spiel"></a><div class="grid-element-background">Elden Ring</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/Diablo4-logo.jpg" class="game-images" alt="Cover für das zweite Spiel"></a><div class="grid-element-background">Diablo 4</div></div>
                <div class="grid-element"><a class="game-images" href="/"><img src="../images/Satisfactory-cover.jpg" class="game-images" alt="Cover für das dritte Spiel"></a><div class="grid-element-background">Satisfactory</div></div>
                <div class="anglediv"><button class="angle"><i class="fa-solid fa-angle-right fa-xl"></i></button></div>
            </div>
        </body>
STARTSEITE;
    }
}