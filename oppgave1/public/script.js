document.getElementById("registration-form").addEventListener("submit", async function (event) {
    event.preventDefault();

    const firstName = document.getElementById("first_name").value.trim();
    const lastName = document.getElementById("last_name").value.trim();
    const email = document.getElementById("e_mail").value.trim();
    const phoneNumber = document.getElementById("phone_number").value.trim();
    const birthDate = document.getElementById("birth_date").value.trim();

    // Client-side validation
    if (!/^[A-Za-z]+$/.test(lastName)) {
        alert("Last name must contain only one word.");
        return;
    }

    if (!/^(9|4)\d{7}$/.test(phoneNumber)) {
        alert("Phone number must be 8 digits and start with 9 or 4.");
        return;
    }

    // Send data to the server
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
            const error = await response.json();
            alert(error.message || "An error occurred.");
            return;
        }

        const newEntry = await response.json();
        addEntryToList(newEntry);
    } catch (error) {
        console.error("Error:", error);
        alert("An error occurred.");
    }
});

// Fetch existing data on load
(async function fetchData() {
    try {
        const response = await fetch("http://localhost:8080/info");
        const data = await response.json();
        data.forEach(addEntryToList);
    } catch (error) {
        console.error("Error fetching data:", error);
    }
})();

function addEntryToList(entry) {
    const list = document.getElementById("data-list");
    const listItem = document.createElement("li");
    listItem.textContent = `Name: ${entry.first_name} ${entry.last_name}, Email: ${entry.e_mail}, Phone: ${entry.phone_number}, Birth Date: ${entry.birth_date}`;
    list.insertBefore(listItem, list.firstChild);
}
