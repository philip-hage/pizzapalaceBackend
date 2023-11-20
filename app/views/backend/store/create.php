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
    <form action="<?= URLROOT; ?>Store/create" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Store</legend>
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeName">Name</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeName" id="storeName">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeZipcode">ZipCode</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeZipcode" id="storeZipcode">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeStreetName">StreetName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeStreetName" id="storeStreetName">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeCity">City</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="storeCity" id="storeCity">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storePhone">Phone Number</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="number" name="storePhone" id="storePhone">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="storeEmail">Email</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="email" name="storeEmail" id="storeEmail">
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