@extends('layouts.pengajar')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> {{ $title }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="card-columns">

                </div>

                <!-- Data Loader -->
                <div class="auto-load text-center py-5">
                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0"
                         xml:space="preserve">
                            <path fill="#000"
                                  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                                  from="0 50 50" to="360 50 50" repeatCount="indefinite"/>
                            </path>
                        </svg>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('script')
    <script>
        var ENDPOINT = "{{ url()->current() }}";
        var page = 1;

        $(document).ready(function() {

            loadMore(page);

            osInstance.options({
                callbacks: {
                    onScroll: function(e) {
                        if (e.target.scrollTop + $(window).height() >= e.target.scrollHeight) {
                            page++;
                            loadMore(page);
                        }
                    }
                }
            });

        });

        function loadMore(page) {
            $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "get",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            }).done(function (response) {
                let card = ``;
                response.data.forEach(e => {
                    let foto = e.foto ? "storage/" + e.foto : "images/info.jpg";
                    foto = "{{ asset('') }}" + foto;
                    card += `
                        <div class="card">
                            <img src="` + foto + `" class="card-img-top" alt="` + e.judul + `">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold mb-2"><a href="` + ENDPOINT + `/` + e.slug + `">` + e.judul + `</a></h5>
                                <p class="card-text mb-2">` + e.konten.substring(0, 255) + `...</p>
                            </div>
                        </div>`;
                });
                if (response.data.length == 0) {
                    $('.auto-load').html("Tidak ada data pengumuman yang dapat dimuat.");
                    return;
                }
                $('.auto-load').hide();
                $(".card-columns").append(card);
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('Server error occured');
            });
        }

    </script>
@endpush
