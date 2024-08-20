@extends('layouts.dashboard-layout')

@section('title', 'Content Management')

@section('content')


<div class="container">
    <div class="row py-3">
        <div class="p-2 text-center my-4 rounded bg-main">
            <h3 class="mb-0">Link new Blog</h3>

        </div>
        <div>



            @if (session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('post-blog') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Link Image</label>
                            <input type="text" class="form-control" id="image" name="image" value="{{ old('image') }}">
                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="link" class="form-label">Link to blog</label>
                            <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}">
                            @error('link')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="public" class="form-label">Should the Blog be public?</label>
                            <select class="form-select" aria-label="Default select example" name="public">
                                <option selected disabled>Select status</option>
                                <option value="0" {{ old('public') == '0' ? 'selected' : '' }}>Private</option>
                                <option value="1" {{ old('public') == '1' ? 'selected' : '' }}>Public</option>
                            </select>
                            @error('public')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-info form-control text-light">Submit</button>
            </form>



        </div>
    </div>
    <div class="row py-3" id="blogsSection">
        <div class="p-2 text-center my-4 rounded bg-main">
            <h3 class="mb-0">All Current Blogs</h3>

        </div>
        <div>
            <div class="row text-center py-4">
                <a class="col-6 p-3 border bg-warning btn text-light" id="publicBlogsButton">Published Blogs</a>
                <a class="col-6 p-3 border bg-warning btn text-light" id="privateBlogsButton">Private Blogs</a>
            </div>
        </div>

        @foreach ($blogs as $blog)
        <div class="col-md-4 mb-4 blogCard" data-public="{{ $blog->public  }}">
            <div class="card" style="width: 100%; min-height: 550px">
                <img src="{{ $blog->image }}" class="card-img-top" alt="Image link not valid" style="height: 350px">
                <div class="card-body">
                    <h5 class="card-title" style="min-height: 50px; overflow-y:hidden">{{ $blog->title }} <span class="info-font-style">({{$blog->public ? 'Public': 'Private'}})</span></h5>
                    <p class=" card-text " style=" min-height: 125px; overflow-y:hidden">{{ $blog->description }}</p>
                    <a href="{{ $blog->link }}" class="btn btn-secondary">Read more</a>
                    @if($blog->public == true)
                    <a href="{{ route('change-blog-status', ['id'=> $blog->id]) }}" class="btn btn-success">Set to private</a>
                    @else
                    <a href="{{ route('change-blog-status', ['id'=> $blog->id]) }}" class="btn btn-info">Set to Public</a>

                    @endif
                    <a href="{{ route('delete-blog', ['id'=> $blog->id]) }}" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>


</div>





<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to section if session variable is set
        let targetId = '{{ session("scrollTo") }}';
        let targetElement = document.getElementById(targetId);
        if (targetId && targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop,
                behavior: 'smooth'
            });
        }

        const privateButton = document.getElementById('privateBlogsButton');
        const publicButton = document.getElementById('publicBlogsButton');
        const blogCards = document.querySelectorAll('.blogCard');

        // Function to toggle active button class
        function setActiveButton(button) {
            privateButton.classList.remove('active-button');
            publicButton.classList.remove('active-button');
            button.classList.add('active-button');
        }

        // Event listener for Private Blogs button
        privateButton.addEventListener('click', function() {
            if (privateButton.classList.contains('active-button')) {
                // Toggle off filter
                privateButton.classList.remove('active-button');
                blogCards.forEach((card) => {
                    card.style.display = 'block';
                });
            } else {
                setActiveButton(privateButton);
                blogCards.forEach((card) => {
                    const isPublic = card.dataset.public === '1';
                    card.style.display = isPublic ? 'none' : 'block';
                });
            }
        });

        // Event listener for Published Blogs button
        publicButton.addEventListener('click', function() {
            if (publicButton.classList.contains('active-button')) {
                // Toggle off filter
                publicButton.classList.remove('active-button');
                blogCards.forEach((card) => {
                    card.style.display = 'block';
                });
            } else {
                setActiveButton(publicButton);
                blogCards.forEach((card) => {
                    const isPublic = card.dataset.public === '1';
                    card.style.display = isPublic ? 'block' : 'none';
                });
            }
        });
    });
</script>
@endsection