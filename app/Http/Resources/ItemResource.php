<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class ItemResource extends JsonResource
{
    public function toArray($request)
    {
        $parent = parent::toArray($request);
        $parent['item_brand'] = new ItemBrandResource(\App\Models\ItemBrand::find($this->item_brand_id));
        $parent['item_group'] = new ItemGroupResource(\App\Models\ItemGroup::find($this->item_group_id));
        return $parent;
    }
}
