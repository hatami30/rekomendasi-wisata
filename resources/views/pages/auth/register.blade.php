@extends('pages.auth.components.main')

@section('title', 'Register')

@section('content')
    <section id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        {{-- <a href="index.html"><img src="./img/atung.png" alt="Logo"></a> --}}
                    </div>
                    <h1 class="auth-title txt-color">Daftar</h1>
                    <p class="auth-subtitle mb-5">Masukkan data untuk membuat akun.</p>

                    <form action="{{ url('/register') }}" method="POST">
                        @csrf

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="name" class="form-control form-control-xl"
                                placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
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
                        <div class="form-group position-relative has-icon-left mb-4">
                            <select name="role" class="form-control form-control-xl">
                                <option value="user">Pengunjung</option>
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-emoji-grimace"></i>
                            </div>
                        </div>
                        <div class="container mt-5">
                            <h5 class="mb-3 txt-color" style="font-size: 1.5rem; ">Minat Kategori Wisata</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferences[]"
                                                value="pantai" id="pantai">
                                            <label class="form-check-label fw-normal" for="pantai">Pantai</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferences[]"
                                                value="danau" id="danau">
                                            <label class="form-check-label fw-normal" for="danau">Danau</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferences[]"
                                                value="air-terjun" id="air-terjun">
                                            <label class="form-check-label fw-normal" for="air-terjun">Air Terjun</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferences[]"
                                                value="air-panas" id="air-panas">
                                            <label class="form-check-label fw-normal" for="air-panas">Air Panas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferences[]"
                                                value="mangrove" id="mangrove">
                                            <label class="form-check-label fw-normal" for="mangrove">Mangrove</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferences[]"
                                                value="penangkaran" id="penangkaran">
                                            <label class="form-check-label fw-normal" for="penangkaran">Penangkaran</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="preferences[]"
                                                value="makam" id="makam">
                                            <label class="form-check-label fw-normal" for="makam">Makam</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="submitBtn"
                            class="btn btn-custom btn-block btn-lg shadow-lg mt-5">Daftar</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Sudah punya akun? <a href="./login"
                                class="font-bold txt-color">Masuk</a>.
                        </p>
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
        document.querySelector('form').addEventListener('submit', async function(event) {
            event.preventDefault();

            try {
                const formData = new FormData(this);
                const csrfToken = '{{ csrf_token() }}';

                const response = await axios.post('{{ url('/register') }}', formData, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = response.data;

                await Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil!',
                    text: data.message,
                    showCancelButton: false,
                    confirmButtonColor: '#9EB384',
                    confirmButtonText: 'Masuk',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/login';
                    }
                });
            } catch (error) {
                console.error('Registrasi Gagal:', error);

                await Swal.fire({
                    icon: 'error',
                    title: 'Registrasi Gagal!',
                    text: 'Please try again later.',
                    showCancelButton: false,
                    confirmButtonColor: '#445434',
                    confirmButtonText: 'OK'
                });
            }
        });

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
