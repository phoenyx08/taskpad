<div class="container">
    <h1>List of tasks</h1>
    <a class="btn btn-primary" href="/task/new">New Task</a>
    <?php if ($variables['status'] == 'fail'):  ?>
    <div class="text-secondary"><?= $variables['message'] ?></div>
    <?php else: ?>
    <div class="row table-header">
        <div class="col-sm-3 table-header-col">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 font-weight-bold">Username</div>
                    <div class="col-sm-4">
                        <div><small><a href="/page/<?= $variables['page'] ?>/sort/name/direction/asc">ASC</a></small></div>
                        <div><small><a href="/page/<?= $variables['page'] ?>/sort/name/direction/desc">DESC</a></small></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3  table-header-col">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 font-weight-bold">Email</div>
                    <div class="col-sm-4">
                        <div><small><a href="/page/<?= $variables['page'] ?>/sort/email/direction/asc">ASC</a></small></div>
                        <div><small><a href="/page/<?= $variables['page'] ?>/sort/email/direction/desc">DESC</a></small></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 text-center font-weight-bold table-header-col">Task Description</div>
        <div class="col-sm-2 table-header-col">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 font-weight-bold">Status</div>
                    <div class="col-sm-4">
                        <div><small><a href="/page/<?= $variables['page'] ?>/sort/status/direction/asc">ASC</a></small></div>
                        <div><small><a href="/page/<?= $variables['page'] ?>/sort/status/direction/desc">DESC</a></small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach($variables['items'] as $item): ?>
        <div class="row task-list-item">
            <div class="col-sm-3"><?= htmlspecialchars($item->getUsername()) ?></div>
            <div class="col-sm-3"><?= htmlspecialchars($item->getUserEmail()) ?></div>
            <div class="col-sm-4">
                <?php if ($_SESSION['user_logged_in']): ?>
                (<a href="/task/<?= $item->getId() ?>/edit">edit</a>)
                <?php endif; ?>
                <?= htmlspecialchars($item->getTaskDescription()) ?>
            </div>
            <div class="col-sm-2">
                <span class="badge badge-<?= ($item->getTaskStatus() == 'In progress') ? 'primary' : 'success' ?>"><?= $item->getTaskStatus() ?></span>
                <?php if ($item->getDescriptionUpdated() == 'yes'): ?>
                    <div><span class="badge badge-info">Edited by Admin</span></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (!empty($variables['pager'])): ?>
    <ul class="pagination">
        <?php foreach($variables['pager'] as $key => $item): ?>
            <?php if ($item['isCurrent']): ?>
                <li class="page-item active"><a class="page-link" href="#"><?= $key ?></a></li>
            <?php else: ?>
                <li class="page-item"><a class="page-link" href="<?= $item['href'] ?>"><?= $key ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>

    </ul>
    <?php endif; ?>
    <?php endif; ?>
    <a class="btn btn-secondary" href="/" role="button">Go Home</a>
</div>
