var dic = [];
if (word_length == 4) {
    $.getJSON("./assets/words/4-words.json", function(data) {
        data.forEach(element => {
            dic.push(element)
        });
    });
} else if (word_length == 5) {
    $.getJSON("./assets/words/5-words.json", function(data) {
        data.forEach(element => {
            dic.push(element)
        });
    });
} else if (word_length == 6) {
    $.getJSON("./assets/words/6-words.json", function(data) {
        data.forEach(element => {
            dic.push(element)
        });
    });
}

console.log(dic)

const WORD_LENGTH = word_length;
const FLIP_ANIMATION_DURATION = 500
const alertContainer = document.querySelector("[data-alert-container]");
const guessGrid = document.querySelector("[data-guess-grid]");
const targetWord = targetword.toLowerCase();


startInteraction()
function startInteraction(){
    document.addEventListener("keydown", handleKeyPress)
}

function stopInteraction(){
    document.removeEventListener("keydown", handleKeyPress)
}

function handleKeyPress(e){
    if(e.key === "Enter"){
        submitGuess()
        return
    }

    if(e.key === "Backspace" || e.key === "Delete"){
        deleteKey()
        return
    }
    //e.key.match(/[a-z]/) || e.key === "æ" || e.key === "ø" || e.key === "å"
    if (e.key.match(/^[a-zæøå]+$/)){
        pressKey(e.key)
        return
    }
}

function pressKey(key){
    const activeTiles = getActiveTiles()
    if (activeTiles.length >= WORD_LENGTH) return
    const nextTile = guessGrid.querySelector(":not([data-letter])")
    nextTile.dataset.letter = key.toLowerCase()
    nextTile.textContent = key
    nextTile.dataset.state = "active"
}

function deleteKey(){
    const activeTiles = getActiveTiles()
    const lastTile = activeTiles[activeTiles.length - 1]
    if (lastTile == null) return
    lastTile.textContent = ""
    delete lastTile.dataset.state
    delete lastTile.dataset.letter
}

function submitGuess(){
    const activeTiles = [...getActiveTiles()]
    if (activeTiles.length !== WORD_LENGTH){
        showAlert("Ikke lang nok")
        return
    }

    const guess = activeTiles.reduce((word, tile) => {
        return word + tile.dataset.letter
    },"")
    
    if (!dic.includes(guess)){
        showAlert("Ikke i ordlisten")
        return
    }

    stopInteraction()
    activeTiles.forEach((...params) => flipTile(...params, guess))
}

function flipTile(tile, index, array, guess){
    const letter = tile.dataset.letter
    setTimeout(()=>{
        tile.classList.add("flip")
    }, index * FLIP_ANIMATION_DURATION / 2)

    tile.addEventListener("transitionend", () =>{
        tile.classList.remove("flip")
        if (targetWord[index] === letter){
            tile.dataset.state = "correct"
        } else if (targetWord.includes(letter)){
            tile.dataset.state = "wrong-location"
        } else {
            tile.dataset.state = "wrong"
        }

        if(index === array.length - 1){
            tile.addEventListener("transitionend", ()=>{
                startInteraction()
                checkWinLose(guess, array)
            },{once: true})
            
        }
        
    },{once: true})
}


function getActiveTiles(){
    return guessGrid.querySelectorAll('[data-state="active"]')
}

function showAlert(message, duration = 1000){
    const alert = document.createElement("div")
    alert.textContent = message
    alert.classList.add("alert")
    alertContainer.prepend(alert)
    if (duration == null) return
        
    setTimeout(() => {
        alert.classList.add("hide")
        alert.addEventListener("transitionend", () =>{
            alert.remove()
        })
    }, duration);
}

function checkWinLose(guess, tiles){
    if (guess === targetWord){
        showAlert("Du fandt ordet!", 5000)
        stopInteraction();
        check = setInterval(() => {
            checkOpponent(game_id, 1, player, check);
        }, 1000);
        return
    }
    const remainingTiles = guessGrid.querySelectorAll(":not([data-letter])")
    if (remainingTiles.length === 0){
        showAlert("Du tabte, ordet var: " + targetWord.toUpperCase(), null)
        stopInteraction()
    }
}

function checkOpponent(id, attr, type, check) {
    $.ajax({
        url: "../backend/update.php",
        type: "POST",
        data: {
            id: id,
            type: type,
            attr: attr
        },
        dataType: "json",
        success: function(data) {
            if(data.player_1_complete && data.player_2_complete) {
                $("#game-complete").show();
                clearInterval(check);
            }
        },
        error: function(data) {
            console.log(data)
        }
    });

}