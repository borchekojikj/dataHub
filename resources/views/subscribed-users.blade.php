@extends('layouts.dashboard-layout')

@section('title', 'Newsletter Subscriptions')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <form action="">
                <div class="mb-3">
                    <label for="sendMail" class="form-label color-main fs-5">Send mail to all users</label>
                    <textarea class="form-control" id="sendMail" rows="3" name="sendMail"></textarea>
                </div>
                <button class="btn custom-button form-control">Send mail</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-center py-4">
        <div class="col-8">
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <table class="table table-bordered table-hover table-striped mt-5">
                <thead class="bg-main"> <!-- Dark header background -->
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Subscribed User</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscribed_users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ ucfirst($user->user->name) }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center"><a href="{{ route('delete-subscribed-user', ['id'=> $user->id]) }}" class=" btn btn-danger w-100">Delete</a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
@endsection