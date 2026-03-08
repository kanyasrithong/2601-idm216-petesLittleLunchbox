// individual item version
document.querySelectorAll(".quantity-control.item").forEach(control => {
  const minus = control.querySelector(".minus");
  const plus = control.querySelector(".plus");
  const input = control.querySelector(".quantity-value");

  plus.addEventListener("click", () => {
    let quantity = parseInt(input.value);
    quantity++;
    input.value = quantity;
  });

  minus.addEventListener("click", () => {
    let quantity = parseInt(input.value);

    if (quantity > 1) {
      quantity--;
      input.value = quantity;
    }
  });
});

// cart version
document.querySelectorAll(".quantity-control.cart").forEach(control => {
  const id = control.dataset.id;
  const minus = control.querySelector(".minus");
  const plus = control.querySelector(".plus");
  const input = control.querySelector(".quantity-value");

  plus.addEventListener("click", () => {
    let quantity = parseInt(input.value);
    quantity++;
    input.value = quantity;

    updateCart(id, quantity);
  });

  minus.addEventListener("click", () => {
    let quantity = parseInt(input.value);

    if (quantity > 1) {
      quantity--;
      input.value = quantity;
      updateCart(id, quantity);
    }
  });
});

function updateCart(id, quantity) {
  fetch("functions/helpers/update_quantity.php", {
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
    const itemPrice = itemCard.querySelector(".item-row h3:last-child");
    itemPrice.textContent = "$" + data.item_total;

    // update variant prices
    itemCard.querySelectorAll(".item-row.variant").forEach((row, index) => {
      const variantPrice = row.querySelector(".variant-price");
      if (variantPrice && data.variants[index]) {
        variantPrice.textContent = "+ $" + data.variants[index].add_price;
      }
    });

    // update subtotal
    const subtotal = document.querySelector(".subtotal-value");
    subtotal.textContent = "$" + data.subtotal;

  });
}