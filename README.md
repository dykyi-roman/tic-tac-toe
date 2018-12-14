# Tic tac toe game bot

The application have an API that can be called to make the moves, and a web interface, where the application can be visible.

**Project include:**

:+1: The game inside

:+1: API

:+1: Test coverage:: OK (18 tests, 40 assertions)

:+1: Code amalyze coverage (PSR2 standart, Phan, Codesniffe, Calisthenics rules)

**Feature:**
- [ ] Cache warm before first start
- [ ] To expand API functions
- [ ] Make server answer faster

# Example

![image](https://github.com/dykyi-roman/tic-tac-toe/blob/master/docs/example.gif)

# MiniMax Algorithm

MiniMax algorithm is used to implement basic AI or game logic in 2 player games. The most common scenario is implementing a perfect Tic-Tac-Toe player. In the game of Tic-Tac-Toe, there are two players, player X and player O. Now imagine there’s a scoreboard which displays a huge number called “score”.

* If X wins, the score increases by 10.

* If O wins, the score is decreased by 10.

* If it is a draw, then the score remains unchanged.

So now, the bigger the number score has, the better it is for X, which means X will try to maximize score as much as possible. Similarly, the lesser the score, the better it is for O, so O will try to minimize the score as much as possible.
To understand this better, read the [article](https://www.neverstopbuilding.com/blog/minimax) or [article](https://en.wikipedia.org/wiki/Minimax) or [article](http://theoryofprogramming.com/2017/12/12/minimax-algorithm/).

# Server
For realization, I did not take heavy framework. I take my simple [skeleton](https://github.com/dykyi-roman/no-framework-skeleton).

For run a server - you can create a the docker container(php7.2 + nginx) as the main platform, and put server code here. [Example](docker-project). If you have any problem with a start please contact me. Or if you have a exist server put server code here. 

![image](https://github.com/dykyi-roman/tic-tac-toe/blob/master/docs/api.png)

## API documentation

* [POST move](https://github.com/dykyi-roman/tic-tac-toe/blob/master/docs/api.md) 

## Install
For up you server you need run only one command:
```composer install```
after that creating a `.env` file with server configuration.

## Configuration

| key        | description             |type   |
| ---------- |-------------------------|:-----:|
| log_path   | Path for you log folder |string |
| debug_mode | debag mode              |bool   |
| cache_mode | cache mode              |bool   |

# Client

The client code lies in the [Client](https://github.com/dykyi-roman/tic-tac-toe/tree/master/client) folder.

## Install

For run a client you just a need change for your `path` a `GAME_URL_API` const, in the main.js file.

## Author
[Dykyi Roman](https://www.linkedin.com/in/roman-dykyi-43428543/), e-mail: [mr.dukuy@gmail.com](mailto:mr.dukuy@gmail.com)
