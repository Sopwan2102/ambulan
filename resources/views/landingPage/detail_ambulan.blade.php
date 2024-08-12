<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Website Pemesanan Ambulans</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="{{asset('user/lib/animate/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('user/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('user/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="{{asset('user/css/style.css')}}" rel="stylesheet" />
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
        <a href="index.html" class="navbar-brand d-flex align-items-center">
            <h1 class="m-0">
                <img class="img-fluid me-3" src="{{asset('user/img/logo-1.jpeg')}}" alt="" />
            </h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto bg-light rounded pe-4 py-3 py-lg-0">
                <a href="{{url('/')}}" class="nav-item nav-link">Beranda</a>
                <a href="{{url('/')}}" class="nav-item nav-link">Tutorial</a>
                <a href="{{url('/')}}" class="nav-item nav-link active">Ambulans</a>
                <a href="{{url('/')}}" class="nav-item nav-link">Hubungi Kami</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <h1 class="display-4 animated slideInDown mb-4 text-light">Detail Ambulans</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ambulans</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="position-relative overflow-hidden rounded ps-5 pt-5 h-100" style="min-height: 400px">
                        <img class="position-absolute w-100 h-100" src="{{ asset('storage/' . $data->gambar) }}" alt="" style="object-fit: cover" />
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="h-100">
                        <h1 class="display-6 mb-5">
                            Ambulans
                        </h1>
                        <span class="fs-5 mb-4">Informasi Ambulan</span>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h5 class="mb-2">Alamat :</h5>
                                <span id="lokasi-{{ $data->ambulan_id }}">{{ $data->lokasi }}</span>
                            </div>
                            <div class="form-group">
                                <h5 class="mb-2">Nomor Plat Ambulan :</h5>
                                <P>{{ $data->no_plat }}</P>
                            </div>
                            <div class="form-group">
                                <h5 class="mb-2">Biaya/Tarif :</h5>
                                <p>RP {{ $data->biaya }}</p>
                            </div>
                            <div class="form-group">
                                <h5 class="mb-2">Pemilik :</h5>
                                <p>{{ $data->milik }}</p>
                            </div>
                            <div class="form-group">
                                <h5 class="mb-2">Fasilitas :</h5>
                                <p>{!! $data->fasilitas !!}</p>
                            </div>
                        </div>
                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex align-items-center">
                                <a class="btn btn-primary py-2 px-3" href="https://wa.me/+{{ $data->no_hp }}">
                                    <img class="flex-shrink-0 rounded-circle me-3" src="{{asset('user/img/wa-logo.png')}}" alt="" style="width: 35px; height: 35px;" />+{{ $data->no_hp }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h1 class="text-white mb-4">
                        <img class="img-fluid me-3" src="{{asset('user/img/logos-1.png')}}" alt="" />
                    </h1>
                    <p>
                        Bersama-sama, kita hadapi setiap darurat dengan sigap dan teliti.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Alamat</h5>
                    <p>
                        <i class="fa fa-map-marker-alt me-3"></i>Jl. Cut Nyak Dien No.III, Jadirejo, Kec. Sukajadi, Kota Pekanbaru, Riau 28121
                    </p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Hubungi Kami</h5>
                    <p>Jika Ada Pesan dan Saran Silahkan Tinggalkan Pesan Melalui Email.</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Kontak</h5>
                    <p><i class="fa fa-phone-alt me-3"></i>076124260</p>
                    <p><i class="fa fa-envelope me-3"></i>info@dinkes.com</p>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">Pesan Ambulans</a>, All Right Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('user/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('user/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('user/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('user/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('user/lib/counterup/counterup.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('user/js/main.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                @php
                    list($latitude, $longitude) = explode(',', $data->lokasi);
                @endphp
                getAddress('{{ trim($latitude) }}', '{{ trim($longitude) }}', '{{ $data->ambulan_id }}');
        });

        function getAddress(latitude, longitude, id) {
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;

            fetch(url)
            .then(response => response.json())
            .then(data => {
                if (data && data.address) {
                    let address = data.display_name;
                    document.getElementById(`lokasi-${id}`).textContent = address;
                    document.getElementById('location').value = address;
                }
            })
            .catch(error => {
                console.error('Error fetching address:', error);
            });
        }
    </script>
</body>

</html>