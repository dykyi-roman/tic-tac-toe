# API

    POST /move

## Description
Makes a move using the boardState(contains 2 dimensional array of the game field (X, O, '') and player unit (X or O).

***

## Requires authentication
**Without authentication**

***

## Parameters
- **boardState** _(required)_ — Current board state.
- **playerUnit** _(required)_ — Player unit representation.

***

## Return

Returns an array, containing x and y coordinates for next move, and the unit that now occupies it.

## Return format
A JSON object with key "status" and value of 200, and key "result" with value array.

***

## Errors
All known errors cause the resource to return HTTP error code header together with a JSON array containing at least 'status' and 'error' keys describing the source of error.

- **404 Not Found** — The photo was not found.

***

## Example
**Request**

    POST /move

**Body**

    boardState={}
    
    playerUnit=X

**Return**
``` json
{
  "status":200,
  "result":"{2, 0, 'O'}",
  "error": null
}
```

## Author
[Dykyi Roman](https://www.linkedin.com/in/roman-dykyi-43428543/), e-mail: [mr.dukuy@gmail.com](mailto:mr.dukuy@gmail.com)
