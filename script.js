function clearSearch() {
    document.getElementById('searchForm').reset();
    let tableBody = document.querySelector('.table tbody');
    if (tableBody) {
        tableBody.innerHTML = ''; // Empty the table body
    }
}
