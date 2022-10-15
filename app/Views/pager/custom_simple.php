<?php $pager->setSurroundCount(3) ?>
<div class="col-md-6">
    <!--Pagination 2-->
    <nav class="Pager2 float-right" aria-label="pagination example">
        <ul class="pagination justify-content-center">

            <!--Arrow left-->
            <li class="page-item <?= $pager->hasPreviousPage() ? '' : 'disabled' ?>"">
                        <a class=" page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php foreach ($pager->links() as $link) : ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>"><a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a></li>
            <?php endforeach ?>
            <li class="page-item <?= $pager->hasNextPage() ? '' : 'disabled' ?>">
                <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
</div>