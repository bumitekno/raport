@extends('layout.admin.v_main')
@section('content')
    @push('styles')
        @include('package.loader.loader_css')
        <link rel="stylesheet" type="text/css" href="{{ asset('asset/custom/account-setting.css') }}">
    @endpush
    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">

            <div class="page-meta mt-3">
                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Siswa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>

            <div class="row" id="cancel-row">

                <div class="col-xl-12 col-lg-12 col-sm-12 layout-top-spacing layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <h4>{{ session('title') }}</h4>
                        </div>
                        <form action="{{ route('setting_scores.description.storeOrUpdate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <table id="table-list" class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kriteria</th>
                                            <th>Deskripsi Capaian Kompetensi</th>
                                            @if (session('role') == 'admin')
                                                <th>
                                                    <a href="javascript:void(0)" id="addMore">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="#00b15f" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <line x1="12" y1="8" x2="12"
                                                                y2="16">
                                                            </line>
                                                            <line x1="8" y1="12" x2="16"
                                                                y2="12">
                                                            </line>
                                                        </svg>
                                                    </a>
                                                </th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($description->isEmpty())
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    <input type="text" name="criteria[]" class="form-control">
                                                </td>
                                                <td><input type="text" name="description[]" class="form-control"></td>
                                                @if (session('role') == 'admin')
                                                    <td>
                                                        <a href="javascript:void(0);" class="remove">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="#f00931" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <circle cx="12" cy="12" r="10">
                                                                </circle>
                                                                <line x1="8" y1="12" x2="16"
                                                                    y2="12">
                                                                </line>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                @endif
                                                <input type="hidden" name="deleted_id[]" value="">
                                            </tr>
                                        @else
                                            @foreach ($description as $index => $criteria)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <input type="text" name="criteria[]" class="form-control"
                                                            value="{{ $criteria->criteria }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="description[]" class="form-control"
                                                            value="{{ $criteria->description }}">
                                                    </td>
                                                    @if (session('role') == 'admin')
                                                        <td>
                                                            <a href="javascript:void(0);" class="remove"
                                                                data-id="{{ $criteria->id }}"
                                                                data-row="{{ $index + 1 }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="#f00931" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <circle cx="12" cy="12" r="10">
                                                                    </circle>
                                                                    <line x1="8" y1="12" x2="16"
                                                                        y2="12">
                                                                    </line>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    @endif
                                                    <input type="hidden" name="id[]" value="{{ $criteria->id }}">
                                                    <input type="hidden" name="deleted_id[]" class="deleted_id"
                                                        value="">
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="account-settings-footer">

            <div class="as-footer-container">

                <button id="multiple-reset" class="btn btn-warning">Reset All</button>
                <div class="blockui-growl-message">
                    <i class="flaticon-double-check"></i>&nbsp; Settings Saved Successfully
                </div>


                <button class="btn btn-primary d-none" id="btnLoader">
                    <div class="spinner-grow text-white mr-2 align-self-center loader-sm">
                        Loading...</div>
                    Loading
                </button>
                <button class="btn btn-primary" id="btnSubmit" onclick="submitForm()">Simpan
                    Data</button>

            </div>

        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });

                var rowCount = $('#table-list tbody tr').length;
                $('#addMore').on('click', function() {
                    var data = $("#table-list tr:eq(1)").clone(true).appendTo("#table-list tbody");
                    data.find("input").val('');
                    data.find("td:first-child").text(++rowCount);
                });
                $(document).on('click', '.remove', function() {
                    var trIndex = $(this).closest("tr").index();
                    var deletedId = $(this).data('id');
                    console.log(trIndex);
                    if (trIndex >= 1) {
                        $(this).closest("tr").remove();
                        $('.deleted_id').eq(trIndex - 1).val(deletedId);
                        rowCount--;
                    } else {
                        alert("Sorry!! Can't remove first row!");
                    }
                });
            });

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
