@extends('layout')
@section('content')

<div class="features_items">
    <h2 class="title text-center" style="position: inherit; font-size: 22px; padding-top: 10px;">{{$meta_title}}</h2>
    <div class="product-image-wrapper">
        
        <div class="blog-post-area" >
            @foreach($post as $p)
                <div class="single-blog-post" style="padding-left: 10px">
                    {{-- <h3>{{ $p->post_title }}</h3> --}}
                    
                    <a href="">
                        <img src="{{ asset('public/uploads/posts/' . $p->post_image) }}" alt="{{ $p->post_slug }}">
                    </a>

                    <p>
                        {!! $p->post_content !!}
                    </p> <br>
                </div>
            @endforeach
        </div>
    </div>
    <h2 class="title text-center" style="position: inherit; font-size: 22px">Bài viết liên quan</h2>
    <style type="text/css">
        ul.post_relate li {
            list-style-type: disc;
            font-size: 16px;
            padding: 6px;
        }
        ul.post_relate li a{
            color: #000;
        }
        ul.post_relate li a:hover{
            color: #FE980F;
        }
    </style>
    <ul class="post_relate">
        @foreach ($related as $post_relate)
        <li><a href="{{ url('/bai-viet/'.$post_relate->post_slug) }}">{{$post_relate->post_title}}</a></li>
        @endforeach
    </ul>
    
</div>

@endsection