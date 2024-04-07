@extends('pages.auth.components.main')

@section('title', 'Forgot Password')

@section('content')
    <section id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        {{-- <a href="index.html"><img src="./img/atung.png" alt="Logo"></a> --}}
                    </div>
                    <h1 class="auth-title txt-color">Forgot</h1>
                    <p class="auth-subtitle mb-5">Masukkan email yang terdaftar untuk reset password.</p>

                    <form action="{{ route('forgot.post') }}" method="POST" id="forgotForm">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button id="submitBtn" class="btn btn-custom btn-block btn-lg shadow-lg mt-5" type="submit">Kirim
                            Email</button>
                        {{-- <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-gray-600">Login?</a>
                        </div> --}}
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Ingat password akun? <a href="./login"
                                class="font-bold txt-color">Masuk</a>.</p>
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
        document.getElementById('forgotForm').addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                icon: 'info',
                title: 'Processing...',
                text: 'Please wait...',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    var form = event.target;
                    var formData = new FormData(form);
                    axios.post(form.action, formData)
                        .then(function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.data.message,
                                confirmButtonColor: '#9EB384',
                                confirmButtonText: 'Check Email',
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/forgot';
                                }
                            });
                        })
                        .catch(function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                confirmButtonColor: '#445434',
                                confirmButtonText: 'OK',
                                allowOutsideClick: false,
                            });
                        });
                }
            });
        });
    </script>
@endsection
