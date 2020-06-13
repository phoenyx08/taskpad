<div class="container">
    <h1>New Task</h1>
    <div class="alert alert-success"><strong>Success!</strong> Task was added to the database</div>

    <div class="container">
        <div class="row">
            <div class="col-sm-2">Username</div>
            <div class="col-sm-2"><?= htmlspecialchars($variables['items']['username']) ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2">Email</div>
            <div class="col-sm-2"><?= htmlspecialchars($variables['items']['email']) ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2">Description</div>
            <div class="col-sm-2"><?= htmlspecialchars($variables['items']['description']) ?></div>
        </div>
    </div>
    <a class="btn btn-primary" href="/task/new" role="button">Create New Task</a>
    <a class="btn btn-secondary" href="/" role="button">Go Home</a>
</div>
