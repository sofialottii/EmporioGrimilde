
document.addEventListener("DOMContentLoaded", function (){
    const quantitaInputs = document.querySelectorAll('input[type="number"]');
    const totaleElement = document.querySelector("p[prezzoTotale]");
    

    function aggiornaTotale() {
        let totale = 0;

        quantitaInputs.forEach((input) => {
            const container = input.closest("div");
            const prezzoElement = container.querySelector("p[data-prezzo-unitario]");
            const prezzoUnitario = parseFloat(prezzoElement.dataset.prezzoUnitario);
            const quantita = parseInt(input.value) || 0;

            const prezzoTotaleProdotto = prezzoUnitario * quantita;
            totale += prezzoTotaleProdotto;

            // aggiorna prezzo del singolo prodotto
            prezzoElement.textContent = `€${prezzoTotaleProdotto.toFixed(2)}`;
        });
        // aggiorna totale
        totaleElement.textContent = `Totale: €${totale.toFixed(2)}`;
    }


    quantitaInputs.forEach((input) => {
        input.addEventListener("input", aggiornaTotale);
    });
    aggiornaTotale();
});
