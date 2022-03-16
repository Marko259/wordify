$("#button-addon2").click(function () { 
  copyToClipboard()
});


function copyToClipboard(){
  console.time('time1');
    var copyText = document.getElementById("inviteLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    document.execCommand("copy");
    document.getElementById("copy-btn").classList.remove('fa-regular');
    document.getElementById("copy-btn").classList.remove('fa-clone');
    document.getElementById("copy-btn").classList.add('fa-solid');
    document.getElementById("copy-btn").classList.add('fa-check');
    console.timeEnd('time1');
}

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





