<?php
namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemController extends Controller
{
    public function __construct(){
        $this->company_api    = new \App\Http\Controllers\Api\ApiCompanyController;
        $this->item_api       = new \App\Http\Controllers\Api\ApiItemController;
        $this->item_brand_api = new \App\Http\Controllers\Api\ApiItemBrandController;
        $this->item_group_api = new \App\Http\Controllers\Api\ApiItemGroupController;
    }
    public function anyData()
    {
        $items = Item::with(['supplier', 'itemBrand', 'itemGroup'])->selectRaw('distinct items.*');
        return Datatables::of($items)
            ->addColumn('action', function ($item) {
                $button  = '';
                $button .= '<button type="button" class="btn btn-default btn-xs mr-xs" name="btn-destroy-item" data-id="' . $item->id . '"><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
                $button .= '<button type="button" class="btn btn-default btn-xs mr-xs" name="btn-edit-item" data-id="' . $item->id . '"><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
                return $button;
            })
            ->make(true);
    }
    public function index()
    {
        $data['item_brands'] = $this->item_brand_api->index();
        $data['item_groups'] = $this->item_group_api->index();
        $data['suppliers']   = $this->company_api->fetchSuppliers();
        return view('items.index', $data);
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->item_api->store($request);
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->item_api->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->item_api->destroy($id);
    }
    public function fetchIdSuppliersForItem($id)
    {
        $item = Item::find($id);
        $data['supplier_ids'] = $item->suppliers->pluck('id');
        return response()->json(['supplier_ids' => $data['supplier_ids']]);
    }
    public function fetchItems()
    {
        $items = Item::pluck('name', 'id');
        return response()->json(['items' => $items]);
    }
}
