<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="bg-dark min-height-100vh flex flex-center padding-md">
    <form class="bg radius-md shadow-sm padding-lg max-width-xx" action="<?= URLROOT ?>IngredientController/delete/<?= $data["ingredientId"] ?>" method="post">
        <div class="text-center margin-bottom-md">
            <h1><?= $data['title'] ?></h1>
        </div>
        <div class="margin-bottom-sm">
            <input type="hidden" value="<?= $data["ingredientId"] ?>" name="ingredientId">
            <button type="submit" class="btn btn--primary btn--md width-100%">Yes</button>
        </div>
        <div class="text-center">
            <p class="text-sm"><a href="<?= URLROOT ?>IngredientController/overview">&larr; Back to index</a></p>
        </div>
    </form>
</div>



<?php require APPROOT . '/views/includes/footer.php'; ?>