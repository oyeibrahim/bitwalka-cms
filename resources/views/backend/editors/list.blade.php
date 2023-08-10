@extends('backend\layout')

@section('content')
    {{-- Start and end content --}}

    <div class="container m-5">
        <div class="pt-5 my-5">

            <div class="container mb-5">
                <form method="GET" action="{{ url('backend/editors/list') }}" class="d-flex">
                    <input class="form-control me-2" id="query" name="query" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>

            <div class="row justify-content-between m-0 p-0">
                <div class="col">
                    <a class="btn btn-outline-info mb-3" href="{{ url('backend/editors/list') }}">All Editors</a>
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
                    @foreach ($editors as $editor)
                        @php
                            $status = $editor['status'] == 0 ? 'Deactivated' : ($editor['status'] == 1 ? 'Activated' : ($editor['status'] == 2 ? 'Pending' : 'Suspended'));
                            $verified = $editor['verified'] == 0 ? 'Not Submitted' : ($editor['verified'] == 1 ? 'Verified' : ($editor['verified'] == 2 ? 'Cancelled' : 'Processing'));
                        @endphp
                        <tr>
                            <td>{{ $editor['id'] }}</td>
                            <td>{{ $editor['user_id'] }}</td>
                            <td>{{ $editor['role'] }}</td>
                            <td>{{ $editor['firstname'] }}</td>
                            <td>{{ $editor['lastname'] }}</td>
                            <td>{{ $status }}</td>
                            <td>{{ $verified }}</td>
                            <td>
                                <a href="{{ url('backend/users/user/' . $editor['id']) }}">VIEW</a>
                                <a href="{{ url('backend/users/edit/' . $editor['id']) }}">EDIT</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-center mb-5">
                {{ $editors->links() }}
            </div>

        </div>
    </div>
@endsection
