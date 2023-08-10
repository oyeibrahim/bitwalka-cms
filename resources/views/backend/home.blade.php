@extends('backend\layout')

@section('content')
    {{-- Start and end content --}}

    <div class="container m-5">
        <div class="pt-5 my-5">

            <div>
                <a href="{{ url('backend/admins/list') }}">Admins List</a>
            </div>
            <div>
                <a href="{{ url('backend/editors/list') }}">Editors List</a>
            </div>
            <div>
                <a href="{{ url('backend/users/list') }}">Users List</a>
            </div>


        </div>
    </div>
@endsection
