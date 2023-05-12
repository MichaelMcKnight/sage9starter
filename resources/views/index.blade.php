@extends('layouts.app')

@section('content')
@php
	$blog_page_id = get_option('page_for_posts');
	$blog_page_url = get_permalink($blog_page_id);

	// Get the "Blog pages show at most" option value
	$posts_per_page = get_option('posts_per_page');

	$currentPage = get_query_var('paged') ? get_query_var('paged') : 1;
	// Check if the current page is a category archive page
	if (is_category()) {
		// Get the current category ID
		$category_id = get_queried_object_id();

		// Add the category parameter to the query args
		$args = array(
			'posts_per_page' => $posts_per_page,
			'paged' => $currentPage,
			'cat' => $category_id
		);
	} else {
		// Use default query args for non-category archive pages
		$args = array(
			'posts_per_page' => $posts_per_page,
			'paged' => $currentPage
		);
	}

	// Create the query
	$query = new WP_Query($args);
@endphp

<div class="posts-archive">
	<div class="posts-archive__hero">
		@php
			// Get the page object for the posts page
			$page_for_posts = get_option( 'page_for_posts' );
		@endphp
		@if( $page_for_posts )
				@php $page_object = get_post( $page_for_posts ); @endphp
				@if( $page_object )
					<div class="container container-lg">
						<div class="posts-archive__hero__content">
							@php
								// Display the page content
								echo apply_filters( 'the_content', $page_object->post_content );
							@endphp
						</div>
					</div>
				@endif
		@endif
	</div>
	<div class="posts-archive__categories">
		<div class="container container-lg">
			<ul>
				<li>
					<a class="active" href="@php echo $blog_page_url; @endphp"> View All</a>
				</li>
				@php
					$categories = get_categories();
					foreach ($categories as $category) {
							$category_link = get_category_link( $category->term_id );
							echo '<li><a href="' . $category_link . '">' . $category->name . '</a></li>';
					}
				@endphp
			</ul>
		</div>
	</div>
	@if($query->have_posts())
	<div class="posts-archive__posts" data-aos="fade-up" data-aos-duration="750">
		<div class="container container-lg posts-archive__posts__loop">
			@while($query->have_posts()) @php $query->the_post(); @endphp
				<div class="posts-archive__posts__loop__post">
					<div class="posts-archive__posts__loop__post__image">
						@thumbnail('full margin-0')
					</div>
					<div class="posts-archive__posts__loop__post__content">
						<a href="@permalink">
							<h2>@title</h2>
						</a>
						<a class="arrow-right arrow-right--primary" href="@permalink">Read More</a>
					</div>
				</div>
			@endwhile
		</div>
	</div>
	@endif
</div>

@php
$totalPages = $query->max_num_pages;

// Define the number of pages to display
$paginationRange = 3;

// Calculate the start and end page numbers for the pagination
if ($totalPages <= $paginationRange) {
    $startPage = 1;
    $endPage = $totalPages;
} else {
    $startPage = max(1, $currentPage - floor($paginationRange / 2));
    $endPage = min($totalPages, $currentPage + floor($paginationRange / 2));
    if ($startPage == 1) {
        $endPage = $paginationRange;
    } elseif ($endPage == $totalPages) {
        $startPage = $totalPages - $paginationRange + 1;
    }
}

// Output the pagination HTML
if ($totalPages > 1) {
    echo '<div class="pagination container container-lg">';
    if ($currentPage > 1) {
        echo '<a href="' . get_pagenum_link(1) . '">&laquo;</a>';
        echo '<a href="' . get_pagenum_link($currentPage - 1) . '">&lsaquo;</a>';
    }
    if ($startPage > 1) {
        echo '<a href="' . get_pagenum_link(1) . '">1</a>';
        if ($startPage > 2) {
            echo '<span class="ellipsis">&hellip;</span>';
        }
    }
    for ($i = $startPage; $i <= $endPage; $i++) {
        echo '<a href="' . get_pagenum_link($i) . '"';
        if ($i == $currentPage) {
            echo ' class="active"';
        }
        echo '>' . $i . '</a>';
    }
    if ($endPage < $totalPages) {
        if ($endPage < $totalPages - 1) {
            echo '<span class="ellipsis">&hellip;</span>';
        }
        echo '<a href="' . get_pagenum_link($totalPages) . '">' . $totalPages . '</a>';
    }
    if ($currentPage < $totalPages) {
        echo '<a href="' . get_pagenum_link($currentPage + 1) . '">&rsaquo;</a>';
        echo '<a href="' . get_pagenum_link($totalPages) . '">&raquo;</a>';
    }
    echo '</div>';
}

wp_reset_postdata();
@endphp
@endsection
