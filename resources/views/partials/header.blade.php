<header id="site-header" class="site-header container flex no-wrap cols-auto justify-content-space-between align-items-center">
	@hasoption('logo_color')
		@php
				$logo_color = get_field('logo_color', 'option');
		@endphp
		<a href="/">@image($logo_color, 'full margin-0 logo')</a>
	@endoption
  @if (has_nav_menu('primary_navigation'))
	<div class="site-header__menu--rounded">
		<nav id="nav-primary" class="nav-primary">
			{!! wp_nav_menu(['theme_location' => 'primary_navigation', 'container' => false, 'menu_class' => 'menu list-reset']) !!}
		</nav>
		<button id="menu-btn" class="hamburger hamburger--elastic" type="button"
		aria-label="Menu" aria-controls="navigation" aria-expanded="true/false">
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
		</button>
	</div>
	@endif
</header>
