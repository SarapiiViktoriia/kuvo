<?php
namespace App\Http\Controllers;
use App\Models\ItemGroup;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemGroupController extends Controller
{
    public function anyData()
    {
        $item_groups = ItemGroup::leftJoin('item_groups as parent', 'item_groups.parent_id', '=', 'parent.id')->select('item_groups.*', 'parent.name as parent_name');
        return Datatables::of($item_groups)
        ->addColumn('action', function ($item_group) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-info" name="btn-edit-item-group" data-id='.$item_group->id.'>Ubah</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" name="btn-destroy-item-group" data-id='.$item_group->id.'>Hapus</button>';
            return $btn;
        })
        ->filterColumn('parent_name', function ($query, $keyword){
            $query->whereRaw('parent.name LIKE ?', ["%$keyword%"]);
        })
        ->make(true);
    }
    public function fetchItemGroups()
    {
        $item_groups = ItemGroup::pluck('name', 'id');
        return response()->json(['item_groups' => $item_groups]);
    }
    public function index()
    {
        return view('item-groups.index');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $item_group = ItemGroup::create($request->all());
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
            'name' => 'required',
            'parent_id' => 'not_in:'.$id
        ]);
        $item_group = ItemGroup::find($id);
        $item_group->update($request->all());
    }
    public function destroy($id)
    {
        $parents = ItemGroup::where('parent_id', $id)->count();
        $item_group = ItemGroup::find($id);
        if ($parents > 0) {
            return response()->json(['message' => 'Grup Barang '.$item_group->name.' masih menjadi parent', 'status' => 'canceled']);
        }else{
            $item_group->delete();
            return response()->json(['message' => 'Grup Barang '.$item_group->name.' berhasil dihapus', 'status' => 'destroyed']);
        }
    }
}
