<div class="container">
    <h1>Task Edit</h1>
    <h2>Edit necessary details</h2>
    <form method="post" action="/task/<?= $variables['task']->getId() ?>/edit">
        <div class="form-group">
            <label for="username">User Name</label>
            <input type="text"  value="<?= $variables['task']->getUserName() ?>" class="form-control" name="username" id="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" value="<?= $variables['task']->getUserEmail() ?>" class="form-control" name="email" id="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="description">Task description</label>
            <textarea class="form-control" name="description" id="description" rows="5" required><?= $variables['task']->getTaskDescription() ?></textarea>
        </div>
        <div class="form-check">
            <?php if ($variables['task']->getTaskStatus() == 'Ready'): ?>
            <input type="checkbox" class="form-check-input" name="ready" value="true" id="task-ready" checked>
            <?php else: ?>
            <input type="checkbox" class="form-check-input" name="ready" value="true" id="task-ready">
            <?php endif; ?>
            <label class="form-check-label" for="task-ready">Mark the task ready</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="/" class="btn btn-secondary">Go Home</a>
    </form>
</div>
