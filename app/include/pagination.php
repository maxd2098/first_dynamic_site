<nav aria-label="Пример навигации по страницам">
    <ul class="pagination justify-content-center">
        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?=$page - 1; ?>">Prev</a>
            </li>
            <?php if($page > 2): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?=$page - 2; ?>"><?=$page - 2; ?></a>
                </li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?=$page - 1; ?>"><?=$page - 1; ?></a>
            </li>
        <?php endif; ?>
        
        <li class="page-item">
            <a class="page-link present-page"><?=$page; ?></a>
        </li>
        <?php if($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?=$page + 1; ?>"><?=$page + 1; ?></a>
            </li>
            <?php if($page < $total_pages - 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?=$page + 2; ?>"><?=$page + 2; ?></a>
                </li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?=$page + 1; ?>">Next</a>
            </li>
        <?php endif; ?>
        
    </ul>
</nav>
