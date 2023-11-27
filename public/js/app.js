function openToastSuccess(title, message) {
  var toast = document.querySelector(".toast1");
  var toastTitle = document.querySelector(".toast__title");
  var toastP = document.querySelector(".toast__p");

  toastTitle.textContent = title;
  message = message.replace(/\+/g, " ");
  toastP.textContent = message;

  var openToastEvent = new CustomEvent("openToast");
  toast.dispatchEvent(openToastEvent);
}

function openToastFailed(title, message) {
  var toast2 = document.querySelector(".toast2");
  var toastTitle2 = document.querySelector(".title2");
  var toastP2 = document.querySelector(".p2");

  toastTitle2.textContent = title;
  message = message.replace(/\+/g, " ");
  toastP2.textContent = message;

  var openToastEvent = new CustomEvent("openToast");
  toast2.dispatchEvent(openToastEvent);
}

// Extract toast parameters from the URL path
const urlPath = window.location.pathname;

// Decode the URL path
const decodedUrlPath = decodeURIComponent(urlPath);

// Use a regular expression to extract content inside curly braces, handling URL-encoded semicolons
const match = decodedUrlPath.match(/\{([^{}]+)\}/);


if (match) {
  // Extract the content inside curly braces and decode each component
  const toastContent = decodeURIComponent(match[1]);

  // Split the content into individual parameters
  const params = toastContent.split(";").map((param) => param.trim());

  // Create an object to hold the parameters
  const toastParams = {};
  params.forEach((param) => {
    const [key, value] = param.split(":");
    toastParams[key] = value;
  });

  console.log("Decoded Parameters:", toastParams);

  // Check if 'toast' parameter is present and has a value of 'true'
  if (
    toastParams.toast === "true" &&
    toastParams.toasttitle &&
    toastParams.toastmessage
  ) {
    console.log("Triggering openToastSuccess function");
    openToastSuccess(toastParams.toasttitle, toastParams.toastmessage);
  } else if (
    toastParams.toast === "false" &&
    toastParams.toasttitle &&
    toastParams.toastmessage
  ) {
    console.log("Triggering openToastFailed function");
    openToastFailed(toastParams.toasttitle, toastParams.toastmessage);
  } else {
    console.log("Invalid or missing parameters for toast.");
  }
}

// this is for the select with the reviews

var reviewEntityDropdown = document.getElementById("reviewEntity");

if (reviewEntityDropdown) {
  reviewEntityDropdown.addEventListener("change", function () {
    var productDropdown = document.getElementById("productDropdown");
    var orderDropdown = document.getElementById("orderDropdown");
    var storeDropdown = document.getElementById("storeDropdown");

    if (this.value === "product") {
      productDropdown.style.display = "block";
      orderDropdown.style.display = "none";
      storeDropdown.style.display = "none";
    } else if (this.value === "order") {
      productDropdown.style.display = "none";
      orderDropdown.style.display = "block";
      storeDropdown.style.display = "none";
    } else if (this.value === "store") {
      productDropdown.style.display = "none";
      orderDropdown.style.display = "none";
      storeDropdown.style.display = "block";
    }
  });
}

// Get elements
const deleteImageBtn = document.getElementById("deleteImageBtn");
const confirmDeleteImageBtn = document.getElementById("confirmDeleteImage");
const deleteImageDialog = document.getElementById(
  "dialog-delete-image-confirmation"
);

// Add event listener to open dialog when delete button is clicked
if (deleteImageBtn) {
  deleteImageBtn.addEventListener("click", () => {
    deleteImageDialog.style.display = "flex";
  });
}

// Add event listener to cancel button in the dialog
if (deleteImageDialog) {
  deleteImageDialog
    .querySelector(".js-dialog__close")
    .addEventListener("click", () => {
      deleteImageDialog.style.display = "none";
    });
}
// Add event listener to confirm delete button in the dialog
if (confirmDeleteImageBtn) {
  confirmDeleteImageBtn.addEventListener("click", () => {
    // Perform the actual deletion by submitting the form
    document.querySelector('form[action*="deleteImage"]').submit();
  });
}
