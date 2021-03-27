<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use Illuminate\Http\Request;
class ApiItemController extends Controller
{
    public function index()
    {
        return ItemResource::collection(Item::all());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'sku'           => 'required|unique:items',
            'name'          => 'required',
            'item_group_id' => 'required',
            'item_brand_id' => 'required',
            'supplier_id'   => 'required'
        ]);
        $item = Item::create($request->all());
    }
    public function show($id)
    {
        $data = Item::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sku'           => 'required|unique:items,sku,' . $id,
            'name'          => 'required',
            'item_group_id' => 'required',
            'item_brand_id' => 'required',
            'supplier_id'   => 'required'
        ]);
        $data = Item::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function destroy($id)
    {
        $data = Item::findOrFail($id);
        $data->delete();
        return response()->json([
            'status'  => 'success',
            'message' => 'Produk ' . $data->name . ' berhasil dihapus',
            'data'    => null
        ]);
    }
}
