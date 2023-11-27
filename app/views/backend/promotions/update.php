<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Promotion</h1>
</div>
<div class="margin-bottom-md">
    <nav class="breadcrumbs text-sm" aria-label="Breadcrumbs">
        <ol class="flex flex-wrap gap-xxs">
            <li class="breadcrumbs__item">
                <a href="<?= URLROOT ?>promotion/overview" class="color-inherit">All Promotions</a>
                <span class="color-contrast-low margin-left-xxs" aria-hidden="true"></span>
            </li>
            <li class="breadcrumbs__item"></li>
        </ol>
    </nav>
</div>
<div class="bg radius-md shadow-xs">
    <form action="<?= URLROOT; ?>promotion/update" method="post">
        <div class="padding-md">
            <!-- basic form controls -->
            <fieldset class="margin-bottom-xl">
                <legend class="form-legend margin-bottom-md">Promotion</legend>
                <!-- ID -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="hidden" name="id" id="id" value="<?= $data['promotions']->promotionId; ?>">
                        </div>
                    </div>
                </div>
                <!-- input text -->
                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="promotionName">Name</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="promotionName" id="promotionName" value="<?= $data['promotions']->promotionName; ?>">
                        </div>
                    </div>
                </div>


                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="promotionStartDate">Start date</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="date-input js-date-input">
                                <?php $promotionStartDate = date("d/m/Y", $data['promotions']->promotionStartDate); ?>
                                <div class="date-input__wrapper">
                                    <input type="text" class="form-control width-100% date-input__text js-date-input__text" name="promotionStartDate" placeholder="JOEHOE" autocomplete="off" id="date-input-1" value="<?= $promotionStartDate ?>">

                                    <button class="reset date-input__trigger js-date-input__trigger js-tab-focus" aria-label="Select date using calendar widget" type="button">
                                        <svg class="icon" aria-hidden="true" viewBox="0 0 20 20">
                                            <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                                <rect x="1" y="4" width="18" height="14" rx="1" />
                                                <line x1="5" y1="1" x2="5" y2="4" />
                                                <line x1="15" y1="1" x2="15" y2="4" />
                                                <line x1="1" y1="9" x2="19" y2="9" />
                                            </g>
                                        </svg>
                                    </button>
                                </div>

                                <div class="date-picker js-date-picker" role="dialog" aria-labelledby="calendar-label-1">
                                    <header class="date-picker__header">
                                        <div class="date-picker__month">
                                            <span class="date-picker__month-label js-date-picker__month-label" id="calendar-label-1"></span> <!-- this will contain month label + year -->

                                            <nav>
                                                <ul class="date-picker__month-nav js-date-picker__month-nav">
                                                    <li>
                                                        <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--prev js-tab-focus" type="button">
                                                            <svg class="icon icon--xs" viewBox="0 0 16 16">
                                                                <title>Previous month</title>
                                                                <polyline points="10 2 4 8 10 14" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                            </svg>
                                                        </button>
                                                    </li>

                                                    <li>
                                                        <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--next js-tab-focus" type="button">
                                                            <svg class="icon icon--xs" viewBox="0 0 16 16">
                                                                <title>Next month</title>
                                                                <polyline points="6 2 12 8 6 14" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                            </svg>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>

                                        <ol class="date-picker__week">
                                            <li>
                                                <div class="date-picker__day">M<span class="sr-only">onday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">T<span class="sr-only">uesday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">W<span class="sr-only">ednesday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">T<span class="sr-only">hursday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">F<span class="sr-only">riday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">S<span class="sr-only">aturday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">S<span class="sr-only">unday</span></div>
                                            </li>
                                        </ol>
                                    </header>

                                    <ol class="date-picker__dates js-date-picker__dates" aria-labelledby="calendar-label-1">
                                        <!-- days will be created using js -->
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="margin-bottom-sm">
                    <div class="grid gap-xxs">
                        <div class="col-3@lg">
                            <label class="inline-block text-sm padding-top-xs@lg" for="promotionEndDate">Start date</label>
                        </div>
                        <div class="col-6@lg">
                            <div class="date-input js-date-input">
                                <?php $promotionEndDate = date("d/m/Y", $data['promotions']->promotionEndDate); ?>
                                <div class="date-input__wrapper">
                                    <input type="text" class="form-control width-100% date-input__text js-date-input__text" name="promotionEndDate" placeholder="JOEHOE" autocomplete="off" id="date-input-1" value="<?= $promotionEndDate ?>">

                                    <button class="reset date-input__trigger js-date-input__trigger js-tab-focus" aria-label="Select date using calendar widget" type="button">
                                        <svg class="icon" aria-hidden="true" viewBox="0 0 20 20">
                                            <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2">
                                                <rect x="1" y="4" width="18" height="14" rx="1" />
                                                <line x1="5" y1="1" x2="5" y2="4" />
                                                <line x1="15" y1="1" x2="15" y2="4" />
                                                <line x1="1" y1="9" x2="19" y2="9" />
                                            </g>
                                        </svg>
                                    </button>
                                </div>

                                <div class="date-picker js-date-picker" role="dialog" aria-labelledby="calendar-label-1">
                                    <header class="date-picker__header">
                                        <div class="date-picker__month">
                                            <span class="date-picker__month-label js-date-picker__month-label" id="calendar-label-1"></span> <!-- this will contain month label + year -->

                                            <nav>
                                                <ul class="date-picker__month-nav js-date-picker__month-nav">
                                                    <li>
                                                        <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--prev js-tab-focus" type="button">
                                                            <svg class="icon icon--xs" viewBox="0 0 16 16">
                                                                <title>Previous month</title>
                                                                <polyline points="10 2 4 8 10 14" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                            </svg>
                                                        </button>
                                                    </li>

                                                    <li>
                                                        <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--next js-tab-focus" type="button">
                                                            <svg class="icon icon--xs" viewBox="0 0 16 16">
                                                                <title>Next month</title>
                                                                <polyline points="6 2 12 8 6 14" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                                            </svg>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>

                                        <ol class="date-picker__week">
                                            <li>
                                                <div class="date-picker__day">M<span class="sr-only">onday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">T<span class="sr-only">uesday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">W<span class="sr-only">ednesday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">T<span class="sr-only">hursday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">F<span class="sr-only">riday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">S<span class="sr-only">aturday</span></div>
                                            </li>
                                            <li>
                                                <div class="date-picker__day">S<span class="sr-only">unday</span></div>
                                            </li>
                                        </ol>
                                    </header>

                                    <ol class="date-picker__dates js-date-picker__dates" aria-labelledby="calendar-label-1">
                                        <!-- days will be created using js -->
                                    </ol>
                                </div>
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
    <form action="<?= URLROOT; ?>promotion/updateImage/{promotionId:<?= $data['promotions']->promotionId ?>}" method="post" enctype="multipart/form-data">
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
                                        <!-- Modify the link to include aria-controls dynamically -->
                                        <a href="#" aria-controls="dialog-delete-user-confirmation-<?= $image->screenId ?>" class="btn btn--danger js-delete-image-btn">Delete Image</a>
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
                    <a class="btn btn--accent" href="<?= URLROOT; ?>promotion/deleteImage/{screenId:<?= $image->screenId . ';' . 'promotionId:' . $data['promotions']->promotionId ?>}">Delete</a>
                </div>
            </footer>
        </div>
    </div>
<?php endforeach; ?>
<?php require APPROOT . '/views/includes/footer.php'; ?>