@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-blue: #0d6efd;
        --dark-navy: #0a2647;
        --soft-blue: #f0f7ff;
        --dark-bg: #050a10;
    }

     nav, footer, .navbar { display: none !important; }

    body, html {
        margin: 0 !important; padding: 0 !important;
        background-color: var(--dark-bg);
        overflow-x: hidden;
    }

     .container, .container-fluid { 
        max-width: 100% !important; 
        padding: 0 !important; 
        margin: 0 !important; 
    }

    .register-container {
        display: flex;
        flex-direction: row-reverse;  
        min-height: 100vh;
        width: 100vw;
    }

     .register-visual {
        flex: 1.2;
        position: relative;
        display: none;
        overflow: hidden;
    }

    @media (min-width: 992px) { .register-visual { display: block; } }

    .mesh-gradient {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 70% 30%, #0d6efd 0%, transparent 45%),
                    radial-gradient(circle at 20% 70%, #0a2647 0%, transparent 45%);
        filter: blur(60px);
        z-index: 1;
        opacity: 0.7;
    }

    .visual-image {
        width: 100%; height: 100%;
        object-fit: cover;
        mix-blend-mode: luminosity;  
        filter: brightness(0.5) contrast(1.1);
        animation: slowZoom 20s infinite alternate;
    }

    @keyframes slowZoom { from { transform: scale(1); } to { transform: scale(1.15); } }

    .visual-overlay-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 10%;
        z-index: 2;
        background: linear-gradient(to left, rgba(5,10,16,0.95), transparent);
        text-align: right;
    }

    .visual-title {
        font-family: 'Syne', sans-serif;
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        font-weight: 800;
        line-height: 0.9;
        letter-spacing: -2px;
        color: white;
        margin-bottom: 25px;
    }

    .text-outline {
        -webkit-text-stroke: 1.5px var(--primary-blue);
        color: transparent;
    }

     .register-form-side {
        flex: 0.9;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
         clip-path: polygon(0 0, 88% 0, 100% 100%, 0% 100%);
        margin-right: -8vw;
        z-index: 10;
        box-shadow: 25px 0 60px rgba(0,0,0,0.4);
    }

    @media (max-width: 991px) {
        .register-form-side { clip-path: none; margin-right: 0; flex: 1; padding: 20px; }
    }

    .form-wrapper { 
        width: 100%; 
        max-width: 480px; 
        color: var(--dark-navy); 
        padding-right: 50px;
    }

    @media (max-width: 991px) { .form-wrapper { padding-right: 0; } }

     .input-wrapper { position: relative; margin-bottom: 15px; }
    .input-wrapper i {
        position: absolute; left: 18px; top: 50%;
        transform: translateY(-50%); color: #94a3b8; transition: 0.3s;
        z-index: 5;
    }

    .input-custom {
        width: 100%; padding: 14px 15px 14px 50px;
        border-radius: 12px; border: 2px solid #f1f5f9;
        background: #f8fafc; font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-custom:focus {
        outline: none; border-color: var(--primary-blue);
        background: white; box-shadow: 0 8px 20px rgba(13, 110, 253, 0.08);
    }

    .input-custom:focus + i { color: var(--primary-blue); }

    .btn-register-pro {
        width: 100%; padding: 15px; border-radius: 12px; border: none;
        background: var(--dark-navy); color: white; font-weight: 700;
        letter-spacing: 1px; transition: 0.4s;
        display: flex; justify-content: center; align-items: center; gap: 10px;
    }

    .btn-register-pro:hover {
        background: var(--primary-blue); transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.3);
    }

</style>

<div class="register-container">
    <div class="register-visual animate__animated animate__fadeIn">
        <div class="mesh-gradient"></div>
        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1600" class="visual-image" alt="Library">
        
        <div class="visual-overlay-content">
            <div class="animate__animated animate__fadeInUp">
                <span class="badge rounded-pill bg-primary px-3 py-2 mb-3">CREATE ACCOUNT</span>
                <h1 class="visual-title">
                    MULAI<br>
                    <span class="text-outline">EKSPLORASI</span><br>
                    DUNIA BARU.
                </h1>
                <p class="text-white-50 fs-5 ms-auto" style="max-width: 450px;">
                    Bergabunglah dengan ribuan pembaca lainnya dan nikmati akses koleksi buku digital eksklusif.
                </p>
            </div>
        </div>
    </div>

    <div class="register-form-side animate__animated animate__fadeInLeft">
        <div class="form-wrapper">
            <div class="mb-4 animate__animated animate__fadeInDown">
                <h2 class="fw-bold mb-1" style="letter-spacing: -1px;">Daftar Akun</h2>
                <p class="text-muted small">Lengkapi informasi untuk menjadi anggota E-PERPUS</p>
            </div>

            <form action="/register" method="POST" class="animate__animated animate__fadeInUp">
                @csrf
                
                <div class="input-wrapper">
                    <input type="text" name="Username" class="input-custom" placeholder="Username" required autofocus>
                    <i class="bi bi-at fs-5"></i>
                </div>

                <div class="input-wrapper">
                    <input type="text" name="NamaLengkap" class="input-custom" placeholder="Nama Lengkap" required>
                    <i class="bi bi-person-badge fs-5"></i>
                </div>

                <div class="input-wrapper">
                    <input type="email" name="Email" class="input-custom" placeholder="Alamat Email" required>
                    <i class="bi bi-envelope fs-5"></i>
                </div>

                <div class="input-wrapper">
                    <textarea name="Alamat" class="input-custom" rows="2" placeholder="Alamat Lengkap" style="padding-left: 50px; padding-top: 15px; height: auto;" required></textarea>
                    <i class="bi bi-geo-alt fs-5" style="top: 25px;"></i>
                </div>

                <div class="input-wrapper">
                    <input type="password" name="Password" class="input-custom" placeholder="Password (Min. 8 Karakter)" required>
                    <i class="bi bi-shield-lock fs-5"></i>
                </div>

                <button type="submit" class="btn-register-pro mt-3 mb-4">
                    BUAT AKUN SEKARANG <i class="bi bi-arrow-right-short fs-4"></i>
                </button>
            </form>

            <div class="text-center">
                <p class="text-muted small">
                    Sudah punya akun? 
                    <a href="/" class="fw-bold text-decoration-none" style="color: var(--primary-blue);">Login di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
@endsection