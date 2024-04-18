@extends('layout.app')
@section('pageTitle', 'Chat History')
@section('content')

<div class="page-content-wrapper py-3">
  <div class="container">
    <ul class="ps-0 chat-user-list">
      @foreach ($chats as $chat)
        <li class="p-3 chat-unread" data-session-id="{{ $chat->session_id }}">
          <a class="d-flex" href="{{ route('chat.details', ['sessionId' => $chat->session_id]) }}">
            <div class="chat-user-info">
              <h6 class="text-truncate last-chat mb-0">{{ $chat->title }}</h6>
              <div class="t">
                <p class="mb-0 text-truncate">Last conversation: {{ $chat->latest_conversation_created_at->diffForHumans() }}</p>
              </div>
            </div>
          </a>
          <div class="dropstart chat-options-btn">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
            <ul class="dropdown-menu">
              <li><a href="#" class="rename-chat" data-bs-toggle="modal" data-bs-target="#renameChatModal" data-chat-title="{{ $chat->title }}" data-session-id="{{ $chat->session_id }}"><i class="bi bi-pencil"></i>Rename</a></li>
              <li><a href="#" class="delete-chat" data-session-id="{{ $chat->session_id }}"><i class="bi bi-trash"></i>Delete</a></li>
            </ul>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</div>

<div class="modal fade" id="deleteChatModal" tabindex="-1" aria-labelledby="deleteChatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteChatModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this chat?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
      </div>
    </div>
  </div>
</div>


<!-- Rename Chat Modal -->
<div class="modal fade" id="renameChatModal" tabindex="-1" aria-labelledby="renameChatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="renameChatModalLabel">Rename Chat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="renameChatForm">
        <div class="modal-body">
          <div class="mb-3">
            <label for="chatTitle" class="form-label">New Chat Title:</label>
            <input type="text" class="form-control" id="chatTitle" name="chatTitle" required>
          </div>
          <input type="hidden" id="sessionIdToRename" name="sessionIdToRename">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" id="save-button" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
@section('js')
<script>



$(document).ready(function() {
  var renameButton = $('#rename-chat-btn');
  var renameChatForm = $('#renameChatForm');
  var saveButton = $('#save-button');

  $('.rename-chat').on('click', function() {
    var chatTitle = $(this).data('chat-title');
    var sessionId = $(this).data('session-id');
    $('#chatTitle').val(chatTitle); // Populate input field with current chat title
    $('#sessionIdToRename').val(sessionId);
    $('#renameChatModal').modal('show');
  });

  renameChatForm.on('submit', function(e) {
    e.preventDefault();
    var chatTitle = $('#chatTitle').val();
    var sessionId = $('#sessionIdToRename').val();

    // Disable the save button and show spinner
    saveButton.prop('disabled', true);
    saveButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

    $.ajax({
      url: '/chat/rename/' + sessionId,
      type: 'PUT',
      data: {
        '_token': '{{ csrf_token() }}',
        'title': chatTitle
      },
      success: function(response) {
        $('#renameChatModal').modal('hide');
        // Update chat title on the page
        $('[data-session-id="' + sessionId + '"] .last-chat').text(chatTitle);
      },
      error: function(xhr, status, error) {
        console.error(error);
      },
      complete: function() {
        // Re-enable the save button
        saveButton.prop('disabled', false).html('Save');
      }
    });
  });
});









$(document).ready(function() {
  var sessionIdToDelete;
  var deleteButton = $('#confirm-delete');

  $('.delete-chat').on('click', function() {
    sessionIdToDelete = $(this).data('session-id');
    $('#deleteChatModal').modal('show');
    console.log('Delete button clicked');
  });

  deleteButton.on('click', function() {

    deleteButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

    $.ajax({
      url: '/chat/delete/' + sessionIdToDelete,
      type: 'DELETE',
      data: {
        '_token': '{{ csrf_token() }}'
      },
      success: function(response) {

        var deletedLi = $('[data-session-id="' + sessionIdToDelete + '"]');
        deletedLi.remove();
      },
   
      error: function(xhr, status, error) {
        console.error(error);
        deleteButton.prop('disabled', false).html('Delete');
      },
      complete: function() {
        deleteButton.prop('disabled', false).html('Delete');
        $('#deleteChatModal').modal('hide');
      }
    });
    console.log('Confirm delete button clicked');
  });
});
</script>
@endsection
