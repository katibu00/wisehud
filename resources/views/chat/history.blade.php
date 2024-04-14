@extends('layout.app')
@section('pageTitle', 'Chat History')
@section('content')

<div class="page-content-wrapper py-3">
  <div class="container">
    <ul class="ps-0 chat-user-list">
      @foreach ($chats as $chat)
        <li class="p-3 chat-unread">
          <a class="d-flex" href="{{ route('chat.details', ['sessionId' => $chat->session_id]) }}">
            <!-- Info -->
            <div class="chat-user-info">
              <h6 class="text-truncate last-chat mb-0">{{ $chat->title }}</h6>
              <div class="t">
                <p class="mb-0 text-truncate">Last conversation: {{ $chat->updated_at->diffForHumans() }}</p>
              </div>
            </div>
          </a>
          <!-- Options -->
          <div class="dropstart chat-options-btn">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></button>
            <ul class="dropdown-menu">
              <li><a href="#"><i class="bi bi-trash"></i>Delete</a></li>
            </ul>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
</div>

@endsection
