const element = document.getElementById('inviteLink')
element.addEventListener("click", () => {
	document.getElementById("play-btn").classList.remove('btn-primary-dis');
});

$(document).ready(function () {
  document.addEventListener("click", function (event) {
    //Hvis der klikkes på knappen, skal der ikke ændres
    if (event.target.closest(".btn-outline-secondary")) return;
    //Hvis der klikkes på alt andet skal den gå tilbage til Kopier
    if (document.getElementById("button-addon2").innerText === "Kopieret!") {
      document.getElementById("button-addon2").innerText = "Kopier";
    }
  });

  function copyToClipboard() {
    /* Tager input */
    var copyText = document.getElementById("inviteLink");
    const button = document.getElementById("button-addon2");

    /*Markere teksten i feltet*/
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile brugere */

    /* Kopierer det til clipboarded */
    navigator.clipboard.writeText(copyText.value);

    /* Ændrer teksten på knappen, som confirmation */
    //document.getElementById("button-addon2").innerText = "Kopieret!";
    document.getElementById("copy-btn").classList.remove('fa-regular');
    document.getElementById("copy-btn").classList.remove('fa-clone');
    document.getElementById("copy-btn").classList.add('fa-solid');
    document.getElementById("copy-btn").classList.add('fa-check');

    document.getElementById("play-btn").classList.remove('btn-primary-dis'); 
  }

  $("#button-addon2").click(function () { 
    copyToClipboard()
  });

  function counterUP(type) {
    var countUP = $("#counter-" + type).val();
    countUP = parseInt(countUP);
    if (countUP >= 6 && type === "length") return;
    if(countUP >= 8) return;
    countUP++;
    $("#counter-" + type).val(countUP);
  }

  function counterDOWN(type) {
    var counterDOWN = $("#counter-" + type).val();
    counterDOWN = parseInt(counterDOWN);
    if (counterDOWN <= 4) return;
    counterDOWN--;
    $("#counter-" + type).val(counterDOWN);
  }

  $("#counterUP-length, #counterUP-quantity").click(function () {
    type = $(this).data("type");
    counterUP(type)
  });

  $("#counterDOWN-length, #counterDOWN-quantity").click(function () { 
    type = $(this).data("type");
    counterDOWN(type)
  });
});
