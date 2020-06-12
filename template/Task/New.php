<div class="container">
    <h1>New Task</h1>
    <h2>Enter the task details below</h2>
    <form method="post" action="/task/new">
        <div class="form-group">
            <label for="username">User Name</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="description">Task description</label>
            <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/" class="btn btn-secondary">Go Home</a>
    </form>
</div>
