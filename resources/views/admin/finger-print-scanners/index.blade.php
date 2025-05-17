@extends('layouts.master')

@section('title',__('index.finger_print_scanner'))

@section('action',__('index.lists'))

@section('button')
    @can('create_router')
        <a href="{{ route('admin.finger-print-scanners.create')}}">
            <button class="btn btn-primary">
                <i class="link-icon" data-feather="plus"></i> @lang('index.add_finger_print_scanner')
            </button>
        </a>
    @endcan
@endsection

@section('main-content')

    <section class="content">

        @include('admin.section.flash_message')

        @include('admin.router.common.breadcrumb')

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('index.ip_address')</th>
                            <th>@lang('index.port')</th>
                            <th>@lang('index.branch') </th>
                            <th>@lang('index.company')</th>
                            @canany(['edit_fingerprint_scanner','delete_fingerprint_scanner'])
                                <th class="text-center">@lang('index.action')</th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                        @forelse($scanners as $key => $value)
                            <tr>
                                <td>{{(($scanners->currentPage()- 1 ) * (\App\Models\FingerPrintScanner::RECORDS_PER_PAGE) + (++$key))}}</td>
                                <td>{{($value->ip)}}</td>
                                <td>{{$value->port}}</td>
                                <td>{{ucfirst($value->branch->name)}}</td>
                                <td>{{ucfirst($value->company->name)}}</td>
                                @canany(['edit_fingerprint_scanner','delete_fingerprint_scanner'])
                                    <td class="text-center">
                                    <ul class="d-flex list-unstyled mb-0 justify-content-center align-items-center">
                                        @can('edit_fingerprint_scanner')
                                            <li class="me-2">
                                                <a href="{{route('admin.finger-print-scanners.edit',$value->id)}}" title="{{ __('index.edit') }}">
                                                    <i class="link-icon" data-feather="edit"></i>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('delete_fingerprint_scanner')
                                            <li>
                                                <a class="deleteFingerPrintScanner"
                                                   data-href="{{route('admin.finger-print-scanners.delete',$value->id)}}" title="{{ __('index.delete') }}">
                                                    <i class="link-icon"  data-feather="delete"></i>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100%">
                                    <p class="text-center"><b>@lang('index.no_records_found')</b></p>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="dataTables_paginate">
            {{$scanners->appends($_GET)->links()}}
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.deleteFingerPrintScanner').click(function (event) {
                event.preventDefault();
                let href = $(this).data('href');
                Swal.fire({
                    title: 'Are you sure you want to Delete Fingerprint Scanner Detail ?',
                    showDenyButton: true,
                    confirmButtonText: `Yes`,
                    denyButtonText: `No`,
                    padding:'10px 50px 10px 50px',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                })
            })

        });
    </script>
@endsection

