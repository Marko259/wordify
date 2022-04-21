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

const guessGrid = document.querySelector("[data-guess-grid]");

startInteraction()
function startInteraction(){
    document.addEventListener("keydown", handleKeyPress)
}

function stopInteraction(){
    document.removeEventListener("keydown", handleKeyPress)
}

function handleKeyPress(e){
    if(e.key === "Enter"){
        submiteGuess()
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
    const nextTile = guessGrid.querySelector(":not([data-letter])")
    nextTile.dataset.letter = key.toLowerCase()
    nextTile.textContent = key
    nextTile.dataset.state = "active"
}