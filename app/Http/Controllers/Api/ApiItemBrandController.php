<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemBrandResource;
use App\Models\ItemBrand;
use Illuminate\Http\Request;
class ApiItemBrandController extends Controller
{
    public function index()
    {
        return ItemBrandResource::collection(ItemBrand::all());
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['name' => 'required|unique:item_brands']
        );
        $data = ItemBrand::create($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function show($id)
    {
        $data = ItemBrand::findOrFail($id);
        return response()->json(['data' => $data]);
    }
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name' => 'required|unique:item_brands,name,' . $id]
        );
        $data = ItemBrand::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function destroy($id)
    {
        $item_brand = ItemBrand::findOrFail($id);
        if ($item_brand->items->count() > 0) {
            return response()->json([
                'status'  => 'canceled',
                'message' => 'Brand ' . $item_brand->name . ' masih digunakan dalam produk.',
                'data'    => null
            ]);
        }
        else {
            $item_brand->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Brand ' . $item_brand->name . ' berhasil dihapus',
                'data'    => null
            ]);
        }
    }
}
