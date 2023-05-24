/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

document.getElementById('add_echantillon_one_by_one_validationDlc').addEventListener('click', changeDisplayNone);
let flexNone1 = document.getElementById('tempOfBreak');
let flexNone2 = document.getElementById('dateOfBreak');

function changeDisplayNone() {
    flexNone1.classList.toggle('qsa-none')
    flexNone2.classList.toggle('qsa-none')
}
