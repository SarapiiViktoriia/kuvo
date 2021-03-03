<?php
namespace App\Http\Controllers;
use App\Models\ItemBrand;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class ItemBrandController extends Controller
{
    public function anyData()
    {
        $item_brands = ItemBrand::select('item_brands.*');
        return Datatables::of($item_brands)
        ->addColumn('action', function ($item_brand) {
            $btn = '';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-info" name="btn-edit-item-brand" data-id=' . $item_brand->id . '><span class="fa fa-edit"></span> ' . ucwords(__('ubah')) . '</button>';
                $btn .= '<button type="button" class="mb-xs mt-xs mr-xs btn btn-xs btn-danger" name="btn-destroy-item-brand" data-id=' . $item_brand->id . '><span class="fa fa-trash-o"></span> ' . ucwords(__('hapus')) . '</button>';
            return $btn;
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
        $this->validate($request, ['name' => 'required']);
        $item_brand = ItemBrand::create($request->all());
    }
    public function show($id)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required']);
        $item_brand = ItemBrand::find($id);
        $item_brand->update($request->all());
    }
    public function destroy($id)
    {
        $item_brand = ItemBrand::find($id);
        if ($item_brand->items->count() > 0) {
            return response()->json(['message' => 'Brand ' . $item_brand->name . ' masih dimiliki oleh barang', 'status' => 'canceled']);
        }
        else {
            $item_brand->delete();
            return response()->json(['message' => 'Brand ' . $item_brand->name . ' berhasil dihapus', 'status' => 'destroyed']);
        }
    }
}
