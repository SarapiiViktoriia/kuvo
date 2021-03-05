<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
class ApiPurchaseController extends Controller
{
    public function index()
    {
        return PurchaseResource::collection(Purchase::all());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => 'required',
            'arrival_date' => 'required|date'
        ]);
        $data = Purchase::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = Purchase::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'supplier_id' => 'required',
            'arrival_date' => 'required|date'
        ]);
        $data = Purchase::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        $data = Purchase::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
            'data' => null
        ]);
    }
}
