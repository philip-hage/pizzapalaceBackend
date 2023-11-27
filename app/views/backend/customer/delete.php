<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="bg-dark min-height-100vh flex flex-center padding-md">
    <form class="bg radius-md shadow-sm padding-lg max-width-xx" action="<?= URLROOT ?>customer/delete/{customerId:<?= $data["customerId"] ?>}" method="post">
        <div class="text-center margin-bottom-md">
            <h1><?= $data['title'] ?></h1>
        </div>
        <div class="margin-bottom-sm">
            <input type="hidden" value="<?= $data["customerId"] ?>" name="customerId">
            <button type="submit" class="btn btn--primary btn--md width-100%">Yes</button>
        </div>
        <div class="text-center">
            <p class="text-sm"><a href="<?= URLROOT ?>customer/overview">&larr; Back to index</a></p>
        </div>
    </form>
</div>



<?php require APPROOT . '/views/includes/footer.php'; ?>