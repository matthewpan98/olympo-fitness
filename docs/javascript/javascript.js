
function showError(input, message) {
    removeChildInput(input);

    const errorElement = document.createElement("strong");
    errorElement.className = "error_Message";
    errorElement.appendChild(document.createTextNode(message));

    input.parentNode.insertBefore(errorElement, input.nextSibling);
}

function removeChildInput(input) {
    const nextSibling = input.nextSibling;

    if (nextSibling && nextSibling.classList && nextSibling.classList.contains("error_Message")) {
        input.parentNode.removeChild(nextSibling);
    }
}



//LOGIN
function addOnBlurLogin(){
    let inputNome = document.getElementById("nome");
    inputNome.onblur = function () {validateNome(this)};
    
    let inputPassword = document.getElementById("password");
    inputPassword.onblur = function () {validatePassword(this)};
}

function validateNome(inputNome){
    removeChildInput(inputNome);
    if(inputNome.value.search(/\w{3,}/)!=0){
        showError(inputNome,"Inserire un nome utente con almeno 3 lettere e/o numeri.");
        inputNome.focus();
        inputNome.select();
        return false;
    }
    return true;
}

function validatePassword(inputPassword){
    removeChildInput(inputPassword);
    if(inputPassword.value.length < 4){
        showError(inputPassword,"Inserire una password con almeno 4 caratteri.");
        inputPassword.focus();
        inputPassword.select();
        return false;
    }
    return true;
}

function validateFormLogin(){
    let inputNome = document.getElementById("nome");
    let inputPassword = document.getElementById("password");

    return validateNome(inputNome)
        && validatePassword(inputPassword);
}



//REGISTRAZIONE
function addOnBlurRegistrazione(){
    let inputEmail = document.getElementById("email");
    inputEmail.onblur = function() {validateEmail(this)};

    let inputNome = document.getElementById("nome");
    inputNome.onblur = function () {validateNome(this)};
    
    let inputPassword = document.getElementById("password");
    inputPassword.onblur = function () {validatePassword(this)};
}

function validateEmail(inputEmail){
    removeChildInput(inputEmail);
    if(inputEmail.value.search(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)!=0){
        showError(inputEmail,"Inserire un indirizzo email valido.");
        inputEmail.focus();
        inputEmail.select();
        return false;
    }
    return true;
}

function validateFormRegistrazione(){
    let inputEmail = document.getElementById("email");
    let inputNome = document.getElementById("nome");
    let inputPassword = document.getElementById("password");

    return validateEmail(inputEmail)
        && validateNome(inputNome)
        && validatePassword(inputPassword);
}



//FAQ UTENTE
function addOnBlurFaqUtente(){
    let inputDomanda = document.getElementById("question");
    inputDomanda.onblur = function() {validateDomanda(this)};
}

function validateDomanda(inputDomanda){
    removeChildInput(inputDomanda);

    if(inputDomanda.value.length < 5){
        showError(inputDomanda,"Inserire una domanda aperta con almeno 5 caratteri.");
        inputDomanda.focus();
        return false;
    }
    return true;
}

function validateFormFaqUtente(){
    let inputDomanda = document.getElementById("question");

    return validateDomanda(inputDomanda);
}



//FAQ ADMIN
function addOnBlurFaqAdmin(){
    let inputRisposta = document.getElementById("answer_");
    inputRisposta.onblur = function() {validateRisposta(this)};
}

function validateRisposta(inputRisposta){
    removeChildInput(inputRisposta);

    if(inputRisposta.value.length < 10){
        showError(inputRisposta,"Inserire una risposta con almeno 10 caratteri.");
        inputRisposta.focus();
        inputRisposta.select();
        return false;
    }
    return true;
}

function validateFormFaqAdmin(){
    let inputRisposta = document.getElementById("answer_");

    return validateRisposta(inputRisposta);
}



//CARRELLO
function addOnBlurCart(){
    let inputIndirizzo = document.getElementById("address");
    inputIndirizzo.onblur = function() {validateIndirizzo(this)};

    let inputCity = document.getElementById("city");
    inputCity.onblur = function () {validateCity(this)};
    
    let inputCap = document.getElementById("cap");
    inputCap.onblur = function () {validateCap(this)};
}

