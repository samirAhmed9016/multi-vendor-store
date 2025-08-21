<x-front-layout title="2FA Challenge">
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

    <style>
        :root {
            --primary: #6366f1;
            /* indigo-500 */
            --primary-600: #4f46e5;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-900: #0f172a;
        }

        .account-login.section {
            padding: 64px 0;
            background: var(--slate-50);
        }

        .login-form.card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(2, 6, 23, 0.08);
            overflow: hidden;
            background: #fff;
        }

        .login-form .card-body {
            padding: 40px;
        }

        .login-form .title h3 {
            margin: 0 0 8px;
            font-weight: 800;
            color: var(--slate-900);
        }

        .login-form .title p {
            margin: 0 0 8px;
            color: var(--slate-500);
        }

        .social-login .btn {
            width: 100%;
            border-radius: 10px;
            padding: 12px 14px;
            font-weight: 700;
            border: none;
        }

        .facebook-btn {
            background: #1877f2;
            color: #fff;
        }

        .twitter-btn {
            background: #1da1f2;
            color: #fff;
        }

        .google-btn {
            background: #ea4335;
            color: #fff;
        }

        .alt-option {
            position: relative;
            text-align: center;
            margin: 24px 0 8px;
            color: var(--slate-400);
            font-weight: 600;
        }

        .alt-option span {
            background: #fff;
            padding: 0 12px;
            position: relative;
            z-index: 1;
        }

        .alt-option::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--slate-100);
            transform: translateY(-50%);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--slate-700);
        }

        .form-control {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            background: #fff;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
        }

        .password-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 38px;
            appearance: none;
            background: transparent;
            border: 0;
            color: var(--slate-500);
            cursor: pointer;
            padding: 4px;
            line-height: 1;
        }

        .toggle-password:hover {
            color: var(--slate-700);
        }

        .bottom-content .form-check-label {
            color: var(--slate-600);
        }

        .lost-pass {
            color: var(--primary);
            font-weight: 600;
        }

        .lost-pass:hover {
            color: var(--primary-600);
        }

        .button .btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-600));
            color: #fff;
            padding: 12px 16px;
            border-radius: 12px;
            font-weight: 800;
            letter-spacing: 0.3px;
            border: none;
            transition: transform 0.06s ease, filter 0.2s ease;
        }

        .button .btn:hover {
            filter: brightness(1.03);
        }

        .button .btn:active {
            transform: translateY(1px);
        }

        /* Responsive padding tweak */
        @media (max-width: 576px) {
            .login-form .card-body {
                padding: 24px;
            }
        }
    </style>

    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form action="{{ route('two-factor.login') }}" class="card login-form" method="post">
                        @csrf
                        <div class="card-body">
                            @if ($errors->has('code'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('code') }}

                                </div>
                            @endif
                            <div class="title">
                                <h3>2FA Challenge</h3>
                                <p>You must enter 2FA code.</p>
                            </div>

                            <div class="form-group input-group">
                                <label for="reg-fn">2FA Code</label>
                                <input class="form-control" type="text" name="code"
                                    placeholder="Enter your 2FA code" id="reg-email" required>
                            </div>



                        </div>
                        <div class="button">
                            <button class="btn" type="submit">Submit</button>
                        </div>

                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- End Account Login Area -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password').forEach(function(button) {
                button.addEventListener('click', function() {
                    var targetSelector = button.getAttribute('data-target');
                    var input = document.querySelector(targetSelector);
                    if (!input) return;
                    var isPassword = input.getAttribute('type') === 'password';
                    input.setAttribute('type', isPassword ? 'text' : 'password');
                    button.innerHTML = isPassword ? '<i class="lni lni-eye-off"></i>' :
                        '<i class="lni lni-eye"></i>';
                });
            });
        });
    </script>

</x-front-layout>
