<?php
namespace App\Http\Controllers;
use App\Models\ItemBundling;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemBundlingController extends Controller
{
    public function anyData()
    {
        $item_bundlings = ItemBundling::with('inventoryUnit')->select('item_bundlings.*');
        return Datatables::of($item_bundlings)
        ->addColumn('action', function ($item_bundling) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-info" name="btn-edit-item-bundling" data-id='.$item_bundling->id.'>Ubah</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" name="btn-destroy-item-bundling" data-id='.$item_bundling->id.'>Hapus</button>';
            return $btn;
        }) 
        ->make(true);
    }
    public function index()
    {
        return view('item-bundlings.index');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'inventory_unit_id' => 'required',
            'name' => 'required'
        ]);
        $item_bundling = ItemBundling::create($request->all());
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
            'inventory_unit_id' => 'required',
            'name' => 'required'
        ]);
        $item_bundling = ItemBundling::find($id);
        $item_bundling->update($request->all());
    }
    public function destroy($id)
    {
        $item_bundling = ItemBundling::find($id);
        $item_bundling->items()->detach();
        $item_bundling->delete();
        return response()->json(['message' => 'Item bundling '.$item_bundling->name.' berhasil dihapus', 'status' => 'destroyed']);
    }
}
