<h3 class="text-semibold">{{ strtoupper($item->name) }}</h3>
<p class="text-muted m-none">Merek: {{ $item->item_brand->name }}</p>
<p class="mt-sm">{{ $item->description }}</p>
<p>Kategori produk <strong>{{ $item->item_group->name }}</strong> disuplai oleh {{ $item->supplier->name }}.</p>
