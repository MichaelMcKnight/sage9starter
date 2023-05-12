{{--
  Title: Accordion
  Description: A block to display accordions for FAQ, or any other section that may need them.
  Category: sage
  Icon:
  Keywords:
  Mode: preview
  Align: full
  PostTypes: page post integrations
  SupportsAlign: true
  SupportsMode: true
  SupportsMultiple: true
  SupportsInnerBlocks: true
  SupportsAlignText: true
  SupportsAlignContent: true
	SupportsAnchor: true
--}}

<section data-{{ $block['id'] }} @if (($block['anchor'])) id="{{ $block['anchor'] }}" @endif class="{{ $block['classes'] }}">

	<div class="container-lg">
		@hasfields('accordion_panels')
			@php
				$panel_count = 0;
			@endphp
			@fields('accordion_panels')
			@php
				$panel_count = $panel_count + 1;
			@endphp
			<div class="accordion__panel">
				<button class="accordion__panel__button" aria-expanded="false" aria-controls="accordion-panel-content-@php echo $panel_count; @endphp">@sub('accordion_panel_title')</button>
				<div class="accordion__panel__content" id="accordion-panel-content-@php echo $panel_count; @endphp">
					@sub('accordion_panel_content')
				</div>
			</div>
			@endfields
		@endhasfields
	</div>

</section>
