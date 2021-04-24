<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Api\ApiCompanyController;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class SupplierController extends Controller
{
    private $company_api;
    public function __construct()
    {
        $this->company_api = new ApiCompanyController;
    }
    public function anyData()
    {
        $models = $this->company_api->getByType('supplier', false);
        return Datatables::of($models)
        ->addColumn('action', function ($model) {
            $button  = '<button type="button" class="btn btn-xs btn-link mb-xs mt-xs mr-xs" name="btn-destroy-supplier" data-id=' . $model->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
            $button .= '<button type="button" class="btn btn-xs btn-link mb-xs mt-xs mr-xs" name="btn-edit-supplier" data-id=' . $model->id . '><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
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
        return redirect()->route('suppliers.index');
    }
    public function store(Request $request)
    {
        $request->request->add(['type' => ['supplier']]);
        return $this->company_api->store($request);
    }
    public function show($id)
    {
        return redirect()->route('suppliers.index');
    }
    public function edit($id)
    {
        return redirect()->route('suppliers.index');
    }
    public function update(Request $request, $id)
    {
        return $this->company_api->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->company_api->destroy($id);
    }
}
