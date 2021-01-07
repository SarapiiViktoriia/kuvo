<?php
namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemController extends Controller
{
    public function anyData()
    {
        $items = Item::with(['suppliers', 'itemBrand', 'itemGroup'])->selectRaw('distinct items.*');
        return Datatables::of($items)
        ->addColumn('supplier', function (Item $item) {
            return $item->suppliers->map(function($supplier) {
                return $supplier->name;
            })->implode(", ");
        })
        ->addColumn('action', function ($item) {
            $btn = '';
            $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-default" name="btn-show-item" data-id='.$item->id.'>Detail</button>';
            $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-info" name="btn-edit-item" data-id='.$item->id.'>Ubah</button>';
            $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" name="btn-destroy-item" data-id='.$item->id.'>Hapus</button>';
            return $btn;
        })
        ->make(true);
    }
    public function index()
    {
        $data['item_brands'] = \App\Models\ItemBrand::pluck('name', 'id');
        $data['item_groups'] = \App\Models\ItemGroup::pluck('name', 'id');
        $data['suppliers'] = \App\Models\Supplier::pluck('name', 'id');
        return view('items.index', $data);
    }
    public function create()
    {
       $data['item_brands'] = \App\Models\ItemBrand::pluck('name', 'id');
       $data['item_groups'] = \App\Models\ItemGroup::pluck('name', 'id');
       $data['suppliers'] = \App\Models\Supplier::pluck('name', 'id');
       return view('items.create', $data);
   }
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:items',
            'name' => 'required',
            'image_url' => 'nullable|url'
        ]);
        $item = Item::create($request->except('supplier_id'));
        $item->suppliers()->sync($request->supplier_id ? $request->supplier_id : []);
    }
    public function show($id)
    {
        $data['item'] = Item::find($id);
        $data['suppliers'] = $data['item']->suppliers->map(function($supplier) {
            return $supplier->name;
        })->implode(", ");
        return view('items._show', $data);
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|unique:items,code,'.$id,
            'name' => 'required',
            'image_url' => 'nullable|url'
        ]);
        $item = Item::find($id);
        $item->update($request->except('supplier_id'));
        $item->suppliers()->sync($request->supplier_id ? $request->supplier_id : []);
    }
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->suppliers()->detach();
        $item->delete();
        return response()->json(['message' => 'Barang '.$item->name.' berhasil dihapus', 'status' => 'destroyed']);
    }
    public function fetchIdSuppliersForItem($id)
    {
        $item = Item::find($id);
        $data['supplier_ids'] = $item->suppliers->pluck('id');
        return response()->json(['supplier_ids' => $data['supplier_ids']]);
    }
}
