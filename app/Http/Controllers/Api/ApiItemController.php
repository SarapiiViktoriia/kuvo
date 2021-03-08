<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Item;
class ApiItemController extends Controller
{
    public function index()
    {
        return ItemResource::collection(Item::all());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:items',
            'name' => 'required',
            'image_url' => 'nullable|url',
            'item_group_id' => 'required',
            'item_brand_id' => 'required'
        ]);
        $item = Item::create($request->except('supplier_id'));
        $item->suppliers()->sync($request->supplier_id ? $request->supplier_id : []);
    }
    public function show($id)
    {
        $data = Item::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|unique:items,code,'.$id,
            'name' => 'required',
            'image_url' => 'nullable|url',
            'item_group_id' => 'required',
            'item_brand_id' => 'required'
        ]);
        $data = Item::findOrFail($id);
        $data->update($request->except('supplier_id'));
        $data->suppliers()->sync($request->supplier_id ? $request->supplier_id : []);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        $data = Item::findOrFail($id);
        $data->suppliers()->detach();
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Barang '.$data->name.' berhasil dihapus',
            'data' => null
        ]);
    }
}
