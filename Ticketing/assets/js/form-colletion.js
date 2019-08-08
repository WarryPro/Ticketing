/*
* Valide les inputs d'un form avec id form-card
* */
function validateCardInputs() {
    const formCard = document.getElementById('form-card');
    const inputs = formCard.querySelectorAll('input');
    const radios = formCard.querySelectorAll('input[type="radio"]');

    for(let i = 0; i < inputs.length; i++) {

        if(inputs[i].value === "") {
            alert('Il faut remplir tous les champs!');
            return false;
        }
        if(inputs[i].getAttribute("type") === "date") {
            let dateVisite = inputs[i].value;
            let now = new Date(), year = now.getFullYear(), month = (now.getMonth()+1), day = now.getDate();

            now = new Date(year + '-' + month + '-' + day);
            dateVisite = new Date(dateVisite);

            if(dateVisite < now) {
                console.log(dateVisite, now);
                alert("Vous ne pouvez pas reserver pour les jours passés!");
            }

            // if(day < 10) day = '0'+ day;
            // if(month < 10) month = '0'+month;

            // now = year + '-' + month + '-' + day;
        }
    }
    if(!radios[0].checked && !radios[1].checked) {
        alert('Il faut choisir le type de billet');
        return false;
    }
    return true
}

// Formulaire dynamique ColletionType

let $collectionHolder;

// setup an "add a form" button
let $addFormButton = $('#reservation_form_Suivant');

jQuery(document).ready(function() {
    // Get the container that holds the collection of forms
    $collectionHolder = $('.form-container');

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addFormButton.on('click', function(e) {
        e.preventDefault();

        if(validateCardInputs()) {

            // Count le nombre de tickets selectionnés dans le 1er form
            let nbrTickets = $('#reservation_form_nbrTickets').val();


    //                    s'il existe un billet il va le supp pour mettre à jour le nouveau nombre de billets
            if($('.visitor')[0]) {
                $('.visitor')[0].remove();
            }

            $('.card--form').hide();
            $('#form-steps-container').removeClass('d-none');

            // add a new form
            for(let i = 0; i < nbrTickets; i++) {

                addCollectionForm($collectionHolder);

            }
            $('.remove')[0].remove(); // Remove btn "Supprimer ce billet" du 1er element

            addNewVisitorForm($collectionHolder); // Add un nouveau billet visitor si btn 'ajouter un autre billet' existe
        }

    });

});


function addCollectionForm($collectionHolder) {
    // Get the data-prototype explained earlier
    let prototype = $collectionHolder.data('prototype');

    // get the new index
    let index = $collectionHolder.data('index');
    let newForm = prototype;
    let visiteurTemplate = `<legend class="title-steps">Visiteur</legend>`;
    let removeFormA = `<div class="py-2"><a class="btn btn-danger remove" href="#">supprimer ce billet</a></div>`;

    // You need this only if you didn't set 'label' => false in your tags field in TicketType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    let frag = document.createRange().createContextualFragment(`<fieldset class="visitor"> ${visiteurTemplate} ${newForm} ${removeFormA} </fieldset>`);

    // Display the form in the page in an visitor container, before the "Supprimer ce billet" link
    let newFormElement = $('.tab')[0].append(frag);

    // Ad new visitor form element
    $collectionHolder.append(newFormElement);
    $(".visitor").insertBefore($('#add-container'));


    collectionFormRemove();

}

function addNewVisitorForm($collectionHolder) {
    let addBillet = $('#add-billet');

    if(addBillet[0]) {
        $(addBillet).on('click', function(e) {
            e.preventDefault();

            addCollectionForm($collectionHolder) // Ajout un nouveau billet visitor
        })
    }
}

//            Remove un billet visitor
function collectionFormRemove() {
    let removeFormA = $('.remove');

    removeFormA.on('click', function(e) {
        e.preventDefault();
        // remove the visitor form
        e.target.parentElement.parentElement.remove()

    });
}