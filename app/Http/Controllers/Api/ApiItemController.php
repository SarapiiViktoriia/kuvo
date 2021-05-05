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
            'name'          => 'required',
            'item_group_id' => 'required',
            'item_brand_id' => 'required',
            'supplier_id'   => 'required'
        ]);
        $this->isDataExist($request->only(['name', 'supplier_id']), null);
        $item = Item::create($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $item
        ]);
    }
    public function show($id)
    {
        $data = Item::with(['itemGroup', 'itemBrand', 'supplier', 'quantities'])->findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'          => 'required',
            'item_group_id' => 'required',
            'item_brand_id' => 'required',
            'supplier_id'   => 'required'
        ]);
        $data = Item::findOrFail($id);
        $this->isDataExist($request->only(['name', 'item_brand_id']), $data);
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
    public function isDataExist($param, $item)
    {
        $is_exist = Item::where($param)->first();
        if ($is_exist) {
            if (is_null($item)) {
                return response()->json([
                    'message' => 'Data yang diberikan tidak sah.',
                    'errors'  => [
                        'name' => ['Produk ' . $is_exist->name . ' dengan merek ' . $is_exist->itemBrand->name . ' telah terdaftar.']
                    ]
                ], 422)->throwResponse();
            }
            else if ($is_exist->id !== $item->id) {
                return response()->json([
                    'message' => 'Data yang diberikan tidak sah.',
                    'errors'  => [
                        'name' => ['Produk ' . $is_exist->name . ' dengan merek ' . $is_exist->itemBrand->name . ' telah terdaftar.']
                    ]
                ], 422)->throwResponse();
            }
        }
    }
    public function query($relation = [])
    {
        if (isset($relation) || '' !== $relation) {
            $data = Item::with($relation)->selectRaw('distinct items.*');
        }
        else {
            $data = Item::query();
        }
        return $data;
    }
    public function getCapital($id)
    {
        $data  = Item::findOrFail($id)->capitalPrices->last();
        return $data;
    }
}
