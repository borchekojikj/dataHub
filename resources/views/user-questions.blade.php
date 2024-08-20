@extends('layouts.dashboard-layout')

@section('title', 'User Questions')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="p-2 text-center my-4 rounded bg-main">
                <h3 class="mb-0">User Questions</h3>
            </div>

        </div>
    </div>
    <div class="row justify-content-center py-4">
        <div class="col-10">
            <table class="table table-bordered table-hover table-striped ">
                <thead class="bg-main"> <!-- Dark header background -->
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Question</th>
                        <th scope="col">User</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question }}</td>
                        <td>{{ ucfirst($question->user->name) }}</td>
                        <td class="text-center"><a href="" class="btn btn-info w-100 mb-2" data-bs-toggle="modal" data-bs-target="#answerUserQuestionModal" data-question="{{ json_encode(['id' => $question->id, 'question' => $question->question]) }}">Answer</a>
                            <a href="{{ route('delete-user-question', ['id'=> $question->id]) }}" class=" btn btn-danger w-100">Delete</a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Answer questions -->
<div class="modal fade" id="answerUserQuestionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="answerUserQuestionModal">Answer Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="answerQuestionForm">
                    <input type="hidden" id="questionId" name="id">
                    <div class="mb-3">
                        <label for="question" class="form-label">Question</label>
                        <input type="text" class="form-control" id="question" name="question">
                    </div>
                    <div class="mb-3">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea class="form-control" id="answer" name="answer" rows="4"></textarea>
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
<!-- POPPER JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#answerUserQuestionModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var questionData = button.data('question'); // Extract info from data-* attributes

            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content.
            var modal = $(this);
            modal.find('#questionId').val(questionData.id);
            modal.find('#question').val(questionData.question);
        });

        $('#saveChanges').on('click', function() {
            // Handle form submission here, e.g., using AJAX
            var formData = $('#answerQuestionForm').serialize();
            // Example AJAX request
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/answer-user-question', // Your update URL
                data: formData,
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    $('#answerUserQuestionModal').modal('hide');
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