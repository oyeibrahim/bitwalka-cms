<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    //
    function admin_list(Request $req)
    {
        $data_per_page = 20;

        $data = null;

        if (!$req->has('query')) {
            $data = User::where('role', 'ADMIN')->paginate($data_per_page);
        }

        if ($req->has('query')) {
            $search_query = $req->input('query');
            $data = User::where('role', 'ADMIN')
                ->where(function (Builder $query) use ($search_query) {
                    $query->where('user_id', 'like', '%' . $search_query . '%')
                        ->orWhere('firstname', 'like', '%' . $search_query . '%')
                        ->orWhere('lastname', 'like', '%' . $search_query . '%')
                        ->orWhere('username', 'like', '%' . $search_query . '%')
                        ->orWhere('email', 'like', '%' . $search_query . '%')
                        ->orWhere('phone', 'like', '%' . $search_query . '%')
                        ->orWhere('country', 'like', '%' . $search_query . '%')
                        ->orWhere('city', 'like', '%' . $search_query . '%')
                        ->orWhere('address', 'like', '%' . $search_query . '%')
                        ->orWhere('bio', 'like', '%' . $search_query . '%')
                        ->orWhere('ip', 'like', '%' . $search_query . '%');
                })
                ->paginate($data_per_page);
        }

        return view('backend/admins/list', ['admins' => $data]);
    }

    function editor_list(Request $req)
    {
        $data_per_page = 20;

        $data = null;

        if (!$req->has('query')) {
            $data = User::where('role', 'EDITOR')->paginate($data_per_page);
        }

        if ($req->has('query')) {
            $search_query = $req->input('query');
            $data = User::where('role', 'EDITOR')
                ->where(function (Builder $query) use ($search_query) {
                    $query->where('user_id', 'like', '%' . $search_query . '%')
                        ->orWhere('firstname', 'like', '%' . $search_query . '%')
                        ->orWhere('lastname', 'like', '%' . $search_query . '%')
                        ->orWhere('username', 'like', '%' . $search_query . '%')
                        ->orWhere('email', 'like', '%' . $search_query . '%')
                        ->orWhere('phone', 'like', '%' . $search_query . '%')
                        ->orWhere('country', 'like', '%' . $search_query . '%')
                        ->orWhere('city', 'like', '%' . $search_query . '%')
                        ->orWhere('address', 'like', '%' . $search_query . '%')
                        ->orWhere('bio', 'like', '%' . $search_query . '%')
                        ->orWhere('ip', 'like', '%' . $search_query . '%');
                })
                ->paginate($data_per_page);
        }

        return view('backend/editors/list', ['editors' => $data]);
    }


    function list(Request $req)
    {
        $data_per_page = 20;

        $data = null;

        if (!$req->has('type') && !$req->has('query')) {
            $data = User::paginate($data_per_page);
        }

        if ($req->has('type') && $req->has('value')) {
            if ($req->input('type') == "email") {

                if ($req->input('value') == "verified") {
                    $data = User::whereNotNull('email_verified_at')->paginate($data_per_page);
                } elseif ($req->input('value') == "unverified") {
                    $data = User::whereNull('email_verified_at')->paginate($data_per_page);
                } else {
                    return redirect()->back()->with('error', 'Only Verified and Unverified allowed for emails');
                }
            } elseif ($req->input('type') == "status") {

                if ($req->input('value') == "deactivated") {
                    $data = User::where('status', 0)->paginate($data_per_page);
                } elseif ($req->input('value') == "activated") {
                    $data = User::where('status', 1)->paginate($data_per_page);
                } elseif ($req->input('value') == "pending") {
                    $data = User::where('status', 2)->paginate($data_per_page);
                } elseif ($req->input('value') == "suspended") {
                    $data = User::where('status', 3)->paginate($data_per_page);
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Only Deactivated, Activated, Pending and Suspended allowed for status');
                }
            } elseif ($req->input('type') == "verified") {

                if ($req->input('value') == "notsubmitted") {
                    $data = User::where('verified', 0)->paginate($data_per_page);
                } elseif ($req->input('value') == "verified") {
                    $data = User::where('verified', 1)->paginate($data_per_page);
                } elseif ($req->input('value') == "cancelled") {
                    $data = User::where('verified', 2)->paginate($data_per_page);
                } elseif ($req->input('value') == "processing") {
                    $data = User::where('verified', 3)->paginate($data_per_page);
                } else {
                    return redirect()
                        ->back()
                        ->with('error', 'Only Notsubmitted, Verified, Cancelled and Processing allowed for status');
                }
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'Invalid Type, only Email, Status and Verified allowed');
            }
        }


        if ($req->has('query')) {
            $data = User::where('user_id', 'like', '%' . $req->input('query') . '%')
                ->orWhere('role', 'like', '%' . $req->input('query') . '%')
                ->orWhere('firstname', 'like', '%' . $req->input('query') . '%')
                ->orWhere('lastname', 'like', '%' . $req->input('query') . '%')
                ->orWhere('username', 'like', '%' . $req->input('query') . '%')
                ->orWhere('email', 'like', '%' . $req->input('query') . '%')
                ->orWhere('phone', 'like', '%' . $req->input('query') . '%')
                ->orWhere('country', 'like', '%' . $req->input('query') . '%')
                ->orWhere('city', 'like', '%' . $req->input('query') . '%')
                ->orWhere('address', 'like', '%' . $req->input('query') . '%')
                ->orWhere('bio', 'like', '%' . $req->input('query') . '%')
                ->orWhere('ip', 'like', '%' . $req->input('query') . '%')
                ->paginate($data_per_page);
        }

        return view('backend/users/list', ['users' => $data]);
    }

    function user($id)
    {
        $data = User::find($id);

        return view('backend/users/detail', ['user' => $data]);
    }

    function edit($id)
    {
        $data = User::find($id);
        $roles = DB::table('roles')->pluck('name');

        return view('backend/users/edit', ['user' => $data, 'roles' => $roles]);
    }

    function editController(Request $req)
    {
        $user = User::find($req->id);

        $user->role = $req->role;
        if ($req->email_verified_at == "CANCEL") {
            $user->email_verified_at = null;
        }
        $user->status = $req->status;
        $user->verified = $req->verified;

        $user->save();

        return redirect('/backend/users/edit/' . $req->id)
            ->with('message', 'User Updated');
    }
}
