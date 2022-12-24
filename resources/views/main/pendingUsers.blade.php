@extends('master')
@section('stylesheets')
<style>
    tr td img {
        width: 54px;
        height: 48px;
    }
</style>
@endsection
@section('content')

<h3 class="mt-2 mb-4">Pending Users</h3>
<table class="table table-hover table-striped text-center">
    <thead>
        <tr>
            <th>photo</th>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
    @forelse($pendingUsers as $user)
        <tr class="align-middle">
            <td><img src="{{ asset('storage/'. $user->avatar) }}" alt=""></td>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form action="{{ route('users.activate', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="submit" class="btn btn-primary btn-sm" value="active">
                </form>    
            </td>
        </tr>
    @empty
    <tr>
        <td colspan="5">EMPTY</td>
    </tr>
    @endforelse
    </tbody>
</table>

@endsection