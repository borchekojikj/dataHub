@extends('layouts.dashboard-layout')

@section('title', 'Catalogues')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <h3 class="bg-main p-2 rounded text-center mb-4">Add a new catalogue</h3>
            <form method="POST" action="{{ route('store-catalogue') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mb-2">
                            <label for="catalogue_name" class="form-label">Catalogue Name</label>
                            <input type="text" class="form-control" id="catalogue_name" name="catalogue_name">
                        </div>
                        @error('catalogue_name')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <div class="mb-2">
                            <label for="catalogue_file_url" class="form-label">Catalogue File Upload</label>
                            <input type="file" class="form-control" id="catalogue_file_url" name="catalogue_file_url" accept=".pdf">
                        </div>
                        @error('catalogue_file_url')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <div class="mb-2">
                            <label for="catalogue_pic_url" class="form-label">Catalogue Picture Upload</label>
                            <input type="file" class="form-control" id="catalogue_pic_url" name="catalogue_pic_url" accept="image/*">
                        </div>
                        @error('catalogue_pic_url')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <div class="mb-2">
                            <label for="store_id" class="form-label">Select Store</label>
                            <select class="form-select" id="store_id" name="store_id">
                                <option selected hidden value="">Select a store</option>
                                @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ucfirst($store->title) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('store_id')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <div class="mb-2">
                            <label for="starting_period" class="form-label">Starting Period</label>
                            <input type="date" class="form-control" id="starting_period" name="starting_period">
                        </div>
                        @error('starting_period')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                        <div class="mb-2">
                            <label for="ending_period" class="form-label">Ending Period</label>
                            <input type="date" class="form-control" id="ending_period" name="ending_period">
                        </div>
                        @error('ending_period')
                        <div class="text-danger mb-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn custom-button mt-3">Add catalogue</button>
            </form>

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <h3 class="bg-main p-2 rounded text-center my-5">Catalogues</h3>

            <div class="row pt-3">
                @foreach ($catalogues as $catalogue)
                <div class="col-md-4 mb-4 blogCard" data-public="{{ $catalogue->is_public  }}">
                    <div class="card" style="width: 100%; min-height: 450px">
                        <img src="{{ asset('storage/catalogue_pictures/' . $catalogue->catalogue_pic_url) }}" class="card-img-top" alt="Image link not valid" style="height: 450px; position: relative; border: 3px gray solid">
                        <div class="card-body bg-transparent" style="position: absolute; bottom:0; left:0; right:0">

                            <h5 class="p-2 fw-bold" style=" overflow-y:hidden; background-color: rgba(255,255,255,0.5)">{{ $catalogue->catalogue_name }} </h5>
                            @if($catalogue->is_public == true)
                            <a href="{{ route('change-catalogue-status', ['id'=> $catalogue->id]) }}" class="btn btn-success">Set to private</a>
                            @else
                            <a href="{{ route('change-catalogue-status', ['id'=> $catalogue->id]) }}" class="btn btn-info">Set to Public</a>

                            @endif
                            <a href="{{ route('delete-catalogue', ['id'=> $catalogue->id]) }}" class="btn btn-danger">Delete</a>
                        </div>
                        <div style="position: absolute;top:0; right:0; padding: 2px">
                            <span style="background-color: rgba(255,255,255,0.5)">{{$catalogue->starting_period}} - {{$catalogue->ending_period}}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
@endsection