<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="margin-bottom-md">
    <h1 class="text-lg">Customer</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>customerController/overview" class="color-inherit">All Customers</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>customerController/create" method="post">
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="customerfirstname">FirstName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="customerfirstname" id="customerfirstname" >
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="customerlastname">LastName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="customerlastname" id="customerlastname" >
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="customerstreetname">StreetName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="customerstreetname" id="customerstreetname" >
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="customercity">City</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="customercity" id="customercity" >
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="customerzipcode">ZipCode</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="customerzipcode" id="customerzipcode" >
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="customerphone">Phone</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="number" name="customerphone" id="customerphone" >
                        </div>
                    </div>
                </div>
                <!-- input email -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="customeremail">Email</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="email" name="customeremail" id="customeremail" >
                        </div>
                    </div>
                </div>
                <!-- custom select -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="customertype">Type</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="form-control width-100%" name="customertype" id="customertype" >
                                    <option value="member">Member</option>
                                    <option value="guest">Guest</option>
                                    <option value="admin">Admin</option>
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
                <button class="btn btn--primary saveButton">Save</button>
                <button type="submit" id="hiddenSubmitButton" style="display: none;"></button>
            </div>
        </div>
    </form>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>