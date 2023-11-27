<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Review</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>review/overview" class="color-inherit">All Reviews</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>review/update" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Profile</legend>
                <!-- ID -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="hidden" name="id" id="id" value="<?= $data['reviews']->reviewId; ?>">
                        </div>
                    </div>
                </div>
                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewRating">Rating</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="number" name="reviewRating" id="reviewRating" min="1" max="5" required value="<?= $data['reviews']->reviewRating; ?>">
                        </div>
                    </div>
                </div>
                <!-- custom select -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewCustomerId">Customer</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="reviewCustomerId" id="reviewCustomerId" required>
                                    <?php foreach ($data['customer'] as $customer) : ?>
                                        <option <?= ($data['reviews']->reviewCustomerId == $customer->customerId) ? "selected" : "" ?> value="<?= $customer->customerId ?>"><?= $customer->customerFirstName ?></option>
                                    <?php endforeach ?>
                                </select>
                                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                    <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewDescription">Review message</label>
                        </div>
                        <div class="col-6@lg">
                            <textarea class="form-control width-100%" name="reviewDescription" id="reviewDescription" required reviewss="2" cols="25" placeholder="Enter your Review message"><?= $data['reviews']->reviewDescription ?></textarea>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="border-top border-alpha padding-md">
            <div class="flex flex-wrap gap-xs justify-between">
                <button class="btn btn--primary">Save</button>
            </div>
        </div>
    </form>
    <form action="<?= URLROOT; ?>review/updateImage/{reviewId:<?= $data['reviews']->reviewId ?>}" method="post" enctype="multipart/form-data">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="file">Add screen</label>
                        </div>
                        <div class="col-6@lg">
                            <input type="file" name="file" id="file" accept="image/*">
                        </div>
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="scope">Scope</label> <br>
                            <br>
                            <div class="col-6@lg">
                                <input type="text" name="scope" id="scope" value="" placeholder="Enter scope">
                            </div>
                            <br>
                        </div>
                        <br>
                        <?php if ($data['images'] && $data['images'] !== URLROOT . 'public/default-image.jpg') : ?>
                            <?php foreach ($data['images'] as $image) : ?>
                                <div class="stats-card bg radius-md padding-md inner-glow shadow-xs col-6@sm col-2@xl">
                                    <div class="flex flex-wrap gap-xxs items-center">
                                        <div>
                                            <h3 class="color-contrast-low"><?= !empty($image->screenScope) ? $image->screenScope : "No Scope" ?></h3>
                                        </div>
                                    </div>
                                    <img class="text-xxl font-semibold color-contrast-higher" src="<?= $image->imagePath ?>" height="200px" width="100%">
                                    <?php if ($image && $image !== URLROOT . 'public/default-image.jpg') : ?>
                                        <a href="#" aria-controls="dialog-delete-user-confirmation-<?= $image->screenId ?>" class="btn btn--danger">Delete Image</a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>There is no image uploaded</p>
                        <?php endif; ?>
                    </div>
            </fieldset>
        </div>
        <div class="border-top border-alpha padding-md">
            <div class="flex flex-wrap gap-xs justify-between">
                <button class="btn btn--primary">Save</button>
            </div>
        </div>
    </form>
</div>
<!-- dialog -->
<?php foreach ($data['images'] as $image) : ?>
    <div class="dialog dialog--sticky js-dialog" id="dialog-delete-user-confirmation-<?= $image->screenId ?>" data-animation="on">
        <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1" aria-describedby="dialog-description">
            <div class="text-component">
                <br>
                <br>
                <h4 id="dialog-title-1">Are you sure you want to delete this image?</h4>
                <p id="dialog-description">This action cannot be undone.</p>
            </div>
            <footer class="margin-top-md">
                <div class="flex justify-end gap-xs flex-wrap">
                    <button class="btn btn--subtle js-dialog__close">Cancel</button>
                    <a class="btn btn--accent" href="<?= URLROOT; ?>review/deleteImage/{screenId:<?= $image->screenId . ';' . 'reviewId:' . $data['reviews']->reviewId ?>}">Delete</a>
                </div>
            </footer>
        </div>
    </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/includes/footer.php'; ?>