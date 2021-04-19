<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Api\ApiItemGroupController;
use App\Models\ItemGroup;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemGroupController extends Controller
{
    private $item_group_api;
    public function __construct()
    {
        $this->item_group_api = new ApiItemGroupController;
    }
    public function anyData()
    {
        $models = $this->item_group_api->query();
        return Datatables::of($models)
            ->addColumn('action', function ($model) {
                $button  = '';
                $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-destroy-item-group" data-id=' . $model->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
                $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-edit-item-group" data-id=' . $model->id . '><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
                $button .= '<button type="button" class="btn btn-link btn-xs mb-xs mt-xs mr-xs" name="btn-show-item-group" data-id=' . $model->id . '><span class="fa fa-eye"></span> ' . ucwords(__('lihat')) . '</button>';
                return $button;
            })
            ->filterColumn('parent_name', function ($query, $keyword){
                $query->whereRaw('parent.name LIKE ?', ["%$keyword%"]);
            })
            ->make(true);
    }
    public function fetchItemGroups()
    {
        $item_groups = $this->item_group_api->getByColumn('name', 'id');
        return response()->json(['item_groups' => $item_groups]);
    }
    public function index()
    {
        return view('item-groups.index');
    }
    public function create()
    {
        return redirect()->route('item-groups.index');
    }
    public function store(Request $request)
    {
        return $this->item_group_api->store($request);
    }
    public function show($id)
    {
        return redirect()->route('item-groups.index');
    }
    public function edit($id)
    {
        return redirect()->route('item-groups.index');
    }
    public function update(Request $request, $id)
    {
        return $this->item_group_api->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->item_group_api->destroy($id);
    }
}
