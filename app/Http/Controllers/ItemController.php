<?php
namespace App\Http\Controllers;
use App\Models\Item;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemController extends Controller
{
    public function __construct(){
        $this->capital_api    = new \App\Http\Controllers\Api\ApiCapitalPriceController;
        $this->company_api    = new \App\Http\Controllers\Api\ApiCompanyController;
        $this->item_api       = new \App\Http\Controllers\Api\ApiItemController;
        $this->item_brand_api = new \App\Http\Controllers\Api\ApiItemBrandController;
        $this->item_group_api = new \App\Http\Controllers\Api\ApiItemGroupController;
    }
    public function anyData()
    {
        $items = $this->item_api->query(['supplier', 'itemBrand', 'itemGroup', 'capitalPrices']);
        return Datatables::of($items)
            ->addColumn('hpp', function (Item $item) {
                return $item->capitalPrices->map(function ($price) {
                    setlocale(LC_MONETARY, config('app.faker_locale'));
                    return money_format('%n', $price->value);
                })->last();
            })
            ->addColumn('action', function ($item) {
                $button  = '';
                $button .= '<button type="button" class="btn btn-link btn-xs mr-xs" name="btn-destroy-item" data-id="' . $item->id . '"><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
                $button .= '<button type="button" class="btn btn-link btn-xs mr-xs" name="btn-edit-item" data-id="' . $item->id . '"><span class="fa fa-edit"></span> ' . ucwords(__('perbarui')) . '</button>';
                $button .= '<button type="button" class="btn btn-link btn-xs" name="btn-show-item" data-id="' . $item->id . '"><span class="fa fa-eye"></span> ' . ucwords(__('lihat')) . '</button>';
                return $button;
            })
            ->make(true);
    }
    public function index()
    {
        $data['item_brands'] = $this->item_brand_api->index();
        $data['item_groups'] = $this->item_group_api->index();
        $data['suppliers']   = $this->company_api->getByType('supplier');
        return view('items.index', $data);
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        return $this->item_api->store($request);
    }
    public function show($id)
    {
        $data['item'] = $this->item_api->show($id)->getData()->data;
        return view('items._show', $data);
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        return $this->item_api->update($request, $id);
    }
    public function destroy($id)
    {
        return $this->item_api->destroy($id);
    }
    public function fetchIdSuppliersForItem($id)
    {
        $data = $this->item_api->show($id)->getData()->data;
        return response()->json([
            'data' => $data
        ]);
    }
    public function fetchItems()
    {
        $items = Item::pluck('name', 'id');
        return response()->json(['items' => $items]);
    }
}
