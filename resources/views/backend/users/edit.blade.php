@extends('backend\layout')

@section('content')
    {{-- Start and end content --}}

    <div class="container">
        <div class="text-center mt-5">
            <h1>
                Edit user {{ $user->user_id }}
            </h1>
        </div>

        <div class="p-5 mt-5">

            <form action="/backend/users/update" method="post">
                @csrf

                <input type="hidden" name="id" value="{{ $user->id }}">

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-select" name="role">
                        @foreach ($roles as $role)
                            <option {{ $user->role == $role ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Verified</label>
                    <select class="form-select" name="email_verified_at">
                        @if ($user->email_verified_at)
                            <option selected>Yes</option>
                            <option value="CANCEL">
                                Cancel Verification
                            </option>
                        @else
                            <option selected>Not Verified</option>
                        @endif
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Deactivated</option>
                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Activated</option>
                        <option value="2" {{ $user->status == 2 ? 'selected' : '' }}>Pending</option>
                        <option value="3" {{ $user->status == 3 ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Verified</label>
                    <select class="form-select" name="verified">
                        <option value="0" {{ $user->verified == 0 ? 'selected' : '' }}>Not Submitted</option>
                        <option value="1" {{ $user->verified == 1 ? 'selected' : '' }}>Verified</option>
                        <option value="2" {{ $user->verified == 2 ? 'selected' : '' }}>Cancelled</option>
                        <option value="3" {{ $user->verified == 3 ? 'selected' : '' }}>Processing</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>

            </form>
        </div>


    </div>
@endsection
