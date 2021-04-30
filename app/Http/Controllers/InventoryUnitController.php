<?php
namespace App\Http\Controllers;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class InventoryUnitController extends Controller
{
    public function __construct()
    {
        $this->unit_api = new \App\Http\Controllers\Api\ApiUnitController;
    }
    public function anyData()
    {
        $inventory_units = $this->unit_api->query();
        return Datatables::of($inventory_units)
        ->addColumn('action', function ($inventory_unit) {
            $button  = '';
            $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-destroy-inventory-unit" data-id=' . $inventory_unit->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
            $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-edit-inventory-unit" data-id=' . $inventory_unit->id . '><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
            return $button;
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
        return $this->unit_api->store($request);
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        return $this->unit_api->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->unit_api->destroy($id);
    }
    public function fetchInventoryUnits()
    {
        return $this->unit_api->getUnits('inventory_units');
    }
}
