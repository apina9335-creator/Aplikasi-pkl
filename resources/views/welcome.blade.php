<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <title>SIPKL - Global Intermedia Style</title>
    
    <link rel="shortcut icon" href="//www.gi.co.id/dist/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="//www.gi.co.id/dist/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//www.gi.co.id/dist/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="//www.gi.co.id/dist/fonts/animate/animate.min.css">
    <link rel="stylesheet" type="text/css" href="//www.gi.co.id/dist/css/flexbin.css">
    <link rel="stylesheet" type="text/css" href="//www.gi.co.id/dist/fonts/baguetteBox/baguetteBox.min.css">
    <link rel="stylesheet" type="text/css" href="//www.gi.co.id/dist/css/style.css?version=1">

    <style>
        #entrance-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.85); /* Gelap transparan */
            z-index: 99999;
            display: flex; justify-content: center; align-items: center;
            backdrop-filter: blur(8px); /* Efek blur background */
        }

        .entrance-box {
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            animation: bounceInDown 0.8s;
            border-top: 5px solid #007bff;
        }

        .entrance-box img { max-width: 180px; margin-bottom: 25px; }
        .entrance-box h2 { color: #333; font-weight: 700; margin-bottom: 10px; }
        .entrance-box p { color: #666; margin-bottom: 30px; font-size: 14px; }

        .btn-entrance {
            display: block; width: 100%; padding: 12px; margin-bottom: 15px;
            border-radius: 8px; text-decoration: none !important;
            font-weight: bold; font-size: 16px; transition: all 0.3s;
        }

        .btn-login {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white !important; border: none;
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,123,255,0.4); }

        .btn-register {
            background: white; color: #007bff !important;
            border: 2px solid #007bff;
        }
        .btn-register:hover { background: #f0f8ff; }

        .skip-link {
            display: inline-block; margin-top: 15px; color: #aaa;
            font-size: 13px; cursor: pointer; text-decoration: underline;
        }
        .skip-link:hover { color: #fff; }
    </style>
</head>
<body>

    <div id="entrance-overlay">
        <div class="entrance-box">
            <img src="//www.gi.co.id/dist/images/logo_gi.png" alt="Logo SIPKL">
            
            <h2>Selamat Datang di SIPKL</h2>
            <p>Sistem Informasi Praktik Kerja Lapangan.<br>Silakan masuk atau daftar untuk melanjutkan.</p>
            
            <a href="{{ route('login') }}" class="btn-entrance btn-login">
                <i class="fa fa-sign-in"></i> Masuk (Login)
            </a>
            
            <a href="{{ route('register') }}" class="btn-entrance btn-register">
                <i class="fa fa-user-plus"></i> Buat Akun Baru
            </a>
            
            <div onclick="closeEntrance()" class="skip-link">Lihat profil perusahaan &rarr;</div>
        </div>
    </div>
    <header id="header">
        <div class="container-fluid">
            <div id="logo" class="pull-left">
                <a href="{{ url('/') }}"><img src="//www.gi.co.id/dist/images/logo_gi.png" width="220"></a>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Products</a></li>
                    
                    @if (Route::has('login'))
                        @auth
                            <li class="menu-has-children"><a href="{{ url('/dashboard') }}" style="color: #007bff; font-weight:bold;">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endauth
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <section id="intro">
        <div class="intro-container">
            <div id="introCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="//www.gi.co.id/dist/images/intro-carousel/slide_1.jpg" class="img-responsive" alt="">
                        <div class="carousel-container">
                            <div class="carousel-content"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <img src="//www.gi.co.id/dist/images/logo_gi.png" width="200">
                        <p style="margin-top:15px; color:#fff;">Sistem Informasi PKL Terintegrasi.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="copyright">
                    &copy; 2026 <strong>SIPKL Project</strong>. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="//www.gi.co.id/dist/js/jquery/jquery-3.2.1.min.js"></script>
    <script src="//www.gi.co.id/dist/bootstrap/js/bootstrap.min.js"></script>
    <script src="//www.gi.co.id/dist/fonts/wow/wow.min.js"></script>
    <script src="//www.gi.co.id/dist/js/main.js"></script>

    <script>
        // Fungsi menutup Pop-up
        function closeEntrance() {
            document.getElementById('entrance-overlay').style.display = 'none';
        }
    </script>
</body>
</html>