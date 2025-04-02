function searchFood() {
    let input = document.getElementById("search-bar").value.toLowerCase();
    let rows = document.querySelectorAll("table tbody tr");  // Get all table rows in the tbody

    rows.forEach(function(row) {
        let foodName = row.getElementsByTagName("td")[1].innerText.toLowerCase(); // Get the name from the second column (index 1)

        if (foodName.includes(input)) {
            row.style.display = "table-row";  // Show the row if it matches the search
        } else {
            row.style.display = "none";  // Hide the row if it doesn't match
        }
    });
}
