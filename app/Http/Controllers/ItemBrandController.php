<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Api\ApiItemBrandController;
use App\Models\ItemBrand;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemBrandController extends Controller
{
    private $brand_api;
    public function __construct()
    {
        $this->brand_api = new ApiItemBrandController;
    }
    public function anyData()
    {
        $models = $this->brand_api->query();
        return Datatables::of($models)
        ->addColumn('action', function ($model) {
            $button  = '';
            $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-destroy-item-brand" data-id=' . $model->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
            $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-edit-item-brand" data-id=' . $model->id . '><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
            $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-show-item-brand" data-id=' . $model->id . '><span class="fa fa-eye"></span> ' . ucwords(__('lihat')) . '</button>';
            return $button;
        })
        ->make(true);
    }
    public function index()
    {
        return view('item-brands.index');
    }
    public function create()
    {
        return redirect()->route('item-brands.index');
    }
    public function store(Request $request)
    {
        return $this->brand_api->store($request);
    }
    public function show($id)
    {
        return redirect()->route('item-brands.index');
    }
    public function edit($id)
    {
        return redirect()->route('item-brands.index');
    }
    public function update(Request $request, $id)
    {
        return $this->brand_api->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->brand_api->destroy($id);
    }
}
