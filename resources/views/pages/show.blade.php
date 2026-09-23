@extends('layouts.twinvexa')

@section('page_title', $page->meta_title ?? $page->title)
@section('page_description', $page->meta_description ?? '')

@section('content')
<div class="container">
    <div class="page-header text-center" style="padding: 40px 0;">
        <h1>{{ $page->title }}</h1>
    </div>
    <div class="page-content">
        {!! $page->content !!}
    </div>
</div>
@endsection
