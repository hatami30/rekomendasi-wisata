@extends('pages.user.components.main')

@section('title', 'Tentang')

@section('content')
    <section class="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="https://i.ibb.co/vv3854R/bawean.jpg" alt="about" class="img-fluid rounded-5">
                </div>
                <div class="col-md-6">
                    <div class="text-about">
                        <h4 class="mb-3">Tentang Pulau Bawean ?</h4>
                        <p class="mb-3"><span>Pulau Bawean</span> adalah pulau yang terletak di Laut Jawa, sekitar
                            135 kilometer
                            sebelah utara Kota Gresik. Secara administratif, pulau ini termasuk ke dalam wilayah
                            Kabupaten Gresik, Jawa Timur. Pasukan VOC menguasai pulau ini pada tahun 1743.
                        </p>

                        <p class="mb-3">Pulau ini terdiri atas dua kecamatan, yaitu Kecamatan
                            Sangkapura dan Kecamatan Tambak.
                            Penduduknya berjumlah sekitar 107.000 jiwa dengan mayoritas suku Bawean serta perpaduan
                            beberapa suku dari Jawa, Madura, Kalimantan, Sulawesi, dan Sumatra yang turut
                            mempengaruhi
                            budaya dan bahasanya. Mata pencaharian utama penduduknya adalah nelayan dan petani
                            serta pekerja rantauan di Malaysia dan Singapura. Orang Bawean ada pula yang menetap di
                            Australia dan Vietnam.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="text-center">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item rounded-3"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127022.04822709865!2d112.57308349361179!3d-5.793498174247495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2ddf5782884529d1%3A0x52621acdfb67b026!2sPulau%20Bawean!5e0!3m2!1sid!2sid!4v1709549448740!5m2!1sid!2sid"
                width="900" height="520" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
@endsection
