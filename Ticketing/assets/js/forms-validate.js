// Valider date et heure




// details commande
function getTypebillet() {
    const formCard = document.getElementById("form-card");

    formCard.addEventListener("change", (e) => {

        if(e.target.type === "radio") {

            if(e.target.value === '0') {
                document.getElementById("type-billet").textContent += ' Journée'
            }else {
                document.getElementById("type-billet").textContent += ' Demi-journée'
            }

        }
        else if(e.target.type === "date") {
            document.getElementById("date-visite-billet").textContent += e.target.value;

        }

    })
}
getTypebillet();