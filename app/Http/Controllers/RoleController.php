<?php
namespace App\Http\Controllers;
use DB;
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
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-role" data-id='.$role->id.'><span class="fa fa-edit"></span> ' . ucwords(__('ubah')) . '</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" name="btn-destroy-role" data-id='.$role->id.'><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
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
        $role = Role::find($id);
        DB::table('model_has_roles')->where('role_id', $id)->delete();
        $role->syncPermissions([]);
        $role->delete();
        return response()->json(['message' => 'Role '.$role->name.' berhasil dihapus', 'status' => 'destroyed']);
    }
    public function fetchIdPermissionsForRole($id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions()->pluck('id');
        return response()->json(['permission_ids' => $permissions]);
    }
    public function fetchIdPermissionsForRoles(Request $request)
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
        return response()->json(['permission_ids' => $permission_ids]);
    }
}
