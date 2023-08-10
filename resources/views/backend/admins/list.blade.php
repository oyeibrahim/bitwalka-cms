@extends('backend\layout')

@section('content')
    {{-- Start and end content --}}

    <div class="container m-5">
        <div class="pt-5 my-5">

            <div class="container mb-5">
                <form method="GET" action="{{ url('backend/admins/list') }}" class="d-flex">
                    <input class="form-control me-2" id="query" name="query" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>

            <div class="row justify-content-between m-0 p-0">
                <div class="col">
                    <a class="btn btn-outline-info mb-3" href="{{ url('backend/admins/list') }}">All Admins</a>
                </div>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">user_id</th>
                        <th scope="col">Role</th>
                        <th scope="col">Firstname</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Status</th>
                        <th scope="col">Verified</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        @php
                            $status = $admin['status'] == 0 ? 'Deactivated' : ($admin['status'] == 1 ? 'Activated' : ($admin['status'] == 2 ? 'Pending' : 'Suspended'));
                            $verified = $admin['verified'] == 0 ? 'Not Submitted' : ($admin['verified'] == 1 ? 'Verified' : ($admin['verified'] == 2 ? 'Cancelled' : 'Processing'));
                        @endphp
                        <tr>
                            <td>{{ $admin['id'] }}</td>
                            <td>{{ $admin['user_id'] }}</td>
                            <td>{{ $admin['role'] }}</td>
                            <td>{{ $admin['firstname'] }}</td>
                            <td>{{ $admin['lastname'] }}</td>
                            <td>{{ $status }}</td>
                            <td>{{ $verified }}</td>
                            <td>
                                <a href="{{ url('backend/users/user/' . $admin['id']) }}">VIEW</a>
                                <a href="{{ url('backend/users/edit/' . $admin['id']) }}">EDIT</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mb-5">
                {{ $admins->links() }}
            </div>

        </div>
    </div>
@endsection
