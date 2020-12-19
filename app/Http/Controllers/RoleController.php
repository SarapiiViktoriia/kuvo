<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
class RoleController extends Controller
{
    public function anyData()
    {
        $roles = Role::select('roles.*');
        return Datatables::of($roles)
        ->addColumn('action', function ($role) {
            $btn = '';
            $btn .= '<a class="mb-xs mt-xs mr-xs modal-edit-role btn btn-primary" href="#modal-edit-role" data-id='.$role->id.'>Ubah</a>';
            return $btn;
        })
        ->toJson();
    }
    public function index()
    {
        $data['permissions'] = Permission::orderBy('name')->pluck('name', 'id');
        return view('roles.index', $data);
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles',
        ]);
        $role = new Role([
            'name' => ucfirst($request['name']),
        ]);
        $role->save();
        $role->syncPermissions($request->permissions ? $request->permissions : []);
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
            'name' => 'required|unique:roles,name,'.$id,
        ]);
        $role = Role::find($id);
        $role->update([
            'name' => ucfirst($request['name'])
        ]);
        $role->syncPermissions($request->permissions ? $request->permissions : []);
    }
    public function destroy($id)
    {
    }
    public function getPermissionsFromARole($id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions()->pluck('id');
        return response()->json(['permissions' => $permissions]);
    }
    public function getPermissionsFromRoles(Request $request)
    {
        $roles = Role::find($request['role_ids']);
        $permission_ids = [];
        if ($roles) {
            foreach ($roles as $role) {
                $permission_id = $role->permissions()->pluck('id')->toArray();
                foreach ($permission_id as $key => $value) {
                    array_push($permission_ids, $value);
                }
            }
        }
        array_unique($permission_ids);
        return response()->json(['permissions' => $permission_ids]);
    }
}
