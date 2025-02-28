@extends('layouts.auth')

@section('title', 'Fix Pages')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet"/>
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />

@endsection

@section('content')

<div class="content-wrapper mb-3">
    <div class="content">
        <div class="card card-default mb-3">
            <div class="card-header mb-3">
                <h2>Fix Pages</h2>
            </div>

            @if (Session::has('alert-success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Success!</strong> {{ Session::get('alert-success') }}
            </div>
            @endif



            <div class="card-body" style="width: 1050px">

                <table class="table" id="addpages">
                    <thead>
                        <tr>
                            <th scope="col">Page Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>About Us</td>
                            <td id="outer" >
                                <a href="{{ route('admin.pages.viewabout') }}" class="btn btn-sm btn-success inner " style="float: right"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.about.edit') }}" class="btn btn-sm btn-info inner mr-1" style="float: right"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>Services</td>
                            <td id="outer">
                                <a href="{{ route('admin.pages.viewservice') }}" class="btn btn-sm btn-success inner" style="float: right"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.services.edit') }}" class="btn btn-sm btn-info inner mr-1" style="float: right"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>Privacy Policy</td>
                            <td id="outer">
                                <a href="{{ route('admin.pages.viewpolicy') }}" class="btn btn-sm btn-success inner" style="float: right"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.about.policy.edit_policy') }}" class="btn btn-sm btn-info inner mr-1" style="float: right"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>Terms & Conditions</td>
                            <td id="outer">
                                <a href="{{ route('admin.pages.viewterm') }}" class="btn btn-sm btn-success inner" style="float: right"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.terms.edit') }}" class="btn btn-sm btn-info inner mr-1" style="float: right"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>Contact Form</td>
                            <td id="outer">
                                <a href="{{ route('admin.pages.viewcontact') }}" class="btn btn-sm btn-success inner" style="float: right"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.contact.contact') }}" class="btn btn-sm btn-info inner mr-1" style="float: right"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td>Contact Info</td>
                            <td id="outer">
                                <a href="{{ route('admin.pages.viewcontactinfo') }}" class="btn btn-sm btn-success inner" style="float: right"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.contact.edit') }}" class="btn btn-sm btn-info inner mr-1" style="float: right"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#addpages').DataTable({

            "searching": true,
            "bLengthChange": false
        });
    });
</script>
@endsection
