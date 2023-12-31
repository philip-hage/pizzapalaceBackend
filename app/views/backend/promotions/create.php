<?php require APPROOT . '/views/includes/head.php'; ?>
<div class="margin-bottom-md">
    <h1 class="text-lg">Promotions</h1>
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
    <form action="<?= URLROOT; ?>promotion/create" method="post">
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
                            <label class="inline-block text-sm padding-top-xs@lg" for="promotionName">Name</label>
                        </div>
                        <div class="col-6@lg">
                            <input class="form-control width-100%" type="text" name="promotionName" id="promotionName">
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
                                <div class="date-input__wrapper">
                                    <input type="text" class="form-control width-100% date-input__text js-date-input__text" name="promotionStartDate" placeholder="dd/mm/yyyy" autocomplete="off" id="date-input-1">

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
                                <div class="date-input__wrapper">
                                    <input type="text" class="form-control width-100% date-input__text js-date-input__text" name="promotionEndDate" placeholder="dd/mm/yyyy" autocomplete="off" id="date-input-1">

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
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>