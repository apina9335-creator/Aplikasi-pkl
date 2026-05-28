<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
        <meta name="title" content="SIPKL - Sistem Informasi PKL"/>
        <meta name="description" content="Platform pendaftaran PKL otomatis tanpa ribet login. Dapatkan Token akses Anda dan mulai petualangan magang hari ini!">

        <title>SIPKL | Home</title>

        {{-- PERBAIKAN: Menambahkan https: pada semua aset GI agar tidak loading terus menerus --}}
        <link rel="stylesheet" type="text/css" href="https://gi.co.id/dist/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://gi.co.id/dist/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="https://gi.co.id/dist/fonts/animate/animate.min.css">
        <link rel="stylesheet" type="text/css" href="https://gi.co.id/dist/css/style.css?version=1">

        {{-- Tambahan CSS khusus untuk Modal SIPKL --}}
        <style>
            .sipkl-modal {
                display: none; 
                position: fixed; 
                z-index: 9999; 
                left: 0; top: 0; 
                width: 100%; height: 100%; 
                overflow: auto; 
                background-color: rgba(0,0,0,0.8);
            }
            .sipkl-modal-content {
                background-color: #fff;
                margin: 10% auto;
                padding: 30px;
                border-radius: 10px;
                width: 90%;
                max-width: 450px;
                text-align: center;
                position: relative;
                box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            }
            .sipkl-close {
                color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;
                position: absolute; top: 10px; right: 15px;
            }
            .sipkl-close:hover { color: #000; }
            .sipkl-input {
                width: 100%; padding: 12px; margin: 20px 0; border: 2px solid #ddd; 
                border-radius: 5px; font-size: 1.2em; text-align: center; text-transform: uppercase;
                letter-spacing: 2px;
            }
            .sipkl-btn {
                background-color: #004a8c; color: white; border: none; padding: 12px 25px; 
                font-size: 1.1em; border-radius: 5px; cursor: pointer; width: 100%; font-weight: bold;
            }
            .sipkl-btn:hover { background-color: #003666; }
            
            /* Penyesuaian agar logo SIPKL terlihat bagus di navbar GI */
            #logo span { font-size: 24px; font-weight: bold; color: #004a8c; margin-top: 10px; display: inline-block;}
            #logo span span { color: #f26522; }
            
            .alert-container { padding: 20px; text-align: center; }
        </style>
</head>
<body>
        {{-- HEADER & NAVIGATION --}}
        <header id="header">
                <div class="container-fluid">
                        <div id="logo" class="pull-left">
                                <a href="{{ url('/') }}">
                                    <span>SI<span>PKL</span></span>
                                </a>
                        </div>
                        <nav id="nav-menu-container">
                                <ul class="nav-menu" alt="#mn_index">
                                        <li id="mn_index" class="menu-active"><a href="{{ url('/') }}">Home</a></li>
                                        <li id="mn_daftar"><a href="{{ route('public.register') }}">Daftar PKL Baru</a></li>
                                        <li id="mn_logbook"><a href="javascript:void(0)" onclick="document.getElementById('modal-laporan').style.display='block'">Isi Laporan Harian</a></li>
                                        <li id="mn_monitor"><a href="javascript:void(0)" onclick="document.getElementById('modal-monitor').style.display='block'">Monitoring Siswa</a></li>
                                        <li id="mn_admin"><a href="{{ route('login') }}">Login Admin Panel</a></li>
                                </ul>
                        </nav>
                </div>
        </header>

        {{-- CAROUSEL SLIDER --}}
        <section id="intro">
                <div class="intro-container">
                        <div id="introCarousel" class="carousel slide carousel-fade" data-ride="carousel">
                        <ol class="carousel-indicators">
                                <li data-target="#introCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#introCarousel" data-slide-to="1" class=""></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                        {{-- PERBAIKAN: Gambar menggunakan https: --}}
                                        <img src="https://gi.co.id/dist/images/intro-carousel/slide_1.jpg" class="img-responsive" alt="">
                                        <div class="carousel-container">
                                                <div class="carousel-content">&nbsp;</div>
                                        </div>
                                </div>
                                <div class="carousel-item">
                                        {{-- PERBAIKAN: Gambar menggunakan https: --}}
                                        <img src="https://gi.co.id/dist/images/intro-carousel/slide_2.jpg" class="img-responsive" alt="">
                                        <div class="carousel-container">
                                                <div class="carousel-content">&nbsp;</div>
                                        </div>
                                </div>
                        </div>

                        <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
        </section>

        <main id="main">
                
                {{-- TAMPILAN ERROR/SUCCESS --}}
                @if(session('error'))
                    <div class="alert-container">
                        <div class="alert alert-danger" style="display:inline-block; margin-top:20px;">
                            <strong>Perhatian!</strong> {{ session('error') }}
                        </div>
                    </div>
                @endif
                
                {{-- FEATURED TEXT --}}
                <section id="featured-services">
                        <div class="container">
                                <div class="row">
                                        <div class="col-md-12 box wow fadeInUp" data-wow-delay="0s" data-wow-duration="4.5s">
                                                <label class="featured_big_small">Memudahkan Pengelolaan Magang & Praktik Kerja Lapangan</label><br>
                                                <label class="featured_big_label">Melalui Sistem Informasi Terintegrasi</label>
                                        </div>
                                </div>
                        </div>
            </section>

            {{-- DUA KOLOM INFORMASI --}}
            <section>
                <div class="container-fluid">
                                <div class="row">
                                        <div class="col-md-6 bg_index_kiri">
                                                <div class="col-md-9 col-md-offset-3 pull-right">
                                                        <label class="text_index_big wow fadeInLeft" data-wow-delay="0s" data-wow-duration="2.5s" style="color:#383838;">Apakah Anda Siswa atau Mahasiswa yang ingin mendaftar PKL?</label><br>
                                                        <label class="text_index_sml wow fadeInLeft" data-wow-delay="0.5s" data-wow-duration="3.5s" style="color:#383838;">Mulai perjalanan PKL Anda dengan mengisi formulir singkat di sini. Setelah disetujui, Anda akan mendapatkan Token untuk mengisi Logbook Harian.</label><br>
                                                        <a class="btn" style="background-color: #f26522; color:white; padding:10px 20px; font-weight:bold; margin-top:10px; border-radius:20px;" href="{{ route('public.register') }}">Daftar Sekarang &raquo;</a>
                                                </div>
                                        </div>
                                        <div class="col-md-6 bg_index_kanan">
                                                <div class="col-md-9 col-md-offset-3 pull-left" data-wow-delay="0s" data-wow-duration="2.5s">
                                                        <label class="text_index_big wow fadeInRight" data-wow-delay="0s" data-wow-duration="2.5s" style="color:#FFFFFF;">Apakah Anda Dosen atau Guru Pembimbing?</label><br>
                                                        <label class="text_index_sml wow fadeInRight" data-wow-delay="0.5s" data-wow-duration="3.5s" style="color:#FFFFFF;">Gunakan fasilitas Monitoring Siswa untuk memantau aktivitas harian dan progres laporan dari siswa yang sedang melaksanakan magang.</label><br>
                                                        <button class="btn" style="background-color: #fff; color:#004a8c; padding:10px 20px; font-weight:bold; margin-top:10px; border-radius:20px;" onclick="document.getElementById('modal-monitor').style.display='block'">Pantau Siswa &raquo;</button>
                                                </div>
                                        </div>
                                </div>
                        </div>
            </section>

        </main>

        {{-- FOOTER --}}
        <footer id="footer">
                <div class="footer-bottom" style="background-color: #000; padding: 20px 0; text-align: center; color: white;">
                        <div class="container">
                                <div class="copyright">
                                  Hak Cipta © {{ date('Y') }}&nbsp;<strong>Sistem Informasi PKL</strong>. Adaptasi Tema Global Intermedia.
                                </div>
                        </div>
                </div>
        </footer>

        {{-- MODAL LOGBOOK --}}
        <div id="modal-laporan" class="sipkl-modal">
            <div class="sipkl-modal-content">
                <span class="sipkl-close" onclick="document.getElementById('modal-laporan').style.display='none'">&times;</span>
                <h3 style="color:#004a8c; font-weight:bold; margin-bottom:10px;">Akses Logbook Harian</h3>
                <p style="color:#666;">Masukkan Token rahasia yang Anda terima dari Email setelah pendaftaran disetujui.</p>
                <form action="{{ route('token.logbook') }}" method="GET">
                    <input type="text" name="token" class="sipkl-input" placeholder="CONTOH: PKL-XXXXXX" required>
                    <button type="submit" class="sipkl-btn">Buka Logbook Saya</button>
                </form>
            </div>
        </div>

        {{-- MODAL MONITORING --}}
        <div id="modal-monitor" class="sipkl-modal">
            <div class="sipkl-modal-content">
                <span class="sipkl-close" onclick="document.getElementById('modal-monitor').style.display='none'">&times;</span>
                <h3 style="color:#f26522; font-weight:bold; margin-bottom:10px;">Monitoring Siswa</h3>
                <p style="color:#666;">Gunakan Token siswa untuk memantau rekam aktivitas dan laporan magang mereka.</p>
                <form action="{{ route('token.monitor') }}" method="GET">
                    <input type="text" name="token" class="sipkl-input" placeholder="CONTOH: PKL-XXXXXX" required>
                    <button type="submit" class="sipkl-btn" style="background-color:#f26522;">Pantau Siswa</button>
                </form>
            </div>
        </div>

        {{-- PERBAIKAN: Menambahkan https: pada script js --}}
        <script src="https://gi.co.id/dist/js/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="https://gi.co.id/dist/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="https://gi.co.id/dist/fonts/wow/wow.min.js"></script>
        <script src="https://gi.co.id/dist/js/main.js"></script>
        
        {{-- SCRIPT UNTUK MODAL & NAVBAR --}}
        <script type="text/javascript">
            // Script untuk menutup modal jika klik di luar kotak
            window.onclick = function(event) {
                if (event.target == document.getElementById('modal-laporan')) {
                    document.getElementById('modal-laporan').style.display = "none";
                }
                if (event.target == document.getElementById('modal-monitor')) {
                    document.getElementById('modal-monitor').style.display = "none";
                }
            }

            // Inisialisasi animasi wow.js
            new WOW().init();
        </script>
</body>
</html>