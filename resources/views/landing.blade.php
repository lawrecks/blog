@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('All Blogs') }}
                    <span class="float-right">{{ $unique_users }} unique user(s) have visited this app</span>
                </div>
                @include('partials.message')

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-deck row mt-3" id="card-deck">
                        @foreach($blogs as $blog)
                            <div class="col-md-6 col-sm-12 col-lg-6 col-xs-12 mb-4">
                                <a href="{{ url('/view-blog', $blog->id) }}">
                                    <div class="card">
                                        <img class="card-img-top"
                                             src="{{ asset($blog->image_url) }}"
                                             alt="Card image cap" id="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $blog->title }}</h5> <small class="f-12">by {{ $blog->user->name }}</small>
                                            <p class="card-text">{{ substr($blog->description, 0, 49) }}{{strlen($blog->description) > 49 ? '...' : '' }}</p>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">Posted {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</small>
                                            <small class="text-muted float-right"> Views : {{ $blog->view_count }}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        let width = document.getElementById('card-img-top').style.width;
        document.getElementById('card-img-top').style.height = width;
    </script>
@endsection
