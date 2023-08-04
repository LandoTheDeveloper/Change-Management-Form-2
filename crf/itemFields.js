
  let itemId = 1; // Initialize the item ID counter

  function addItemField() {
    const itemsContainer = document.getElementById("items-container");

    // Create a new item field div
    const itemFieldDiv = document.createElement("div");
    itemFieldDiv.className = "item";

    // Create the scope of work textarea
    const scopeOfWorkTextarea = document.createElement("textarea");
    scopeOfWorkTextarea.name = "items[]";
    scopeOfWorkTextarea.required = true;
    scopeOfWorkTextarea.id = "scope-of-work-editor-" + itemId; // Use unique IDs
    itemFieldDiv.appendChild(scopeOfWorkTextarea);

    // Create the hours assigned input field
    const hoursAssignedInput = document.createElement("input");
    hoursAssignedInput.type = "number";
    hoursAssignedInput.name = "hours[]";
    hoursAssignedInput.required = true;
    itemFieldDiv.appendChild(hoursAssignedInput);

    // Create the remove button
    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.innerText = "Remove";
    removeButton.classList.add("button");
    removeButton.onclick = function () {
      itemFieldDiv.remove();
    };
    itemFieldDiv.appendChild(removeButton);

    // Append the new item field to the container
    itemsContainer.appendChild(itemFieldDiv);

    // Initialize the new textarea as TinyMCE editor
    initializeTinyMCE("#scope-of-work-editor-" + itemId);

    // Increment the item ID counter
    itemId++;
  }