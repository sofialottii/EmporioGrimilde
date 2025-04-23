//usato in listaProdotti.php

let stars = document.querySelectorAll('input[name="rating"]'); // prende tutti gli input con name="rating"
let output = document.getElementById("output"); // voto: x/5

// aggiungo eventListener a ogni input
stars.forEach(star => {
    star.addEventListener("change", function () {
        let rating = this.value; // valore input selezionato

        output.innerText = "Voto: " + rating + "/5"; // aggiorno il testo
        updateStars(rating); // aggiorno il colore delle stelle
    });
});

function updateStars(rating) {
    stars.forEach(star => {
        let starLabel = document.querySelector(`label[for="${star.id}"]`);
        if (star.value <= rating) { // se il valore dell'input è minore o uguale al rating
            starLabel.style.color = "gold";
        } else {
            starLabel.style.color = "gray";
        }
    });
}