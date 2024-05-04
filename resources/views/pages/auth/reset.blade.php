@extends('pages.auth.components.main')

@section('title', 'Reset Password')

@section('content')
    <section id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        {{-- <a href="index.html"><img src="./img/atung.png" alt="Logo"></a> --}}
                    </div>
                    <h1 class="auth-title txt-color">Reset Password</h1>
                    <p class="auth-subtitle mb-5">Masukkan password baru untuk reset password.</p>

                    <form method="POST" action="{{ route('reset.post', ['token' => $token]) }}" id="resetForm">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl"
                                placeholder="Password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-control-icon">
                                <button type="button" id="togglePassword" class="btn btn-link p-0 m-0">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password_confirmation" class="form-control form-control-xl"
                                placeholder="Confirm Password" required autocomplete="new-password">
                            <div class="form-control-icon">
                                <i class="bi bi-eye"></i>
                            </div>
                        </div>
                        <button id="submitBtn" class="btn btn-custom btn-block btn-lg shadow-lg mt-5" type="submit">Reset
                            Password</button>
                    </form>
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
        document.getElementById('resetForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);

            axios.post(form.action, formData)
                .then(function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                        showCancelButton: false,
                        confirmButtonColor: '#9EB384',
                        confirmButtonText: 'Login',
                        allowOutsideClick: false,
                    }).then(function() {
                        window.location.href = '{{ route('login') }}';
                    });
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        showCancelButton: false,
                        confirmButtonColor: '#445434',
                        confirmButtonText: 'OK',
                    });
                });
        });

        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordInput = document.querySelector('input[name="password"]');
            var confirmPasswordInput = document.querySelector('input[name="password_confirmation"]');
            var icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                confirmPasswordInput.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                confirmPasswordInput.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    </script>
@endsection
