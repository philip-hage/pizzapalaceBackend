<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Order</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>order/ordersOverview" class="color-inherit">All Orders</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>order/update" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Profile</legend>
                <!-- ID -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="hidden" name="id" id="id" value="<?= $data['orders']->orderId; ?>">
                        </div>
                    </div>
                </div>
                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="orderStoreId">Store</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="orderStoreId" id="orderStoreId" required>
                                    <?php foreach ($data['store'] as $store) : ?>
                                        <option <?= ($data['orders']->orderStoreId == $store->storeId) ? "selected" : "" ?> value="<?= $store->storeId ?>"><?= $store->storeName ?></option>
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="orderCustomerId">Customer</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="orderCustomerId" id="orderCustomerId" required>
                                    <?php foreach ($data['customer'] as $customer) : ?>
                                        <option <?= ($data['orders']->orderCustomerId == $customer->customerId) ? "selected" : "" ?> value="<?= $customer->customerId ?>"><?= $customer->customerFirstName ?></option>
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="orderPrice">Price</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="orderPrice" id="orderPrice" value="<?= $data['orders']->orderPrice; ?>">
                        </div>
                    </div>
                </div>
                <!-- custom select -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="orderState">State</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="select__input form-control" name="orderState" id="orderState">
                                    <?php foreach ($data['orderState'] as $value => $name) : ?>
                                        <option <?= ($data['orders']->orderState == $value) ? "selected" : "" ?> value="<?= $value ?>"><?= $name ?></option>
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="orderStatus">Status</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="select__input form-control" name="orderStatus" id="orderStatus">
                                    <?php foreach ($data['orderStatus'] as $value => $name) : ?>
                                        <option <?= ($data['orders']->orderStatus == $value) ? "selected" : "" ?> value="<?= $value ?>"><?= $name ?></option>
                                    <?php endforeach; ?>
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
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>