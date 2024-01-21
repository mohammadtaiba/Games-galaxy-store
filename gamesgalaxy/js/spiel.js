document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.games-grid-item').forEach(function (element) {
        element.addEventListener('click', function () {
            let gameId = this.getAttribute('data-game-id');

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/dwp_ws2324_rkt/gamesgalaxy/Spiel/Show';

            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'gameId';
            input.value = gameId;

            form.appendChild(input);
            document.body.appendChild(form);

            form.submit();
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.wunschliste-grid-inhalt').forEach(function (element) {
        element.addEventListener('click', function () {
            let gameId = this.getAttribute('data-game-id');

            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '/dwp_ws2324_rkt/gamesgalaxy/Spiel/Show';

            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'gameId';
            input.value = gameId;

            form.appendChild(input);
            document.body.appendChild(form);

            form.submit();
        });
    });
});

