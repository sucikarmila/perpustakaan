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

    nav, footer, .navbar { 
        display: none !important; 
    }

    body, html {
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
    }

    .main-container { 
        margin: 0 !important; 
        padding: 0 !important; 
        max-width: 100% !important;
        width: 100% !important;
    }

    .login-container {
        display: flex;
        min-height: 100vh;
        background-color: var(--dark-bg);
    }

    .login-visual {
        flex: 1.2;
        position: relative;
        display: none;
        overflow: hidden;
    }

    @media (min-width: 992px) { 
        .login-visual { display: block; } 
    }

    .mesh-gradient {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 20% 30%, #0d6efd 0%, transparent 45%),
                    radial-gradient(circle at 80% 70%, #0a2647 0%, transparent 45%);
        filter: blur(60px);
        z-index: 1;
        opacity: 0.7;
    }

    .visual-image {
        width: 100%; height: 100%;
        object-fit: cover;
        mix-blend-mode: luminosity;
        filter: brightness(0.4);
        animation: slowZoom 20s infinite alternate;
    }

    @keyframes slowZoom { 
        from { transform: scale(1); } to { transform: scale(1.15); } 
    }

    .visual-overlay-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 10%;
        z-index: 2;
        background: linear-gradient(to right, rgba(5,10,16,0.95), transparent);
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

    .login-form-side {
        flex: 0.8;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
        clip-path: polygon(12% 0, 100% 0, 100% 100%, 0% 100%);
        margin-left: -10vw; 
        z-index: 10;
        box-shadow: -25px 0 60px rgba(0,0,0,0.4);
    }

    @media (max-width: 991px) {
        .login-form-side { 
            clip-path: none; 
            margin-left: 0; 
            flex: 1; 
        }
    }

    .form-wrapper { 
        width: 100%; 
        max-width: 380px; 
        color: var(--dark-navy); 
    }

    .input-wrapper { 
        position: relative; 
        margin-bottom: 20px; 
    }
    
    .input-wrapper i {
        position: absolute;
        left: 20px; top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        transition: 0.3s;
    }

    .input-custom {
        width: 100%;
        padding: 16px 16px 16px 55px;
        border-radius: 14px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .input-custom:focus {
        outline: none;
        border-color: var(--primary-blue);
        background: white;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.1);
        transform: translateY(-2px);
    }

    .input-custom:focus + i { 
        color: var(--primary-blue); 
    }

    .btn-login-pro {
        width: 100%;
        padding: 16px;
        border-radius: 14px;
        border: none;
        background: var(--dark-navy);
        color: white;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        transition: 0.4s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .btn-login-pro:hover {
        background: var(--primary-blue);
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(13, 110, 253, 0.3);
    }

    .badge-status {
        background: rgba(13, 110, 253, 0.1);
        color: var(--primary-blue);
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 50px;
        display: inline-block;
        margin-bottom: 15px;
    }
</style>

<div class="login-container">
    <div class="login-visual animate__animated animate__fadeIn">
        <div class="mesh-gradient"></div>
        <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=1600" class="visual-image" alt="Library">
        
        <div class="visual-overlay-content">
            <div class="animate__animated animate__fadeInLeft animate__delay-1s">
                <span class="badge-status">E-PERPUS V.2 DIGITAL</span>
                <h1 class="visual-title">
                    GERBANG<br>
                    <span class="text-outline">WAKTU</span><br>
                    ILMU PENGETAHUAN.
                </h1>
                <p class="text-white-50 fs-5" style="max-width: 480px;">
                    Kelola dan pinjam koleksi buku terbaik dengan sistem manajemen perpustakaan tercanggih.
                </p>
            </div>
        </div>
    </div>

    <div class="login-form-side animate__animated animate__fadeInRight">
        <div class="form-wrapper">
            <div class="mb-5 animate__animated animate__fadeInDown animate__delay-1s text-center text-lg-start">
                <h2 class="fw-bold mb-1" style="letter-spacing: -1px;">Selamat Datang Kembali</h2>
                <p class="text-muted">Gunakan akun Anda untuk masuk</p>
            </div>

            @if($errors->has('loginError'))
                <div class="alert alert-danger border-0 small mb-4 py-3 shadow-sm" style="border-radius: 12px;">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first('loginError') }}
                </div>
            @endif

            <form action="/login" method="POST" class="animate__animated animate__fadeInUp animate__delay-1s">
                @csrf
                <div class="input-wrapper">
                    <input type="text" name="Username" class="input-custom" placeholder="Username" required autofocus>
                    <i class="fas fa-user-circle fs-5"></i>
                </div>

                <div class="input-wrapper">
                    <input type="password" name="Password" class="input-custom" placeholder="Password" required>
                    <i class="fas fa-lock fs-5"></i>
                </div>

                <button type="submit" class="btn-login-pro mt-2 mb-4">
                    MASUK KE SISTEM <i class="bi bi-arrow-right-circle-fill fs-5"></i>
                </button>
            </form>

            <div class="text-center animate__animated animate__fadeIn animate__delay-2s">
                <p class="text-muted small">
                    Belum memiliki akses? 
                    <a href="/register" class="fw-bold text-decoration-none" style="color: var(--primary-blue);">Buat Akun Sekarang</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            borderRadius: '15px'
        });
    @endif

    @if(session('success_admin'))
        Swal.fire({
            title: 'Mode Admin',
            text: "{{ session('success_admin') }}",
            icon: 'info',
            confirmButtonColor: '#0a2647'
        });
    @endif
</script>
@endpush