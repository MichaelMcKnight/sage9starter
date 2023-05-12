@extends('layouts.app')

@section('content')
  <section class="error">
    <div class="container container-lg">
      <h1><span class="error__message">404</span><br>Oops this page doesn't exist...</h1>
      <p>Try returning to the homepage to find what you are looking for.</p>
      <a href="/" class="btn btn-primary">Return Home</a>
    </div>
  </section>
@endsection
