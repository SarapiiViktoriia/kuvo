<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\ItemGroup;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemGroupResource;
class ApiItemGroupController extends Controller
{
    public function index()
    {
        return ItemGroupResource::collection(ItemGroup::all());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $data = ItemGroup::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = ItemGroup::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'parent_id' => 'not_in:'.$id
        ]);
        $data = ItemGroup::find($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        $parents    = ItemGroup::where('parent_id', $id)->count();
        $data = ItemGroup::findOrFail($id);
        if ($parents > 0) {
            return response()->json([
                'status' => 'canceled',
                'message' => 'Grup Barang '.$data->name.' masih menjadi induk',
                'data' => null 
            ]);
        }
        else {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Grup Barang '.$data->name.' berhasil dihapus',
                'data' => null
            ]);
        }
    }
}
