let checkBoxValidationDLC = document.getElementById('add_echantillon_one_by_one_validationDlc');
let checkBoxAnalyseDLC = document.getElementById('add_echantillon_one_by_one_analyseDlc');
let tempOfBreak = document.getElementById('tempOfBreak');
let dateOfBreak = document.getElementById('dateOfBreak');
let tempOfBreakInput = document.getElementById('add_echantillon_one_by_one_tempOfBreak');
let dateOfBreakInput = document.getElementById('add_echantillon_one_by_one_dateOfBreak');
let manufacturingInput = document.getElementById('add_echantillon_one_by_one_dateOfManufacturing');
let dlcDluoInput = document.getElementById('add_echantillon_one_by_one_DlcOrDluo');

function checkBoxValidationDLCFunction() {
    if (checkBoxValidationDLC.checked === true){
        tempOfBreak.style.display = 'block';
        dateOfBreak.style.display = 'block';
        dateOfBreakInput.classList.add('qsa-input-form-needed');
        tempOfBreakInput.classList.add('qsa-input-form-needed');
        manufacturingInput.classList.add('qsa-input-form-needed');
        dlcDluoInput.classList.add('qsa-input-form-needed');
        checkBoxAnalyseDLC.checked = true;
    } else {
        dateOfBreak.style.display = 'none';
        tempOfBreak.style.display = 'none';
        dateOfBreakInput.classList.remove('qsa-input-form-needed');
        tempOfBreakInput.classList.remove('qsa-input-form-needed');
        if (checkBoxAnalyseDLC.checked !== true) {
            manufacturingInput.classList.remove('qsa-input-form-needed');
            dlcDluoInput.classList.remove('qsa-input-form-needed');
        }
    }
}

function checkBoxAnalyseDLCFunction() {
    if (checkBoxAnalyseDLC.checked === true) {
        manufacturingInput.classList.add('qsa-input-form-needed');
        dlcDluoInput.classList.add('qsa-input-form-needed');
    } else {
        if (checkBoxValidationDLC.checked === true) {
            checkBoxAnalyseDLC.checked = true
        } else {
            manufacturingInput.classList.remove('qsa-input-form-needed');
            dlcDluoInput.classList.remove('qsa-input-form-needed');
        }
    }
}

checkBoxValidationDLC.addEventListener('click', checkBoxValidationDLCFunction);
checkBoxAnalyseDLC.addEventListener('click', checkBoxAnalyseDLCFunction);
document.addEventListener("DOMContentLoaded", function(event) {
    checkBoxValidationDLCFunction();
    checkBoxAnalyseDLCFunction();
});