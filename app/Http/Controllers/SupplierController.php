<?php
namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class SupplierController extends Controller
{
    public function anyData()
    {
        $suppliers = Supplier::all()->except(['created_at', 'updated_at']);
        return Datatables::of($suppliers)
        ->addColumn('action', function ($supplier) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-info" name="btn-edit-supplier" data-id='.$supplier->id.'>Ubah</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" name="btn-destroy-supplier" data-id='.$supplier->id.'>Hapus</button>';
            return $btn;
        })
        ->make(true);
    }
    public function index()
    {
        return view('suppliers.index');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|unique:suppliers',
            'name' => 'required',
        ]);
        $supplier = Supplier::create($request->all());
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required|unique:suppliers,code,'.$id,
            'name' => 'required',
        ]);
        $supplier = Supplier::find($id);
        $supplier->update($request->all());
    }
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier->items->count() > 0) {
            return response()->json(['message' => 'Supplier '.$supplier->name.' masih menyuplai item', 'status' => 'canceled']);
        }else{
            $supplier->delete();
            return response()->json(['message' => 'Supplier '.$supplier->name.' berhasil dihapus', 'status' => 'destroyed']);
        }
    }
}
