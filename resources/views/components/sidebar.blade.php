<aside class="sidebar-left" id="sidebar-left">
	<div class="sidebar-header">
		<div class="sidebar-title">
			Navigasi
		</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>
	<div class="nano">
		<div class="nano-content">
			<nav class="nav-main" id="menu" role="navigation">
				<ul class="nav nav-main">
					<li>
						<a href="{{ route('home') }}">
							<i class="fa fa-home" aria-hidden="true"></i>
							<span>Dashboard</span>
						</a>
					</li>
					<li class="nav-parent">
						<a>
							<i class="fa fa-database" aria-hidden="true"></i>
							<span>{{ ucwords(__('manajemen produk')) }}</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="{{ route('items.index') }}">
									{{ ucwords(__('produk')) }}
								</a>
							</li>
							<li>
								<a href="{{ route('suppliers.index') }}">
									{{ ucwords(__('pemasok')) }}
								</a>
							</li>
							<li>
								<a href="{{ route('item-groups.index') }}">
									{{ ucwords(__('kategori produk')) }}
								</a>
							</li>
							<li>
								<a href="{{ route('item-brands.index') }}">
									{{ ucwords(__('brand produk')) }}
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</aside>
