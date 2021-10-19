// Wait for the page to load before trying to do anything with JavaScript
document.addEventListener('DOMContentLoaded', function(event) {

	// Identify the form
	// One way of identifying one element is using an ID
	let myForm = document.getElementById('insert-form');

	// Identify the result message
	// Using querySelector, we can identify a single element using a selector just like we do in CSS
	let message = document.querySelector('.form-row .message-box');

	// Add an event listener to the form and create a function to run when that event is detected
	myForm.addEventListener('submit', function(event) {
		// Stop the default form submission action
		event.preventDefault();

		// Validate the form, and store the validation result (true or false) in a variable
		let valid = validateForm();

		// When the data is valid, we can submit the form
		if(valid) {
			myForm.submit();
		}
		// If it's not valid, update the message
		else {
			message.innerHTML = 'Please correct errors and submit again';
			message.classList.add('alert-error');
		}
	})

	// The form validation function run when the form is submitted
	function validateForm() {
		let valid = true;
		let errors = 0;

		// Get all the inputs
		let inputs = myForm.querySelectorAll('input[type=text][required], input[type=file][required], textarea[required]');

		// Loop through text inputs and do the same validation and styling for each of them
		for(let input of inputs) {
			if(isNotEmpty(input.value)) {
				updateStyling(input, true);
			}
			else {
				errors++;
				updateStyling(input, false);
			}
		}

		// If there's at least one error, the submission is not valid
		if(errors > 0) {
			valid = false;
		}

		// Return whether the form submission is valid or not
		return valid;
	}

	// Utility function to check that input is not empty, including whitespace only
	// Ref: https://gist.github.com/EdCharbeneau/9552248
	// Ref: https://stackoverflow.com/a/42668364
	// Ref: https://stackoverflow.com/a/6471736
	function isNotEmpty(str) {
		let result = true;
		// Check conditions that would make the result of this check false
		if(!str) {
			//console.log('No string submitted');
			result = false;
		}
		else if(str.length === 0) {
			//console.log('String has 0 characters');
			result = false;
		}
		else if(new RegExp(/^\s+$/).test(str)) {
			//console.log('String is only whitespace');
			result = false;
		}
		// if none of the above conditions are met, result remains true

		return result;
	}

	// Utility function to add styling to each field based on whether they're valid or not
	function updateStyling(field, valid) {
		if(valid) {
			field.closest('.form-row').classList.remove('invalid');
			field.closest('.form-row').classList.add('valid');
		}
		else {
			field.closest('.form-row').classList.remove('valid');
			field.closest('.form-row').classList.add('invalid');
		}
	}
})