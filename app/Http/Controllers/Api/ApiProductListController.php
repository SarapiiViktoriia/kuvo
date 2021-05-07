<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Models\ProductList;
use Illuminate\Http\Request;
class ApiProductListController extends Controller
{
    public function index()
    {
        return ProductListResource::collection(ProductList::all());
    }
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'count' => 'required|numeric',
            'quantifiable_type' => 'required|in:App\Purchase',
            'quantifiable_id' => 'required|numeric',
        ]);
        $data = ProductList::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = ProductList::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id' => 'required',
            'count' => 'required|numeric',
            'quantifiable_type' => 'required|in:App\Purchase',
            'quantifiable_id' => 'required|numeric',
        ]);
        $data = ProductList::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        $data = ProductList::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
            'data' => null
        ]);
    }
}
