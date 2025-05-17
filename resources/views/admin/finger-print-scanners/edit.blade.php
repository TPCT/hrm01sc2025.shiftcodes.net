
@extends('layouts.master')

@section('title',__('index.finger_print_scanner'))

@section('action',__('index.edit'))

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.finger-print-scanners.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.finger-print-scanners.update',$fingerprintScannerDetail->id)}}" enctype="multipart/form-data" method="post">
                    @method('PUT')
                    @csrf
                    @include('admin.finger-print-scanners.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

