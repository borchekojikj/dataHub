@extends('layouts.dashboard-layout')

@section('title', 'Admin Dashboard')

@section('content')


@if (session('token'))
<p>Your API Token: {{ session('token') }}</p>
@else
<p>No token found.</p>
@endif

<div class="container">

    <div class="row justify-content-center py-3">
        <div class="col-7">
            <h1 class="text-center color-main">Insert Products into Database</h1>
            <form class="" action="{{ route('save-data') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="mb-3">
                    <label for="excel" class="form-label">Excel</label>
                    <input type="file" class="form-control" id="excel" name="excel">
                </div>
                <button type="submit" class="btn custom-button">Import</button>
            </form>
        </div>
        <div class="row justify-content-center">
            <div class="col-11 mt-5">


                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-start">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search...">
                    </div>
                    <div>
                        <ul class="pagination" id="pagination">
                            <!-- Pagination links will be inserted here -->
                        </ul>
                    </div>
                </div>
                <table class="table table-bordered table-hover table-striped mt-5">
                    <thead class="bg-main"> <!-- Dark header background -->
                        <tr class="text-center">
                            <th scope="col">Product Name</th>
                            <th scope="col">Store Name</th>
                            <th scope="col">Regular Price</th>
                            <th scope="col">Discounted Price</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Discount Percentage</th>
                            <th scope="col">Product Code</th>
                            <th scope="col">Category</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Dynamic rows will be inserted here -->
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

<script>
    const tableBody = document.getElementById('tableBody');
    const pagination = document.getElementById('pagination');

    // Fetch products for a specific page
    function fetchProducts(page = 1) {

        const url = `http://127.0.0.1:8000/api/products?page=${page}`;


        // let sanctumToken = '{{ session("token") }}';
        let sanctumToken = '24|1EPKwFiupUxWco6Fz3jfAyMZF4C5OEBvcnKfwmOe125885e9';
        $.ajax({
            headers: {
                'Authorization': 'Bearer ' + sanctumToken, // Replace with your actual Sanctum token
                'X-Requested-With': 'XMLHttpRequest' // Required for Laravel to recognize it as an AJAX request
            },
            url: url,
            method: 'GET',

            success: function(response) {

                console.log(response);
                displayProducts(response.products.data);
                setupPagination(response.products);

            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(xhr.responseText);
            }
        });
    }

    // Display products in the table
    function displayProducts(products) {
        tableBody.innerHTML = '';
        products.forEach(product => {
            tableBody.innerHTML += `
       
                <tr>
                    <td>${product.product_name}</td>
                    <td>${product.store ? product.store.title : 'N/A'}</td>
                    <td>${product.regular_price}</td>
                    <td>${product.discounted_price}</td>
                    <td>${product.manufacturer ? product.manufacturer.title : 'N/A'}</td>
                    <td>${product.discount_percentage}</td>
                    <td>${product.product_code}</td>
                    <td>${product.category ? product.category.title : 'N/A'}</td>
                </tr>
          
            `;
        });
    }

    // Setup pagination links
    function setupPagination(paginationData) {
        pagination.innerHTML = '';

        if (paginationData.prev_page_url) {
            pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${paginationData.current_page - 1}">&laquo; Previous</a></li>`;
        }

        // paginationData.links.forEach(link => {
        //     pagination.innerHTML += `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="#" data-page="${link.url ? new URL(link.url).searchParams.get('page') : ''}">${link.label}</a></li>`;
        // });

        if (paginationData.next_page_url) {
            pagination.innerHTML += `<li class="page-item"><a class="page-link" href="#" data-page="${paginationData.current_page + 1}">Next &raquo;</a></li>`;
        }

        // Add click event listener to pagination links
        document.querySelectorAll('.page-link').forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const page = event.target.dataset.page;
                if (page) {
                    fetchProducts(page);
                }
            });
        });
    }

    // Initial fetch
    fetchProducts();
</script>


<script>
    document.getElementById('searchInput').addEventListener('keyup', function(event) {

        const searchTerm = event.target.value.toLowerCase();
        console.log(searchTerm);

        const rows = document.querySelectorAll('#tableBody > tr');

        // console.log(rows)
        rows.forEach(row => {


            const rowName = row.textContent.toLowerCase();
            console.log(rowName);
            if (rowName.includes(searchTerm)) {

                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

@endsection