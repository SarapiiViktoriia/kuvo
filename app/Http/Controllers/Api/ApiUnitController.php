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
        $this->validate($request, [
            'label'  => 'required',
            'pieces' => 'required'
        ]);
        $data = Unit::create($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
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
            'data'   => $data
        ]);
    }
    public function destroy($id)
    {
        $data = Unit::findOrFail($id);
        if ($data->stocks->count() > 0) {
            return response()->json([
                'status'  => 'canceled',
                'message' => 'Satuan ' . $data->label . ' ' . $data->pieces . ' masih digunakan dalam data stok.',
                'data'    => null
            ]);
        }
        else {
            $data->delete();
            return response()->json([
                'status'  => 'destroyed',
                'message' => 'Satuan ' .$data->label . ' ' . $data->pieces . ' berhasil dihapus.',
                'data'    => null
            ]);
        }
    }
    public function query($relation = [])
    {
        if (isset($relation) || '' !== $relation) {
            $data = Unit::with($relation)->selectRaw('distinct units.*');
        }
        else {
            $data = Unit::query();
        }
        return $data;
    }
    public function getUnits($name)
    {
        $data = Unit::pluck('label', 'id');
        return response()->json([$name => $data]);
    }
}
