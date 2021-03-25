<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Api\ApiCompanyController;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class SupplierController extends Controller
{
    public function anyData()
    {
        $models = Company::query()->whereIn('type', ['supplier', 'both']);
        return Datatables::of($models)
        ->addColumn('action', function ($model) {
            $button  = '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-default" name="btn-destroy-supplier" data-id=' . $model->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
            $button .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-supplier" data-id=' . $model->id . '><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
            return $button;
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
        $api = new ApiCompanyController;
        $api->store($request);
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $api = new ApiCompanyController;
        return $api->update($request, $id);
    }
    public function destroy($id)
    {
        $api = new ApiCompanyController;
        return $api->destroy($id);
    }
}
