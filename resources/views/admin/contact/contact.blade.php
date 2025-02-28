@extends('layouts.auth')

@section('title', 'Contact Messages')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
<link href="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<style>
    #outer {
        text-align: center;
    }

    .inner {
        display: inline-block;
    }
</style>
@endsection

@section('content')

<div class="content-wrapper">
    <div class="content">
        <div class="card card-default">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2>Contact Messages</h2>
                <!-- You can add a button here if you want to add new messages -->
                <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#addMessageModal">
                    <i class="fas fa-plus"></i> Add Message
                </button> -->
            </div>

            <div class="card-body">
                @if (session('alert-success'))
                    <div class="alert alert-success">
                        {{ session('alert-success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($messages) > 0)
                <table class="table" id="messages">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Message</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                        <tr>
                            <td>{{ $message->id }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->message }}</td>
                            <td>
                                <!-- Delete Form -->
                                <form action="{{ route('admin.contact.delete', $message->id) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="float: right">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $messages->links() }} <!-- Pagination links -->
                @else
                <h3 class="text-center text-danger">No Messages Found</h3>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script src="{{ asset('assets/auth/plugins/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#messages').DataTable({
            "bLengthChange": false
        });
    });
</script>
@endsection
