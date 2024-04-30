document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("searchForm");
    const resultsDiv = document.getElementById("results");

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        
        const price = document.getElementById("price").value;

        fetchProducts(price);
    });

    function fetchProducts(price) {
        fetch("search.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `price=${price}`
        })
        .then(response => response.json())
        .then(data => {
            let html = "<h2>Results</h2><ul>";
            
            data.forEach(product => {
                html += `<li>${product.name} - $${product.price}</li>`;
            });
            
            html += "</ul>";
            resultsDiv.innerHTML = html;
        })
        .catch(error => {
            console.error("Error fetching products:", error);
        });
    }
});
