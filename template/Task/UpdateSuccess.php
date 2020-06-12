<div class="container">
    <h1>Task Update</h1>
    <div class="alert alert-success"><strong>Success!</strong> The task updated successfully</div>

    <div class="container">
        <div class="row">
            <div class="col-sm-2">Username</div>
            <div class="col-sm-2"><?= htmlspecialchars($variables['username']) ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2">Email</div>
            <div class="col-sm-2"><?= htmlspecialchars($variables['email']) ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2">Description</div>
            <div class="col-sm-2"><?= htmlspecialchars($variables['description']) ?></div>
        </div>
        <div class="row">
            <div class="col-sm-2">Status</div>
            <div class="col-sm-2">
                <div><?= htmlspecialchars($variables['status']) ?></div>
                <?php if ($variables['descriptionEdited'] == 'yes'): ?>
                    <div>Edited by Admin</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <a class="btn btn-primary" href="/task/<?= $variables['id']?>/edit">Edit Again</a>
    <a class="btn btn-secondary" href="/" role="button">Go Home</a>
</div>