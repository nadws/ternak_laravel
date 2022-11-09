@extends('template.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{$title}}</h1>
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <style>
        @charset "UTF-8";

        .toggler-wrapper {
            display: block;
            width: 45px;
            height: 25px;
            cursor: pointer;
            position: relative;
        }

        .toggler-wrapper input[type="checkbox"] {
            display: none;

        }

        .toggler-wrapper input[type="checkbox"]:checked+.toggler-slider {
            background-color: #44cc66;
        }

        .toggler-wrapper .toggler-slider {
            background-color: rgb(250, 8, 8);
            position: absolute;
            border-radius: 100px;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            -webkit-transition: all 300ms ease;
            transition: all 300ms ease;
        }

        .toggler-wrapper .toggler-knob {
            position: absolute;
            -webkit-transition: all 300ms ease;
            transition: all 300ms ease;
        }

        .toggler-wrapper.style-29 {
            width: 65px;
            height: 30px;
        }

        .toggler-wrapper.style-29 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:before {
            top: 100%;
        }

        .toggler-wrapper.style-29 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
            top: 3px;
        }

        .toggler-wrapper.style-29 .toggler-knob {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .toggler-wrapper.style-29 .toggler-knob:before {
            content: 'OFF';
            position: absolute;
            width: calc(30px - 6px);
            height: calc(30px - 6px);
            border-radius: 50%;
            left: 3px;
            top: 3px;
            background-color: #fff;
            -webkit-transition: all 300ms ease;
            transition: all 300ms ease;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            font-size: 75%;
            font-weight: 500;
        }

        .toggler-wrapper.style-29 .toggler-knob:after {
            content: 'ON';
            position: absolute;
            width: calc(30px - 6px);
            height: calc(30px - 6px);
            border-radius: 50%;
            right: 3px;
            top: 100%;
            background-color: #fff;
            -webkit-transition: all 300ms ease;
            transition: all 300ms ease;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            font-size: 75%;
            font-weight: 500;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <form action="{{route('save_cancel_jurnal')}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered" id="tb_bkin">
                                    <thead>

                                        <tr>
                                            <th>No</th>
                                            <th>Bulan-Tahun</th>
                                            <th>Penyesuaian</th>
                                            <th>Penutup</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($tgl as $t)
                                        @php
                                        $penyesuaian = DB::selectOne("SELECT MONTH(a.tgl) as bulan2 FROM tb_jurnal as a
                                        where MONTH(a.tgl) = '$t->bulan' and YEAR(a.tgl) = '$t->tahun' and a.id_buku
                                        in('4','5')
                                        GROUP BY MONTH(a.tgl)");

                                        $penutup = DB::selectOne("SELECT MONTH(a.tgl) as bulan2 FROM tb_jurnal as a
                                        where MONTH(a.tgl) = '$t->bulan' and YEAR(a.tgl) = '$t->tahun' and a.id_buku =
                                        '7' GROUP BY MONTH(a.tgl) ")
                                        @endphp
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$t->bulan}}-{{$t->tahun}}</td>
                                            <td align="center">
                                                @if (empty($penyesuaian))
                                                <label class="toggler-wrapper style-29">
                                                    <input type="checkbox" class="" disabled>
                                                    <div class="toggler-slider">
                                                        <div class="toggler-knob"></div>
                                                    </div>
                                                </label>
                                                @else
                                                <label class="toggler-wrapper style-29">
                                                    <input type="checkbox" class="check1" checked
                                                        id_checkbox="{{ $t->id_jurnal }}" month="{{$t->bulan}}"
                                                        year="{{$t->tahun}}">
                                                    <div class="toggler-slider">
                                                        <div class="toggler-knob"></div>
                                                    </div>
                                                </label>
                                                @endif

                                            </td>
                                            <td align="center">
                                                @if (empty($penutup))
                                                <label class="toggler-wrapper style-29">
                                                    <input type="checkbox" disabled>
                                                    <div class=" toggler-slider">
                                                        <div class="toggler-knob"></div>
                                                    </div>
                                                </label>
                                                @else
                                                <label class="toggler-wrapper style-29">
                                                    <input type="checkbox" checked class="check2" checked
                                                        id_checkbox="{{ $t->id_jurnal }}" month="{{$t->bulan}} "
                                                        year="{{$t->tahun}}">
                                                    <div class=" toggler-slider">
                                                        <div class="toggler-knob"></div>
                                                    </div>
                                                </label>
                                                @endif

                                            </td>
                                        </tr>
                                        @php
                                        $bulan = $t->bulan;
                                        $tahun = $t->tahun;
                                        @endphp
                                        @endforeach
                                        <input style="display: none" class="month-penyesuaian" name="month_penyesuaian">
                                        <input style="display: none" class="year-penyesuaian" name="year_penyesuaian">

                                        <input style="display: none" name="last_month_penyesuaian"
                                            value="{{empty($bulan) ? '' : $bulan}}">
                                        <input style="display: none" name="last_year_penyesuaian"
                                            value="{{empty($tahun) ? '' : $tahun}}">

                                        <input style="display: none" class="month-penutup" name="month_penutup">
                                        <input style="display: none" class="year-penutup" name="year_penutup">
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-costume float-right button-sm">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/izitoast/dist/js/iziToast.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $(document).on('click','.check1',function(){
           var month = $(this).attr('month');
           var year = $(this).attr('year');

           if ($(this).is(':checked')) {
                var nilai1 = '';
                $('.month-penyesuaian').val(nilai1);
                var nilai2 = '';
                $('.year-penyesuaian').val(nilai2);
            } else {
                var nilai1 = month;
                $('.month-penyesuaian').val(nilai1);
                var nilai2 = year;
                $('.year-penyesuaian').val(nilai2);
            }
           
           
        });

        $(document).on('click','.check2',function(){
           var month = $(this).attr('month');
           var year = $(this).attr('year');
           if ($(this).is(':checked')) {
                var nilai1 = '';
                $('.month-penutup').val(nilai1);
                var nilai2 = '';
                $('.year-penutup').val(nilai2);
            } else {
                var nilai1 = month;
                $('.month-penutup').val(nilai1);
                var nilai2 = year;
                $('.year-penutup').val(nilai2);
            }
        });
    });
</script>
@endsection