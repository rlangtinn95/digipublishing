    document.getElementById("registration-form").addEventListener("submit", async function (event) {
        event.preventDefault()

        const firstName = document.getElementById("first_name").value.trim()
        const lastName = document.getElementById("last_name").value.trim()
        const email = document.getElementById("e_mail").value.trim()
        const phoneNumber = document.getElementById("phone_number").value.trim()
        const birthDate = document.getElementById("birth_date").value.trim()

        //client-side validation
        if (!/^[A-Za-z]+$/.test(lastName)) {
            alert("Etternavn skal bare være ett ord.")
            return;
        }

        if (!/^\d{8}$/.test(phoneNumber)) {
            alert("Telefonnummer må være akkurat 8 nummer.")
            return
        }

        //send data to the server
        try {
            const response = await fetch("http://localhost:8080/info", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    first_name: firstName,
                    last_name: lastName,
                    e_mail: email,
                    phone_number: phoneNumber,
                    birth_date: birthDate,
                }),
            });

            if (!response.ok) {
                const error = await response.json()
                alert(error.message || "An error occurred.")
                return;
            }

            const newEntry = await response.json()
            addEntryToList(newEntry)
        } catch (error) {
            console.error("Error:", error)
            alert("An error occurred.")
        }
    });

    //fetch existing data on load
    (async function fetchData() {
        try {
            const response = await fetch("http://localhost:8080/info");
            const data = await response.json()
            data.forEach(addEntryToList)
        } catch (error) {
            console.error("Error fetching data:", error)
        }
    })();

    function formatDate(dateString) {
        const date = new Date(dateString)
        const day = String(date.getDate()).padStart(2, '0')
        const month = String(date.getMonth() + 1).padStart(2, '0')
        const year = date.getFullYear()
        return `${day}.${month}.${year}`
    }

    function addEntryToList(entry) {
        const list = document.getElementById("data-list")
        const listItem = document.createElement("li")
        const formattedBirthDate = formatDate(entry.birth_date)
        listItem.textContent = `Fornavn: ${entry.first_name}, 
                                Etternavn: ${entry.last_name}, 
                                E-post: ${entry.e_mail}, 
                                Telefonnummer: ${entry.phone_number}, 
                                Fødselsdato: ${formattedBirthDate}`
        list.insertBefore(listItem, list.firstChild)
    }
