<?php $this->layout('app:layout');?>
<?php if(isset($page)): ?>
    <?= '------' . $page->id . '======' ?>
<?php endif ?>