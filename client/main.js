function startGame() {
    for (let i = 1; i <= 9; i = i + 1) {
        clearBox(i);
    }

    document.turn = "X";
    document.robot = "O";
    if (Math.random() < 0.5) {
        document.turn = "O";
        document.robot = "X";
    }
    document.winner = null;
    setMessage("You play => " + document.turn + "\n Robot play => " + document.robot);
}

function setMessage(msg) {
    document.getElementById("message").innerText = msg;
}

function nextMove(square) {
    if (document.winner != null) {
        setMessage(document.winner + " game is over. Try again");
    } else if (square.innerText == "") {
        square.innerText = document.turn;
        switchTurn();
    }
}

function switchTurn() {
    if (checkForWinner(document.turn)) {
        setMessage(document.turn + " win!");
        document.winner = document.turn;
    }
}

function checkForWinner(move) {
    let result = false;
    if (checkRow(1, 2, 3, move) ||
        checkRow(4, 5, 6, move) ||
        checkRow(7, 8, 9, move) ||
        checkRow(1, 4, 7, move) ||
        checkRow(2, 5, 8, move) ||
        checkRow(3, 6, 9, move) ||
        checkRow(1, 5, 9, move) ||
        checkRow(3, 5, 7, move)) {

        result = true;
    }
    return result;
}

function checkRow(a, b, c, move) {
    let result = false;
    if (getBox(a) == move && getBox(b) == move && getBox(c) == move) {
        result = true;
    }
    return result;
}

function getBox(number) {
    return document.getElementById("s" + number).innerText;
}

function clearBox(number) {
    document.getElementById("s" + number).innerText = "";
}
        
   
