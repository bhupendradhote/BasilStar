

// -------------------------------------------------------------------------------------
const FMP_API_KEY_ = "T8HogSezq0WNy97WinOjjLMEOuiKjnu5";

const tickerSymbols = [
    'RELIANCE.NS', 'HINDUNILVR.NS', 'HDFCBANK.NS', 'BHARTIARTL.NS', 'MARUTI.NS', 'SBIN.NS',
    'WIPRO.NS', 'ICICIBANK.NS', 'AXISBANK.NS', 'KOTAKBANK.NS',
    'ITC.NS', 'LT.NS', 'SUNPHARMA.NS', 'ASIANPAINT.NS', 'BAJFINANCE.NS', 'NESTLEIND.NS',
    'ULTRACEMCO.NS', 'POWERGRID.NS', 'NTPC.NS', 'TITAN.NS', 'TECHM.NS', 'GRASIM.NS',
    'ADANIENT.NS', 'ADANIGREEN.NS', 'ADANIPORTS.NS', 'ONGC.NS', 'COALINDIA.NS', 'JSWSTEEL.NS',
    'HCLTECH.NS', 'BPCL.NS', 'IOC.NS', 'EICHERMOT.NS', 'HEROMOTOCO.NS', 'TATAMOTORS.NS'
];

const stockTickerContent = document.getElementById('stock-ticker-content');

async function fetchAndRenderStockTicker() {
    if (FMP_API_KEY_ === "") {
        stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">API Key is empty. Cannot fetch stock data.</div>';
        return;
    }

    const symbolsString = tickerSymbols.join(',');
    const quoteApiUrl = `https://financialmodelingprep.com/api/v3/quote/${symbolsString}?apikey=${FMP_API_KEY_}`;

    try {
        stockTickerContent.innerHTML = '<div class="scroll-item text-gray-600">Fetching stock data...</div>';
        const response = await fetch(quoteApiUrl);

        if (!response.ok) {
            const errorText = await response.text();
            console.error(`HTTP error fetching stock data! Status: ${response.status}, Body: ${errorText}`);
            stockTickerContent.innerHTML = `<div class="scroll-item text-red-600">Error fetching data: ${response.status}. Check console.</div>`;
            return;
        }

        const data = await response.json();
        stockTickerContent.innerHTML = '';

        const itemsToDuplicate = [];
        let foundValidData = false;

        tickerSymbols.forEach(symbol => {
            const stockData = data.find(d => d.symbol === symbol);

            if (stockData && stockData.price !== undefined) {
                foundValidData = true;

                const price = parseFloat(stockData.price).toFixed(2);
                const change = parseFloat(stockData.change).toFixed(2);
                const changePercentage = parseFloat(stockData.changesPercentage).toFixed(2);

                let colorClass = 'text-gray-700';
                if (Math.sign(change) > 0) colorClass = 'text-green-600';
                else if (Math.sign(change) < 0) colorClass = 'text-red-600';

                const scrollItem = document.createElement('div');
                scrollItem.classList.add('scroll-item', 'text-sm');
                scrollItem.innerHTML = `
                    <span class="font-semibold">${symbol.replace('.NS', '')}:</span>
                    <span class="text-white-400">${price}</span>
                    <span class="${colorClass}">${change > 0 ? '+' : ''}${change} (${changePercentage}%)</span>
                `;
                itemsToDuplicate.push(scrollItem);
            } else {
                const scrollItem = document.createElement('div');
                scrollItem.classList.add('scroll-item', 'text-sm', 'text-yellow-600');
                scrollItem.textContent = `${symbol.replace('.NS', '')}: N/A`;
                itemsToDuplicate.push(scrollItem);
            }
        });

        if (!foundValidData) {
            stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">No valid stock data received.</div>';
            return;
        }

        itemsToDuplicate.forEach(item => stockTickerContent.appendChild(item.cloneNode(true)));
        itemsToDuplicate.forEach(item => stockTickerContent.appendChild(item.cloneNode(true)));

        if (stockTickerContent.children.length > 0) {
            stockTickerContent.style.animation = 'scroll 30s linear infinite';
        } else {
            stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">No stock data to display.</div>';
        }

    } catch (error) {
        console.error("Fetch Error fetching stock data:", error);
        stockTickerContent.innerHTML = '<div class="scroll-item text-red-600">Failed to fetch stock data. Check console for details.</div>';
    }
}


document.addEventListener('DOMContentLoaded', () => {
    fetchAndRenderStockTicker();
});
