<?php
namespace App\Http\Controllers;
use App\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
class ProfileController extends Controller
{
    public function anyData()
    {
        $profiles = Profile::select('profiles.*');
        return Datatables::of($profiles)
        ->addColumn('account', function ($profile) {
            return $profile->user ? $profile->user->name : '-';
        })
        ->addColumn('action', function ($profile) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-profile" data-id='.$profile->id.'><span class="fa fa-edit"></span> ' . ucwords(__('ubah')) . '</button>';
            return $btn;
        })
        ->toJson();
    }
    public function index()
    {
        $data['users'] = User::whereNull('profile_id')->orderBy('name')->pluck('name', 'id');
        $data['roles'] = Role::orderBy('name')->pluck('name', 'id');
        $data['permissions'] = Permission::orderBy('name')->pluck('name', 'id');
        return view('profiles.index', $data);
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);
        $profile = new Profile([
            'name' => $request['name'],
        ]);
        $profile->save();
        if ($request['user_id']) {
            $user = User::find($request['user_id']);
            $user->update([
                'profile_id' => $profile->id,
            ]);
        }
        $profile->syncRoles($request->roles ? $request->roles : []);
        $profile->syncPermissions($request->permissions ? $request->permissions : []);
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);
        $profile = Profile::find($id);
        $profile->update([
            'name' => $request['name'],
        ]);
        if ($request['user_id']) {
            $user = User::find($request['user_id']);
            $user->update([
                'profile_id' => $profile->id,
            ]);
        }
        $profile->syncRoles($request->roles ? $request->roles : []);
        $profile->syncPermissions($request->permissions ? $request->permissions : []);
        return redirect()->route('profiles.index');
    }
    public function destroy($id)
    {
    }
    public function fetchIdRolesForProfile($id)
    {
        $profile = Profile::find($id);
        $roles = $profile->roles()->pluck('id');
        return response()->json(['role_ids' => $roles]);
    }
    public function fetchIdPermissionsForProfile($id)
    {
        $profile = Profile::find($id);
        $permissions = $profile->permissions()->pluck('id');
        return response()->json(['permission_ids' => $permissions]);
    }
    public function fetchProfiles()
    {
        $profiles = Profile::whereDoesntHave('user')->orderBy('name')->pluck('name', 'id');
        return response()->json(['profiles' => $profiles]);
    }
}
