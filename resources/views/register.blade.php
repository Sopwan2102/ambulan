<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="{{asset('images/favicon.ico')}}">

	<title>Registrasi - Diver </title>

	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{asset('admin/css/vendors_css.css')}}">

	<!-- Style-->
	<link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('admin/css/skin_color.css')}}">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="hold-transition theme-primary bg-img" style="background-image: url(../images/auth-bg/bg-2.jpg)">

	<div class="container h-p100">
		<div class="row align-items-center justify-content-md-center h-p100">

			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-5 col-md-5 col-12">
						<div class="bg-white rounded10 shadow-lg">
							<div class="content-top-agile p-20 pb-0">
								<h2 class="text-primary">Daftar Sebagai Driver Kami</h2>
								<p class="mb-0">Register Akun Baru</p>
							</div>
							<div class="p-40">
								<form class="m-login__form m-form" action="{{route('auth.postRegister')}}" method="POST">
                        			@csrf
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="text" class="form-control ps-15 bg-transparent" name="name" placeholder="Nama Lengkap">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-user"></i></span>
											<input type="text" class="form-control ps-15 bg-transparent" name="username" placeholder="Username">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-mobile"></i></span>
											<input type="number" class="form-control ps-15 bg-transparent" name="no_hp" placeholder="Nomor Whatsapp">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text bg-transparent"><i class="ti-lock"></i></span>
											<input type="password" class="form-control ps-15 bg-transparent" name="password" id="password" placeholder="Password">
											<span class="input-group-text bg-transparent" id="togglePassword"><i class="fas fa-eye"></i></span>
										</div>
									</div>
									<div class="row">
										<div class="col-12 text-center">
											<button type="submit" class="btn btn-info margin-top-10">Buat Akun</button>
										</div>
									</div>
								</form>
								<div class="text-center">
									<p class="mt-15 mb-0">Sudah punya akun?<a href="{{route('auth.login')}}" class="text-danger ms-5"> Login</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const passwordField = document.getElementById('password');
			const togglePassword = document.getElementById('togglePassword');

			togglePassword.addEventListener('click', function() {
				// Toggle the type attribute using getAttribute() and setAttribute()
				const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
				passwordField.setAttribute('type', type);

				// Toggle the icon using classList
				this.querySelector('i').classList.toggle('fa-eye');
				this.querySelector('i').classList.toggle('fa-eye-slash');
			});
		});
	</script>
	
</body>
</html>