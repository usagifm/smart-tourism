@extends('layouts.app')

@section('title')
    User - Smart Tourism
@endsection

@section('custom_styles')
    <link rel="stylesheet" href="{{ asset('css/table/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Tabel User</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>KTP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        @if ($user->photo)
                                            <a href="{{ asset($user->photo) }}" class="btn btn-sm btn-outline-info">KTP</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->tokens()->count() > 0)
                                            <form action="{{ route('manage.user.resetToken', $user) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                                    class="btn btn-sm btn-danger">Hapus Token</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection

@section('custom_scripts')
    <script src="{{ asset('js/table/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/table/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/table/jszip.min.js') }}"></script>
    <script src="{{ asset('js/table/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/table/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/table/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "order": [],
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "buttons": ['copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5', "colvis"
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
