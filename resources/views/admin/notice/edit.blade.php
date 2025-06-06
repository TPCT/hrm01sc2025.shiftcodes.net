@extends('layouts.master')

@section('title', __('index.edit_notice'))

@section('action', __('index.edit'))

@section('button')
    <a href="{{ route('admin.notices.index') }}">
        <button class="btn btn-sm btn-primary"><i class="link-icon" data-feather="arrow-left"></i> @lang('index.back')</button>
    </a>
@endsection

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.notice.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <form id="notification" class="forms-sample" action="{{ route('admin.notices.update', $noticeDetail->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    @include('admin.notice.common.form')
                </form>
            </div>
        </div>

    </section>

@endsection

@section('scripts')
    @include('admin.notice.common.scripts')
@endsection
