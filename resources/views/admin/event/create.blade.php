
@extends('layouts.master')

@section('title',__('index.event'))

@section('action',__('index.create'))

@section('button')
    <a href="{{route('admin.event.index')}}" >
        <button class="btn btn-sm btn-primary" ><i class="link-icon" data-feather="arrow-left"></i> {{__('index.back')}}</button>
    </a>
@endsection

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.event.common.breadcrumb')

        <div class="card">
            <div class="card-body pb-0">
                <form id="notification" class="forms-sample" action="{{ route('admin.event.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @include('admin.event.common.form')
                </form>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    @include('admin.event.common.scripts')

@endsection
