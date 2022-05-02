// const { redirect } = require("express/lib/response");

var dic = [];
if (word_length == 4) {
    $.getJSON("./assets/words/4 - da_DK.json", function(data) {
        data.forEach(element => {
            dic.push(element)
        });
    });
} else if (word_length == 5) {
    $.getJSON("./assets/words/5 - da_DK.json", function(data) {
        data.forEach(element => {
            dic.push(element)
        });
    });
} else if (word_length == 6) {
    $.getJSON("./assets/words/6 - da_DK.json", function(data) {
        data.forEach(element => {
            dic.push(element)
        });
    });
}

const alertContainer = document.querySelector("[data-alert-container]");
$("#waitButton").hide();


function confirmWord(id, type){
    const word = document.querySelector('input').value;
    if (!dic.includes(word.toLowerCase())) {
        showAlert("Ord ikke i ordliste, prøv igen")
    } else {
        $("#confirmButton").hide();
        $("#waitButton").show();
        $("input").prop('readonly', true);
        type = swapWord(type);
        setInterval(function(){ UpdateWords(id, word.toLowerCase(), type) }, 1000);
    }
}

function swapWord(type) {
    if (type == 'player_1') {
        type = 'player_1_word';
    } else {
        type = 'player_2_word';
    }

    return type;
}

function UpdateWords(id, word, type) {
    $.ajax({
        url: "../backend/update.php",
        type: "POST",
        data: {
            id: id,
            attr: word,
            type: type
        },
        dataType: "json",
        success: function(data) {
            if(data.player_1_word != null && data.player_2_word != null) {
                window.location.href = "../game.php?id=" + id;
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
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

