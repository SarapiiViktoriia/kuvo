<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
class ApiUnitController extends Controller
{
    public function index()
    {
        return UnitResource::collection(Unit::all());
    }
    public function store(Request $request)
    {
        $data = Unit::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = Unit::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = Unit::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        $data = Unit::findOrFail($id);
        $data->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus',
            'data' => null
        ]);
    }
}
