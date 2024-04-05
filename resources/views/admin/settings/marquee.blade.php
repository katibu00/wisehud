@extends('admin.layout.app')

@section('pageTitle', 'Marquee Notification')

@section('content')
<main id="main-container">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Marquee Notification</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form id="marqueeForm" action="{{ route('marquee_notification.save') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="notificationTitle">Notification Title</label>
                                <input type="text" class="form-control" id="notificationTitle" name="notificationTitle" value="{{ @$marqueeNotification->title }}">
                            </div>

                            <div class="form-group">
                                <label for="notificationMessage">Notification Message</label>
                                <textarea class="form-control" id="notificationMessage" name="notificationMessage" rows="5">{{ @$marqueeNotification->message }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="notificationPriority">Priority</label>
                                <select class="form-control" id="notificationPriority" name="notificationPriority">
                                    <option value="low" {{ @$marqueeNotification->priority === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ @$marqueeNotification->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ @$marqueeNotification->priority === 'high' ? 'selected' : '' }}>High</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary mt-2">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
