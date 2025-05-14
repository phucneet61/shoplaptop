@extends('layout')
@section('content')

<div class="features_items">
    <h2 class="title text-center">{{$meta_title}}</h2>
    <div class="product-image-wrapper">
        @foreach ($post as $key => $p)

            
        <div class="blog-post-area">
            <div class="single-blog-post">
            <h3>{{ $p->post_title }}</h3>
            <a href="{{ url('/bai-viet/'.$p->post_slug) }}">
                <img src="{{ asset('public/uploads/posts/'.$p->post_image) }}" alt="{{ $p->post_slug }}">
            </a>
            <p>{!! $p->post_desc !!}</p>
            <a class="btn btn-primary" href="{{ url('/bai-viet/'.$p->post_slug) }}">Đọc thêm</a>
            </div>
        </div>
        @endforeach
    </div>
    <ul class="pagination pagination-sm-m-t-none-m-b-none">
        {!!$post->links()!!}
    </ul>
    
</div><!--features_items-->

@endsection