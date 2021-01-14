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
							<span>Data Master</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="{{ route('items.index') }}">
									Barang
								</a>
							</li>
							<li>
								<a href="{{ route('suppliers.index') }}">
									Supplier
								</a>
							</li>
							<li>
								<a href="{{ route('item-groups.index') }}">
									Grup Barang
								</a>
							</li>
							<li>
								<a href="{{ route('item-brands.index') }}">
									Brand Barang
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-parent">
						<a>
							<i class="fa fa-users" aria-hidden="true"></i>
							<span>Data User</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<a href="{{ route('users.index') }}">
									User
								</a>
							</li>
							<li>
								<a href="{{ route('profiles.index') }}">
									Profil
								</a>
							</li>
							<li>
								<a href="{{ route('roles.index') }}">
									Role
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</aside>
