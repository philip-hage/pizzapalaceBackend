let isValidationChecked = false; // Flag to track if validation has been checked

function openToast(title, message) {
  var toast = document.querySelector(".js-toast");
  var toastTitle = document.querySelector(".toast__title");
  var toastP = document.querySelector(".toast__p");

  toastTitle.textContent = title;
  toastP.textContent = message;

  var openToastEvent = new CustomEvent("openToast");
  toast.dispatchEvent(openToastEvent);
}

function isFormValid() {
  var customerfirstname = document.getElementById("customerfirstname");
  var customerlastname = document.getElementById("customerlastname");
  var customerstreetname = document.getElementById("customerstreetname");
  var customercity = document.getElementById("customercity");
  var customerzipcode = document.getElementById("customerzipcode");
  var customerphone = document.getElementById("customerphone");
  var customeremail = document.getElementById("customeremail");

  if (
    validateField(customerfirstname, "First Name") &&
    validateField(customerlastname, "Last Name") &&
    validateField(customerstreetname, "Street Name") &&
    validateField(customercity, "City") &&
    validateField(customerzipcode, "Zip Code") &&
    validateField(customerphone, "Phone") &&
    validateEmail(customeremail)
  ) {
    return true; // Form is valid
  } else {
    return false; // Form is not valid
  }
}

function validateField(field, fieldName) {
  if (field.value.trim() === "") {
    openToast("Error", fieldName + " cannot be empty.");
    return false;
  }
  return true;
}

function validateEmail(emailField) {
  var email = emailField.value.trim();
  var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  if (!emailRegex.test(email)) {
    openToast("Error", "Invalid email address.");
    return false;
  }
  return true;
}

const saveButton = document.querySelector(".saveButton");
saveButton.addEventListener("click", function (e) {
  e.preventDefault(); // Prevent the default form submission
  isValidationChecked = false; // Reset the flag

  if (isFormValid()) {
    openToast("Success", "You successfully created a customer");
    setTimeout(function () {
      document.getElementById("hiddenSubmitButton").click();
    }, 3000);
  }
});
