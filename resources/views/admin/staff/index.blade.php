@extends('admin/layout/layout')
@section('section')
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Manage Staff</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">All Staff</a></li>
            </ol>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <form method="post" action="{{ route('staff.store') }}">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Staff</h4>
                            <a href="{{ route('staff.create') }}" class="btn btn-warning btn-sm"><i class="flaticon-plus-1"></i> Staff</a>
                        </div>
                        <div class="card-body pb-2 svg-area px-3">
                            <div class="row justify-content-center">
                               <div class="col-12">
                                     <div class="table-responsive">
                                        <table id="staff_table" class="display w-100">
                                            <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>Architect</td>
                                                    <td>Male</td>
                                                    <td>M.COM., P.H.D.</td>
                                                    <td><a href="javascript:void(0);"><strong>123 456 7890</strong></a></td>
                                                    <td><a href="javascript:void(0);"><strong>info@example.com</strong></a></td>
                                                    <td>2011/04/25</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </div>												
                                                    </td>												
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('custom_js')
    <script>
        var table = $('#staff_table').DataTable({
            processing: true,
            // serverSide: true,
            // ajax: '{{ url("staff.more") }}',
        });
        // $('#staff_table').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     // ajax: '/api/data3',
        //     search: {
        //         return: true
        //     },
        //     // columns: [
        //     //     { data: 'id' },
        //     //     { data: 'name' },
        //     //     { data: 'email' }
        //     // ]
        // });

        $(document).ready(function () {
            var table = $('#staff_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('staff.fetch') }}",
                    type: 'GET'
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'mobile' }
                ],
                deferLoading: 0 // Don't load on page load
            });

            // Trigger DataTable manually on interaction
            $('#ststaff_tableaffTable').on('click', 'a.paginate_button', function () {
                table.ajax.reload();
            });

            // You can also trigger on custom button click:
            // $('#loadData').click(function () {
            //     table.ajax.reload();
            // });
        });
    </script>

@endsection