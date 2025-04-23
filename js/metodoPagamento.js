
document.addEventListener("DOMContentLoaded", function () {
    const cartaSalvataInput = document.getElementById("cartaSalvata");
    const nuovaCartaInput = document.getElementById("nuovaCarta");

    const sezioneCartaSalvata = document.getElementById("sezione-carta-salvata");
    const sezionePagamento = document.getElementById("sezione-pagamento");

    // Aggiungi listener per il primo radio
    cartaSalvataInput.addEventListener("change", function () {
        if (this.checked) {
            sezioneCartaSalvata.style.display = "block";
            sezionePagamento.style.display = "none";
        }
    });

    // Aggiungi listener per il secondo radio
    nuovaCartaInput.addEventListener("change", function () {
        if (this.checked) {
            sezionePagamento.style.display = "block";
            sezioneCartaSalvata.style.display = "none";
        }
    });
});