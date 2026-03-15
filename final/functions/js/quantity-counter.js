// individual item version
document.querySelectorAll(".qty-controls.item").forEach(control => {
  const minus = control.querySelector(".minus");
  const plus = control.querySelector(".plus");
  const value = control.querySelector(".qty-value");
  const input = control.querySelector('.qty-input');

  plus.addEventListener("click", () => {
    let quantity = parseInt(input.value);
    quantity++;
    input.value = quantity;
    value.textContent = quantity;
  });

  minus.addEventListener("click", () => {
    let quantity = parseInt(input.value);
    if (quantity > 1) {
      quantity--;
      input.value = quantity;
      value.textContent = quantity;
    }
  });
});

// cart version
document.querySelectorAll(".qty-controls.cart").forEach(control => {
  const id = control.dataset.id;
  const minus = control.querySelector(".minus");
  const plus = control.querySelector(".plus");
  const value = control.querySelector(".qty-value");

  let quantity = parseInt(value.textContent);

  plus.addEventListener("click", () => {
    quantity++;
    value.textContent = quantity;
    updateCart(id, quantity);
  });

  minus.addEventListener("click", () => {
    if (quantity > 1) {
      quantity--;
      value.textContent = quantity;
      updateCart(id, quantity);
    }
  });
});

function updateCart(id, quantity) {
  fetch("/final/functions/helpers/update_quantity.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      item_id: id,
      quantity: quantity
    })
  })

  // converts POST data to JS object
  .then(response => response.json())
  .then(data => {

    // update this item's price
    const itemCard = document.querySelector(`article[data-id="${data.item_id}"]`);
    const itemPrice = itemCard.querySelector(".bag-item-price");
    itemPrice.textContent = "$" + data.item_total;

    // TODO: UPDATE FOR VARIANT PRICES IN CHECKOUT
    itemCard.querySelectorAll(".item-row.variant").forEach((row, i) => {
      const variantPrice = row.querySelector(".variant-price");
      const variant = data.variants[i];

      if (variantPrice && variant ) {
        variantPrice.textContent = "+ $" + variant.add_price;
      }
    });

    // update subtotal
    const subtotal = document.querySelector(".bag-total-value");
    subtotal.textContent = "$" + data.subtotal;
  });
}