<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StockResource;
use App\Models\Stock;
class ApiStockController extends Controller
{
    public function index()
    {
        return StockResource::collection(Stock::all());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'item_id' => 'required',
            'unit_id' => 'required',
        ]);
        $request->count = 0;
        $data = Stock::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = Stock::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate([
            'item_id' => 'required',
            'unit_id' => 'required',
        ]);
        $request->count = 0;
        $data = Stock::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        $data = Stock::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
            'data' => null
        ]);
    }
    public function query($relation = [])
    {
        if (isset($relation) || '' !== $relation) {
            $data = Stock::with($relation)->selectRaw('distinct stocks.*');
        }
        else {
            $data = Stock::query();
        }
        return $data;
    }
}
