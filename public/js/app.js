// let isValidationChecked = false; // Flag to track if validation has been checked

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
  var toast = document.querySelector(".toast2");
  var toastTitle = document.querySelector(".toast__title");
  var toastP = document.querySelector(".toast__p");

  toastTitle.textContent = title;
  message = message.replace(/\+/g, " ");
  toastP.textContent = message;

  var openToastEvent = new CustomEvent("openToast");
  toast.dispatchEvent(openToastEvent);
}

// Extract toast parameters from the URL path
const urlPath = window.location.pathname;

// Use a regular expression to extract content inside slashes
const match = urlPath.match(/\/([^\/]+)\/([^\/]+)\/([^\/]+)$/);

console.log("URL Path:", urlPath); // Log URL path for debugging

if (match) {
  // Extract the content inside slashes and decode each component
  const toastValue = decodeURIComponent(match[1]);
  const toasttitleValue = decodeURIComponent(match[2]);
  const toastmessageValue = decodeURIComponent(match[3]);

  console.log(
    "Decoded Parameters:",
    toastValue,
    toasttitleValue,
    toastmessageValue
  ); // Log decoded parameters for debugging

  // Check if 'toast' parameter is present and has a value of 'true'
  if (toastValue === "true" && toasttitleValue && toastmessageValue) {
    console.log("Triggering openToast function");
    console.log(toastmessageValue);
    openToastSuccess(toasttitleValue, toastmessageValue);
  } else if (toastValue == "false" && toasttitleValue && toastmessageValue) {
    openToastFailed(toasttitleValue, toastmessageValue);
  } else {
    console.log(toastValue);
    console.log("Invalid or missing parameters for toast.");
  }
} else {
  // 'toast' parameter is not present
  console.log("Toast parameter is not present in the URL.");
}

// this is for the select with the reviews

document.getElementById("reviewEntity").addEventListener("change", function () {
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

function previewImage() {
  var fileInput = document.getElementById("file");
  var imageContainer = document.getElementById("imageContainer");
  var imagePreview = document.getElementById("imagePreview");
  var noImageMessage = document.getElementById("noImageMessage");
  var deleteImage = document.getElementById("deleteImage");

  if (fileInput.files && fileInput.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      imagePreview.src = e.target.result;
      imageContainer.style.display = "block";
      noImageMessage.style.display = "none";
    };

    reader.readAsDataURL(fileInput.files[0]);
  } else {
    // Hide image preview and show the message
    imageContainer.style.display = "none";
    noImageMessage.style.display = "block";
  }
}
