@extends('layout.app')
@section('pageTitle', 'Home')
@section('css')
<link rel="stylesheet" href="/styles.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
  #submit-button {
    position: relative;
}

#spinner-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    border: 2px solid rgba(0, 0, 0, 0.2);
    border-top: 2px solid #000;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    display: none; /* Initially hidden */
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

</style>

@endsection
@section('content')

<div class="page-content-wrapper py-3">
  <div class="container">
    <div class="card image-gallery-card direction-rtl">
      
        <div id="chat_container">

        </div>
    
        <form>
            <textarea name="prompt" rows="1" cols="1" placeholder="Ask me anything..."></textarea>
            <button type="submit" id="submit-button">
              <img src="/assets/send.svg" id="send-icon" />
              <div class="spinner" id="spinner-icon"></div>
          </button>
          
        </form>

    </div>
  </div>
</div>

@endsection
@section('js')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
  <script src="/script.js"></script>
  
@endsection
