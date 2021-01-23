<?php
namespace App\Http\Controllers;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemStockController extends Controller
{
    public function anyData()
    {
        $item_stocks = ItemStock::with(['inventoryUnit', 'item'])->select('item_stocks.*');
        return Datatables::of($item_stocks)
        ->addColumn('action', function ($item_stock) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-info" name="btn-edit-item-stock" data-id='.$item_stock->id.'>Ubah</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" name="btn-destroy-item-stock" data-id='.$item_stock->id.'>Hapus</button>';
            return $btn;
        }) 
        ->make(true);
    }
    public function index()
    {
        return view('item-stocks.index');
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'inventory_unit_id' => 'required',
            'item_id' => 'required',
            'count' => 'required|min:0'
        ]);
        $item_stock = ItemStock::create($request->all());
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'inventory_unit_id' => 'required',
            'item_id' => 'required',
            'count' => 'required|min:0'
        ]);
        $item_stock = ItemStock::find($id);
        $item_stock->update($request->all());
    }
    public function destroy($id)
    {
        $item_stock = ItemStock::find($id);
        $item_stock->delete();
        return response()->json(['message' => 'Stok barang '.$item_stock->item->name.' di gudang '.$item_stock->inventoryUnit->name.' berhasil dihapus', 'status' => 'destroyed']);
    }
}
