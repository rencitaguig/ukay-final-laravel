<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Pagination</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        .product-card img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div id="product-list" class="row"></div>
        <div id="pagination-controls" class="d-flex justify-content-center"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="{{ asset('js/components/Paginate.js') }}"></script>
    <script type="module">
        import Pagination from './js/components/Paginate.js';

        function fetchProducts(page = 1) {
            $.ajax({
                url: `/api/products?page=${page}`,
                method: 'GET',
                success: function(response) {
                    renderProducts(response.data);
                    const pagination = new Pagination(response.links, response.meta.current_page);
                    pagination.render('#pagination-controls').onClick((page) => {
                        fetchProducts(page);
                    });
                },
                error: function(error) {
                    console.error('Error fetching products:', error);
                }
            });
        }

        function renderProducts(products) {
            const productList = $('#product-list');
            productList.empty();
            products.forEach(product => {
                productList.append(`
                    <div class="col-md-4 product-card">
                        <div class="card">
                            <img src="${product.image.split(',')[0]}" class="card-img-top" alt="${product.name}">
                            <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">${product.description}</p>
                                <p class="card-text">Price: $${product.price}</p>
                                <p class="card-text">Stock: ${product.stock}</p>
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        $(document).ready(function() {
            fetchProducts();
        });
    </script>
</body>
</html>