function validateIndirizzo(inputIndirizzo) {
    removeChildInput(inputIndirizzo);

    if(inputIndirizzo.value.search(/^[A-Za-z]+(\s[A-Za-z]+)*\s\d+$/)!=0) {
        showError(inputIndirizzo, "Inserire un indirizzo valido, ad esempio: via Rossi 53.");
        inputIndirizzo.focus();
        inputIndirizzo.select();
        return false;
    }
    return true;
}

function validateCity(inputCity) {
    removeChildInput(inputCity);

    if(inputCity.value.search(/^[A-Za-z]+$/)!=0) {
        showError(inputCity, "Inserire una città valida (solo lettere).");
        inputCity.focus();
        inputCity.select();
        return false;
    }
    return true;
}

function validateCap(inputCap) {
    removeChildInput(inputCap);

    if(inputCap.value.search(/^\d{5}$/)!=0) {
        showError(inputCap, "Inserire un CAP valido, ad esempio: 36100.");
        inputCap.focus();
        inputCap.select();
        return false;
    }
    return true;
}

function validateFormCart(){
    let inputIndirizzo = document.getElementById("address");
    let inputCity = document.getElementById("city");
    let inputCap = document.getElementById("cap");

    return validateIndirizzo(inputIndirizzo)
        &&validateCity(inputCity)
        &&validateCap(inputCap);
}



//AGGIUNGI-MODIFICA PRODOTTO
function addOnBlurProdotto(){
    let inputName = document.getElementById("nome");
    inputName.onblur = function() {validateName(this)};

    let inputPrezzo = document.getElementById("prezzo");
    inputPrezzo.onblur = function () {validatePrezzo(this)};
    
    let inputPeso = document.getElementById("peso");
    inputPeso.onblur = function () {validatePeso(this)};

    let inputDimensione = document.getElementById("dimensione");
    inputDimensione.onblur = function () {validateDimensione(this)};

    let inputColore = document.getElementById("colore");
    inputColore.onblur = function () {validateColore(this)};

    let inputVolume = document.getElementById("volume");
    inputVolume.onblur = function () {validateVolume(this)};

    let inputMateriale = document.getElementById("materialeUtilizzato");
    inputMateriale.onblur = function () {validateMateriale(this)};

    let inputQuantita = document.getElementById("quantita");
    inputQuantita.onblur = function () {validateQuantita(this)};

    let inputDescrizione = document.getElementById("descrizione");
    inputDescrizione.onblur = function () {validateDescrizione(this)};

    let inputAlt = document.getElementById("alt");
    inputAlt.onblur = function () {validateAlt(this)};
}

function validateName(inputName){
    removeChildInput(inputName);
    if(inputName.value.search(/\w{3,}/)!=0){
        showError(inputName,"Inserire il nome del prodotto con almeno 3 lettere e/o numeri.");
        inputName.focus();
        inputName.select();
        return false;
    }
    return true;
}

function validatePrezzo(inputPrezzo){
    removeChildInput(inputPrezzo);
    if(inputPrezzo.value.search(/^(?!0*(\.0+)?$)[1-9]\d*(\.\d+)?$/)!=0){
        showError(inputPrezzo,"Inserire un prezzo maggiore di 0, ad esempio: 19 o 5.7.");
        inputPrezzo.focus();
        inputPrezzo.select();
        return false;
    }
    return true;
}

function validatePeso(inputPeso) {
    removeChildInput(inputPeso);
    let unitaMisura = ["mg", "kg"];
    let pesoExpr = /^(\d+(\.\d+)?)\s*([a-zA-Z]{1,2})$/;
    
    if (!pesoExpr.test(inputPeso.value) || !unitaMisura.includes(inputPeso.value.trim().substr(-2).toLowerCase()) || parseFloat(inputPeso.value) <= 0) {
        showError(inputPeso, "Inserire un peso valido (mg, kg)");
        inputPeso.focus();
        inputPeso.select();
        return false;
    }
    return true;
}

