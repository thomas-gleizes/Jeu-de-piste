$(document).ready(() => {
    //fonction contenant les attributs des boules
    function boule() {
        this.color = 'rgb(255, 86, 96,1)';
        this.minRadius = 1;
        this.maxRadius = 10;
        this.fps = 240;
        this.numBoule = 80;
        this.canvas = document.getElementById('canvas');
        this.ctx = this.canvas.getContext('2d');
    }

    //fonction permettant de démarrer le rendu graphique
    boule.prototype.init = function () {
        this.render();
        this.createCircle();
    }

    boule.prototype.random = function (min, max) {
        return Math.random() * (max - min) + min;
    }

    //fonction permettant d'initialiser le canvas
    boule.prototype.render = function () {
        var self = this,
            wHeight = window.innerHeight,
            wWidth = window.innerWidth;
        self.canvas.width = wWidth;
        self.canvas.height = wHeight;
        self.canvas.style.position = 'absolute';
        self.canvas.style.top = '0%';
        window.addEventListener('resize', self.render);
    }

    //fonction permettant de remplir l'array groupe de toute les boules affiché à l'image
    boule.prototype.createCircle = function () {
        var groupe = [];

        for (var i = 0; i < this.numBoule; i++) {
            groupe[i] = {
                radius: this.random(this.minRadius, this.maxRadius),
                xPos: this.random(0, canvas.width),
                yPos: this.random(0, canvas.height),
                color: this.color,
                yVelocity: this.random(this.random(-0.05, -0.025), this.random(0.025, 0.05)),
                xVelocity: this.random(this.random(-0.05, -0.025), this.random(0.025, 0.05)),
                lifeTime: this.random(1, 999),
                status: Math.round(this.random(0, 1)),
            }
            this.draw(groupe, i);
        }
        this.animate(groupe);
    }

    //fonction permettant de d'afficher et donc de donner un effet de déplacement aux boules
    boule.prototype.draw = function (groupe, i) {
        var ctx = this.ctx;
        ctx.fillStyle = groupe[i].color;

        ctx.beginPath();
        ctx.arc(groupe[i].xPos, groupe[i].yPos, groupe[i].radius, 0, 2 * Math.PI, false);
        ctx.fill();
    }

    //fonction permettant de déplacer la position des boules et de les garder dans le cadre de l'écran
    boule.prototype.animate = function (groupe) {
        var ctx = this.ctx;

        z = setInterval(() => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            for (let i = 0; i < this.numBoule; i++) {
                groupe[i].yPos += groupe[i].yVelocity;
                groupe[i].xPos += groupe[i].xVelocity;
                if (groupe[i].status == 0) groupe[i].lifeTime++;
                if (groupe[i].lifeTime >= 1000) groupe[i].status = 1;
                if (groupe[i].status == 1) groupe[i].lifeTime--;
                if (groupe[i].lifeTime <= 0) {
                    this.resetBall(groupe, i);
                    groupe[i].status = 0;
                } else {
                    groupe[i].color = 'rgb(255, 86, 96,' + (groupe[i].lifeTime/1000) +')';
                    this.draw(groupe, i);
                }
            }
        }, 1000 / this.fps);
    }

    //fonction permettant de remettre les boules dans le cadre
    boule.prototype.resetBall = function (groupe, i) {
        groupe[i].xPos = this.random(0, canvas.width);
        groupe[i].yPos = this.random(0, canvas.height);
        groupe[i].lifeTime = 1;
        groupe[i].yVelocity= this.random(this.random(-0.05, -0.025), this.random(0.025, 0.05));
        groupe[i].xVelocity= this.random(this.random(-0.05, -0.025), this.random(0.025, 0.05));
        this.draw(groupe, i);
    }

    //démarre le rendu graphique
    var background = new boule().init();
});