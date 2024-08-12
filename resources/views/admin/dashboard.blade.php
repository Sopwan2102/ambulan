@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-xl-8 col-12">
        <div class="box bg-primary-light">
            <div class="box-body d-flex px-0">
                <div class="flex-grow-1 p-30 flex-grow-1 bg-img dask-bg bg-none-md" style="background-position: right bottom; background-size: auto 100%; background-image: url(../images/svg-icon/color-svg/custom-1.svg)">
                    <div class="row">
                        <div class="col-12 col-xl-7">
                            @if(auth()->user()->role == 'admin')
                                <h2>Kamu Masuk Sebagai Administrator, <strong>{{$data->name}}</strong></h2>
                            @endif

                            @if(auth()->user()->role == 'driver')
                                <h2>Selamat Datang Driver, <strong>{{$data->name}}</strong></h2>
                            @endif
                        </div>
                        <div class="col-12 col-xl-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection