@extends('layouts.dashboard-layout')

@section('title', 'Content Management')

@section('content')
<div class="container">
    <div class="row py-3">
        <div class="p-2 text-center my-4 rounded bg-main">
            <h3 class="mb-0">About us</h3>
        </div>
        @foreach ($content as $contentRow)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3" style="height: 100%;">
                <div class="card-body d-flex flex-column" style="overflow-y: auto; height: 250px;">
                    <h5 class="card-title fw-bold">Title: {{ $contentRow->title }}</h5>
                    <div class="card-text flex-grow-1">
                        <p><span class="fw-bold">Content:</span> {{ $contentRow->content }}</p>
                    </div>
                </div>
                <div class="p-2">
                    <a href="#" class="btn custom-button mt-2 w-100" data-bs-toggle="modal" data-bs-target="#exampleModal" data-user="{{ json_encode(['id' => $contentRow->id, 'title' => $contentRow->title, 'content' => $contentRow->content]) }}">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row py-3">
        <div class="p-2 text-center my-4 rounded bg-main">
            <h3 class="mb-0">Socials</h3>
        </div>
        @foreach ($socials as $socialRow)
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-3" style="height: 100%;">
                <div class="card-body d-flex flex-column" style="overflow-y: auto; height: 250px;">
                    <h5 class="card-title fw-bold text-secondary">Edit socials</h5>
                    <div class="card-text flex-grow-1">
                        <p><span class="fw-bold">Email:</span> {{ $socialRow->email }}</p>
                        <p><span class="fw-bold">Facebook:</span> {{ $socialRow->facebook }}</p>
                        <p><span class="fw-bold">Instagram:</span> {{ $socialRow->instagram }}</p>
                        <p><span class="fw-bold">Twitter:</span> {{ $socialRow->twitter }}</p>
                    </div>
                </div>
                <div class="p-2">
                    <a href="#" class="btn custom-button mt-2 w-100" data-bs-toggle="modal" data-bs-target="#exampleModalSocials" data-social="{{ json_encode(['id' => $socialRow->id, 'email' => $socialRow->email, 'facebook' => $socialRow->facebook, 'instagram' => $socialRow->instagram,'twitter' => $socialRow->twitter]) }}">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>

<!-- Modal Content -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="contentId" name="id">
                    <div class="mb-3">
                        <label for="contentTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="contentTitle" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="contentBody" class="form-label">Content</label>
                        <textarea class="form-control" id="contentBody" name="content" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Socials -->
<div class="modal fade" id="exampleModalSocials" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalSocials">Edit socials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSocials">
                    <input type="hidden" id="socialId" name="id">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" class="form-control" id="facebook" name="facebook">
                    </div>
                    <div class="mb-3">
                        <label for="instagram" class="form-label">Instagram</label>
                        <input type="text" class="form-control" id="instagram" name="instagram">
                    </div>
                    <div class="mb-3">
                        <label for="twitter" class="form-label">Twitter</label>
                        <input type="text" class="form-control" id="twitter" name="twitter">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesSocial">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userData = button.data('user'); // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content.
            var modal = $(this);
            modal.find('#contentId').val(userData.id);
            modal.find('#contentTitle').val(userData.title);
            modal.find('#contentBody').val(userData.content);
        });

        $('#saveChanges').on('click', function() {
            // Handle form submission here, e.g., using AJAX
            var formData = $('#editForm').serialize();
            // Example AJAX request
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/update-content', // Your update URL
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    $('#exampleModal').modal('hide');
                    window.location.reload();
                    // Optionally update the page with the new data
                },
                error: function(error) {
                    // Handle error response
                    console.log(error);
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        $('#exampleModalSocials').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var socialData = button.data('social'); // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content.
            var modal = $(this);
            modal.find('#socialId').val(socialData.id);
            modal.find('#email').val(socialData.email);
            modal.find('#facebook').val(socialData.facebook);
            modal.find('#instagram').val(socialData.instagram);
            modal.find('#twitter').val(socialData.twitter);
        });

        $('#saveChangesSocial').on('click', function() {
            // Handle form submission here, e.g., using AJAX
            var formData = $('#editSocials').serialize();
            // Example AJAX request
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/update-socials', // Your update URL
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    $('#exampleModalSocials').modal('hide');
                    window.location.reload();
                    // Optionally update the page with the new data
                },
                error: function(error) {
                    // Handle error response
                    console.log(error);
                }
            });
        });
    });
</script>
@endsection