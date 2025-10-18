@extends('layouts.master')

@section('title', __('Contacts'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Contacts') }}</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="datatables-permissions table border-top custom-json-datatables">
                <thead>
                    <tr>
                        <th>{{ __('Sr.') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Company Name') }}</th>
                        <th>{{ __('Submit at') }}</th>
                        @canany(['delete contact', 'view contact'])<th>{{ __('Action') }}</th>@endcan
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach ($contacts as $index => $contact)
                        <tr>
                            <td></td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->company_name }}</td>
                            <td>{{ $contact->created_at->format('M d, Y') }}</td>
                            @canany(['delete contact', 'view contact'])
                                <td class="d-flex">
                                    @canany(['delete contact'])
                                        <form action="{{ route('dashboard.contacts.destroy', $contact->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <a href="#" type="submit"
                                                class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Delete Contact') }}">
                                                <i class="ti ti-trash ti-md"></i>
                                            </a>
                                        </form>
                                    @endcan
                                    @can(['view contact'])
                                        <a href="{{ route('dashboard.contact.show', $contact->id) }}"
                                            class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('View Contact Details') }}">
                                            <i class="ti ti-trash ti-md"></i>
                                        </a>
                                    @endcan
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody> --}}
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(function() {
                $('.custom-json-datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('contacts.json') }}",
                        type: 'GET',
                        xhrFields: {
                            withCredentials: true
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'company_name',
                            name: 'company_name'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'col-20'
                        },
                    ],
                    language: {
                        searchPlaceholder: 'Search...',
                        paginate: {
                            next: '<i class="ti ti-chevron-right ti-sm"></i>',
                            previous: '<i class="ti ti-chevron-left ti-sm"></i>'
                        }
                    },
                    dom: 'Bfrtip',
                    dom: '<"row"' +
                        '<"col-md-2"<l>>' +
                        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0"fB>>' +
                        '>t' +
                        '<"row"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        '>',
                    buttons: [{
                        extend: 'collection',
                        className: 'btn btn-label-secondary dropdown-toggle me-4 waves-effect waves-light border-left-0 border-right-0 rounded',
                        text: '<i class="ti ti-upload ti-xs me-sm-1 align-text-bottom"></i> <span class="d-none d-sm-inline-block">{{ __('Export') }}</span>',
                        buttons: [{
                                extend: 'print',
                                text: '<i class="ti ti-printer me-1"></i>{{ __('Print') }}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="ti ti-file-text me-1"></i>{{ __('Csv') }}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'excel',
                                text: '<i class="ti ti-file-spreadsheet me-1"></i>{{ __('Excel') }}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="ti ti-file-description me-1"></i>{{ __('Pdf') }}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            },
                            {
                                extend: 'copy',
                                text: '<i class="ti ti-copy me-1"></i>{{ __('Copy') }}',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: ':not(:last-child)' // Exclude the last column (Actions)
                                }
                            }
                        ]
                    }],
                });
            });
        });
    </script>
@endsection
