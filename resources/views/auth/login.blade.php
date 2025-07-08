<!doctype html>

<html lang="en" class="layout-wide customizer-hide" data-assets-path="admin/assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>Velova | Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="admin/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="{{ asset('admin/assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <!-- Login -->
          <div class="card p-sm-7 p-2">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
                <a href="#" class="app-brand-link gap-3">
                  <span class="app-brand-logo demo">
                    <span class="text-primary">
                        <svg width="70" height="70" viewBox="0 0 250 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Shadow -->
                            <path d="M20 25 L125 195 L230 20"
                                  fill="none"
                                  stroke="rgba(0, 0, 0, 0.1)"
                                  stroke-width="60"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>

                            <!-- Gradient definition -->
                            <defs>
                              <linearGradient id="vGradient" x1="125" y1="0" x2="125" y2="200" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7367F0" />  <!-- Ungu kebiruan Materio -->
                                <stop offset="1" stop-color="#A9A7F1" /> <!-- Ungu pastel -->
                              </linearGradient>
                            </defs>

                            <!-- Main Huruf V -->
                            <path d="M20 20 L125 190 L230 20"
                                  fill="none"
                                  stroke="url(#vGradient)"
                                  stroke-width="50"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>

                    </span>
                  </span>
                  <span class="app-brand-text demo text-heading fw-semibold">Velova</span>
                </a>
            </div>

            <!-- /Logo -->

            <div class="card-body mt-1">
              <h4 class="mb-5">Welcome to Velova! 👋🏻</h4>

              <form id="formAuthentication" class="mb-5" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-floating form-floating-outline mb-5 form-control-validation">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your email or username" required autocomplete="email" autofocus>
                    <label for="email">Email or Username</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-5">
                  <div class="form-password-toggle form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" aria-describedby="password" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <label for="password">Password</label>
                      </div>
                      <span class="input-group-text cursor-pointer"><i class="icon-base ri ri-eye-off-line icon-20px"></i></span>
                    </div>
                  </div>
                </div>
                <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label"  name="remember" id="remember"  for="remember-me" {{ old('remember') ? 'checked' : '' }}> Remember Me </label>
                  </div>
                  <a href="{{ route('password.request') }}" class="float-end mb-1">
                    <span>Forgot Password?</span>
                  </a>
                </div>
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">login</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Login -->
          <img src="{{ asset('admin/assets/img/illustrations/tree-3.png') }}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block" />
          <img src="{{ asset('admin/assets/img/illustrations/auth-basic-mask-light.png') }}" class="authentication-image d-none d-lg-block scaleX-n1-rtl"
            height="172" alt="triangle-bg" />
          <img src="{{ asset('admin/assets/img/illustrations/tree.png') }}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block" />
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->

    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async="async" defer="defer" src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
