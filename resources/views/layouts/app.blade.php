<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-PERPUS | Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-blue: #0a2647;
            --deep-black: #141414;
            --soft-white: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            color: var(--deep-black);
        }

        .navbar {
            background: rgba(10, 38, 71, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 3px solid var(--primary-blue);
            padding: 0.8rem 0;
        }

        .navbar-brand {
            letter-spacing: 2px;
            font-size: 1.5rem;
            color: #fff !important;
        }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 500;
            margin: 0 5px;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .nav-link:hover {
            color: #fff !important;
            background: rgba(255,255,255,0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--primary-blue) !important;
            font-weight: 700;
        }

        .btn-logout {
            background-color: #dc3545;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-logout:hover {
            background-color: #a71d2a;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }

        .main-container {
            animation: fadeIn 0.8s ease-in-out;
            margin-top: 30px;
            min-height: 80vh;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        footer {
            background: var(--deep-black);
            color: #888;
            padding: 20px 0;
            margin-top: 50px;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-book-reader me-2 text-primary"></i>E-PERPUS
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="/dashboard"><i class="fas fa-home me-1"></i> Dashboard</a></li>
                        
                        @if(Auth::user()->Role == 'peminjam')
                            <li class="nav-item"><a class="nav-link" href="/pinjam-buku"><i class="fas fa-book me-1"></i> Pinjam</a></li>
                            <li class="nav-item"><a class="nav-link" href="/riwayat"><i class="fas fa-history me-1"></i> Riwayat</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="/kategori"><i class="fas fa-tags me-1"></i> Kategori</a></li>
                            <li class="nav-item"><a class="nav-link" href="/buku"><i class="fas fa-layer-group me-1"></i> Pendataan</a></li>
                            <li class="nav-item"><a class="nav-link" href="/laporan"><i class="fas fa-file-alt me-1"></i> Laporan</a></li>
                            <li class="nav-item"><a class="nav-link" href="/user-management"><i class="fas fa-users-cog me-1"></i> User</a></li>
                        @endif
                        
                        <li class="nav-item ms-lg-3">
                            <form action="/logout" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout text-white btn-sm">
                                    <i class="fas fa-sign-out-alt me-1"></i> Keluar
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="/">Masuk</a></li>
                        <li class="nav-item"><a class="nav-link btn btn-outline-primary ms-lg-2 px-3 py-1" href="/register">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>