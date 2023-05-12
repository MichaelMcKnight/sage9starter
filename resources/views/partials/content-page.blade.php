<style>header{position:relative;}</style>
@php
  $basic_page = get_field('basic_page');
  if ($basic_page) : @endphp
    <div class="container container-lg basic-page-wrap">
      @php the_content(); @endphp
    </div>
  @php else :
    the_content();
  endif ;
@endphp