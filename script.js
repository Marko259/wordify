$(document).ready(function () {
  document.addEventListener("click", function (event) {
    //Hvis der klikkes på knappen, skal der ikke ændres
    if (event.target.closest(".btn-outline-secondary")) return;
    //Hvis der klikkes på alt andet skal den gå tilbage til Kopier
    if (document.getElementById("button-addon2").innerText === "Kopieret!") {
      document.getElementById("button-addon2").innerText = "Kopier";
    }
  });

  function generateUUID() {
    $("#inviteLink").val(uuidv4());
  }

  generateUUID();

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
    document.getElementById("button-addon2").innerText = "Kopieret!";
  }
});
