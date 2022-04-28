// const dic4 = fs.readFileSync("./assets/words/4 - da_DK.json", "utf8");
// const data4 = JSON.parse(dic4);

$.getJSON("./assets/words/4 - da_DK.json", function(data){
    dic4 = data    
});

$.getJSON("./assets/words/5 - da_DK.json", function(data){
    dic5 = data    
});

$.getJSON("./assets/words/6 - da_DK.json", function(data){
    dic6 = data    
});

const WORD_LENGTH = 5;
const alertContainer = document.querySelector("[data-alert-container]");
const guessGrid = document.querySelector("[data-guess-grid]");
const targetWord = "SLOPE"

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

    if (e.key.match(/[a-z]/) || e.key === "æ" || e.key === "ø" || e.key === "å"){
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