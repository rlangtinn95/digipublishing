document.addEventListener('DOMContentLoaded', () => {
      const drinksContainer = document.getElementById('drinks-container')
      const addonsContainer = document.getElementById('addons-container')
      const orderSummary = document.getElementById('order-summary')
      const resetButton = document.getElementById('reset-order')
      const placeOrderButton = document.getElementById('place-order')
      const receipt = document.getElementById('receipt')
      const receiptTotal = document.getElementById('receipt-total')
      const receiptItems = document.getElementById('receipt-items')
      const orderItemsList = document.getElementById('order-items')
      const totalPriceDisplay = document.getElementById('total-price')
  
      let selectedDrinks = []
      let selectedAddOns = []
      let totalPrice = 0
  
      const drinks = [
          { id: 1, name: "Kaffe", price: 30 },
          { id: 2, name: "Cappuccino", price: 35 },
          { id: 3, name: "Macchiato", price: 40 },
          { id: 4, name: "Pumpkin Spice Latte", price: 45 }
      ]
  
      const addOns = [
          { id: 1, name: "Melk", price: 5 },
          { id: 2, name: "Sukker", price: 5 },
          { id: 3, name: "Sjokoladedryss", price: 5 },
          { id: 4, name: "Is", price: 0, isFree: true },
          { id: 5, name: "Sugerør", price: 0, isFree: true }
      ]

      function resetOrder() {
            selectedDrinks = []
            selectedAddOns = []
            totalPrice = 0
            orderItemsList.innerHTML = ''

            totalPriceDisplay.textContent = 'Sum: 0 kr'
            document.querySelectorAll('.drink-checkbox').forEach(checkbox => checkbox.checked = false)
            document.querySelectorAll('.add-on-checkbox').forEach(checkbox => checkbox.checked = false)
            document.querySelectorAll('.double-checkbox').forEach(checkbox => checkbox.checked = false)
            receipt.style.display = 'none'
        }

        resetButton.addEventListener('click', resetOrder)
  
      function populateDrinks() {
            drinks.forEach(drink => {
                const drinkElement = document.createElement('div')
                drinkElement.classList.add('drink')
                const isDoubleOption = (drink.name === "Kaffe" || drink.name === "Macchiato")

                // adds double checkbox for kaffe and macchiato only  
                drinkElement.innerHTML = `
                    <input type="checkbox" id="drink-${drink.id}" data-id="${drink.id}" data-price="${drink.price}" class="drink-checkbox">
                    <label for="drink-${drink.id}">${drink.name} - ${drink.price} kr</label>
                    ${isDoubleOption ? `
                        <input type="checkbox" id="double-${drink.id}" class="double-checkbox" data-price="${drink.price}" data-drink="${drink.name}">
                        <label for="double-${drink.id}">Dobbel</label>` : ''}
                `;
                drinksContainer.appendChild(drinkElement)
            });
        }
        
  
      function populateAddOns() {
          addOns.forEach(addOn => {
              const addOnElement = document.createElement('div')
              addOnElement.classList.add('add-on')
              addOnElement.innerHTML = `
                  <input type="checkbox" id="addon-${addOn.id}" data-id="${addOn.id}" data-price="${addOn.price}" class="add-on-checkbox">
                  <label for="addon-${addOn.id}">${addOn.name} ${addOn.isFree ? '- 0 kr' : `- ${addOn.price} kr`}</label>
              `;
              addonsContainer.appendChild(addOnElement)
          });
      }
  
      function updateOrder() {
            const selectedDrinkElements = document.querySelectorAll('.drink-checkbox:checked')
            const selectedAddOnElements = document.querySelectorAll('.add-on-checkbox:checked')
        
            selectedDrinks = []
            selectedAddOns = []
            totalPrice = 0
            orderItemsList.innerHTML = ''
        
            selectedDrinkElements.forEach(drinkElement => {
                const drinkId = drinkElement.dataset.id
                const drinkPrice = parseFloat(drinkElement.dataset.price)
                selectedDrinks.push({ id: drinkId, price: drinkPrice })
                totalPrice += drinkPrice
                const drinkLabel = document.querySelector(`label[for="${drinkElement.id}"]`).textContent
                const li = document.createElement('li')
                li.textContent = drinkLabel
                orderItemsList.appendChild(li)
        
                const doubleElement = document.querySelector(`#double-${drinkId}`)
                if (doubleElement && doubleElement.checked) {
                    totalPrice += drinkPrice
                    const doubleLabel = `Dobbel ${drinkLabel}`
                    const li = document.createElement('li')
                    li.textContent = doubleLabel
                    orderItemsList.appendChild(li)
                }
            });
        
            selectedAddOnElements.forEach(addOnElement => {
                const addOnId = addOnElement.dataset.id
                const addOnPrice = parseFloat(addOnElement.dataset.price)
                selectedAddOns.push({ id: addOnId, price: addOnPrice })
                totalPrice += addOnPrice
                const addOnLabel = document.querySelector(`label[for="${addOnElement.id}"]`).textContent
                const li = document.createElement('li')
                li.textContent = addOnLabel
                orderItemsList.appendChild(li)
            })
        
            totalPriceDisplay.textContent = `Sum: ${totalPrice} kr`
        }
        
  
        placeOrderButton.addEventListener('click', async () => {
            if (selectedDrinks.length === 0) {
                alert('Vennligst velg minst 1 drikke.')
                return
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
                })
      
                const textResponse = await response.text()
                console.log(textResponse)
        
                const receiptData = JSON.parse(textResponse);
                receiptTotal.textContent = `Sum: ${receiptData.totalPrice} kr`
                receiptItems.innerHTML = ''
        
                
                selectedDrinks.forEach(drink => {
                    const drinkName = drinks.find(d => d.id == drink.id).name
                    const li = document.createElement('li')
                    li.textContent = drinkName
                    receiptItems.appendChild(li)
        
                    const doubleElement = document.querySelector(`#double-${drink.id}`)
                    if (doubleElement && doubleElement.checked) {
                        const doubleLabel = `Dobbel ${drinkName}`
                        const li = document.createElement('li')
                        li.textContent = doubleLabel
                        receiptItems.appendChild(li)
                    }
                })
        
                // Display the ordered add-ons
                selectedAddOns.forEach(addOn => {
                    const addOnName = addOns.find(a => a.id == addOn.id).name
                    const li = document.createElement('li')
                    li.textContent = addOnName
                    receiptItems.appendChild(li)
                });
        
                receipt.style.display = 'block'
            } catch (error) {
                console.error('Feil med ordre:', error)
            }
        })
        
      
      document.addEventListener('change', updateOrder)
      populateDrinks()
      populateAddOns()
  });
  