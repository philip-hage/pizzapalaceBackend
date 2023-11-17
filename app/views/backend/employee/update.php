<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Employee</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>employeeController/overview" class="color-inherit">All Employees</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>employeeController/update" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Profile</legend>
                <!-- ID -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="hidden" name="id" id="id" value="<?= $data['row']->employeeId; ?>">
                        </div>
                    </div>
                </div>
                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeeFirstName">FirstName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="employeeFirstName" id="employeeFirstName" value="<?= $data['row']->employeeFirstName; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeeLastName">LastName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="employeeLastName" id="employeeLastName" value="<?= $data['row']->employeeLastName; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeeStreetName">StreetName</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="employeeStreetName" id="employeeStreetName" value="<?= $data['row']->employeeStreetName; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeeCity">City</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="employeeCity" id="employeeCity" value="<?= $data['row']->employeeCity; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeeZipCode">ZipCode</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="employeeZipCode" id="employeeZipCode" value="<?= $data['row']->employeeZipCode; ?>">
                        </div>
                    </div>
                </div>
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeePhone">Phone</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="number" name="employeePhone" id="employeePhone" value="<?= $data['row']->employeePhone; ?>">
                        </div>
                    </div>
                </div>
                <!-- input email -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeeEmail">Email</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="email" name="employeeEmail" id="employeeEmail" value="<?= $data['row']->employeeEmail; ?>">
                        </div>
                    </div>
                </div>
                <!-- custom select -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="employeeRole">Type</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="select">
                                <select class="select__input form-control" name="employeeRole" id="employeeRole">
                                    <option><?php echo $data['row']->employeeRole; ?></option>
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
    <form action="<?= URLROOT; ?>employeeController/updateImage/<?= $data['row']->employeeId ?>" method="post" enctype="multipart/form-data">
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
                                    <a href="<?= URLROOT; ?>employeeController/deleteImage/<?= $data['image']->screenId ?>" class="btn btn--danger">Delete Image</a>
                                <?php endif; ?>
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