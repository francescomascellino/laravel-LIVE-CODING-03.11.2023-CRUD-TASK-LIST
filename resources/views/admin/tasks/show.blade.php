@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Task n. {{ $task->id }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted ">Task Description</h6>
                        <p class="card-text">{{ $task->description }}</p>
                        <h6 class="card-subtitle mb-2 text-muted ">Added on date</h6>
                        <p class="card-text">{{ $task->created_at }}</p>
                        <h6 class="card-subtitle mb-2 text-muted ">Status</h6>
                        <p>{{ $task->status ? 'Done' : 'To do' }}</p>
                    </div>
                </div>
                <h1></h1>
            </div>
        </div>

    </div>
@endsection
