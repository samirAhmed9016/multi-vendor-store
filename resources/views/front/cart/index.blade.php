<x-front-layout title="Shopping Cart">
    <x-slot name="breadcrumbs">
        <!-- Start Breadcrumbs Area -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Shopping Cart</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>Shopping Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs Area -->
    </x-slot>

    <!-- Start Shopping Cart Area -->
    <section class="shopping-cart section">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    @if ($carts)
                        <!-- Start Shopping Cart Table -->
                        <div class="shopping-cart-table">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $item)
                                            <tr>
                                                <td>
                                                    <div class="product-image">
                                                        <a href="{{ route('product.show', $item->product->slug) }}">
                                                            <img src="https://static.thenounproject.com/png/default-image-icon-4974686-512.png"
                                                                alt="{{ $item->product->name }}"
                                                                style="width: 80px; height: 80px; object-fit: cover;">
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="product-info">
                                                        <h4>
                                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                                {{ $item->product->name }}
                                                            </a>
                                                        </h4>
                                                        @if ($item->product->category)
                                                            <p class="category">{{ $item->product->category->name }}</p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="price">
                                                        <span
                                                            class="current-price">${{ number_format($item->product->price, 2) }}</span>
                                                        @if ($item->product->compare_price)
                                                            <span
                                                                class="old-price">${{ number_format($item->product->compare_price, 2) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="quantity">
                                                        <div class="count-input">
                                                            <input class="form-control item-quantity"
                                                                data-id="{{ $item->id }}"
                                                                value="{{ $item->quantity }}">
                                                        </div>
                                                        {{-- <div class="input-group">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary quantity-btn"
                                                                data-action="decrease"
                                                                data-item-id="{{ $item->id }}">-</button>
                                                            <input type="number"
                                                                class="form-control text-center quantity-input"
                                                                value="{{ $item->quantity }}" min="1"
                                                                data-item-id="{{ $item->id }}"
                                                                style="width: 60px;">
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary quantity-btn"
                                                                data-action="increase"
                                                                data-item-id="{{ $item->id }}">+</button>
                                                        </div> --}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="total-price">
                                                        <span>${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="action">
                                                        <button type="button" class="btn btn-sm btn-danger remove-item"
                                                            data-item-id="{{ $item->id }}" title="Remove Item">
                                                            <i class="lni lni-close"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Shopping Cart Table -->

                        <!-- Start Cart Bottom -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="coupon-form">
                                    <h4>Apply Coupon</h4>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Enter your coupon code">
                                        <button class="btn btn-primary" type="button">Apply Coupon</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="cart-summary">
                                    <div class="summary-item">
                                        <span>Subtotal:</span>
                                        <span>$200</span>
                                    </div>
                                    <div class="summary-item">
                                        <span>Shipping:</span>
                                        <span>{{ Currency::format(10.0) }}</span>
                                    </div>
                                    <div class="summary-item">
                                        <span>Tax:</span>
                                        <span>$12.00</span>
                                    </div>
                                    <div class="summary-item total">
                                        <span>Total:</span>
                                        <span>$172.00</span>
                                    </div>
                                    <div class="button">
                                        <a href="#" class="btn btn-primary">Proceed to
                                            Checkout</a>
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Continue
                                            Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Cart Bottom -->
                    @else
                        <!-- Empty Cart -->
                        <div class="empty-cart text-center">
                            <div class="empty-cart-icon">
                                <i class="lni lni-cart" style="font-size: 80px; color: #ccc;"></i>
                            </div>
                            <h3>Your cart is empty</h3>
                            <p>Looks like you haven't added any items to your cart yet.</p>
                            <div class="button">
                                <a href="{{ route('home') }}" class="btn btn-primary">Start Shopping</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End Shopping Cart Area -->

    @push('styles')
        <style>
            .shopping-cart {
                padding: 80px 0;
            }

            .shopping-cart-table {
                margin-bottom: 40px;
            }

            .product-image img {
                border-radius: 8px;
            }

            .product-info h4 {
                margin-bottom: 5px;
            }

            .product-info h4 a {
                color: #333;
                text-decoration: none;
            }

            .product-info h4 a:hover {
                color: #0167F3;
            }

            .category {
                color: #666;
                font-size: 14px;
                margin: 0;
            }

            .current-price {
                font-weight: bold;
                color: #0167F3;
            }

            .old-price {
                text-decoration: line-through;
                color: #999;
                margin-left: 10px;
            }

            .quantity .input-group {
                width: auto;
            }

            .quantity-input {
                border-left: none;
                border-right: none;
            }

            .total-price {
                font-weight: bold;
                color: #0167F3;
            }

            .remove-item {
                border: none;
                background: none;
                color: #dc3545;
            }

            .remove-item:hover {
                color: #c82333;
            }

            .coupon-form {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 20px;
            }

            .cart-summary {
                background: #f8f9fa;
                padding: 20px;
                border-radius: 8px;
            }

            .summary-item {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid #dee2e6;
            }

            .summary-item.total {
                font-weight: bold;
                font-size: 18px;
                border-bottom: none;
                margin-bottom: 20px;
            }

            .empty-cart {
                padding: 60px 0;
            }

            .empty-cart-icon {
                margin-bottom: 20px;
            }

            .empty-cart h3 {
                margin-bottom: 10px;
                color: #333;
            }

            .empty-cart p {
                color: #666;
                margin-bottom: 30px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Quantity buttons
                $('.quantity-btn').on('click', function() {
                    const action = $(this).data('action');
                    const itemId = $(this).data('item-id');
                    const input = $(`.quantity-input[data-item-id="${itemId}"]`);
                    let quantity = parseInt(input.val());

                    if (action === 'increase') {
                        quantity++;
                    } else if (action === 'decrease' && quantity > 1) {
                        quantity--;
                    }

                    updateQuantity(itemId, quantity);
                });

                // Quantity input change
                $('.quantity-input').on('change', function() {
                    const itemId = $(this).data('item-id');
                    const quantity = parseInt($(this).val());

                    if (quantity > 0) {
                        updateQuantity(itemId, quantity);
                    }
                });

                // Remove item
                $('.remove-item').on('click', function() {
                    const itemId = $(this).data('item-id');

                    if (confirm('Are you sure you want to remove this item?')) {
                        removeItem(itemId);
                    }
                });

                function updateQuantity(itemId, quantity) {
                    $.ajax({
                        url: `/cart/update/${itemId}`,
                        method: 'POST',
                        data: {
                            quantity: quantity,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error updating quantity');
                        }
                    });
                }

                function removeItem(itemId) {
                    $.ajax({
                        url: `/cart/remove/${itemId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error removing item');
                        }
                    });
                }
            });
        </script>
        <script>
            const csrf_token = {{ csrf_token() }};
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="{{ asset('build/assets/cart-YsYdbUKw.js') }}"></script>
    @endpush
    @vite('resources/js/cart.js')
</x-front-layout>
