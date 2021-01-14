<div class="row">
	<div class="pricing-table">
		<div class="col-lg-12 col-sm-6">
			<div class="plan">
				<h3>{{ $item->name }}</h3>
				<div>
					@if($item->image_url)
					<img src="{{ $item->image_url }}" style="max-height: 200px;">
					@else
					<img src="{{ asset('assets/images/device.png') }}" style="max-height: 200px;">
					@endif
				</div>
				<ul>
					<li>Kode: <b>{{ $item->code }}</b></li>
					<li>Grup Barang: <b>{{ $item->itemGroup->name }}</b></li>
					<li>Brand Barang: <b>{{ $item->itemBrand->name }}</b></li>
					<li>Supplier: <b>{{ $suppliers }}</b></li>
					<li>Deskripsi: <b>{{ $item->description }}</b></li>
				</ul>
			</div>
		</div>
	</div>
</div>
