<div class="container">
    <form action="{{ route('tasks.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label for="description" class="form-label">Create a new task</label>
            <input type="text" name="description" id="description" class="form-control" placeholder="Write something here..."
                aria-describedby="helpId">
            <small id="helpId" class="text-muted">Enter the new task description</small>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>

    </form>

</div>