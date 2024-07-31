function osiFormInit(id) {
    const formId = id.id;
    /*if (formId !== 17) {
        console.error("Form ID is not 17. This script is only for form ID 17.");
        return;
    }*/

    const form = document.getElementById('remoteForm-form-ContributionPage' + formId);
    const firstName = document.getElementById('first_name').closest('.form-group');
    const lastName = document.getElementById('last_name').closest('.form-group');
    const email = document.getElementById('email-primary').closest('.form-group');
	const creditCardNumber = document.getElementById('credit_card_number').closest('.form-group');
    const cvv = document.getElementById('cvv2').closest('.form-group');
    const expMonth = document.getElementById('credit_card_exp_date_M').closest('.form-group');
    const expYear = document.getElementById('credit_card_exp_date_Y').closest('.form-group');
	const submitButton = document.getElementById('remoteform-submit');
    const amountSection = document.querySelector('label.rf-label').parentNode;
    const radioInputs = document.querySelectorAll('.form-check-input:not([value="54"])'); // Exclude the OSI membership checkbox
    const alert = document.querySelector('.alert-warning');

    // Create new div for grid layout and set it up for CSS Grid
    const gridContainer = document.createElement('div');
    gridContainer.className = 'form-check-grid';
    amountSection.parentNode.insertBefore(gridContainer, amountSection);

    // Move only the radio buttons into the grid container
    radioInputs.forEach(radio => {
        gridContainer.appendChild(radio.parentNode);
    });

    // Create new div and append input fields
    const newDiv = document.createElement('div');
    newDiv.style.display = 'none'; // Initially hidden
    newDiv.append(firstName, lastName, email, creditCardNumber, cvv, expMonth, expYear, submitButton);
    if (alert) {
        newDiv.appendChild(alert);
    }
    form.insertBefore(newDiv, amountSection.nextSibling);

    // Modify amounts display
    document.querySelectorAll('.form-check-label').forEach(label => {
        label.textContent = label.textContent.replace(/ - \$[\d\.]+/, '');
    });

    // Change last radio to checkbox
    const memberRadio = document.querySelector('input[value="54"]');
    if (memberRadio) {  // Check if element exists before changing
        memberRadio.type = 'checkbox';
        memberRadio.closest('.form-check').querySelector('label').textContent = 'Yes, I want to become an OSI member!';
		newDiv.prepend(memberRadio.closest('.form-check'));
    }

    // Handle button click interactions
    radioInputs.forEach(radio => {
        const label = radio.nextElementSibling; // Assuming label immediately follows input
        label.addEventListener('click', function() {
            // Uncheck all other radios
            radioInputs.forEach(otherRadio => {
                if (otherRadio !== radio) {
                    otherRadio.checked = false;
                }
            });
            // Check this radio
            radio.checked = true;
            // Manually trigger the 'change' event if necessary
            radio.dispatchEvent(new Event('change'));
        });
    });

    // Add Donate button
    const donateButton = document.createElement('button');
    donateButton.textContent = 'Contribute';
    donateButton.type = 'button';
    donateButton.addEventListener('click', () => {
        if (newDiv.style.display === 'none') {
            newDiv.style.display = 'block';
			donateButton.textContent = 'Cancel';
            newDiv.style.transition = 'all 0.3s ease';
        } else {
            newDiv.style.display = 'none';
			donateButton.textContent = 'Contribute';
        }
    });
    form.appendChild(donateButton);
}

function customFieldCreation(key, def, type, createFieldFunc, wrapFieldFunc) {
    var field = createFieldFunc(key, def, type);
    if (field === null) {
        return null;
    }

    if (key === 'credit_card_number' || key === 'cvv2' || key === 'credit_card_exp_date_M' || key === 'credit_card_exp_date_Y') {
        // return null;
    }
    


    return wrapFieldFunc(key, def, field);
}

function customSubmitData(data) {
    // Display the data that will be submitted
    console.log(data);
    return data;
}