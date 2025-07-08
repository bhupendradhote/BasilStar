// const FMP_API_KEY = "T8HogSezq0WNy97WinOjjLMEOuiKjnu5";

function fetchCompanyProfile(symbol) {
    const profileApiUrl = `https://financialmodelingprep.com/api/v3/profile/${symbol}?apikey=${FMP_API_KEY}`;

    $.ajax({
        url: profileApiUrl,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (!response || response.length === 0) {
                console.warn("No company profile data available.");
                showMessageBox(`No company profile data found for ${symbol}.`);
                return;
            }

            const profileData = response[0]; // FMP returns an array
            renderCompanyProfile(profileData, profileData.image);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error (Company Profile):", textStatus, errorThrown);
            showMessageBox(`Failed to fetch company profile data for ${symbol}.`);
        }
    });
}


function renderCompanyProfile(profile, logoUrl) {
    const profileContainer = document.getElementById('companyProfileContainer');
    profileContainer.innerHTML = '';

    const profileHTML = `
        <div class="profile-header">
            <div class="profile-logo">
                <img src="${logoUrl}" alt="${profile.companyName} Logo" class="company-logo">
                <h2>${profile.companyName} <br> (${profile.symbol})</h2>
            </div>
            <p>${profile.description}</p>
        </div>
        <div class="profile-details">
            <div class="profile-row"><span class="profile-label">CEO:</span> ${profile.ceo}</div>
            <div class="profile-row"><span class="profile-label">Sector:</span> ${profile.sector}</div>
            <div class="profile-row"><span class="profile-label">Industry:</span> ${profile.industry}</div>
            <div class="profile-row"><span class="profile-label">Employees:</span> ${parseInt(profile.fullTimeEmployees).toLocaleString()}</div>
            <div class="profile-row"><span class="profile-label">Exchange:</span> ${profile.exchange}</div>
            <div class="profile-row"><span class="profile-label">Website:</span> <a href="${profile.website}" target="_blank">${profile.website}</a></div>
            <div class="profile-row"><span class="profile-label">Address:</span> ${profile.address}, ${profile.city}, ${profile.state} ${profile.zip}, ${profile.country}</div>
            <div class="profile-row"><span class="profile-label">Phone:</span> ${profile.phone}</div>

        </div>
    `;

    profileContainer.innerHTML = profileHTML;
}


// Call this function when a stock is selected
$('#stockSelector').on('change', function () {
    const selectedSymbol = this.value;
    fetchCompanyProfile(selectedSymbol);
});