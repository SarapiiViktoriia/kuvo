<?php
namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\Stock;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class StockController extends Controller
{
    public function __construct()
    {
        $this->item_api  = new \App\Http\Controllers\Api\ApiItemController;
        $this->stock_api = new \App\Http\Controllers\Api\ApiStockController;
    }
    public function index()
    {
        return view('stocks.index');
    }
    public function create()
    {
        return redirect()->route('stocks.index');
    }
    public function store(Request $request)
    {
        return redirect()->route('stocks.index');
    }
    public function show($id)
    {
        return redirect()->route('stocks.index');
    }
    public function edit($id)
    {
        return redirect()->route('stocks.index');
    }
    public function update(Request $request, $id)
    {
        return redirect()->route('stocks.index');
    }
    public function destroy($id)
    {
        return redirect()->route('stocks.index');
    }
    public function setDatatable()
    {
        $query = $this->item_api->query(['supplier', 'itemBrand', 'itemGroup', 'stocks', 'quantities']);
        return Datatables::of($query)
        ->addcolumn('stock', function (Item $item) {
            return $item->stocks->map(function ($stock) {
                return $stock->count;
            })->last();
        })
        ->make(true);
    }
}
