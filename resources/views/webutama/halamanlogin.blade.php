@extends('webutama.layout.layoutwebutama')

@section('title', 'Halaman Login || PT.INKA Multi Solusi E-Procurement')

{{-- Disable Footer --}}
@section('no-footer', true)

@push('styles')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="{{ asset('css/webutama/halamanlogin.css') }}">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')
<style>
    .btn-modern {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    background: linear-gradient(135deg, #000080, #0055ff);
    color: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.25s ease;
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 18px rgba(0,0,0,0.2);
    background: linear-gradient(135deg, #0055ff, #000080);
}

.btn-modern:active {
    transform: translateY(0);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

</style>

<style>
    .password-wrapper {
        position: relative;
    }

    .password-wrapper input[type="password"],
    .password-wrapper input[type="text"] {
        width: 100%;
        padding-right: 45px;
        height: 45px;
        font-size: 16px;
    }

    .password-wrapper i {
        position: absolute;
        right: 10px;
        top: 70%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 22px;
        color: #555;
    }

    .password-wrapper i:hover {
        color: #000;
    }
</style>

<div class="login-container">
    <div class="login-form">
        <div class="login-header">
            <i class='bx bxs-lock-open'></i>
            <h2>Login</h2>
        </div>

        <form action="{{ url('/login') }}" method="post">
            @csrf

            <div class="input-group">
                <label for="username">Username</label>
                <input type="text"
                       id="username"
                       name="username"
                       required
                       value="{{ old('username') }}">
            </div>

            <div class="input-group password-wrapper mt-3">
                <label for="password">Password</label>
                <input type="password"
                       id="password"
                       name="password"
                       required>
                <i id="togglePassword" class='bx bx-show'></i>
            </div>

<button type="submit" class="btn-modern mt-4">
    Masuk
</button>

        </form>

        <p class="mt-2">
            Apakah anda belum memiliki akun?
            <a href="{{ url('registrasi') }}"><span>Klik Disini</span></a>
        </p>
    </div>

    <div class="login-image">
        <img src="{{ asset('img/login.png') }}" alt="Illustration">
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bx-show');
        this.classList.toggle('bx-hide');
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: '{{ session('error') }}',
        confirmButtonColor: '#d33'
    });
    @endif
</script>
@endpush
