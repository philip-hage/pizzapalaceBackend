<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Product</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>product/overview" class="color-inherit">All Products</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>product/update" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Profile</legend>
                <!-- ID -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="hidden" name="id" id="id" value="<?= $data['products']->productId; ?>">
                        </div>
                    </div>
                </div>
                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="productName">FirstName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="productName" id="productName" value="<?= $data['products']->productName; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="productPrice">LastName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="productPrice" id="productPrice" value="<?= $data['products']->productPrice; ?>">
                        </div>
                    </div>
                </div>
                <!-- custom select -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="productType">Type</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="select__input form-control" name="productType" id="productType">
                                    <?php foreach ($data['productType'] as $value => $name) : ?>
                                        <option <?= ($data['products']->productType == $value) ? "selected" : "" ?> value="<?= $value ?>"><?= $name ?></option>
                                    <?php endforeach; ?>
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="productOwner">Customer</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="productOwner" id="productOwner" required>
                                    <?php foreach ($data['customer'] as $customer) : ?>
                                        <option <?= ($data['products']->productOwner == $customer->customerId) ? "selected" : "" ?> value="<?= $customer->customerId ?>"><?= $customer->customerFirstName ?></option>
                                    <?php endforeach ?>
                                </select>
                                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                    <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
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
    <form action="<?= URLROOT; ?>product/updateImage/{productId:<?= $data['products']->productId ?>}" method="post" enctype="multipart/form-data">
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
                                    <a href="#" aria-controls="dialog-delete-user-confirmation" class="btn btn--danger">Delete Image</a>
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
                <a class="btn btn--accent" href="<?= URLROOT; ?>product/deleteImage/{screenId:<?= $data['image']->screenId . ';' . 'productId:' . $data['products']->productId ?>}">Delete</a>
            </div>
        </footer>
    </div>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>