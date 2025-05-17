
@extends('layouts.master')

@section('title',__('index.finger_print_scanner'))

@section('action',__('index.create'))

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.finger-print-scanners.common.breadcrumb')
        <div class="card">
            <div class="card-body pb-0">
                <h4 class="mb-4">@lang('index.finger_print_scanner_details') </h4>
                <form class="forms-sample" action="{{route('admin.finger-print-scanners.store')}}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @include('admin.finger-print-scanners.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection
