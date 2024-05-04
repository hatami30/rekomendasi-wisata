@extends('pages.auth.components.main')

@section('title', 'Login')

@section('content')
    <section id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        {{-- <a href="index.html"><img src="./img/atung.png" alt="Logo"></a> --}}
                    </div>
                    <h1 class="auth-title txt-color">Masuk</h1>
                    <p class="auth-subtitle mb-5">Masuk menggunakan data yang telah di daftarkan.</p>

                    <form action="{{ url('/login') }}" method="POST" id="loginForm">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl"
                                placeholder="Password">
                            <div class="form-control-icon">
                                <button type="button" id="togglePassword" class="btn btn-link p-0 m-0">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        <button class="btn btn-custom btn-block btn-lg shadow-lg mt-5" type="submit">Masuk</button>
                        <div class="text-center mt-3">
                            <a href="{{ route('forgot.form') }}" class="text-gray-600">Lupa sandi?</a>
                        </div>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Belum mempunyai akun? <a href="./register"
                                class="font-bold txt-color">Daftar</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordInput = document.querySelector('input[name="password"]');
            var icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
@endsection
