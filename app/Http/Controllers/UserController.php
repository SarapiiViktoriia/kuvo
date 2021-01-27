<?php
namespace App\Http\Controllers;
use App\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class UserController extends Controller
{
    public function __construct()
    {
        $this->default_password = env('DEFAULT_PASSWORD', 'password');
    }
    public function anyData()
    {
        $users = User::with('profile')->select('users.*');
        return Datatables::of($users)
        ->addColumn('profile', function ($user) {
            return $user->profile ? $user->profile->name : '-';
        })
        ->addColumn('action', function ($user) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-user" data-id='.$user->id.'>Ubah</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" name="btn-destroy-user" data-id='.$user->id.'>Hapus</button>';
            return $btn;
        })
        ->toJson();
    }
    public function index()
    {
        $data['profiles'] = Profile::whereDoesntHave('user')->orderBy('name')->pluck('name', 'id');
        return view('users.index', $data);
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
        ]);
        $user = new User([
            'name' => $request['name'],
            'email' => $request['email'],
            'username' => $request['username'],
            'password' => bcrypt($this->default_password),
            'profile_id' => $request['profile_id'],
        ]);
        $user->save();
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
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|unique:users,username,'.$id,
            'password' => 'confirmed'
        ]);
        $user = User::find($id);
        $user->update([
            'email' => $request['email'],
            'username' => $request['username'],
            'profile_id' => $request['profile_id'],
        ]);
        if ($request['password']) {
            $user->update([
                'password' => bcrypt($request['password']),
            ]);
        }
    }
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user->username == 'admin') {
            return response()->json(['message' => "Maaf, pengguna $user->name tidak diperbolehkan dihapus.", 'status' => 'error']);
        }
        else {
            $user->delete();
            return response()->json(['message' => 'User '.$user->name.' berhasil dihapus', 'status' => 'destroyed']);
        }
    }
}
