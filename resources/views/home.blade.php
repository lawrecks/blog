@extends('layouts.app')

@section('page-style')
    <style>
        #create-form {
            display: {{ count($errors) > 0 || session()->has('error') ? 'block' : 'none' }};
        }

        #back-button {
            display: {{ sizeof($errors) > 0 || session()->has('error') ? 'block' : 'none' }};
        }

        #create-button {
            display: {{ count($errors) > 0 || session()->has('error') ? 'none' : 'block' }};
        }

        #card-deck {
            display: {{ sizeof($errors) > 0 || session()->has('error') ? 'none' : 'flex' }};
        }
        label[for=image] {
            cursor: pointer;
        }

        label[for=image]:hover {
            color: orangered;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Blogs') }}

                    <button type="button"
                            class="btn btn-sm btn-info text-right"
                            style="float: right"
                            id="create-button"
                            onclick="showCreateForm(this)">
                        Create Blog
                    </button>
                    <button type="button"
                            class="btn btn-sm btn-info text-right"
                            style="float: right"
                            id="back-button"
                            onclick="hideCreateForm(this)">
                        Back
                    </button>
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
                                <div class="card">
                                    <a href="{{ url('/view-blog', $blog->id) }}">
                                        <img class="card-img-top"
                                             src="{{ asset($blog->image_url) }}"
                                             alt="Card image cap" id="card-img-top">

                                        <div class="card-body">
                                            <h5 class="card-title">{{ $blog->title }}</h5>
                                            <p class="card-text">{{ substr($blog->description, 0, 34) }}{{strlen($blog->description) > 34 ? '...' : '' }}</p>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">Posted {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</small>
                                            <br> <small class="text-muted"> Views : {{ $blog->view_count }}</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <form class="mt-3" id="create-form" method="post" action="{{ route('create.blog') }}" enctype="multipart/form-data">
                        <h5 class="text-center mt-3">Create a new blog</h5>
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input required type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input required type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea required type="text" rows="7" class="form-control" id="body" name="body">{{ old('body') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image" title="Click to Upload Image">
                                Attach Image ( Square images only )
                                <div>
                                    <img src="" alt="" id="display_image">
                                </div>
                            </label>
                            <input type="file"
                                   id="image"
                                   name="image"
                                   style="visibility: hidden"
                                   onchange="showUploadFile()"
                                   accept="image/jpeg,image/png">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-info" type="submit">Create</button>
                        </div>
                    </form>
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

        const showCreateForm = (element) => {
            let cardDeck = document.getElementById('card-deck');
            let form = document.getElementById('create-form');
            let back = document.getElementById('back-button');

            cardDeck.style.display = 'none';
            form.style.display = 'block';
            element.style.display = 'none';
            back.style.display = 'block';
        };

        const hideCreateForm = (element) => {
            let cardDeck = document.getElementById('card-deck');
            let form = document.getElementById('create-form');
            let create_button = document.getElementById('create-button');

            cardDeck.style.display = 'flex';
            form.style.display = 'none';
            element.style.display = 'none';
            create_button.style.display = 'block';
        };

        const showUploadFile = () => {
            // Get html elements
            let new_image = document.getElementById("image").files[0];
            let display_image = document.getElementById("display_image");
            display_image.width = '200';
            display_image.style.border = '2px solid #ff45004d';
            display_image.src = URL.createObjectURL(new_image);
        };
    </script>
@endsection

