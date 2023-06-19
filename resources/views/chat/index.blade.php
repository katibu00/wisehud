@extends('layout.app')
@section('pageTitle', 'Home')
@section('css')
<link rel="stylesheet" href="/styles.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

<div class="page-content-wrapper py-3">
  <div class="container">
    <div class="card image-gallery-card direction-rtl">
      
        <div id="chat_container">

        </div>
    
        <form>
            <textarea name="prompt" rows="1" cols="1" placeholder="Ask me anything..."></textarea>
            <button type="submit"><img src="/assets/send.svg" /></button>
        </form>




    </div>
  </div>
</div>

@endsection
@section('js')
<script src="/script.js"></script>
@endsection
