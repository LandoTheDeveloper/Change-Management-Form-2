function addItemField() {
  const itemsContainer = document.getElementById("items-container");
  const newItem = document.createElement("div");
  newItem.classList.add("item");
  newItem.innerHTML = `
    <label>Item:</label>
    <input type="text" name="items[]" required>
    <label>Hours Assigned:</label>
    <input type="number" name="hours[]" required>
    <button type="button" onclick="removeItemField(this)">Remove</button>
  `;
  itemsContainer.appendChild(newItem);
}

function removeItemField(button) {
  const item = button.parentElement;
  const itemsContainer = document.getElementById("items-container");
  itemsContainer.removeChild(item);
}