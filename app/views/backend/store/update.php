<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Store</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>Store/overview" class="color-inherit">All Stores</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>Store/update" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Store</legend>
                <!-- ID -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="hidden" name="id" id="id" value="<?= $data['row']->storeId; ?>">
                        </div>
                    </div>
                </div>
                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeName">Name</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeName" id="storeName" value="<?= $data['row']->storeName; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeZipcode">ZipCode</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeZipcode" id="storeZipcode" value="<?= $data['row']->storeZipcode; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeStreetName">StreetName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeStreetName" id="storeStreetName" value="<?= $data['row']->storeStreetName; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeCity">City</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeCity" id="storeCity" value="<?= $data['row']->storeCity; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storePhone">Phone Number</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="number" name="storePhone" id="storePhone" value="<?= $data['row']->storePhone; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeEmail">Email</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="email" name="storeEmail" id="storeEmail" value="<?= $data['row']->storeEmail; ?>">
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
    <form action="<?= URLROOT; ?>Store/updateImage/{storeId:<?= $data['row']->storeId ?>}" method="post" enctype="multipart/form-data">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="file">Image</label>
                        </div>
                        <div class="col-6@lg">
                            <input type="file" name="file" id="file" accept="image/*">
                        </div>
                    </div>
                    <div class="margin-bottom-sm">
                        <div class="grid gap-xxs">
                            <div class="col-3@lg">
                                <label class="inline-block text-sm padding-top-xs@lg" for="file">file</label>
                            </div>
                            <div class="col-6@lg">
                                <?php if ($data['imageSrc'] && $data['imageSrc'] !== URLROOT . 'public/default-image.jpg') : ?>
                                    <figure class="user-menu-control__img-wrapper radius-50%">
                                        <img class="user-menu-control__img image_picture" src="<?= $data['imageSrc'] ?>" alt="User picture">
                                    </figure>
                                <?php else : ?>
                                    <p>There is no image uploaded</p>
                                <?php endif; ?>
                                <!-- Add delete button conditionally -->
                                <?php if ($data['imageSrc'] && $data['imageSrc'] !== URLROOT . 'public/default-image.jpg') : ?>
                                    <a href="" aria-controls="dialog-delete-user-confirmation" class="btn btn--danger">Delete Image</a>
                                <?php endif; ?>
                            </div>
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
</div>
<!-- dialog -->
<div class="dialog dialog--sticky js-dialog" id="dialog-delete-user-confirmation" data-animation="on">
    <div class="dialog__content max-width-xxs" role="alertdialog" aria-labelledby="dialog-title-1"
        aria-describedby="dialog-description">
        <div class="text-component">
            <br>
            <br>
            <h4 id="dialog-title-1">Are you sure you want to delete this image?</h4>
            <p id="dialog-description">This action cannot be undone.</p>
        </div>
        <footer class="margin-top-md">
            <div class="flex justify-end gap-xs flex-wrap">
                <button class="btn btn--subtle js-dialog__close">Cancel</button>
                <a class="btn btn--accent" href="<?= URLROOT; ?>Store/deleteImage/{screenId:<?= $data['image']->screenId . ';' . 'storeId:' . $data['row']->storeId ?>}">Delete</a>
            </div>
        </footer>
    </div>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>