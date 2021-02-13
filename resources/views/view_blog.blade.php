@extends('layouts.app')

@section('page-style')
    <style>
        .card-img-top {
            width: 52%;
        }
    </style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $blog->title }}
                    <a role="button"
                            class="btn btn-sm btn-info text-right"
                            style="float: right"
                            id="back-button"
                            href="{{ url('/home') }}">
                        Back
                    </a>
                </div>
                @include('partials.message')

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-deck row mt-3" id="card-deck">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 mb-4 text-center">
                                <img class="card-img-top"
                                     src="{{ asset($blog->image_url) }}"
                                     alt="Card image cap" id="card-img-top">
                                <div class="text-center">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $blog->title }}</h5>
                                        <small class="card-text">By {{ $blog->user->name }}</small> <br>
                                        <small class="card-text">{{ $blog->description }}</small>
                                        <p class="mt-4">
                                            {{ $blog->body }}
                                        </p>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted">Last updated {{ \Carbon\Carbon::parse($blog->updated_at)->diffForHumans() }}</small>
                                        <br> <small class="text-muted"> Views : {{ $blog->view_count }}</small>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
    <script>
        let width;
        if (document.getElementById('card-img-top')) {
            width = document.getElementById('card-img-top').style.width;
            document.getElementById('card-img-top').style.height = width;
        }
    </script>
@endsection

