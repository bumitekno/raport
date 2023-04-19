@extends('layout.admin.v_main')
@section('content')
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
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>{{ session('title') }}</h4>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('setting_scores.pts_configurations.storeOrUpdate') }}" method="post">
                            @csrf
                            <div class="widget-content widget-content-area br-8">
                                <table class="table dt-table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tahun Ajaran</th>
                                            <th>Semester</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $school_year)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ substr($school_year->name, 0, 9) }} @if ($school_year->status == 1)
                                                        <div class="badge badge-success">Sekarang</div>
                                                    @endif
                                                </td>
                                                <td>{{ substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap' }}</td>
                                                <td><a href="">Lihat raport</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            $(function() {
                $("form").submit(function() {
                    $('#btnLoader').removeClass('d-none');
                    $('#btnSubmit').addClass('d-none');
                });
            });

            function submitForm() {
                $('form').submit();
            }
        </script>
    @endpush
@endsection
