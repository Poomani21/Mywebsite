@extends('admin.layout.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* PAGE TITLE */

        .page-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1f2937;
        }


        /* CARD */

        .card-box {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
        }


        /* TABLE */

        #usersTable {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        #usersTable thead th {
            border: none !important;
            font-size: 13px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
        }

        #usersTable tbody tr {
            background: #f9fafb;
            border-radius: 10px;
        }

        #usersTable tbody td {
            border-top: none !important;
            border-bottom: none !important;
            vertical-align: middle;
            padding: 14px 12px;
        }


        /* IMAGE */

        .table img {
            border-radius: 50%;
        }


        /* SEARCH BOX */

        .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 6px 10px;
            margin-left: 8px;
        }

        .dataTables_filter input:focus {
            outline: none;
            border-color: #6366f1;
        }


        /* PAGINATION */

        .dataTables_paginate {
            margin-top: 15px;
        }





        /* ACTION BUTTONS */

        .btn-sm {
            border-radius: 6px;
        }

        .btn-primary {
            background: #6366f1;
            border: none;
        }

        .btn-danger {
            background: #ef4444;
            border: none;
        }

        /* TOP BAR (SHOW ENTRIES + SEARCH) */

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_length {
            float: left;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
        }

        /* CLEAR FLOAT */

        .dataTables_wrapper .dataTables_length::after,
        .dataTables_wrapper .dataTables_filter::after {
            content: "";
            display: block;
            clear: both;
        }

        /* BOTTOM SECTION */

        .dataTables_wrapper .dataTables_info {
            float: left;
            margin-top: 20px;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: right;
            margin-top: 15px;
        }

        #usersTable {
            width: 100% !important;
        }

        .card-box {
            width: 100%;
        }

        /* HOVER */

        #usersTable tbody tr:hover {
            background: #eef2ff;
        }

        /* PAGINATION CONTAINER */

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .dataTables_wrapper .dataTables_paginate .page-item {
            margin: 0 4px;
        }

        /* BUTTON STYLE */

        .dataTables_wrapper .dataTables_paginate .page-link {
            padding: 8px 14px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            transition: all .2s ease;
        }

        /* PAGINATION BUTTON */

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0 4px;
            border-radius: 8px;
            border: 1px solid #e5e7eb !important;
            background: #ffffff !important;
            color: #374151 !important;
            font-size: 14px;
            transition: all 0.2s ease;
        }


        /* HOVER */

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #eef2ff !important;
            border-color: #6366f1 !important;
            color: #6366f1 !important;
        }


        /* ACTIVE PAGE */

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #6366f1 !important;
            color: #fff !important;
            border-color: #6366f1 !important;
            font-weight: 600;
        }


        /* DISABLED */

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }


        /* PREV NEXT */

        .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
        .dataTables_wrapper .dataTables_paginate .paginate_button.next {
            font-weight: 600;
        }

        .page-link {
            padding: 6px 12px !important;
            border: none !important;
            color: #374151 !important;
            background: #ffffff !important;
            border-radius: 8px;
        }

        /* ACTIVE PAGE FULL BLUE */

        .page-item.active .page-link {
            background: #6366f1 !important;
            color: #fff !important;
            border-radius: 8px;
        }

        /* HOVER EFFECT */

        .page-link:hover {
            background: #eef2ff !important;
            color: #6366f1 !important;
        }


        /* PAGINATION CONTAINER */

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }


        /* PAGE ITEM SPACING */

        .dataTables_paginate .page-item {
            margin: 0 4px;
        }

        /* HOVER */

        .dataTables_wrapper .dataTables_paginate .page-link:hover {
            background: #eef2ff;
            border-color: #6366f1;
            color: #6366f1;
        }


        /* ACTIVE BUTTON */

        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
            background: #6366f1;
            border-color: #6366f1;
            color: #fff;
        }


        /* DISABLED */

        .dataTables_wrapper .dataTables_paginate .page-item.disabled .page-link {
            opacity: .4;
        }

        .page-item:not(:first-child) .page-link {
            margin-left: 0px;
        }


        .dataTables_wrapper {
            width: 100%;
        }

        /* MOBILE VIEW */

        @media (max-width: 768px) {

            .page-title {
                font-size: 20px;
            }

            .card-box {
                padding: 15px;
            }

            /* TABLE SCROLL */

            .table {
                min-width: 700px;
            }

            /* SEARCH */

            .dataTables_filter {
                text-align: left;
                margin-bottom: 10px;
                width: 100%;
            }

            .dataTables_filter input {
                width: 100%;
                margin-left: 0;
                margin-top: 5px;
            }

            /* LENGTH DROPDOWN */

            .dataTables_length {
                width: 100%;
                margin-bottom: 10px;
            }

            /* FIX INFO + PAGINATION LAYOUT */

            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                float: none !important;
                width: 100%;
                text-align: center;
            }

            .dataTables_wrapper .dataTables_info {
                margin-bottom: 10px;
                font-size: 13px;
            }

            /* PAGINATION CENTER */

            .dataTables_wrapper .dataTables_paginate {
                display: flex;
                justify-content: center;
                margin-top: 10px;
            }

            /* TABLE CELL SIZE */

            #usersTable tbody td {
                padding: 10px 8px;
                font-size: 13px;
            }

            /* ACTION BUTTONS */

            .btn-sm {
                padding: 4px 8px;
                font-size: 12px;
            }

        }
    </style>


    <div class="container-fluid">

        <div class="page-title">Users Management</div>

        <div class="card-box">

            <div class="mb-3 d-flex gap-2">

                <button class="btn btn-danger btn-sm" id="bulkDelete">
                    <i class="bi bi-trash"></i> Bulk Delete
                </button>

                <button class="btn btn-success btn-sm" id="exportPDF">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>

            </div>

            <table id="usersTable" class="table align-middle">

                <thead>

                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Action</th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>



    <!-- USER MODAL -->

    <div class="modal fade" id="userModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5>User Details</h5>

                    <button class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div id="userDetail"></div>

                </div>

            </div>

        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>


    <script>
        $(function() {

            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                scrollX: true,

                dom: '<"row mb-3"<"col-md-6"l><"col-md-6 text-end"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6 text-end"p>>',

                ajax: "{{ route('users.list') }}",

                language: {
                    paginate: {
                        previous: "‹",
                        next: "›"
                    }
                },

                columns: [

                    {
                        data: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'role'
                    },
                    {
                        data: 'created_at',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });



            /* VIEW USER */

            $(document).on('click', '.viewUser', function() {

                let id = $(this).data('id');

                let url = "{{ route('users.detail', ':id') }}";
                url = url.replace(':id', id);

                $.get(url, function(user) {

                    let html = `
                <div class="text-center mb-3">
                    <img src="{{ asset('images') }}/${user.image}" width="80" class="rounded-circle">
                </div>

                <p><b>Name:</b> ${user.name}</p>
                <p><b>Email:</b> ${user.email}</p>
                <p><b>Phone:</b> ${user.phone}</p>
                <p><b>Role:</b> ${user.role}</p>
                <p><b>Country:</b> ${user.login_device?.country ?? ''}</p>
                <p><b>City:</b> ${user.login_device?.city ?? ''}</p>
                <p><b>Browser:</b> ${user.login_device?.browser ?? ''}</p>
                <p><b>OS:</b> ${user.login_device?.os ?? ''}</p>
                `;

                    $('#userDetail').html(html);
                    $('#userModal').modal('show');

                });

            });



            /* DELETE USER */

            $(document).on('click', '.deleteUser', function() {

                let id = $(this).data('id');

                Swal.fire({

                    title: "Delete User?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "{{ route('users.delete', ':id') }}".replace(':id', id),

                            type: "POST",

                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "DELETE"
                            },

                            success: function() {

                                Swal.fire(
                                    "Deleted!",
                                    "User has been deleted.",
                                    "success"
                                );

                                $('#usersTable').DataTable().ajax.reload();

                            }

                        });

                    }

                });

            });


        });

        $(document).on('change', '#selectAll', function() {

            $('.userCheckbox').prop('checked', $(this).prop('checked'));

        });

        $('#bulkDelete').click(function() {

            let ids = [];

            $('.userCheckbox:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                Swal.fire("Select users first");
                return;
            }

            Swal.fire({
                title: "Delete selected users?",
                icon: "warning",
                showCancelButton: true
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({

                        url: "{{ route('users.bulkDelete') }}",
                        type: "POST",

                        data: {
                            ids: ids,
                            _token: "{{ csrf_token() }}"
                        },

                        success: function() {

                            Swal.fire("Deleted!", "", "success");

                            $('#usersTable').DataTable().ajax.reload();

                        }

                    });

                }

            });

        });

        $('#exportPDF').click(function() {

            Swal.fire({
                title: "Preparing PDF...",
                text: "Please wait",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            let search = $('.dataTables_filter input').val();

            let url = "{{ route('users.export') }}?search=" + search;

            let iframe = document.createElement('iframe');
            iframe.style.display = "none";
            iframe.src = url;

            document.body.appendChild(iframe);

            setTimeout(() => {
                Swal.close();
            }, 2000);

        });
    </script>
@endsection
