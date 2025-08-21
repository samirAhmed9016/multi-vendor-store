<x-front-layout title="Checkout">

    <x-slot name="breadcrumbs">
        <!-- Start Breadcrumbs Area -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Checkout</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li>Shopping Cart</li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs Area -->
    </x-slot>

    <!-- Custom Styles for Better Form Design -->
    <style>
        .checkout-form-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-row .form-group {
            flex: 1;
            margin-bottom: 0;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f0f0;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 60px;
            height: 2px;
            background: #007bff;
        }

        .btn-primary {
            background: #007bff;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
            color: white;
            transform: translateY(-2px);
        }

        .shipping-option {
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .shipping-option:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .shipping-option.selected {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .checkout-sidebar {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 25px;
            position: sticky;
            top: 20px;
        }

        .payment-row {
            display: flex;
            gap: 15px;
        }

        .payment-row .form-group {
            flex: 1;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-row .form-group {
                margin-bottom: 25px;
            }

            .payment-row {
                flex-direction: column;
                gap: 0;
            }

            .checkout-form-section {
                padding: 20px;
            }
        }
    </style>

    <section class="checkout-wrapper section">
        <form action="{{ route('checkout') }}" method="post">
            @csrf

            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Personal Details Section -->
                        <div class="checkout-form-section">
                            <h3 class="section-title">Personal Details</h3>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name">First Name *</label>
                                    <x-form.input type="text" id="first_name" name="addr[billing][first_name]"
                                        class="form-control" placeholder="Enter your first name" />
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name *</label>
                                    <x-form.input type="text" id="last_name" name="addr[billing][last_name]"
                                        class="form-control" placeholder="Enter your last name" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <x-form.input name="addr[billing][email]" type="email" id="email"
                                        class="form-control" placeholder="Enter your email address" />
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <x-form.input name="addr[billing][phone_number]" type="tel" id="phone"
                                        class="form-control" placeholder="Enter your phone number" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Street Address *</label>
                                <x-form.input name="addr[billing][street_address]" type="text" id="address"
                                    class="form-control" placeholder="Enter your street address" />
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">City *</label>
                                    <x-form.input name="addr[billing][city]" type="text" id="city"
                                        class="form-control" placeholder="Enter your city" />
                                </div>
                                <div class="form-group">
                                    <label for="postal_code">Postal Code *</label>
                                    <x-form.input name="addr[billing][postal_code]" type="text" id="postal_code"
                                        class="form-control" placeholder="Enter postal code" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state">State/Region *</label>
                                <x-form.input name="addr[billing][state]" type="text" id="state"
                                    class="form-control" placeholder="Enter postal code" />
                                {{-- <select id="state" name="state" class="form-control" required>
                                        <option value="">Select State/Region</option>
                                        <option value="CA">California</option>
                                        <option value="NY">New York</option>
                                        <option value="TX">Texas</option>
                                        <option value="FL">Florida</option>
                                    </select> --}}
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="country">Country *</label>
                                    <x-form.select name="addr[billing][country]" id="country" :options="$countries"
                                        class="form-control" placeholder="Select Country" />
                                    {{-- <select id="country" name="country" class="form-control" required>
                                        <option value="">Select Country</option>
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                        <option value="DE">Germany</option>
                                    </select> --}}
                                </div>

                            </div>
                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="same_address" name="same_address">
                                <label for="same_address">Shipping address is the same as billing address</label>
                            </div>


                            <div style="margin-top: 30px;">
                                <button type="submit" class="btn-primary"
                                    style="width: 100%; padding: 15px; font-size: 16px;">
                                    Next Step
                                </button>
                            </div>

                        </div>

                        <!-- Billing Address Section -->
                        <div class="checkout-form-section">
                            <h3 class="section-title">Billing Address</h3>












                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first_name">First Name *</label>
                                    <x-form.input type="text" id="first_name" name="addr[shipping][first_name]"
                                        class="form-control" placeholder="Enter your first name" />
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name *</label>
                                    <x-form.input type="text" id="last_name" name="addr[shipping][last_name]"
                                        class="form-control" placeholder="Enter your last name" />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <x-form.input name="addr[shipping][email]" type="email" id="email"
                                        class="form-control" placeholder="Enter your email address" />
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone Number *</label>
                                    <x-form.input name="addr[shipping][phone_number]" type="tel" id="phone"
                                        class="form-control" placeholder="Enter your phone number" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Street Address *</label>
                                <x-form.input name="addr[shipping][street_address]" type="text" id="address"
                                    class="form-control" placeholder="Enter your street address" />
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">City *</label>
                                    <x-form.input name="addr[shipping][city]" type="text" id="city"
                                        class="form-control" placeholder="Enter your city" />
                                </div>
                                <div class="form-group">
                                    <label for="postal_code">Postal Code *</label>
                                    <x-form.input name="addr[shipping][postal_code]" type="text" id="postal_code"
                                        class="form-control" placeholder="Enter postal code" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state">State/Region *</label>
                                <x-form.input name="addr[shipping][state]" type="text" id="state"
                                    class="form-control" placeholder="Enter postal code" />
                                {{-- <select id="state" name="state" class="form-control" required>
                                        <option value="">Select State/Region</option>
                                        <option value="CA">California</option>
                                        <option value="NY">New York</option>
                                        <option value="TX">Texas</option>
                                        <option value="FL">Florida</option>
                                    </select> --}}
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="country">Country *</label>
                                    <x-form.select name="addr[shipping][country]" id="country" :options="$countries"
                                        class="form-control" placeholder="Select Country" />
                                    {{-- <select id="country" name="country" class="form-control" required>
                                        <option value="">Select Country</option>
                                        <option value="US">United States</option>
                                        <option value="CA">Canada</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="AU">Australia</option>
                                        <option value="DE">Germany</option>
                                    </select> --}}
                                </div>

                            </div>






























                            <div class="checkbox-wrapper">
                                <input type="checkbox" id="same_address" name="same_address">
                                <label for="same_address">Shipping address is the same as billing address</label>
                            </div>
                        </div>

                        <!-- Shipping Options Section -->
                        {{-- <div class="checkout-form-section">
                            <h3 class="section-title">Shipping Options</h3>

                            <div class="shipping-option" onclick="selectShipping(this, 'standard')">
                                <input type="radio" name="shipping" value="standard" id="shipping_standard"
                                    checked style="display: none;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h5 style="margin: 0; font-weight: 600;">Standard Shipping</h5>
                                        <p style="margin: 5px 0 0 0; color: #666;">5-7 business days</p>
                                    </div>
                                    <span style="font-weight: 700; color: #007bff;">$10.50</span>
                                </div>
                            </div>

                            <div class="shipping-option" onclick="selectShipping(this, 'express')">
                                <input type="radio" name="shipping" value="express" id="shipping_express"
                                    style="display: none;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h5 style="margin: 0; font-weight: 600;">Express Shipping</h5>
                                        <p style="margin: 5px 0 0 0; color: #666;">2-3 business days</p>
                                    </div>
                                    <span style="font-weight: 700; color: #007bff;">$25.00</span>
                                </div>
                            </div>

                            <div class="shipping-option" onclick="selectShipping(this, 'overnight')">
                                <input type="radio" name="shipping" value="overnight" id="shipping_overnight"
                                    style="display: none;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <h5 style="margin: 0; font-weight: 600;">Overnight Shipping</h5>
                                        <p style="margin: 5px 0 0 0; color: #666;">Next business day</p>
                                    </div>
                                    <span style="font-weight: 700; color: #007bff;">$45.00</span>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <!-- Payment Information Section -->
                        <div class="checkout-form-section">
                            <h3 class="section-title">Payment Information</h3>

                            <div class="form-group">
                                <label for="card_name">Cardholder Name *</label>
                                <input type="text" id="card_name" name="card_name" class="form-control"
                                    placeholder="Name as it appears on card" required>
                            </div>

                            <div class="form-group">
                                <label for="card_number">Card Number *</label>
                                <input type="text" id="card_number" name="card_number" class="form-control"
                                    placeholder="1234 5678 9012 3456" required>
                            </div>

                            <div class="payment-row">
                                <div class="form-group">
                                    <label for="expiry_month">Expiry Month *</label>
                                    <select id="expiry_month" name="expiry_month" class="form-control" required>
                                        <option value="">Month</option>
                                        <option value="01">01 - January</option>
                                        <option value="02">02 - February</option>
                                        <option value="03">03 - March</option>
                                        <option value="04">04 - April</option>
                                        <option value="05">05 - May</option>
                                        <option value="06">06 - June</option>
                                        <option value="07">07 - July</option>
                                        <option value="08">08 - August</option>
                                        <option value="09">09 - September</option>
                                        <option value="10">10 - October</option>
                                        <option value="11">11 - November</option>
                                        <option value="12">12 - December</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="expiry_year">Expiry Year *</label>
                                    <select id="expiry_year" name="expiry_year" class="form-control" required>
                                        <option value="">Year</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cvv">CVV *</label>
                                    <input type="text" id="cvv" name="cvv" class="form-control"
                                        placeholder="123" maxlength="4" required>
                                </div>
                            </div> --}}

                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn-primary"
                                style="width: 100%; padding: 15px; font-size: 16px;">
                                Complete Order
                            </button>
                        </div>
                    </div>
                </div>
        </form>

        <!-- Order Summary Sidebar -->
        <div class="col-lg-4">
            <div class="checkout-sidebar">
                <!-- Coupon Section -->
                <div style="margin-bottom: 30px;">
                    <h5 style="margin-bottom: 15px; color: #333;">Discount Code</h5>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" class="form-control" placeholder="Enter coupon code" style="flex: 1;">
                        <button class="btn-secondary" style="padding: 12px 20px;">Apply</button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div>
                    <h5 style="margin-bottom: 20px; color: #333;">Order Summary</h5>

                    <div style="padding: 20px 0; border-top: 1px solid #eee;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span>Subtotal:</span>
                            <span style="font-weight: 600;">{{ Currency::format($cart->total()) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span>Shipping:</span>
                            <span style="font-weight: 600;">$10.50</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <span>Tax:</span>
                            <span style="font-weight: 600;">$12.36</span>
                        </div>
                        <div
                            style="display: flex; justify-content: space-between; margin-bottom: 12px; color: #28a745;">
                            <span>Discount:</span>
                            <span style="font-weight: 600;">-$10.00</span>
                        </div>
                    </div>

                    <div style="padding: 20px 0; border-top: 2px solid #007bff;">
                        <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 700;">
                            <span>Total:</span>
                            <span style="color: #007bff;">{{ Currency::format($cart->total()) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Security Badge -->
                <div
                    style="text-align: center; margin-top: 25px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <small style="color: #666;">
                        🔒 Secure SSL encryption<br>
                        Your information is protected
                    </small>
                </div>
            </div>
        </div>
        </div>
        </div>

    </section>

    <script>
        function selectShipping(element, value) {
            // Remove selected class from all shipping options
            document.querySelectorAll('.shipping-option').forEach(option => {
                option.classList.remove('selected');
            });

            // Add selected class to clicked option
            element.classList.add('selected');

            // Check the radio button
            document.getElementById('shipping_' + value).checked = true;
        }

        // Set initial selection
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.shipping-option').classList.add('selected');
        });
    </script>

</x-front-layout>
