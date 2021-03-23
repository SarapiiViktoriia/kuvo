<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Api\ApiItemBrandController;
use App\Models\ItemBrand;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemBrandController extends Controller
{
    public function anyData()
    {
        $models = ItemBrand::query();
        return Datatables::of($models)
        ->addColumn('action', function ($model) {
            $button  = '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-default" name="btn-destroy-item-brand" data-id=' . $model->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
            $button .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-item-brand" data-id=' . $model->id . '><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
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
    }
    public function store(Request $request)
    {
        $api = new ApiItemBrandController;
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
        $api = new ApiItemBrandController;
        return $api->update($request, $id);
    }
    public function destroy($id)
    {
        $api = new ApiItemBrandController;
        return $api->destroy($id);
    }
}
