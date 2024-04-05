@extends('pages.auth.components.main')

@section('title', 'Verifikasi Email')

@section('content')
    <section id="auth">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div id="auth-left">
                    {{-- <div class="logo">
                        <a href="{{ url('/') }}" id="logo">Wisata Bawean</a>
                    </div> --}}
                    <h1 class="auth-title txt-color">Reset Password</h1>
                    <p class="auth-subtitle mb-2">Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tombol
                        di bawah ini untuk mengatur ulang kata sandi Anda.</p>
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </div>
                    @endif
                    <a href="{{ route('reset.form', ['token' => $token]) }}"
                        class="btn btn-custom btn-block btn-lg shadow-lg mt-5">Reset</a>
                </div>
            </div>
        </div>
    </section>
@endsection
