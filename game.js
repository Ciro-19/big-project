
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');

    const pacSize = 30;
    const pacSpeed = 3;
    let pacX = canvas.width / 2 - pacSize / 2;
    let pacY = canvas.height / 2 - pacSize / 2;
    let pacDx = 0;
    let pacDy = 0;

    const ghostSize = 30;
    const ghostSpeed = 2;
    let ghostX = 50;
    let ghostY = 50;
    let ghostDx = ghostSpeed;
    let ghostDy = ghostSpeed;

    const pointSize = 5;
    const points = [];
    for (let i = 0; i < 100; i++) {
        points.push({
            x: Math.random() * (canvas.width - pointSize),
            y: Math.random() * (canvas.height - pointSize),
        });
    }

    let score = 0;

    let gameStarted = false;
    let gameOver = false;

    window.addEventListener('keydown', (e) => {
        if (!gameStarted && !gameOver) {
            gameStarted = true;
        } else if (gameOver) {
            gameOver = false;
            gameStarted = false;
            score = 0;
            pacX = canvas.width / 2 - pacSize / 2;
            pacY = canvas.height / 2 - pacSize / 2;
            ghostX = 50;
            ghostY = 50;
            ghostDx = ghostSpeed;
            ghostDy = ghostSpeed;
            return;
        }

        switch (e.key) {
            case 'ArrowUp':
                pacDx = 0;
                pacDy = -1;
                break;
            case 'ArrowDown':
                pacDx = 0;
                pacDy = 1;
                break;
            case 'ArrowLeft':
                pacDx = -1;
                pacDy = 0;
                break;
            case 'ArrowRight':
                pacDx = 1;
                pacDy = 0;
                break;
        }
    });

    function drawPac() {
        ctx.beginPath();
        ctx.arc(pacX, pacY, pacSize, 0.2 * Math.PI, 1.8 * Math.PI);
        ctx.lineTo(pacX, pacY);
        ctx.closePath();
        ctx.fillStyle = 'yellow';
        ctx.fill();
    }

    function drawGhost() {
        ctx.fillStyle = 'red';
        ctx.fillRect(ghostX, ghostY, ghostSize, ghostSize);
    }

    function drawPoints() {
        ctx.fillStyle = 'white';
        points.forEach((point, index) => {
                ctx.beginPath();
                ctx.arc(point.x, point.y, pointSize, 0, 2 * Math.PI);
                ctx.fill();

                const pointDistance = Math.sqrt(Math.pow(point.x - pacX, 2) + Math.pow(point.y - pacY, 2));
                if (pointDistance < pacSize / 2 + pointSize / 2) {
                    points.splice(index, 1);
                    score++;
                    points.push({
                        x: Math.random() * (canvas.width - pointSize),
                        y: Math.random() * (canvas.height - pointSize),
                    });
                }
            });
        }

        function drawScore() {
            ctx.font = '20px Arial';
            ctx.fillStyle = 'white';
            ctx.fillText(`Score: ${score}`, 10, 30);
        }

        function drawStartScreen() {
            ctx.font = '40px Arial';
            ctx.fillStyle = 'yellow';
            ctx.fillText('Pac-Man', canvas.width / 2 - 80, canvas.height / 2 - 30);

            ctx.font = '20px Arial';
            ctx.fillStyle = 'white';
            ctx.fillText('Press any arrow key to start', canvas.width / 2 - 120, canvas.height / 2 + 30);
        }

        function drawGameOverScreen() {
            ctx.font = '40px Arial';
            ctx.fillStyle = 'yellow';
            ctx.fillText('Game Over', canvas.width / 2 - 100, canvas.height / 2 - 30);

            ctx.font = '20px Arial';
            ctx.fillStyle = 'white';
            ctx.fillText('Press any arrow key to restart', canvas.width / 2 - 130, canvas.height / 2 + 30);
        }

        window.addEventListener('keydown', (e) => {
        // Ajout pour empêcher le scroll
        if (e.key.includes('Arrow')) {
            e.preventDefault();
        }
    });

    function getRandomDirection() {
        const directions = [
            { dx: ghostSpeed, dy: 0 },
            { dx: -ghostSpeed, dy: 0 },
            { dx: 0, dy: ghostSpeed },
            { dx: 0, dy: -ghostSpeed },
        ];
        return directions[Math.floor(Math.random() * directions.length)];
    }

    let ghostDirectionChangeTimer = 0;
    const ghostDirectionChangeInterval = 60;

        function update() {
            if (!gameStarted) {
                drawStartScreen();
                return;
            }

            if (gameOver) {
                drawGameOverScreen();
                return;
            }

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            pacX += pacDx * pacSpeed;
            pacY += pacDy * pacSpeed;

            if (pacX < 0) pacX = 0;
            if (pacX + pacSize > canvas.width) pacX = canvas.width - pacSize;
            if (pacY < 0) pacY = 0;
            if (pacY + pacSize > canvas.height) pacY = canvas.height - pacSize;

            ghostX += ghostDx;
            ghostY += ghostDy;

            if (ghostX < 0 || ghostX + ghostSize > canvas.width) ghostDx *= -1;
            if (ghostY < 0 || ghostY + ghostSize > canvas.height) ghostDy *= -1;

            const pacGhostDist = Math.sqrt(Math.pow(ghostX - pacX, 2) + Math.pow(ghostY - pacY, 2));
            if (pacGhostDist < pacSize / 2 + ghostSize / 2) {
                gameOver = true;
            }
            ghostDirectionChangeTimer++;
        if (ghostDirectionChangeTimer >= ghostDirectionChangeInterval) {
            const newDirection = getRandomDirection();
            ghostDx = newDirection.dx;
            ghostDy = newDirection.dy;
            ghostDirectionChangeTimer = 0;
        }
            drawPac();
            drawGhost();
            drawPoints();
            drawScore();
        }
        setInterval(update, 1000 / 60);