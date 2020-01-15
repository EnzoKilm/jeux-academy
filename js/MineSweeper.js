var MineSweeper = {
    name: 'MineSweeper',

    difficulties: {
        easy: {
            lines: 8,
            columns: 8,
            mines: 8,
        },
        normal: {
            lines: 12,
            columns: 12,
            mines: 16,
        },
        hard: {
            lines: 16,
            columns: 16,
            mines: 32,
        },
    },

    settings: {

    },

    game: {
        status: 0,
        field: new Array(),
    },

    initialise: function() {
        this.startGame('easy');
    },

    startGame: function(difficulty) {
        this.settings = this.difficulties[difficulty];
        this.drawGameBoard();
        this.resetGame();
    },

    drawGameBoard: function() {

        board = document.getElementById('plateau');
        board.innerHTML = '';

        var elements = document.getElementsByClassName('result');
        for (var i = 0, len = elements.length; i < len; i++) {
            elements[i].innerHTML = '';
            elements[i].style.backgroundColor = '#eeeeee';
            elements[i].style.borderWidth = '0';
        }

        border = document.createElement('table');
        border.setAttribute('oncontextmenu', 'return false;');
        field = document.createElement('tbody');
        border.appendChild(field);
        border.className = 'field';

        board.appendChild(border);

        for (i = 1; i <= this.settings['lines']; i++) {
            line = document.createElement('tr');

            for (j = 1; j <= this.settings['columns']; j++) {
                cell = document.createElement('td');
                cell.id = 'cell-'+i+'-'+j;
                cell.className = 'cell';
                cell.setAttribute('onclick', this.name+'.checkPosition('+i+', '+j+', true);');
                cell.setAttribute('oncontextmenu', this.name+'.markPosition('+i+', '+j+'); return false;');
                line.appendChild(cell);
            }
            field.appendChild(line);
        }
    },

    resetGame: function() {

        /* Creons le champ, vide */
        this.game.field = new Array();
        for (i = 1; i <= this.settings['lines']; i++) {
            this.game.field[i] = new Array();
            for (j = 1; j <= this.settings['columns']; j++) {
                this.game.field[i][j] = 0;
            }
        }

        /* Ajoutons les mines */
        for (i = 1; i <= this.settings['mines']; i++) {
            /* On place la mine de facon aleatoire */
            x = Math.floor(Math.random() * (this.settings['columns'] - 1) + 1);
            y = Math.floor(Math.random() * (this.settings['lines'] - 1) + 1);
            while (this.game.field[x][y] == -1) {
                x = Math.floor(Math.random() * (this.settings['columns'] - 1) + 1);
                y = Math.floor(Math.random() * (this.settings['lines'] - 1) + 1);
            }
            this.game.field[x][y] = -1;

            /* On met a jour les donnees des cellules adjacentes */
            for (j = x-1; j <= x+1; j++) {
                if (j == 0 || j == (this.settings['columns'] + 1))
                    continue;
                for (k = y-1; k <= y+1; k++) {
                    if (k == 0 || k == (this.settings['lines'] + 1))
                        continue;
                    if (this.game.field[j][k] != -1)
                        this.game.field[j][k] ++;
                }
            }
        }

        /* On definit le status au mode jeu */
        this.game.status = 1;
    },

    checkPosition: function(x, y, check) {
        /* Verifie si le jeu est en fonctionnement */
        if (this.game.status != 1)
            return;

        /* Verifie si la cellule a deja ete visitee */
        if (this.game.field[x][y] == -2) {
            return;
        }

        /* Verifie si la cellule est marquee */
        if (this.game.field[x][y] < -90) {
            return;
        }

        /* Verifie si la cellule est une mine */
        if (this.game.field[x][y] == -1) {
            document.getElementById('cell-'+x+'-'+y).className = 'cell bomb';
            document.getElementById('cell-'+x+'-'+y).innerHTML = '&#128163';
            /* On fait apparaître toutes les bombes */
            for (i = 1; i <= this.settings['lines']; i++) {
                for (j = 1; j <= this.settings['columns']; j++) {
                    if (this.game.field[i][j] == -1) {
                        document.getElementById('cell-'+i+'-'+j).innerHTML = '&#128163';
                    }
                }
            }
            this.displayLose();
            return;
        }

        /* Marque la cellule comme verifiee */
        document.getElementById('cell-'+x+'-'+y).className = 'cell clear';
        if (this.game.field[x][y] > 0) {
            /* On marque le nombre de mine des cases adjacentes */
            document.getElementById('cell-'+x+'-'+y).innerHTML = this.game.field[x][y];

            /* On marque la case comme visitee */
            this.game.field[x][y] = -2;
        } else if (this.game.field[x][y] == 0) {
            /* On marque la case comme visitee */
            this.game.field[x][y] = -2;

            /* On devoile les cases adjacentes */
            for (var j = x-1; j <= x+1; j++) {
                if (j == 0 || j == (this.settings['columns'] + 1))
                    continue;
                for (var k = y-1; k <= y+1; k++) {
                    if (k == 0 || k == (this.settings['lines'] + 1))
                        continue;
                    if (this.game.field[j][k] > -1) {
                        this.checkPosition(j, k, false);
                    }
                }
            }
        }

        /* Lance la verification de la victoire si necessaire */
        if (check !== false)
            this.checkWin();
    },

    markPosition: function(x, y) {

        /* Verifie si le jeu est en fonctionnement */
        if (this.game.status != 1)
            return;

        /* Verifie si la cellule a deja ete visitee */
        if (this.game.field[x][y] == -2)
            return;

        if (this.game.field[x][y] < -90) {
            /* Retire le marquage */
            document.getElementById('cell-'+x+'-'+y).className = 'cell';
            document.getElementById('cell-'+x+'-'+y).innerHTML = '';
            this.game.field[x][y] += 100;

        } else {
            /* Applique le marquage */
            document.getElementById('cell-'+x+'-'+y).className = 'cell marked';
            document.getElementById('cell-'+x+'-'+y).innerHTML = '&#127988';
            this.game.field[x][y] -= 100;
        }
    },

    checkWin: function() {
        /* On verifie toutes les cases */
        for (var i = 1; i <= this.settings['lines']; i++) {
            for (var j = 1; j <= this.settings['columns']; j++) {
                v = this.game.field[i][j];
                if (v != -1 && v != -2 && v != -101)
                    return;
            }
        }

        /* Aucune case bloquante trouvee, on affiche la victoire */
        this.displayWin();
    },

    displayWin: function() {
        /* Affiche le resultat dans l'espace dedie, en couleur */
        var left = document.getElementById('left');
        left.innerHTML = '<p>Gagn&eacute;</p>';
        left.style.color = '#43b456';
        left.style.backgroundColor = '#55ce3d60';
        left.style.borderWidth = '0 2px 0 0';
        var right = document.getElementById('right');
        right.innerHTML = '<p>Gagn&eacute;</p>';
        right.style.color = '#43b456';
        right.style.backgroundColor = '#55ce3d60';
        right.style.borderWidth = '0 0 0 2px';

        /* Defini l'etat de la partie a termine */
        this.game.status = 0;
    },

    displayLose: function() {
        /* Affiche le resultat dans l'espace dedie, en couleur */
        var left = document.getElementById('left');
        left.innerHTML = '<p>Perdu</p>';
        left.style.color = '#CC3333';
        left.style.backgroundColor = '#d12d2d60';
        left.style.borderWidth = '0 2px 0 0';
        var right = document.getElementById('right');
        right.innerHTML = '<p>Perdu</p>';
        right.style.color = '#CC3333';
        right.style.backgroundColor = '#d12d2d60';
        right.style.borderWidth = '0 0 0 2px';

        /* Defini l'etat de la partie a termine */
        this.game.status = 0;
    },
};
