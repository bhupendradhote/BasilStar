// institutionalOwnership.js
// const FMP_API_KEY = "T8HogSezq0WNy97WinOjjLMEOuiKjnu5";

// DOM references
const ownershipTableBody = document.getElementById("institutionalOwnershipBody");
const ownershipLoader = document.getElementById("institutionalOwnershipLoader");

// Function to fetch institutional ownership data
function fetchInstitutionalOwnership(symbol) {
    const apiUrl = `https://financialmodelingprep.com/api/v4/institutional-ownership/institutional-holders/symbol-ownership-percent?symbol=${symbol}&apikey=${FMP_API_KEY}`;

    ownershipLoader.style.display = "block";
    ownershipTableBody.innerHTML = "";

    fetch(apiUrl)
        .then(res => res.json())
        .then(data => {
            console.log("Institutional Ownership Response:", data); // 👈 Console log added for debugging

            if (!Array.isArray(data) || data.length === 0) {
                ownershipTableBody.innerHTML = `<tr><td colspan="6">No institutional ownership data found for ${symbol}.</td></tr>`;
                return;
            }

            data.forEach(entry => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${entry.date || 'N/A'}</td>
                    <td>${entry.investorName || 'N/A'}</td>
                    <td>${entry.ownership?.toFixed(2) || '0.00'}%</td>
                    <td>${entry.sharesNumber?.toLocaleString() || 'N/A'}</td>
                    <td>$${entry.marketValue ? (entry.marketValue / 1e9).toFixed(2) : '0.00'}B</td>
                    <td>${entry.changeInOwnership?.toFixed(2) || '0.00'}%</td>
                `;
                ownershipTableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error("Institutional ownership fetch error:", error);
            ownershipTableBody.innerHTML = `<tr><td colspan="6">Error fetching data.</td></tr>`;
        })
        .finally(() => {
            ownershipLoader.style.display = "none";
        });
}

// Add this to ensure institutional data is fetched when a stock is selected
$('#stockSelector').on('change', function () {
    const selectedSymbol = this.value;
    fetchBalanceSheet(selectedSymbol); // ✅ existing
    fetchInstitutionalOwnership(selectedSymbol); // ✅ fix: ADD THIS
});
