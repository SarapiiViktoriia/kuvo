<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Api\ApiItemGroupController;
use App\Models\ItemGroup;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemGroupController extends Controller
{
    public function anyData()
    {
        $models = ItemGroup::leftJoin('item_groups as parent', 'item_groups.parent_id', '=', 'parent.id')
            ->select('item_groups.*', 'parent.name as parent_name');
        return Datatables::of($models)
            ->addColumn('action', function ($model) {
                $button  = '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-default" name="btn-destroy-item-group" data-id=' . $model->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
                $button .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-item-group" data-id=' . $model->id . '><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
                return $button;
            })
            ->filterColumn('parent_name', function ($query, $keyword){
                $query->whereRaw('parent.name LIKE ?', ["%$keyword%"]);
            })
            ->make(true);
    }
    public function fetchItemGroups()
    {
        $item_groups = ItemGroup::pluck('name', 'id');
        return response()->json(['item_groups' => $item_groups]);
    }
    public function index()
    {
        return view('item-groups.index');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $api = new ApiItemGroupController;
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
        $api = new ApiItemGroupController;
        return $api->update($request, $id);
    }
    public function destroy($id)
    {
        $api = new ApiItemGroupController;
        return $api->destroy($id);
    }
}
