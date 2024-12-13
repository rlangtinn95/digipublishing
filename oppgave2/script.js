document.addEventListener('DOMContentLoaded', () => {
      const drinksContainer = document.getElementById('drinks-container');
      const addonsContainer = document.getElementById('addons-container');
      const orderSummary = document.getElementById('order-summary');
      const placeOrderButton = document.getElementById('place-order');
      const receipt = document.getElementById('receipt');
      const receiptTotal = document.getElementById('receipt-total');
      const receiptItems = document.getElementById('receipt-items');
      const orderItemsList = document.getElementById('order-items');
      const totalPriceDisplay = document.getElementById('total-price');
  
      let selectedDrinks = [];
      let selectedAddOns = [];
      let totalPrice = 0;
  
      // Hardcoded data for drinks and add-ons
      const drinks = [
          { id: 1, name: "Kaffe", price: 30 },
          { id: 2, name: "Cappuccino", price: 35 },
          { id: 3, name: "Macchiato", price: 40 },
          { id: 4, name: "Pumpkin Spice Latte", price: 45 }
      ];
  
      const addOns = [
          { id: 1, name: "Milk", price: 5 },
          { id: 2, name: "Sugar", price: 5 },
          { id: 3, name: "Strawberry Straws", price: 5 },
          { id: 4, name: "Ice", price: 0, isFree: true },
          { id: 5, name: "Straw", price: 0, isFree: true }
      ];
  
      // Populate drinks section
      function populateDrinks() {
          drinks.forEach(drink => {
              const drinkElement = document.createElement('div');
              drinkElement.classList.add('drink');
              drinkElement.innerHTML = `
                  <input type="checkbox" id="drink-${drink.id}" data-id="${drink.id}" data-price="${drink.price}" class="drink-checkbox">
                  <label for="drink-${drink.id}">${drink.name} - ${drink.price} kr</label>
              `;
              drinksContainer.appendChild(drinkElement);
          });
      }
  
      // Populate add-ons section
      function populateAddOns() {
          addOns.forEach(addOn => {
              const addOnElement = document.createElement('div');
              addOnElement.classList.add('add-on');
              addOnElement.innerHTML = `
                  <input type="checkbox" id="addon-${addOn.id}" data-id="${addOn.id}" data-price="${addOn.price}" class="add-on-checkbox">
                  <label for="addon-${addOn.id}">${addOn.name} ${addOn.isFree ? '(Free)' : `- ${addOn.price} kr`}</label>
              `;
              addonsContainer.appendChild(addOnElement);
          });
      }
  
      // Update selected items and total price
      function updateOrder() {
          const selectedDrinkElements = document.querySelectorAll('.drink-checkbox:checked');
          const selectedAddOnElements = document.querySelectorAll('.add-on-checkbox:checked');
  
          selectedDrinks = [];
          selectedAddOns = [];
          totalPrice = 0;
          orderItemsList.innerHTML = '';
  
          selectedDrinkElements.forEach(drinkElement => {
              const drinkId = drinkElement.dataset.id;
              const drinkPrice = parseFloat(drinkElement.dataset.price);
              selectedDrinks.push({ id: drinkId, price: drinkPrice });
              totalPrice += drinkPrice;
              const drinkLabel = document.querySelector(`label[for="${drinkElement.id}"]`).textContent;
              const li = document.createElement('li');
              li.textContent = drinkLabel;
              orderItemsList.appendChild(li);
          });
  
          selectedAddOnElements.forEach(addOnElement => {
              const addOnId = addOnElement.dataset.id;
              const addOnPrice = parseFloat(addOnElement.dataset.price);
              selectedAddOns.push({ id: addOnId, price: addOnPrice });
              totalPrice += addOnPrice;
              const addOnLabel = document.querySelector(`label[for="${addOnElement.id}"]`).textContent;
              const li = document.createElement('li');
              li.textContent = addOnLabel;
              orderItemsList.appendChild(li);
          });
  
          totalPriceDisplay.textContent = `Total Price: ${totalPrice} kr`;
      }
  
      // Handle placing the order
      placeOrderButton.addEventListener('click', async () => {
          if (selectedDrinks.length === 0) {
              alert('Please select at least one drink.');
              return;
          }
  
          try {
              const response = await fetch('place_order.php', {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify({
                      drinks: selectedDrinks,
                      addOns: selectedAddOns,
                      totalPrice: totalPrice
                  })
              });
  
              const receiptData = await response.json();
  
              // Show receipt
              receiptTotal.textContent = `Total Price: ${receiptData.totalPrice} kr`;
              receiptItems.innerHTML = '';
              receiptData.items.forEach(item => {
                  const li = document.createElement('li');
                  li.textContent = item.name;
                  receiptItems.appendChild(li);
              });
              receipt.style.display = 'block';
          } catch (error) {
              console.error('Error placing order:', error);
          }
      });
  
      // Listen for changes in drink or add-on selection
      document.addEventListener('change', updateOrder);
  
      // Populate drinks and add-ons when the page loads
      populateDrinks();
      populateAddOns();
  });
  