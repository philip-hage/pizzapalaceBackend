const buttons = document.querySelectorAll(".js-filter-nav__btn");
const cards = document.querySelectorAll(".card");

buttons.forEach((button) => {
  button.addEventListener("click", () => {
    const category = button.getAttribute("data-filter");

    cards.forEach((card) => {
      const cardCategory = card.getAttribute("data-category");
      if (category === cardCategory || category === "all") {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
});

function openToast(productName) {
  var toast = document.querySelector(".js-toast");
  toast.querySelector(".toast__p").innerHTML = productName + " added to cart";
  openToastEvent = new CustomEvent("openToast"); // custom event
  toast.dispatchEvent(openToastEvent);
}

document.addEventListener("DOMContentLoaded", function () {
  const productCart = JSON.parse(localStorage.getItem("productCart")) || [];
  const selectedPizzasContainer = document.getElementById(
    "selectedPizzasContainer"
  );

  // Add event listeners to the "Add To Cart" buttons
  const addToCartButtons = document.querySelectorAll(".addToCartBtn");
  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      const card = button.parentElement;
      console.log(card);
      const productId = card.querySelector(".productId").value;
      const productName = card.querySelector(".productName").value;
      const productPrice = card.querySelector(".productPrice").value;
      const productPath = card.querySelector(".productPath").value;

      openToast(productName);

      addToCart(productId, productName, productPrice, productPath);
      updateSelectedProducts();
    });
  });

  function addToCart(productId, productName, productPrice, productPath) {
    const existingProduct = productCart.find((item) => item.id === productId);
    if (existingProduct) {
      // If it's in the cart, increase its quantity
      existingProduct.quantity++;
    } else {
      // If it's not in the cart, add it as a new item
      productCart.push({
        id: productId,
        name: productName,
        price: productPrice,
        path: productPath,
        quantity: 1,
      });
    }
    saveCartToLocalStorage();

    updateCartCount();
  }

  function saveCartToLocalStorage() {
    localStorage.setItem("productCart", JSON.stringify(productCart));
  }

  function updateCartCount() {
    const totalProductsInCart = productCart.reduce(
      (total, product) => total + product.quantity,
      0
    );

    // Select the <h1> element by its id
    const cartTitle = document.getElementById("cartcount");

    // Update the content of the <h1> element
    cartTitle.textContent = `Your Cart (${totalProductsInCart})`;
  }

  // Function to update and display selected pizzas
  function updateSelectedProducts() {
    const selectedPizzasContainer = document.getElementById(
      "selectedPizzasContainer"
    );
    const selectedProductsList = document.getElementById(
      "selectedProductsList"
    );
    const totalPriceElement = document.getElementById("totalPrice");
    let totalPrice = 0;
    let totalCartPrice = 0;

    selectedProductsList.innerHTML = "";

    if (productCart.length > 0) {
      productCart.forEach(function (product, index) {
        // Create a new list item for each pizza
        const listItem = document.createElement("li");
        listItem.classList.add("dr-cart__product");

        // Create an <img> element for pizza image
        const imageUrl = `http://localhost/pizzapalace/${product.path}`;
        const productImage = document.createElement("img");
        productImage.classList.add("dr-cart__img");
        productImage.src = imageUrl;

        // Create an <h2> element for pizza name
        const productName = document.createElement("h2");
        productName.classList.add("text-sm");
        productName.textContent = product.name;

        // Create an <h2> element for pizza name
        const productAmount = document.createElement("h2");
        productAmount.classList.add("text-sm");
        productAmount.textContent = product.quantity + "x";

        const textDiv = document.createElement("div");
        textDiv.appendChild(productName);
        textDiv.appendChild(productAmount);

        // Calculate the total price for this type of pizza
        const totalProductPrice = parseFloat(product.price) * product.quantity;

        // Create a <p> element for the total price of this type of pizza
        const productTotalPrice = document.createElement("p");
        productTotalPrice.classList.add("text-sm", "color-contrast-higher");
        productTotalPrice.textContent = `Total: €${totalProductPrice.toFixed(
          2
        )}`;

        // Create a button for removing the pizza
        const removeButton = document.createElement("button");
        removeButton.classList.add("dr-cart__remove-btn", "margin-top-xxxs");
        removeButton.textContent = "Remove";

        removeButton.addEventListener("click", function () {
          if (product.quantity > 1) {
            // If the quantity is greater than 1, decrement the quantity
            product.quantity--;
          } else {
            // If the quantity is 1, remove the entire entry from the cart
            productCart.splice(index, 1);
          }
          // Update the local storage after removing an item
          saveCartToLocalStorage();
          // Update the selected pizzas display
          updateSelectedProducts();

          updateCartCount();
        });

        const textRightDiv = document.createElement("div");
        textRightDiv.classList.add("text-right");
        textRightDiv.appendChild(productTotalPrice);
        textRightDiv.appendChild(removeButton);

        listItem.appendChild(productImage);
        listItem.appendChild(textDiv);
        listItem.appendChild(textRightDiv);

        selectedProductsList.appendChild(listItem);

        totalCartPrice += totalProductPrice;

        totalPrice += parseFloat(product.price) * product.quantity;
      });

      totalPriceElement.textContent = `Total Price: €${totalPrice.toFixed(2)}`;
    } else {
      const listItem = document.createElement("li");
      listItem.classList.add("dr-cart__product");

      const emptyCart = document.createElement("h2");
      emptyCart.classList.add("text-lg", "text-center");
      emptyCart.textContent = "Your cart is empty!!!";

      listItem.appendChild(emptyCart);

      selectedProductsList.appendChild(listItem);

      totalPriceElement.textContent = "Total Price: €0.00";
    }
  }

  updateSelectedProducts();

  updateCartCount();
});