function validateDimensione(inputDimensione) {
    removeChildInput(inputDimensione);

    if (!/^(\d+(\.\d+)?\s*(cm|m))(?:\s*x\s*(?!0)(\d+(\.\d+)?\s*(cm|m)))?(?:\s*x\s*(?!0)(\d+(\.\d+)?\s*(cm|m)))?$/i.test(inputDimensione.value)) {
        showError(inputDimensione, "Inserire una dimensione valida (cm, m), ad esempio: 22 cm x 56 cm x 28 cm.");
        inputDimensione.focus();
        inputDimensione.select();
        return false;
    }
    return true;
}

function validateColore(inputColore) {
    removeChildInput(inputColore);

    if(inputColore.value.search(/^[a-zA-Z]*$/) !=0) {
        showError(inputColore, "Inserire un colore, senza numeri.");
        inputColore.focus();
        inputColore.select();
        return false;
    }
    return true;
}

function validateVolume(inputVolume) {
    removeChildInput(inputVolume);
    let unitaMisura = ["ml", "cl"];
    let volumeExpr = /^(\d+(\.\d+)?\s*([a-zA-Z]{1,2})?)?$/;

    if (!volumeExpr.test(inputVolume.value) || (inputVolume.value.trim().length > 0 && !unitaMisura.includes(inputVolume.value.trim().substr(-2).toLowerCase())) || (parseFloat(inputVolume.value) <= 0 && inputVolume.value.trim().length > 0)) {
        showError(inputVolume, "Inserire un volume valido (ml, cl)");
        inputVolume.focus();
        inputVolume.select();
        return false;
    }
    return true;
}

function validateMateriale(inputMateriale){
    removeChildInput(inputMateriale);
    
    if(inputMateriale.value.search(/^[a-zA-Z]*$/) !=0) {
        showError(inputMateriale,"Inserire il/i materiale/i utilizzato/i nel prodotto, senza numeri.");
        inputMateriale.focus();
        inputMateriale.select();
        return false;
    }
    return true;
}
        
function validateQuantita(inputQuantita){
    removeChildInput(inputQuantita);
    
    if(inputQuantita.value.search(/^[1-9]\d*$/)!=0){
        showError(inputQuantita,"Inserire un numero intero.");
        inputQuantita.focus();
        inputQuantita.select();
        return false;
    }
    return true;
}
        
function validateDescrizione(inputDescrizione){
    removeChildInput(inputDescrizione);
    
    if(inputDescrizione.value.length < 25){
        showError(inputDescrizione,"Inserire una descrizione di almeno 25 caratteri.");
        inputDescrizione.focus();
        return false;
    }
    return true;
}
        
function validateAlt(inputAlt){
    removeChildInput(inputAlt);
    
    if(inputAlt.value.length < 5 || inputAlt.value.length > 75){
        showError(inputAlt,"Inserire una breve descrizione maggiore di 5 e minore di 75 caratteri.");
        inputAlt.focus();
        return false;
    }
    return true;
}

function validateFormProdotto(){
    let inputName = document.getElementById("nome");
    let inputPrezzo = document.getElementById("prezzo");
    let inputPeso = document.getElementById("peso");
    let inputDimensione = document.getElementById("dimensione");
    let inputColore = document.getElementById("colore");
    let inputVolume = document.getElementById("volume");
    let inputMateriale = document.getElementById("materialeUtilizzato");
    let inputQuantita = document.getElementById("quantita");
    let inputDescrizione = document.getElementById("descrizione");
    let inputAlt = document.getElementById("alt");

    return validateName(inputName)
        &&validatePrezzo(inputPrezzo)
        &&validatePeso(inputPeso)
        &&validateDimensione(inputDimensione)
        &&validateColore(inputColore)
        &&validateVolume(inputVolume)
        &&validateMateriale(inputMateriale)
        &&validateQuantita(inputQuantita)
        &&validateDescrizione(inputDescrizione)
        &&validateAlt(inputAlt);
}