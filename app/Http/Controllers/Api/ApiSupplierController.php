<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
class ApiSupplierController extends Controller
{
    public function index()
    {
        return SupplierResource::collection(Supplier::all());
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['code' => 'required|unique:suppliers',
            'name' => 'required']
        );
        $supplier = Supplier::create($request->all());
    }
    public function show($id)
    {
        $data = Supplier::findOrFail($id);
        return response()->json(['data' => $data]);
    }
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['code' => 'required|unique:suppliers,code,' . $id,
            'name' => 'required']
        );
        $data = Supplier::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        if ($supplier->items->count() > 0) {
            return response()->json([
                'status'  => 'canceled',
                'message' => 'Supplier ' . $supplier->name . ' masih menyuplai item untuk kita.',
                'data'    => null,
            ]);
        }
        else {
            $supplier->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Supplier ' . $supplier->name . ' berhasil dihapus.',
                'data'    => null,
            ]);
        }
    }
}
