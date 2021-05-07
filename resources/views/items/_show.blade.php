<div class="row">
	<div class="pricing-table">
		<div class="col-lg-12 col-sm-6">
			<div class="plan">
				<h3>{{ $item->name }}</h3>
				<div>
				</div>
				<ul>
					<li>Grup Barang: <b>{{ $item->item_group->name }}</b></li>
					<li>Brand Barang: <b>{{ $item->item_brand->name }}</b></li>
					<li>Supplier: <b>{{ $item->supplier->name }}</b></li>
					<li>Deskripsi: <b>{{ $item->description }}</b></li>
				</ul>
			</div>
		</div>
	</div>
</div>
