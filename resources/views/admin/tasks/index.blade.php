@extends('layouts.admin')

@section('content')
    <div class="container">
        @include('partials.TaskCreateForm')

        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Attention:</strong> {{ session('message') }}
            </div>
        @endif

        <div class="table-responsive my-3">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">DESCRIPTION</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">DATE</th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td scope="row" class="align-middle"><strong>{{ $task->id }}</strong></td>
                            <td class="align-middle">{{ $task->description }}</td>
                            <td class="align-middle">{{ $task->status ? 'done' : 'To do' }}</td>
                            <td class="align-middle">{{ $task->created_at }}</td>
                            <td class="align-middle">
                                {{-- ACTIONS --}}
                                <a class="btn btn-primary mx-1" href="{{ route('tasks.show', $task) }}">Details</a>

                                <!-- EDIT Modal trigger button -->
                                <button type="button" class="btn btn-warning m-2" data-bs-toggle="modal"
                                    data-bs-target="#modalTaskEdit{{ $task->id }}">
                                    Edit
                                </button>

                                <!-- EDIT Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div class="modal fade" id="modalTaskEdit{{ $task->id }}" tabindex="-1"
                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-muted" id="modalTitleId">EDIT TASK ID
                                                    {{ $task->id }}</h5>
                                            </div>

                                            <div class="modal-body">

                                                <form action="{{ route('tasks.update', $task) }}" method="POST">

                                                    @csrf

                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Edit Task n.
                                                            {{ $task->id }} Description</label>
                                                        <input type="text" name="description" id="description"
                                                            class="form-control" placeholder="TEXT"
                                                            value="{{ $task->description }}" aria-describedby="helpId">
                                                        <small id="helpId" class="text-muted">Enter a New
                                                            description</small>
                                                    </div>

                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-dismiss="modal">Cancel</button>

                                                        <button type="submit" class="btn btn-warning">Submit</button>

                                                    </div>

                                                </form>

                                            </div>



                                        </div>
                                    </div>
                                </div>

                                <!-- DELETE Modal trigger button -->
                                <button type="button" class="btn btn-danger m-2" data-bs-toggle="modal"
                                    data-bs-target="#modalTaskDelete{{ $task->id }}">
                                    Delete
                                </button>

                                <!-- DELETE Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div class="modal fade" id="modalTaskDelete{{ $task->id }}" tabindex="-1"
                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-muted" id="modalTitleId">DELETE TASK ID
                                                    {{ $task->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                This action will delete the selected task and will not be reversible.
                                                Do you want to continue?
                                            </div>
                                            <div class="modal-footer">

                                                <button type="button" class="btn btn-primary"
                                                    data-bs-dismiss="modal">Cancel</button>

                                                <form action="{{ route('tasks.destroy', $task) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">DELETE</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>

        </div>
    </div>
    </div>
    </div>

    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>

    </div>
@endsection
