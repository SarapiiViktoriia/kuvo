<?php
namespace App\Http\Controllers;
use App\Models\InventoryUnit;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class InventoryUnitController extends Controller
{
    public function anyData()
    {
        $inventory_units = InventoryUnit::select('inventory_units.*');
        return Datatables::of($inventory_units)
        ->addColumn('action', function ($inventory_unit) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-info" name="btn-edit-inventory-unit" data-id='.$inventory_unit->id.'>Ubah</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" name="btn-destroy-inventory-unit" data-id='.$inventory_unit->id.'>Hapus</button>';
            return $btn;
        })
        ->make(true);
    }
    public function index()
    {
        return view('inventory-units.index');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $inventory_unit = InventoryUnit::create($request->all());
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
            'name' => 'required',
        ]);
        $inventory_unit = InventoryUnit::find($id);
        $inventory_unit->update($request->all());
    }
    public function destroy($id)
    {
        $inventory_unit = InventoryUnit::find($id);
        if (($inventory_unit->itemBundlings->count() > 0) || ($inventory_unit->itemStocks->count() > 0)) {
            return response()->json(['message' => 'Inventory unit '.$inventory_unit->name.' masih berhubungan dengan data lain', 'status' => 'canceled']);
        }else{
            $inventory_unit->delete();
            return response()->json(['message' => 'InventoryUnit '.$inventory_unit->name.' berhasil dihapus', 'status' => 'destroyed']);
        }
    }
}
