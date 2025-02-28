@extends('layouts.auth')

@section('title', 'Contact')
@section('content')

<div class="card card-default mt-5 ml-3 mr-3">


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
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                            <tr>
                                <td>{{ $message->id }}</td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->message }}</td>
                                <td>{{ $message->created_at->format('d M Y') }}</td>
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
</div>


@endsection


