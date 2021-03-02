<?php
namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class CompanyController extends Controller
{
    public function index()
    {
        return view('companies.index');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            ['code' => 'required|unique:companies',
            'name'  => 'required']
        );
        $company = Company::create($request->all());
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            ['code' => 'required|unique:companies,id,' . $id,
            'name'  => 'required']
        );
        $company = Company::findOrFail($id);
        $company->update(['name' => $request->name]);
        return redirect()->route('companies.index');
    }
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json([
            'message' => 'Supplier ' . $supplier->name . ' berhasil dihapus',
            'status' => 'destroyed']);
    }
    public function anyData()
    {
        $companies = Company::select('companies.*');
        return Datatables::of($companies)
        ->addColumn(
            'action',
            function ($company) {
                $button  = '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-company" data-id=' . $company->id . '><span class="fa fa-edit"></span> ' . ucwords(__('ubah')) . '</button>';
                return $button;
            })
        ->toJson();
    }
}
