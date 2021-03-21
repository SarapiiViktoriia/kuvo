<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CapitalPriceResource;
use App\Models\CapitalPrice;
class ApiCapitalPriceController extends Controller
{
    public function index()
    {
        return CapitalPriceResource::collection(CapitalPrice::all());
    }
    public function store(Request $request)
    {
        $this->validate([
            'item_id' => 'required',
            'value' => 'required',
        ]);
        $data = CapitalPrice::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = CapitalPrice::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate([
            'item_id' => 'required',
            'value' => 'required',
        ]);
        $data = CapitalPrice::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        $data = CapitalPrice::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
            'data' => null
        ]);
    }
}
