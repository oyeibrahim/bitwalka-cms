@extends('backend\layout')

@section('content')
    {{-- Start and end content --}}

    <div class="container m-5">
        <div class="pt-5 my-5">

            <div class="container mb-5">
                <form method="GET" action="{{ url('backend/users/list') }}" class="d-flex">
                    <input class="form-control me-2" id="query" name="query" type="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>

            <div class="row justify-content-between m-0 p-0">
                <div class="col">
                    <a class="btn btn-outline-info mb-3" href="{{ url('backend/users/list') }}">All Users</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=email&value=verified') }}">Email Verified</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=email&value=unverified') }}">Email Not Verified</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=status&value=deactivated') }}">Status: Deactivated</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=status&value=activated') }}">Status: Activated</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=status&value=pending') }}">Status: Pending</a>
                </div>

            </div>

            <div class="row justify-content-between m-0 p-0">
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=status&value=suspended') }}">Status: Suspended</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=verified&value=notsubmitted') }}">Verified: Not Submitted</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=verified&value=verified') }}">Verified: Verified</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=verified&value=cancelled') }}">Verified: Cancelled</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-info mb-3"
                        href="{{ url('backend/users/list?type=verified&value=processing') }}">Verified: Processing</a>
                </div>
            </div>

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">user_id</th>
                        <th scope="col">Role</th>
                        <th scope="col">Username</th>
                        <th scope="col">Status</th>
                        <th scope="col">Verified</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $status = $user['status'] == 0 ? 'Deactivated' : ($user['status'] == 1 ? 'Activated' : ($user['status'] == 2 ? 'Pending' : 'Suspended'));
                            $verified = $user['verified'] == 0 ? 'Not Submitted' : ($user['verified'] == 1 ? 'Verified' : ($user['verified'] == 2 ? 'Cancelled' : 'Processing'));
                        @endphp
                        <tr>
                            <td>{{ $user['id'] }}</td>
                            <td>{{ $user['user_id'] }}</td>
                            <td>{{ $user['role'] }}</td>
                            <td>{{ $user['username'] }}</td>
                            <td>{{ $status }}</td>
                            <td>{{ $verified }}</td>
                            <td>
                                <a href="{{ url('backend/users/user/' . $user['id']) }}">VIEW</a>
                                <a href="{{ url('backend/users/edit/' . $user['id']) }}">EDIT</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mb-5">
                {{ $users->links() }}
            </div>

        </div>
    </div>
@endsection
