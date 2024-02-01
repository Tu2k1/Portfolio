const emailEl = document.querySelector('#email');
const titleEl = document.querySelector("#title");
const messageEl = document.querySelector("#message");
const form = document.querySelector('#contact-form');


function checkTitle(){

    let valid = false;

    const title = titleEl.value.trim();

    if (!isRequired(title)) {
        showError(titleEl, 'Title cannot be blank.');
    } else {
        showSuccess(titleEl);
        valid = true;
    }
    return valid;
};

function checkMessage(){

    let valid = false;

    const message = messageEl.value.trim();

    if (!isRequired(message)) {
        showError(messageEl, 'Message cannot be blank.');
    } else {
        showSuccess(messageEl);
        valid = true;
    }
    return valid;
};

function checkEmail(){
    let valid = false;
    const email = emailEl.value.trim();
    if (!isRequired(email)) {
        showError(emailEl, 'Email cannot be blank.');
    } else if (!isEmailValid(email)) {
        showError(emailEl, 'Email is not valid.')
    } else {
        showSuccess(emailEl);
        valid = true;
    }
    return valid;
};


function isEmailValid(email){
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};

function isRequired(value){
    if (value === '')
        return false;
    else
        return true;
}
const showError = (input, message) => {
    // get the form-field element
    const formField = input.parentElement;
    // add the error class
    formField.classList.remove('success');
    formField.classList.add('error');

    // show the error message
    const error = formField.querySelector('small');
    error.textContent = message;
};

const showSuccess = (input) => {
    // get the form-field element
    const formField = input.parentElement;

    // remove the error class
    formField.classList.remove('error');

    // hide the error message
    const error = formField.querySelector('small');
    error.textContent = '';
}


form.addEventListener('submit', function (e) {
    // prevent the form from submitting
    e.preventDefault();

    // validate fields
    let isTitleValid = checkTitle(),
        isEmailValid = checkEmail(),
        isMessageValid = checkMessage();

    let isFormValid = isTitleValid && isEmailValid && isMessageValid;

    // submit to the server if the form is valid
    if (isFormValid) {
        const formData = new FormData(form);
        formData.append('submit', '1');
        fetch('../controller/contact.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => {
            if (response.ok) {
                return response.json(); // Assuming your server responds with JSON
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .then(data =>{
            form.reset();
            const feedbackDiv = document.getElementById('feedback');
            feedbackDiv.textContent = data.message;
        })
        .catch(error => {
            console.error('Error', error);
        });
    }
});


const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};

form.addEventListener('input', debounce(function (e) {
    switch (e.target.id) {
        case 'title':
            checkTitle();
            break;
        case 'email':
            checkEmail();
            break;
        case 'message':
            checkMessage();
            break;
    }
}));