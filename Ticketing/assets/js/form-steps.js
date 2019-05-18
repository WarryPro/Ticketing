let currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
    // This function will display the specified tab of the form...
    const tab = document.getElementsByClassName("tab"),
        step = document.getElementsByClassName("step");

    tab[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n === 0) {
        document.getElementById("prevBtn").style.display = "none";
        step[n].classList.add("active");

    } else {
        document.getElementById("prevBtn").style.display = "inline";
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
    if (n === 1 && !validateForm()) return false;
    // Hide the current tab:
    tab[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form...
    if (currentTab >= tab.length) {
        // ... the form gets submitted:
        document.getElementById("form-ticket").submit();
        return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
    fixStepIndicator(currentTab);
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
