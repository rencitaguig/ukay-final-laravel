<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .spinner {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    </form>
    <div class="container">
        <h1 class="my-4">Product List</h1>
        <div id="product-list" class="row">
            @include('products.partials.products', ['products' => $products])
        </div>


        
        <div id="spinner" class="spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            let page = 1;
            let loading = false;

            function loadMoreProducts() {
                if (loading) return;
                loading = true;
                $('#spinner').show();

                $.ajax({
                    url: `?page=${page + 1}`,
                    type: 'get',
                    success: function (data) {
                        $('#spinner').hide();
                        if (data.html.trim() === '') {
                            $(window).off('scroll');
                            $('#spinner').html("No more products to load.");
                            return;
                        }
                        $('#product-list').append(data.html);
                        page++;
                        loading = false;
                    },
                    error: function () {
                        $('#spinner').hide();
                        alert('Failed to load more products.');
                        loading = false;
                    }
                });
            }

            $(window).scroll(function () {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    loadMoreProducts();
                }
            });
        });
    </script>
</body>
</html>
