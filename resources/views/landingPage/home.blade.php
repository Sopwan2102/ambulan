<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Website Pemesanan Ambulans</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="keywords" />
    <meta content="" name="description" />

    <!-- Favicon -->
    <link href="{{asset('user/img/favicon.ico')}}" rel="icon" />

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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDD49orLyT6fzUuLRQLcKTB4aSEDNyQFWs&callback=initMap&libraries=places" defer></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        initMap();

        @foreach($data as $row)
            @php
                // Pemisahan lokasi menjadi latitude dan longitude
                list($latitude, $longitude) = explode(',', $row->lokasi);
            @endphp
            getAddress('{{ trim($latitude) }}', '{{ trim($longitude) }}', '{{ $row->ambulan_id }}');
        @endforeach
    });

    let map;
    let marker;

    function initMap() {
        const pekanbaruCenter = { lat: 0.5344, lng: 101.4451 };

        map = new google.maps.Map(document.getElementById("map"), {
            center: pekanbaruCenter,
            zoom: 12,
        });

        const pekanbaruBounds = {
            north: 0.6059,
            south: 0.4507,
            east: 101.5371,
            west: 101.4087,
        };

        map.fitBounds(pekanbaruBounds);

        marker = new google.maps.Marker({
            position: pekanbaruCenter,
            map: map,
            draggable: true,
        });

        google.maps.event.addListener(marker, 'dragend', function() {
            const position = marker.getPosition();
            document.getElementById("location").value = position.lat() + ', ' + position.lng();
        });

        map.addListener('click', function(event) {
            marker.setPosition(event.latLng);
            document.getElementById("location").value = event.latLng.lat() + ', ' + event.latLng.lng();
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLatLng = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    // Letakkan marker di lokasi pengguna
                    marker.setPosition(userLatLng);
                    map.setCenter(userLatLng);
                    document.getElementById("location").value = userLatLng.lat + ', ' + userLatLng.lng;
                },
                function(error) {
                    console.error('Error getting geolocation:', error);
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }

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

    function filter() {
        const location = document.getElementById('location').value;
        const url = `/filter-ambulance?location=${encodeURIComponent(location)}`;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                let ambulanceListHtml = '';
                response.forEach(ambulance => {
                    ambulanceListHtml += `
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item rounded">
                                 <img class="img-fluid" src="{{ asset('storage/${ambulance.gambar}') }}" alt="" />
                                <div class="text-center p-4">
                                    <h5>Ambulans</h5>
                                    <span id="lokasi-${ambulance.ambulan_id}">${ambulance.lokasi}</span>
                                </div>
                                <div class="team-text text-center bg-white p-4">
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-light m-1" href="{{url('/ambulan/detail/${ambulance.ambulan_id}')}}">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#ambulance-list').html(ambulanceListHtml);

                // Update addresses for filtered ambulances
                response.forEach(ambulance => {
                    const [latitude, longitude] = ambulance.lokasi.split(',');
                    getAddress(latitude.trim(), longitude.trim(), ambulance.ambulan_id);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }
    </script>
</head>


<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
        <a href="{{url('/')}}" class="navbar-brand d-flex align-items-center">
            <h1 class="m-0">
                <img class="img-fluid me-3" src="{{asset('user/img/logo-1.jpeg')}}" alt="" />
            </h1>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto bg-light rounded pe-4 py-3 py-lg-0">
                <a href="#" class="nav-item nav-link">Beranda</a>
                <a href="#tentang" class="nav-item nav-link">Tutorial</a>
                <a href="#ambulans" class="nav-item nav-link">Ambulans</a>
                <a href="#hubungiKami" class="nav-item nav-link">Hubungi Kami</a>
            </div>
        </div>
        <a href="{{route('auth.register')}}" class="btn btn-primary px-3 d-none d-lg-block me-2">Driver</a>
        <a href="{{route('auth.login')}}" class="btn btn-primary px-3 d-none d-lg-block">Admin</a>
    </nav>
    <!-- Navbar End -->

    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div id="header-carousel" class="" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{asset('user/img/img-1.jpg')}}" alt="Image" />
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <h1 class="display-3 text-light mb-4 animated slideInDown">
                                        Keselamatan adalah prioritas utama kami.
                                    </h1>
                                    <p class="fs-5 text-light mb-5">
                                        Kami ada di sini untuk mengatasi setiap keadaan darurat.
                                    </p>
                                    <a href="#ambulans" class="btn btn-primary py-3 px-5">Mulai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{asset('user/img/img-2.jpg')}}" alt="Image" />
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <h1 class="display-3 text-light mb-4 animated slideInDown">
                                        Cepat, tepat, dan penuh perhatian.
                                    </h1>
                                    <p class="fs-5 text-light mb-5">
                                        Dengan kecepatan dan kehati-hatian, kami siap membantu.
                                    </p>
                                    <a href="#ambulans" class="btn btn-primary py-3 px-5">Mulai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span aria-hidden="true"></span>
                <span class="visually-hidden"></span>
            </button>
        </div>
    </div>

    <!-- Ambulans -->
    <div class="container-xxl py-5" id="ambulans">
        <div class="container">
            <div class="text-center mx-auto" style="max-width: 500px">
                <h1 class="display-6 mb-5">Pelayanan Pesan Ambulans</h1>
            </div>
            <div class="form-group">
                <div class="controls">
                    <div id="map" style="height: 300px; width: 100%;"></div>
                    <input type="hidden" id="location" name="lokasi" class="form-control" required placeholder="Lokasi">
                </div>
            </div>
            <a href="#ambulans" onclick="filter()" id="btnSaveAjax" class="btn btn-primary text-start mb-2 mt-2">Search</a>
            <div id="ambulance-list" class="row g-4">
                <!-- ambulan -->
            </div>
        </div>
    </div>
    <!-- Team End -->

    <!-- Tentang -->
    <div class="container-xxl py-5" id="tentang">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="display-6 mb-5">Tutorial Cara Pemesanan Ambulans</h1>
                    <div class="row g-3">
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                            <div class="bg-light rounded h-100 p-3">
                                <div class="bg-white d-flex flex-column justify-content-center text-center rounded h-100 py-4 px-3">
                                    <img class="align-self-center mb-3" src="{{asset('user/img/icon/icon-06-primary.png')}}" alt="" />
                                    <h5 class="mb-0">Input Lokasi</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                            <div class="bg-light rounded h-100 p-3">
                                <div class="bg-white d-flex flex-column justify-content-center text-center rounded py-4 px-3">
                                    <img class="align-self-center mb-3" src="{{asset('user/img/icon/icon-04-primary.png')}}" alt="" />
                                    <h5 class="mb-0">Pilih Ambulan</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                            <div class="bg-light rounded h-100 p-3">
                                <div class="bg-white d-flex flex-column justify-content-center text-center rounded h-100 py-4 px-3">
                                    <img class="align-self-center mb-3" src="{{asset('user/img/icon/icon-07-primary.png')}}" alt="" />
                                    <h5 class="mb-0">Hubungi No Whatsapp</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="position-relative rounded overflow-hidden h-100" style="min-height: 400px">
                        <img class="position-absolute w-100 h-100" src="https://www.riau1.com/assets/2023/03/13/1678725186-dinkes-pekanbaru-butuh-36-ambulans-layani-11-juta-penduduk.jpg" alt="" style="object-fit: cover" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div class="container-xxl py-5" id="hubungiKami">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <h1 class="display-6 mb-5">
                        Jika Anda Memiliki Pertanyaan, Silakan Hubungi Kami
                    </h1>
                    <form>
                        <div class="row g-3">
                            <div class="col-12">
                                <a href="https://wa.me/+6281291226484" class="btn btn-primary py-3 px-5" type="submit"> Hubungi Kami</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s" style="min-height: 450px">
                    <div class="position-relative rounded overflow-hidden h-100">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.657093356139!2d101.44254497447436!3d0.5150879636912817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5aea801ab68d1%3A0x46a5073ad98c34be!2sDinas%20Kesehatan%20Provinsi%20Riau!5e0!3m2!1sid!2sid!4v1719243848273!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Footer Start -->
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
                    <p><i class="fa fa-phone-alt me-3"></i>(0761)23810-26032</p>
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

</body>
</html>