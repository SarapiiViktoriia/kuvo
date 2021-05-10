<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemGroupResource;
use App\Models\ItemGroup;
use Illuminate\Http\Request;
class ApiItemGroupController extends Controller
{
    public function index()
    {
        return ItemGroupResource::collection(ItemGroup::all());
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['name' => 'required|unique:item_groups']
        );
        $data = ItemGroup::create($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function show($id)
    {
        $data = ItemGroup::findOrFail($id);
        return response()->json(['data' => $data]);
    }
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['name'     => 'required|unique:item_groups,name,' . $id,
            'parent_id' => 'not_in:' . $id]
        );
        $data = ItemGroup::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function destroy($id)
    {
        $parents = ItemGroup::where('parent_id', $id)->count();
        $data    = ItemGroup::findOrFail($id);
        if ($parents > 0 || $data->items()->count() > 0) {
            if ($parents > 0) {
                return response()->json([
                    'status'  => 'canceled',
                    'message' => 'Kategori produk ' . $data->name . ' merupakan induk kategori.',
                    'data'    => null
                ]);
            }else{
                return response()->json([
                    'status'  => 'canceled',
                    'message' => 'Kategori produk ' . $data->name . ' masih dimiliki produk yang lain.',
                    'data'    => null
                ]);
            }        
        }
        else {
            $data->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Kategori produk ' . $data->name . ' berhasil dihapus.',
                'data'    => null
            ]);
        }
    }
}
