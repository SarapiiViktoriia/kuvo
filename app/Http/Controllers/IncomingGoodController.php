<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class IncomingGoodController extends Controller
{
    public function __construct()
    {
        $this->company_api  = new \App\Http\Controllers\Api\ApiCompanyController;
        $this->item_api     = new \App\Http\Controllers\Api\ApiItemController;
        $this->purchase_api = new \App\Http\Controllers\Api\ApiPurchaseController;
    }
    public function index()
    {
        return redirect()->route('incoming-goods.create');
    }
    public function create()
    {
        $data['suppliers'] = $this->company_api->getByType('supplier');
        $data['items']     = $this->item_api->index();
        return view('incoming-goods.create', $data);
    }
    public function store(Request $request)
    {
        $purchase = $this->purchase_api->store($request)->getData()->data;
        foreach ($request->item as $key => $value) {
            $item = \App\Models\Item::findOrFail($value['id']);
            $quantity = new \App\Models\ProductList;
            $quantity->count             = $value['count'];
            $quantity->quantifiable_id   = $purchase->id;
            $quantity->quantifiable_type = '\App\Models\Purchase';
            $item->quantities()->save($quantity);
        }
        return redirect()->route('stocks.index');
    }
    public function show($id)
    {
        return redirect()->route('incoming-goods.create');
    }
    public function edit($id)
    {
        return redirect()->route('incoming-goods.create');
    }
    public function update(Request $request, $id)
    {
        return redirect()->route('incoming-goods.create');
    }
    public function destroy($id)
    {
        return redirect()->route('incoming-goods.create');
    }
    public function chooseItem(Request $request)
    {
        $data['price_text'] = number_format($request['capital_price'], 2, ',', '.');
        $data['item_price'] = $request['capital_price'];
        $data['item']       = $this->item_api->show($request['product'])->getData()->data;
        $data['item_count'] = $request['count'];
        return view('incoming-goods.selected-item', $data);
    }
}
