document.addEventListener("DOMContentLoaded", () => {
    let page = 1;
    let loading = false;
    const loadingElement = document.getElementById('loading');

    const loadSales = () => {
        if (loading) return;
        loading = true;
        loadingElement.style.display = 'block';

        fetch(`load_sales.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const salesBody = document.getElementById('sales-body');
                    data.forEach(sale => {
                        const row = `<tr>
                            <td>${sale.firma_adi}</td>
                            <td>${sale.urun_adi}</td>
                            <td>${sale.urun_turu}</td>
                            <td>${sale.urun_rengi}</td>
                            <td>${sale.adet}</td>
                            <td>${sale.satilma_tarihi}</td>
                            <td>${sale.musteri_adi}</td>
                            <td>${sale.musteri_adres}</td>
                            <td>${sale.musteri_telefon}</td>
                        </tr>`;
                        salesBody.insertAdjacentHTML('beforeend', row);
                    });
                    page++;
                } else {
                    loadingElement.style.display = 'none';
                }
                loading = false;
            })
            .catch(error => {
                console.error('Error loading sales:', error);
                loading = false;
            });
    };

    loadSales();

    window.addEventListener('scroll', () => {
        if (window.innerHeight + window.scrollY >= document.documentElement.scrollHeight) {
            loadSales();
        }
    });
});
