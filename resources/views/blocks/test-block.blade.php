{{--
  Title: Test Block
  Description: Example block!
  Category: sage
  Icon: format-image
  Keywords: custom hero
  Mode: preview
  Align: full
  PostTypes: page post
  SupportsAlign: true
  SupportsMode: true
  SupportsMultiple: true
  SupportsInnerBlocks: true
  SupportsAlignText: true
  SupportsAlignContent: true
	SupportsAnchor: true
--}}

@php
	$template = [
	[ 'core/paragraph', ['content' => 'Placeholder paragraph'] ],
	];
@endphp

<section data-{{ $block['id'] }} @if (($block['anchor'])) id="{{ $block['anchor'] }}" @endif class="{{ $block['classes'] }}">
	<div class="container-lg background-color-primary full-width">
		<div class="test-block__innerblocks">
			<InnerBlocks template="{{ wp_json_encode( $template ) }}" />
		</div>
		<div class="flex align-items-start justify-content-lg-center gap-1 cols-md-4">
			<div class="background-color-secondary text-color-white">hello</div>
			<div class="background-color-secondary text-color-white">
				<p class="text-align-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			</div>
			<div class="background-color-secondary text-color-white">obob</div>
			<div class="background-color-secondary text-color-white">hello</div>
			<div class="background-color-secondary text-color-white">bob</div>
			<div class="background-color-secondary text-color-white">obob</div>
			<div class="background-color-secondary text-color-white">hello</div>
			<div class="background-color-secondary text-color-white">bob</div>
			<div class="background-color-secondary text-color-white">obob</div>
		</div>
		@php echo wp_get_attachment_image(16, 'full') @endphp
		@hasfield('block_heading')
		<h2>@field('block_heading')</h2>
		@endfield
		@hasfields('slides')
		<div class="test-block__slides">
			@fields('slides')
			@php
				$slide_image = get_sub_field('slide_image');
			@endphp
			<div class="test-block__slides__slide">
				<div class="text-block__slides__slide__image">
					@image($slide_image, 'full')
				</div>
				<div class="test-block__slides__slide__content">
					@hassub('slide_heading')
					<h3>@sub('slide_heading')</h3>
					@endsub
					@sub('slide_content')
				</div>
			</div>
			@endfields
		</div>
		@endhasfields
	</div>
</section>
