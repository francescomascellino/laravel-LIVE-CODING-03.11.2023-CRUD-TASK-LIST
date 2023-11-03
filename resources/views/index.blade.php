@extends('layouts.app')

@section('content')
    <h1 class="text-center">Welcome, go to the Dashboard to edit your Task list!</h1>

    <div class="container">

        <div class="table-responsive my-3">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">DESCRIPTION</th>
                        <th scope="col">STATUS</th>
                        <th scope="col">DATE</th>
                        {{-- <th scope="col">ACTIONS</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td scope="row" class="align-middle"><strong>{{ $task->id }}</strong></td>
                            <td class="align-middle">{{ $task->description }}</td>
                            <td class="align-middle">{{ $task->status ? 'done' : 'To do' }}</td>
                            <td class="align-middle">{{ $task->created_at }}</td>
                            {{-- <td class="align-middle">
                                <a class="btn btn-primary mx-1" href="{{ route('tasks.show', $task) }}">Details</a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection
