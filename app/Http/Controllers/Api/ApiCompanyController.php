<?php
namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
class ApiCompanyController extends Controller
{
    public function index()
    {
        return CompanyResource::collection(Company::all());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:companies',
            'name' => 'required'
        ]);
        if (count($request->type) == 2) {
            $type = 'both';
        }
        else {
            $type = implode(',', $request->type);
        }
        $data = Company::create([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $type
        ]);
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function show($id)
    {
        $data = Company::findOrFail($id);
        return response()->json(['data'   => $data]);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|unique:companies,code,' . $id,
            'name' => 'required'
        ]);
        $data = Company::findOrFail($id);
        if (null !== $request->type) {
            if (count($request->type) == 2) {
                $request->type == 'both';
            }
        }
        $data->update($request->all());
        return response()->json([
            'status' => 'success',
            'data'   => $data
        ]);
    }
    public function destroy($id)
    {
        $data = Company::findOrFail($id);
        if ($data->items->count() > 0) {
            return response()->json([
                'status'  => 'canceled',
                'message' => 'Supplier ' . $data->name . ' masih memiliki produk yang terdaftar.',
                'data'    => null,
            ]);
        }
        else {
            $data->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Supplier ' . $data->name . ' berhasil dihapus.',
                'data'    => null
            ]);
        }
    }
    public function fetchSuppliers()
    {
        $suppliers = Company::whereIn('type', ['supplier', 'both'])->get();
        return CompanyResource::collection($suppliers);
    }
    public function getByType($type, $collection = true)
    {
        $data = Company::whereIn('type', [$type, 'both'])->get();
        if (true == $collection) {
            return CompanyResource::collection($data);
        }
        else {
            return $data;
        }
    }
}
