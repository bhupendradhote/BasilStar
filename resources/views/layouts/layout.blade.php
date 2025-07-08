<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO -->
    <meta name="keywords" content="mobile banking, business consulting, bank loans, credit cards, finance, insurance, broker business, forex trading">
    <meta name="description" content="Basil-star – is a clean, modern and responsive design for finance, insurance, and banking websites.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basil-star</title>

    <!-- OG Tags -->
    <meta property="og:site_name" content="Basil-star">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Basil-star">
    <meta property="og:image" content="{{ asset('images/assets/ogg.png') }}">

    <!-- Tab & Mobile Colors -->
    <meta name="theme-color" content="#913BFF">
    <meta name="msapplication-navbutton-color" content="#913BFF">
    <meta name="apple-mobile-web-app-status-bar-style" content="#913BFF">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/BasilFav.png') }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/satoshi.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('../assets/css/admindash.css') }}">

</head>

<body>

    @include('components.header')

    <div class="layout-wrapper">
        <main class="main-content">
            @yield('content')
        </main>
        
        			<!-- Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
			<div class="modal-dialog modal-fullscreen modal-dialog-centered">
				<div class="container">
					<div class="user-data-form modal-content">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						<div class="form-wrapper m-auto">
							<ul class="nav nav-tabs border-0 w-100" role="tablist">
								<li class="nav-item" role="presentation">
									<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#fc1"
										role="tab" aria-selected="true">Login</button>
								</li>
								<li class="nav-item" role="presentation">
									<button class="nav-link" data-bs-toggle="tab" data-bs-target="#fc2" role="tab"
										aria-selected="false" tabindex="-1">Signup</button>
								</li>
							</ul>
							<div class="tab-content mt-30">
								<div class="tab-pane show active" role="tabpanel" id="fc1">
									<div class="text-center mb-20">
										<h2>Hi, Welcome Back!</h2>
										<p>Still don't have an account? <a href="#">Sign up</a></p>
									</div>
									<form id="loginForm">
										@csrf
										<div class="row">
											<div class="col-12">
												<div class="input-wrapper position-relative mb-25">
													<label>Email*</label>
													<input type="email" id="email" name="email" placeholder="Youremail@gmail.com" required>
												</div>
											</div>
											<div class="col-12">
												<div class="input-wrapper position-relative mb-20">
													<label>Password*</label>
													<input type="password" id="password" name="password" placeholder="Enter Password" class="pass-log-id" required>
													<span class="placeholder-icon">
														<span class="passVicon">
															<img src="assets/img/icon/icon-44.svg" alt="icon">
														</span>
													</span>
												</div>
											</div>
											<div class="col-12">
												<div
													class="agreement-checkbox d-flex justify-content-between align-items-center">
													<div>
														<input type="checkbox" id="remember">
														<label for="remember">Keep me logged in</label>
													</div>
													<a href="#">Forget Password?</a>
												</div> <!-- /.agreement-checkbox -->
											</div>
											<div class="col-12">
												<button class="ht-btn w-100 d-block mt-20" type="submit">Login</button>
											</div>
										</div>
									</form>

									<script>
										document.getElementById('loginForm').addEventListener('submit', async function (event) {
											event.preventDefault();
									
											const email = document.getElementById('email').value;
											const password = document.getElementById('password').value;
									
											try {
												const response = await fetch('{{ route('login.user') }}', {
													method: 'POST',
													headers: {
														'Content-Type': 'application/json',
														'X-CSRF-TOKEN': '{{ csrf_token() }}',
													},
													body: JSON.stringify({ email, password }),
												});
									
												const data = await response.json();
									
												if (response.ok) {
													// Store token and user details in local storage
													localStorage.setItem('auth_token', data.token);
													localStorage.setItem('user', JSON.stringify(data.user));
													
													localStorage.setItem('showAlert', 'true');
													
													// Redirect to home page

													window.location.href = '/liveChart';
												} else {
													alert(data.message || 'Login failed');
												}
											} catch (error) {
												console.error('Error:', error);
												alert('An error occurred while logging in.');
											}
										});

										document.addEventListener('DOMContentLoaded', function () {
											if (localStorage.getItem('logoutAlert') === 'true') {
												Swal.fire({
													title: 'Logged Out',
													text: 'You have been logged out successfully.',
													icon: 'success',
													confirmButtonText: 'OK',
													confirmButtonColor: '#913BFF',
												}).then(() => {
													localStorage.removeItem('logoutAlert'); // Remove the flag after showing the alert
												});
											}
										});
									</script>
								</div>
								<!-- /.tab-pane -->
								<div class="tab-pane" role="tabpanel" id="fc2">
									<div class="text-center mb-20">
										<h2>Register</h2>
										<p>Already have an account? <a href="#">Login</a></p>
									</div>
									<form action="{{ route('register.user') }}" method="POST">
										@csrf
										<div class="row">
											<div class="col-12">
												<div class="input-wrapper position-relative mb-25">
													<label>Name*</label>
													<input type="text" name="name" placeholder="your name..." required>
												</div>
											</div>
											<div class="col-12">
												<div class="input-wrapper position-relative mb-25">
													<label>Email*</label>
													<input type="email" name="email" placeholder="your email..." required>
												</div>
											</div>
											<div class="col-12">
												<div class="input-wrapper position-relative mb-20">
													<label>Password*</label>
													<input type="password" name="password" placeholder="Enter Password" class="pass-log-id" required>
													<span class="placeholder-icon">
														<span class="passVicon">
															<img src="assets/img/icon/icon-44.svg" alt="icon">
														</span>
													</span>
												</div>
											</div>
											<div class="col-12">
												<div
													class="agreement-checkbox d-flex justify-content-between align-items-center">
													<div>
														<input type="checkbox" id="remember2">
														<label for="remember2">By hitting the "Register" button, you
															agree
															to the <a href="#">Terms conditions</a> &amp; <a
																href="#">Privacy Policy</a></label>
													</div>
												</div> <!-- /.agreement-checkbox -->
											</div>
											<div class="col-12">
												<button class="btn-four w-100 tran3s d-block mt-20" type="submit">Sign up</button>
											</div>
										</div>
									</form>
								</div>
								<!-- /.tab-pane -->
							</div>

							<div class="d-flex align-items-center mt-30 mb-10">
								<div class="line"></div>
								<span class="pe-3 ps-3 fs-6">OR</span>
								<div class="line"></div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<a href="#"
										class="social-use-btn d-flex align-items-center justify-content-center tran3s w-100 mt-10">
										<img src="assets/img/icon/google-2.svg" alt="icon">
										<span class="ps-3">Signup with Google</span>
									</a>
								</div>
								<div class="col-sm-6">
									<a href="#"
										class="social-use-btn d-flex align-items-center justify-content-center tran3s w-100 mt-10">
										<img src="assets/img/icon/fb.svg" alt="icon">
										<span class="ps-3">Signup with Facebook</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

    @include('components.footer')

    <!-- JS Scripts -->
    <script src="{{ asset('assets/js/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.meanmenu.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
