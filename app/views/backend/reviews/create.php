<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Reviews</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>Review/overview" class="color-inherit">All Reviews</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>Review/create" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Profile</legend>
                <!-- ID -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="hidden" name="id" id="id">
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
                            <input class="form-control width-100%" type="number" name="reviewRating" id="reviewRating" required min="1" max="5">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewCustomerId">Customer</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="reviewCustomerId" id="reviewCustomerId" required>
                                    <?php foreach ($data['customer'] as $customer) : ?>
                                        <option value="<?= $customer->customerId ?>"><?= $customer->customerFirstName . " " . $customer->customerLastName ?></option>
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewEntity">Entity Type</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="reviewEntity" id="reviewEntity" required>
                                    <option value="" disabled selected>Select Entity Type</option>
                                    <option value="product">Product</option>
                                    <option value="order">Order</option>
                                    <option value="store">Store</option>
                                </select>
                                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                    <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm" id="productDropdown" style="display:none;">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewEntityId">Product</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="reviewEntityId" id="reviewEntityId" required>
                                    <?php foreach ($data['products'] as $product) : ?>
                                        <option value="<?= $product->productId ?>"><?= $product->productName ?></option>
                                    <?php endforeach ?>
                                </select>
                                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                    <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm" id="orderDropdown" style="display:none;">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewEntityId">Order</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="reviewEntityId" id="reviewEntityId" required>
                                    <?php foreach ($data['orders'] as $order) : ?>
                                        <option value="<?= $order->orderId ?>"><?= $order->orderId ?></option>
                                    <?php endforeach ?>
                                </select>
                                <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
                                    <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm" id="storeDropdown" style="display:none;">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="reviewEntityId">Store</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="reviewEntityId" id="reviewEntityId" required>
                                    <?php foreach ($data['store'] as $store) : ?>
                                        <option value="<?= $store->storeId ?>"><?= $store->storeName ?></option>
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
                            <textarea class="form-control width-100%" name="reviewDescription" id="reviewDescription" required rows="2" cols="25" placeholder="Enter your Review message"></textarea>
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
<?php require APPROOT . '/views/includes/footer.php'; ?>