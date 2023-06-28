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
	<div class="container-lg">
		<div class="test-block__innerblocks">
			<InnerBlocks template="{{ wp_json_encode( $template ) }}" />
		</div>
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
