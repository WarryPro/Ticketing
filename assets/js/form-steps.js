let currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
    // This function will display the specified tab of the form...
    const tab = document.getElementsByClassName("tab"),
        step = document.getElementsByClassName("step");

    tab[n].classList.remove("d-none");
    //... and fix the Previous/Next buttons:
    if (n === 0) {
        document.getElementById("prevBtn").classList.add("d-none");
        step[n].classList.add("active");

    } else {
        document.getElementById("prevBtn").classList.remove("d-none");
    }
    if (n === (tab.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Confirmer";
    } else {
        document.getElementById("nextBtn").innerHTML = "Suivant";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n);
}

window.addEventListener("click", (e) => {
    if(e.target.getAttribute("data-trigger")) {
        let n = parseInt(e.target.getAttribute("data-trigger"));
        nextPrev(n);

    }
});

function nextPrev(n) {
    // This function will figure out which tab to display
    let tab = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n === 1 && !validateForm()) {
        document.querySelector("form").classList.add("was-validated");
        return false
    }

    // Hide the current tab:
    // tab[currentTab].classList.add("d-none");
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= tab.length) {
        // ... the form gets submitted:
        document.getElementsByTagName("form")[0].submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
    fixStepIndicator(currentTab);
    getTypebillet();
    console.log(tab, currentTab);
    if(tab[currentTab].classList.contains('stripe-content')) {
        getStripeForm();
    }
    // getNombreVisitors(); // obtain le nombre de billets
}

function validateForm() {
    // This function deals with validation of the form fields
    let tab, inputs, selects, i, valid = true;
    tab = document.getElementsByClassName("tab");
    selects = tab[currentTab].getElementsByTagName("select");
    inputs = tab[currentTab].getElementsByTagName("input");

    // A loop that checks every input field in the current tab:
    if(inputs.length) {
        for (i = 0; i < inputs.length; i++) {

            // If a field is empty...
            if (inputs[i].value === "") {
                // add an "invalid" class to the field:
                inputs[i].classList.add("invalid");
                // and set the current valid status to false
                valid = false;
            }
        }
    }
    if(selects.length) {
        for(i = 0; i < selects.length; i++) {
            if (selects[i].value === "") {
                // add an "invalid" class to the field:
                selects[i].classList.add("invalid");
                // and set the current valid status to false
                valid = false;
            }
        }
    }


    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
        document.getElementsByClassName("step")[currentTab].classList.add("finish");
    }
    return valid; // return the valid status
}

/*
* @param n : currentTab
* */
function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    let i, step = document.getElementsByClassName("step");
    for (i = 0; i < step.length; i++) {
        if(step[i].classList.contains("active")) {
            step[i].classList.remove("active");
        }else {
            step[n].classList.remove("finish"); // si step précédent
        }
    }
    //... and adds the "active" class on the current step:
    step[n].classList.add("active");
}



function getNombreVisitors() {
    let visitors = document.querySelectorAll(".visitor");
    return visitors.length;
}


// details commande
function getTypebillet() {
    const formCard = document.getElementById("form-card");
    let nbrBillets = document.getElementById("nbr-billets"),
        inputReduction = document.querySelectorAll('.visitor input[type="checkbox"]:checked'),
        inputTypeBillet = formCard.querySelector("input[type='radio']:checked"),
        inputDateVisite = formCard.querySelector("input[type='date']");


    if(inputTypeBillet.value === '0') {
        document.getElementById("type-billet").textContent = 'Type de billet: Journée';
    }else {
        document.getElementById("type-billet").textContent = 'Type de billet: Demi-journée';
    }
    if(inputReduction.length > 0){
       document.getElementById("billet-reduit").textContent = 'Billet avec réduction: ' + inputReduction.length;
    }else {document.getElementById("billet-reduit").textContent = 'Billet avec réduction: Non' }

    nbrBillets.textContent = 'Nombre de billets: ' + getNombreVisitors();
    document.getElementById("date-visite-billet").textContent = 'Date de visite: ' + inputDateVisite.value;
}


function getStripeForm() {
    const formContainer = document.getElementById("payment-container");

    const formTemplate = document.createRange().createContextualFragment(
        `<form id="payment-form">
            <div class="form-row">
                <label for="card-element">Credit or debit card</label>
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
             </div>
             <button>Submit Payment</button>
        </form>`);

            $('.tab')[2] = formContainer.append(formTemplate);


    // Create a Stripe client.
    let stripe = Stripe('pk_test_CNsJfNp2J2FHaa4Ikr0xIapy');

    // Create an instance of Elements.
    let elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    let card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
        let displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    let form = $('#payment-form')[0];
    console.log(form);
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        stripe.createToken(card).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error.
                let errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        let form = document.getElementById('payment-form');
        let hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
}


// function validInteger() {
//     let inputInteger = document.querySelector("[data-integer]");
//
//     if(inputInteger !== null) {
//         inputInteger.addEventListener("blur", (e) => {
//             if(!Number.isInteger(parseInt(e.target.value))) {
//                 inputInteger.classList.add("invalid");
//             }
//         })
//     }
// }


