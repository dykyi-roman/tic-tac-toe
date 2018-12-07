const GAME_URL_API = "http://test.loc/move";

function startGame() {
    for (let i = 0; i <= 8; i = i + 1) {
        clearBox(i);
    }

    document.turn = "X";
    document.robot = "O";
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
    if (checkForWinner('X')) {
        setMessage("X win!");
        document.winner = 'X';
        return;
    }

    if (checkForWinner('O')) {
        setMessage("O win!");
        document.winner = 'O';
        return;
    }

    if (checkForDrawWin()) {
        setMessage("draw!");
        return;
    }

    askRobot(parseBoard(), document.robot);
}

function parseBoard() {
    let filds = [];
    $('#game tr').each(function () {
        let tmp = [];
        $(this).find('td').each(function () {
            tmp.push($(this).text());
        });
        filds.push(tmp);
    });

    return filds;
}

function move(x, y, unit) {
    let board = [[0, 3, 6], [1, 4, 7], [2, 5, 8]];
    $('#s' + board[x][y]).text(unit);
}

function askRobot(boardState, playerUnit) {
    $.ajax({
        type: "POST",
        url: GAME_URL_API,
        data: {'boardState': boardState, 'playerUnit': playerUnit},
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        dataType: "json",
        crossDomain: true,
        success: function (data) {
            move(data.result[0], data.result[1], data.result[2]);
            if (checkForWinner('X')) {
                setMessage("X win!");
                document.winner = 'X';
            }

            if (checkForWinner('O')) {
                setMessage("O win!");
                document.winner = 'O';
            }

            if (checkForDrawWin()) {
                setMessage("draw!");
            }
        },
        failure: function (errMsg) {
            console.log(errMsg);
        }
    });
}

function checkForDrawWin() {
    let result = true;
    $('#game tr').each(function () {
        $(this).find('td').each(function () {
            if ($(this).text() === "") {
                result = false;
            }
        });
    });

    return result;
}

function checkForWinner(move) {
    let result = false;
    if (checkRow(0, 1, 2, move) ||
        checkRow(3, 4, 5, move) ||
        checkRow(6, 7, 8, move) ||
        checkRow(0, 3, 6, move) ||
        checkRow(1, 4, 7, move) ||
        checkRow(2, 5, 8, move) ||
        checkRow(0, 4, 8, move) ||
        checkRow(2, 4, 6, move)) {

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


