@extends('backend\layout')

@section('content')
    {{-- Start and end content --}}

    <div class="container m-5">
        <div class="pt-5 my-5">

            <div class="row justify-content-between m-0 p-0">
                <div class="col">
                    <a class="btn btn-outline-info mb-3" href="{{ url('backend/users/edit/' . $user['id']) }}">Edit User</a>
                </div>

            </div>



            <div class="mb-4 mt-4">
                <h4>
                Avatar - 
            </h4>

                <img src="{{ asset('') . str_replace('public', 'storage', $user->image) }}"
                    class="rounded" alt="{{ $user->username . ' Profile Image' }}"
                    style="max-height: 200px; max-width: 200px;" />
            </div>
            <div>
                <h4>
                    Role - {{ $user->role }}
                </h4>
            </div>
            <div>
                <h4>
                    id - {{ $user->id }}
                </h4>
            </div>
            <div>
                <h4>
                    User ID - {{ $user->user_id }}
                </h4>
            </div>
            <div>
                <h4>
                    Firstname - {{ $user->firstname }}
                </h4>
            </div>
            <div>
                <h4>
                    Lastname - {{ $user->lastname }}
                </h4>
            </div>
            <div>
                <h4>
                    Username - {{ $user->username }}
                </h4>
            </div>
            <div>
                <h4>
                    Email - {{ $user->email }}
                </h4>
            </div>
            <div>
                <h4>
                    Email Verify Date - {{ $user->email_verified_at }}
                </h4>
            </div>
            <div>
                <h4>
                    Phone No - {{ $user->phone }}
                </h4>
            </div>
            <div>
                <h4>
                    Referrer - {{ $user->referral_id }}
                </h4>
            </div>
            <div>
                <h4>
                    Locale - {{ $user->locale }}
                </h4>
            </div>
            <div>
                <h4>
                    Gender - {{ $user->gender }}
                </h4>
            </div>
            <div>
                <h4>
                    Country - {{ $user->country }}
                </h4>
            </div>
            <div>
                <h4>
                    City - {{ $user->city }}
                </h4>
            </div>
            <div>
                <h4>
                    Address - {{ $user->address }}
                </h4>
            </div>
            <div>
                <h4>
                    Bio - {{ $user->bio }}
                </h4>
            </div>
            <div>
                <h4>
                    Theme - {{ $user->theme }}
                </h4>
            </div>
            <div>
                <h4>
                    Status - {{ $user->status == 0 ? 'Deactivated' : ($user->status == 1 ? 'Activated' : ($user->status == 2 ? 'Pending' : 'Suspended')) }}
                </h4>
            </div>
            <div>
                <h4>
                    Verified - {{ $user->verified == 0 ? 'Not Submitted' : ($user->verified == 1 ? 'Verified' : ($user->verified == 2 ? 'Cancelled' : 'Processing')) }}
                </h4>
            </div>
            <div>
                <h4>
                    IP Address - {{ $user->ip }}
                </h4>
            </div>
            <div>
                <h4>
                    Last Login - {{ $user->last_login }}
                </h4>
            </div>
            <div>
                <h4>
                    Last Logout - {{ $user->last_logout }}
                </h4>
            </div>
            <div>
                <h4>
                    Created At - {{ $user->created_at }}
                </h4>
            </div>
            <div>
                <h4>
                    Updated At - {{ $user->updated_at }}
                </h4>
            </div>


        </div>
    </div>
@endsection
