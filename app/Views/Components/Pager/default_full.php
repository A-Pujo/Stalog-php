<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="my-4">
    <ul class="pagination justify-content-center">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="page-item">
            <a href="<?= $pager->getFirst() ?>" aria-label="First" class="page-link">
                <span aria-hidden="true">First</span>
            </a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link) : ?>
        <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
            <a class="page-link" href="<?= $link['uri'] ?>">
                <?= $link['title'] ?>
            </a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a href="<?= $pager->getLast() ?>" aria-label="Last" class="page-link">
                <span aria-hidden="true">Last</span>
            </a>
        </li>
    <?php endif ?>
    </ul>
</nav>