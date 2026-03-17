// cart version
document.querySelectorAll(".tip-box").forEach(button => {
  const tipValueElement = button.querySelector(".tip-value");
  if (tipValueElement) {
    const tipValue = parseFloat(tipValueElement.textContent);

    button.addEventListener("click", () => {
      updateTip(tipValue);
    });
  }
});

function updateTip(tipValue) {
  // update tip amount
  const tip = document.querySelector("#tipValue");
  tip.textContent = tipValue.toFixed(2);

  // update tax
  const pretaxValue = parseFloat(document.querySelector("#pretaxValue").textContent);

  const taxPercent = 0.08;
  const tax = document.querySelector("#taxValue");
  const taxAmount = (pretaxValue * taxPercent).toFixed(2);
  tax.textContent = taxAmount;

  // update total
  const total = document.querySelector("#totalAmount");
  const orderTotal = document.querySelector("#orderTotal")
  const totalAmount = (pretaxValue + parseFloat(taxAmount) + tipValue).toFixed(2);
  total.textContent = totalAmount;
  orderTotal.value = parseFloat(totalAmount);
};
