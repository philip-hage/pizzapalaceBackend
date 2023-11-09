<?php require APPROOT . '/views/includes/head.php'; ?>

<div class="margin-bottom-md">
  <div class="flex flex-column gap-sm flex-row@sm justify-between@sm items-baseline@sm">
    <h1 class="text-lg">Dashboard</h1>

    <div>
      <div class="flex flex-wrap flex-column flex-row@xs gap-xxs">
        <div class="date-range-select flex-shrink-0 js-date-range-select">
          <label class="sr-only" for="select-date-range">Select a date range:</label>

          <div class="select text-sm@sm">
            <select class="select__input form-control" name="select-date-range" id="select-date-range">
              <option value="0">Last Week</option>
              <option value="1">Last Month</option>
              <option value="custom">Custom Range</option>
            </select>

            <svg class="icon select__icon" aria-hidden="true" viewBox="0 0 16 16">
              <polyline points="1 5 8 12 15 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
            </svg>
          </div>
        </div>

        <div class="date-range is-hidden flex-shrink-0 js-date-range">
          <div class="date-range__input js-date-range__input">
            <input type="text" class="js-date-range__text js-date-range__text--start" aria-label="Select start date, format is dd/mm/yyyy">
          </div>

          <div class="date-range__input js-date-range__input">
            <input type="text" class="js-date-range__text js-date-range__text--end" aria-label="Select end date, format is dd/mm/yyyy">
          </div>

          <button class="btn btn--subtle text-sm@sm height-100% width-100% js-date-range__trigger js-tab-focus" aria-label="Select start and end dates using the calendar widget">
            <span class="js-date-range__trigger-label" aria-hidden="true">
              <span>Select dates</span>

              <span class="is-hidden">
                <i class="js-date-range__value js-date-range__value--start">Start date</i> - <i class="js-date-range__value js-date-range__value--end">End date</i>
              </span>
            </span>
          </button>

          <div class="date-picker bg radius-md shadow-md js-date-picker" role="dialog" aria-labelledby="calendar-label-1">
            <header class="date-picker__header">
              <div class="date-picker__month">
                <span class="date-picker__month-label js-date-picker__month-label" id="calendar-label-1"></span> <!-- this will contain month label + year -->

                <nav>
                  <ul class="date-picker__month-nav js-date-picker__month-nav">
                    <li>
                      <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--prev js-tab-focus">
                        <svg class="icon icon--xs" viewBox="0 0 16 16">
                          <title>Previous month</title>
                          <polyline points="11 14 5 8 11 2" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" />
                        </svg>
                      </button>
                    </li>

                    <li>
                      <button class="reset date-picker__month-nav-btn js-date-picker__month-nav-btn js-date-picker__month-nav-btn--next js-tab-focus">
                        <svg class="icon icon--xs" viewBox="0 0 16 16">
                          <title>Next month</title>
                          <polyline points="5 2 11 8 5 14" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2" />
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
</div>

<div class="grid gap-sm">
  <!-- alert -->
  <div class="alert-card bg radius-md padding-md inner-glow shadow-xs col-12 js-alert-card">
    <div class="text-component line-height-lg">
      <h1 class="text-lg flex flex-wrap items-center">
        <svg class="block icon icon--md margin-right-xxs color-accent" viewBox="0 0 32 32" aria-hidden="true">
          <circle opacity="0.2" cx="16" cy="16" r="16" />
          <path opacity="0.2" d="M25.7,3.3A15.98,15.98,0,0,1,3.3,25.7,15.986,15.986,0,1,0,25.7,3.3Z" />
          <circle opacity="0.2" cx="14" cy="9" r="3" />
          <circle opacity="0.2" cx="7.5" cy="16.5" r="1.5" />
          <circle opacity="0.2" cx="19.5" cy="18.5" r="2.5" />
        </svg>
        <span>Welcome to Marte!</span>
      </h1>

      <p class="color-contrast-low">Marte is a premium HTML, CSS, JS template by CodyHouse. <a href="https://codyhouse.co/template/marte">Buy Now &rarr;</a>.</p>
    </div>

    <button class="reset alert-card__close-btn js-tab-focus js-alert-card__close-btn">
      <svg class="icon icon--xs" viewBox="0 0 16 16">
        <title>Hide alert</title>
        <g fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2">
          <line x1="1" y1="1" x2="15" y2="15" />
          <line x1="15" y1="1" x2="1" y2="15" />
        </g>
      </svg>
    </button>
  </div>

  <!-- stats card 1 -->
  <div class="stats-card bg radius-md padding-md inner-glow shadow-xs col-6@sm col-3@xl">
    <div class="flex flex-wrap gap-xxs items-center">
      <div>
        <p class="color-contrast-low">Subscribers</p>
      </div>

      <div class="flex items-center">
        <span class="inline-block bg-success bg-opacity-20% text-xs padding-x-xxs padding-y-xxxxs radius-full">+33.2%</span>
      </div>
    </div>

    <p class="text-xxl font-semibold color-contrast-higher">5,097</p>

    <div class="chart chart--area" id="stats-card-chart-1">
      <div class="chart__area js-chart__area">
        <!-- chart will be created here using JavaScript-->
      </div>
    </div>
  </div>

  <!-- stats card 2 -->
  <div class="stats-card bg radius-md padding-md inner-glow shadow-xs col-6@sm col-3@xl">
    <div class="flex flex-wrap gap-xxs items-center">
      <div>
        <p class="color-contrast-low">Followers</p>
      </div>

      <div class="flex items-center">
        <span class="inline-block bg-error bg-opacity-20% text-xs padding-x-xxs padding-y-xxxxs radius-full">-0.2%</span>
      </div>
    </div>

    <p class="text-xxl font-semibold color-contrast-higher">4,134</p>

    <div class="chart chart--area" id="stats-card-chart-2">
      <div class="chart__area js-chart__area">
        <!-- chart will be created here using JavaScript-->
      </div>
    </div>
  </div>

  <!-- stats card 3 -->
  <div class="stats-card bg radius-md padding-md inner-glow shadow-xs col-6@sm col-3@xl">
    <div class="flex flex-wrap gap-xxs items-center">
      <div>
        <p class="color-contrast-low">Engagement</p>
      </div>

      <div class="flex items-center">
        <span class="inline-block bg-warning bg-opacity-20% text-xs padding-x-xxs padding-y-xxxxs radius-full">+1.7%</span>
      </div>
    </div>

    <p class="text-xxl font-semibold color-contrast-higher">5,097</p>

    <div class="chart chart--area" id="stats-card-chart-3">
      <div class="chart__area js-chart__area">
        <!-- chart will be created here using JavaScript-->
      </div>
    </div>
  </div>

  <!-- stats card 4 -->
  <div class="stats-card bg radius-md padding-md inner-glow shadow-xs col-6@sm col-3@xl">
    <div class="flex flex-wrap gap-xxs items-center">
      <div>
        <p class="color-contrast-low">Watch Time</p>
      </div>

      <div class="flex items-center">
        <span class="inline-block bg-success bg-opacity-20% text-xs padding-x-xxs padding-y-xxxxs radius-full">+7.5%</span>
      </div>
    </div>

    <p class="text-xxl font-semibold color-contrast-higher">27min</p>

    <div class="chart chart--area" id="stats-card-chart-4">
      <div class="chart__area js-chart__area">
        <!-- chart will be created here using JavaScript-->
      </div>
    </div>
  </div>

  <!-- column chart  -->
  <div class="bg radius-md padding-md inner-glow shadow-xs col-12">
    <div class="margin-bottom-md">
      <div class="flex flex-wrap gap-xxs items-center">
        <div>
          <p class="color-contrast-low">Column Chart</p>
        </div>

        <div class="flex items-center">
          <span class="inline-block bg-success bg-opacity-20% text-xs padding-x-xxs padding-y-xxxxs radius-full">+3.5%</span>
        </div>
      </div>
    </div>

    <div class="chart chart--column" id="column-chart-3">
      <div class="chart__area js-chart__area">
        <!-- chart will be created here using JavaScript-->
      </div>

      <div class="margin-top-lg">
        <ul class="flex flex-wrap flex-center gap-md" aria-hidden="true">
          <li class="flex items-center">
            <span class="chart__bullet bg-primary margin-right-xxs"></span>
            <span class="text-sm">Current period</span>
          </li>

          <li class="flex items-center">
            <span class="chart__bullet bg-contrast-high margin-right-xxs"></span>
            <span class="text-sm">Previous period</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- interactive table -->
  <div class="bg radius-md padding-md inner-glow shadow-xs col-12">
    <p class="color-contrast-low margin-bottom-md">Interactive Table</p>

    <div class="int-table-actions padding-bottom-xxxs border-bottom border-alpha" data-table-controls="interactive-table-1">
      <menu class="menu-bar js-int-table-actions__no-items-selected js-menu-bar">
        <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger" role="menuitem" aria-label="More options">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <circle cx="8" cy="7.5" r="1.5" />
            <circle cx="1.5" cy="7.5" r="1.5" />
            <circle cx="14.5" cy="7.5" r="1.5" />
          </svg>
        </li>

        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M8,3c1.179,0,2.311,0.423,3.205,1.17L8.883,6.492l6.211,0.539L14.555,0.82l-1.93,1.93 C11.353,1.632,9.71,1,8,1C4.567,1,1.664,3.454,1.097,6.834l1.973,0.331C3.474,4.752,5.548,3,8,3z"></path>
              <path d="M8,13c-1.179,0-2.311-0.423-3.205-1.17l2.322-2.322L0.906,8.969l0.539,6.211l1.93-1.93 C4.647,14.368,6.29,15,8,15c3.433,0,6.336-2.454,6.903-5.834l-1.973-0.331C12.526,11.248,10.452,13,8,13z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Refresh</span>
        </li>

        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M15,16H1c-0.6,0-1-0.4-1-1V3c0-0.6,0.4-1,1-1h3v2H2v10h12V9h2v6C16,15.6,15.6,16,15,16z"></path>
              <path d="M10,3c-3.2,0-6,2.5-6,7c1.1-1.7,2.4-3,6-3v3l6-5l-6-5V3z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Export</span>
        </li>
      </menu>

      <menu class="menu-bar is-hidden js-int-table-actions__items-selected js-menu-bar">
        <li class="menu-bar__item menu-bar__item--trigger js-menu-bar__trigger" role="menuitem" aria-label="More options">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <circle cx="8" cy="7.5" r="1.5" />
            <circle cx="1.5" cy="7.5" r="1.5" />
            <circle cx="14.5" cy="7.5" r="1.5" />
          </svg>
        </li>

        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M2,6v8c0,1.1,0.9,2,2,2h8c1.1,0,2-0.9,2-2V6H2z"></path>
              <path d="M12,3V1c0-0.6-0.4-1-1-1H5C4.4,0,4,0.4,4,1v2H0v2h16V3H12z M10,3H6V2h4V3z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Delete</span>
        </li>

        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M15.977,4.887a.975.975,0,0,0-.04-.2.909.909,0,0,0-.089-.186,1.048,1.048,0,0,0-.048-.1l-3-4A1,1,0,0,0,12,0H4a1,1,0,0,0-.8.4l-3,4a1.048,1.048,0,0,0-.048.1.892.892,0,0,0-.089.187.957.957,0,0,0-.04.2A.885.885,0,0,0,0,5v9a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V5A.87.87,0,0,0,15.977,4.887ZM8,13.5,5,10H7V7H9v3h2ZM3,4,4.5,2h7L13,4Z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Archive</span>
        </li>

        <li class="menu-bar__item " role="menuitem">
          <svg class="icon menu-bar__icon" aria-hidden="true" viewBox="0 0 16 16">
            <g>
              <path d="M14.6,5.6l-8.2,8.2C6.9,13.9,7.5,14,8,14c3.6,0,6.4-3.1,7.6-4.9c0.5-0.7,0.5-1.6,0-2.3 C15.4,6.5,15,6.1,14.6,5.6z"></path>
              <path d="M14.3,0.3L11.6,3C10.5,2.4,9.3,2,8,2C4.4,2,1.6,5.1,0.4,6.9c-0.5,0.7-0.5,1.6,0,2.2c0.5,0.8,1.4,1.8,2.4,2.7 l-2.5,2.5c-0.4,0.4-0.4,1,0,1.4C0.5,15.9,0.7,16,1,16s0.5-0.1,0.7-0.3l14-14c0.4-0.4,0.4-1,0-1.4S14.7-0.1,14.3,0.3z M5.3,9.3 C5.1,8.9,5,8.5,5,8c0-1.7,1.3-3,3-3c0.5,0,0.9,0.1,1.3,0.3L5.3,9.3z"></path>
            </g>
          </svg>
          <span class="menu-bar__label">Hide</span>
        </li>
      </menu>
    </div>

    <div id="interactive-table-1" class="int-table text-sm js-int-table">
      <div class="int-table__inner">
        <table class="int-table__table" aria-label="Interactive table example">
          <thead class="int-table__header js-int-table__header">
            <tr class="int-table__row">
              <td class="int-table__cell">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-all" type="checkbox" aria-label="Select all rows" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </td>

              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                <div class="flex items-center">
                  <span>ID</span>

                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" />
                  </svg>
                </div>

                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingId" id="sortingIdNone" value="none" checked>
                    <label for="sortingIdNone">No sorting</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingId" id="sortingIdAsc" value="asc">
                    <label for="sortingIdAsc">Sort in ascending order</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingId" id="sortingIdDes" value="desc">
                    <label for="sortingIdDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>

              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                <div class="flex items-center">
                  <span>Name</span>

                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" />
                  </svg>
                </div>

                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingName" id="sortingNameNone" value="none" checked>
                    <label for="sortingNameNone">No sorting</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingName" id="sortingNameAsc" value="asc">
                    <label for="sortingNameAsc">Sort in ascending order</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingName" id="sortingNameDes" value="desc">
                    <label for="sortingNameDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>

              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort">
                <div class="flex items-center">
                  <span>Email</span>

                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" />
                  </svg>
                </div>

                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingEmail" id="sortingEmailNone" value="none" checked>
                    <label for="sortingEmailNone">No sorting</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingEmail" id="sortingEmailAsc" value="asc">
                    <label for="sortingEmailAsc">Sort in ascending order</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingEmail" id="sortingEmailDes" value="desc">
                    <label for="sortingEmailDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>

              <th class="int-table__cell int-table__cell--th text-left">
                Description
              </th>

              <th class="int-table__cell int-table__cell--th int-table__cell--sort js-int-table__cell--sort" data-date-format="dd-mm-yyyy">
                <div class="flex items-center">
                  <span>Date</span>

                  <svg class="icon icon--xxs margin-left-xxxs int-table__sort-icon" aria-hidden="true" viewBox="0 0 12 12">
                    <polygon class="arrow-up" points="6 0 10 5 2 5 6 0" />
                    <polygon class="arrow-down" points="6 12 2 7 10 7 6 12" />
                  </svg>
                </div>

                <ul class="sr-only js-int-table__sort-list">
                  <li>
                    <input type="radio" name="sortingDate" id="sortingDateNone" value="none" checked>
                    <label for="sortingDateNone">No sorting</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingDate" id="sortingDateAsc" value="asc">
                    <label for="sortingDateAsc">Sort in ascending order</label>
                  </li>

                  <li>
                    <input type="radio" name="sortingDate" id="sortingDateDes" value="desc">
                    <label for="sortingDateDes">Sort in descending order</label>
                  </li>
                </ul>
              </th>

              <th class="int-table__cell int-table__cell--th text-left">Location</th>
              <th class="int-table__cell int-table__cell--th text-right">Action</th>
            </tr>
          </thead>

          <tbody class="int-table__body js-int-table__body">
            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">1</td>
              <td class="int-table__cell"><a href="customer.html">Bryony Mcmillan</a></td>
              <td class="int-table__cell">r.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">01/01/2021</td>
              <td class="int-table__cell">Hungary</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">2</td>
              <td class="int-table__cell"><a href="customer.html">Hetty Maxwell</a></td>
              <td class="int-table__cell">f.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">11/10/2020</td>
              <td class="int-table__cell">United Kingdom</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">3</td>
              <td class="int-table__cell"><a href="customer.html">Honey Leblanc</a></td>
              <td class="int-table__cell">v.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">17/09/2020</td>
              <td class="int-table__cell">Maldives</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">4</td>
              <td class="int-table__cell"><a href="customer.html">Maira Hodges</a></td>
              <td class="int-table__cell">a.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">04/08/2020</td>
              <td class="int-table__cell">Iceland</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">5</td>
              <td class="int-table__cell"><a href="customer.html">Nigel Lang</a></td>
              <td class="int-table__cell">g.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">03/07/2020</td>
              <td class="int-table__cell">Italy</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">6</td>
              <td class="int-table__cell"><a href="customer.html">Saif Acevedo</a></td>
              <td class="int-table__cell">l.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">21/05/2020</td>
              <td class="int-table__cell">Argentina</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">7</td>
              <td class="int-table__cell"><a href="customer.html">Isaak O'Gallagher</a></td>
              <td class="int-table__cell">b.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">11/04/2020</td>
              <td class="int-table__cell">Maldives</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">8</td>
              <td class="int-table__cell"><a href="customer.html">Lucille Arias</a></td>
              <td class="int-table__cell">m.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">05/03/2020</td>
              <td class="int-table__cell">Thailand</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">9</td>
              <td class="int-table__cell"><a href="customer.html">Kendall Rankin</a></td>
              <td class="int-table__cell">e.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">02/02/2020</td>
              <td class="int-table__cell">Austria</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>

            <tr class="int-table__row">
              <th class="int-table__cell" scope="row">
                <div class="custom-checkbox int-table__checkbox">
                  <input class="custom-checkbox__input js-int-table__select-row" type="checkbox" aria-label="Select this row" />
                  <div class="custom-checkbox__control" aria-hidden="true"></div>
                </div>
              </th>
              <td class="int-table__cell">10</td>
              <td class="int-table__cell"><a href="customer.html">Raihan Boone</a></td>
              <td class="int-table__cell">c.email@email.com</td>
              <td class="int-table__cell text-truncate max-width-xxxxs">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellat eveniet nisi itaque!</td>
              <td class="int-table__cell">01/01/2020</td>
              <td class="int-table__cell">USA</td>
              <td class="int-table__cell">
                <button class="reset int-table__menu-btn margin-left-auto js-tab-focus" data-label="Edit row" aria-controls="menu-example">
                  <svg class="icon" viewBox="0 0 16 16">
                    <circle cx="8" cy="7.5" r="1.5" />
                    <circle cx="1.5" cy="7.5" r="1.5" />
                    <circle cx="14.5" cy="7.5" r="1.5" />
                  </svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="flex items-center justify-between padding-top-sm">
      <p class="text-sm">450 results</p>

      <nav class="pagination text-sm" aria-label="Pagination">
        <ul class="pagination__list flex flex-wrap gap-xxxs">
          <li>
            <a href="#0" class="pagination__item">
              <svg class="icon" viewBox="0 0 16 16">
                <title>Go to previous page</title>
                <g stroke-width="1.5" stroke="currentColor">
                  <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.5,3.5 5,8 9.5,12.5 "></polyline>
                </g>
              </svg>
            </a>
          </li>

          <li>
            <span class="pagination__jumper flex items-center">
              <input aria-label="Page number" class="form-control" type="text" id="pageNumber" name="pageNumber" value="1">
              <em>of 50</em>
            </span>
          </li>

          <li>
            <a href="#0" class="pagination__item">
              <svg class="icon" viewBox="0 0 16 16">
                <title>Go to next page</title>
                <g stroke-width="1.5" stroke="currentColor">
                  <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline>
                </g>
              </svg>
            </a>
          </li>
        </ul>
      </nav>
    </div>

    <menu id="menu-example" class="menu js-menu" data-scrollable-element=".js-app-ui__body">
      <li role="menuitem">
        <span class="menu__content js-menu__content">
          <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 12 12">
            <path d="M10.121.293a1,1,0,0,0-1.414,0L1,8,0,12l4-1,7.707-7.707a1,1,0,0,0,0-1.414Z"></path>
          </svg>
          <span>Edit</span>
        </span>
      </li>

      <li role="menuitem">
        <span class="menu__content js-menu__content">
          <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 16 16">
            <path d="M15,4H1C0.4,4,0,4.4,0,5v10c0,0.6,0.4,1,1,1h14c0.6,0,1-0.4,1-1V5C16,4.4,15.6,4,15,4z M14,14H2V6h12V14z"></path>
            <rect x="2" width="12" height="2"></rect>
          </svg>
          <span>Copy</span>
        </span>
      </li>

      <li role="menuitem">
        <span class="menu__content js-menu__content">
          <svg class="icon menu__icon" aria-hidden="true" viewBox="0 0 12 12">
            <path d="M8.354,3.646a.5.5,0,0,0-.708,0L6,5.293,4.354,3.646a.5.5,0,0,0-.708.708L5.293,6,3.646,7.646a.5.5,0,0,0,.708.708L6,6.707,7.646,8.354a.5.5,0,1,0,.708-.708L6.707,6,8.354,4.354A.5.5,0,0,0,8.354,3.646Z"></path>
            <path d="M6,0a6,6,0,1,0,6,6A6.006,6.006,0,0,0,6,0ZM6,10a4,4,0,1,1,4-4A4,4,0,0,1,6,10Z"></path>
          </svg>
          <span>Delete</span>
        </span>
      </li>
    </menu>
  </div>

  <!-- percentage bar -->
  <div class="bg radius-md padding-md inner-glow shadow-xs col-12">
    <p class="color-contrast-low margin-bottom-md">Percentage Bar</p>

    <div class="pct-bar flex-grow flex flex-column js-pct-bar">
      <div class="pct-bar__bg js-pct-bar__bg margin-bottom-md" aria-hidden="true">
        <!-- bar fill is created in JS  -->
      </div>

      <ul class="grid gap-xs">
        <li class="flex items-center">
          <span class="pct-bar__bullet bg-primary margin-right-xxs" aria-hidden="true"></span>
          <span class="text-sm">Label 1 (<i class="js-pct-bar__value" data-pct-bar-bg="bg-primary">43%</i>)</span>
        </li>

        <li class="flex items-center">
          <span class="pct-bar__bullet bg-contrast-lower margin-right-xxs" aria-hidden="true"></span>
          <span class="text-sm">Label 2 (<i class="js-pct-bar__value" data-pct-bar-bg="bg-contrast-lower">28%</i>)</span>
        </li>

        <li class="flex items-center">
          <span class="pct-bar__bullet bg-contrast-higher margin-right-xxs" aria-hidden="true"></span>
          <span class="text-sm">Label 3 (<i class="js-pct-bar__value" data-pct-bar-bg="bg-contrast-higher">17%</i>)</span>
        </li>

        <li class="flex items-center">
          <span class="pct-bar__bullet bg-accent margin-right-xxs" aria-hidden="true"></span>
          <span class="text-sm">Label 4 (<i class="js-pct-bar__value" data-pct-bar-bg="bg-accent">12%</i>)</span>
        </li>
      </ul>
    </div>
  </div>

  <!-- pie chart -->
  <div class="bg radius-md padding-md inner-glow shadow-xs col-12 col-4@sm">
    <p class="color-contrast-low margin-bottom-md">Pie Chart</p>

    <div class="pie-chart flex flex-column gap-md js-pie-chart">
      <div class="flex flex-center">
        <div class="pie-chart__area block flex-shrink-0 js-pie-chart__area">
          <!-- svg will be created here using javascript -->
          <!-- tooltip element -->
          <div class="pie-chart__tooltip is-hidden js-pie-chart__tooltip"></div>
        </div>
      </div>

      <div>
        <ul class="grid gap-xs">
          <li class="flex items-center">
            <span class="pie-chart__bullet bg-primary margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 1 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-primary);">43%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="pie-chart__bullet bg-contrast-lower margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 2 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-contrast-lower);">28%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="pie-chart__bullet bg-contrast-higher margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 3 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-contrast-higher);">17%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="pie-chart__bullet bg-accent margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 4 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-accent);">12%</i>)</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- donut chart -->
  <div class="bg radius-md padding-md inner-glow shadow-xs col-12 col-4@sm">
    <p class="color-contrast-low margin-bottom-md">Donut Chart</p>

    <div class="pie-chart flex flex-column gap-md js-pie-chart" data-pie-chart-type="donut">
      <div class="flex flex-center">
        <div class="pie-chart__area block flex-shrink-0 js-pie-chart__area">
          <!-- svg will be created here using javascript -->
          <!-- tooltip element -->
          <div class="pie-chart__tooltip is-hidden js-pie-chart__tooltip"></div>
        </div>
      </div>

      <div>
        <ul class="grid gap-xs">
          <li class="flex items-center">
            <span class="pie-chart__bullet bg-primary margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 1 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-primary);">43%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="pie-chart__bullet bg-contrast-lower margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 2 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-contrast-lower);">28%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="pie-chart__bullet bg-contrast-higher margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 3 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-contrast-higher);">17%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="pie-chart__bullet bg-accent margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 4 (<i class="js-pie-chart__value" data-pie-chart-style="fill: var(--color-accent);">12%</i>)</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- radial bar chart -->
  <div class="bg radius-md padding-md inner-glow shadow-xs col-12 col-4@sm">
    <p class="color-contrast-low margin-bottom-md">Radial Chart</p>

    <div class="radial-bar flex flex-column gap-md js-radial-bar">
      <div class="flex-shrink-0 flex justify-center">
        <div class="radial-bar__area js-radial-bar__area" aria-hidden="true">
          <!-- radial bars are created in JS  -->

          <div class="radial-bar__tooltip is-hidden js-radial-bar__tooltip"></div>
        </div>
      </div>

      <div>
        <ul class="grid gap-xs">
          <li class="flex items-center">
            <span class="radial-bar__bullet bg-primary margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 1 (<i class="js-radial-bar__value" data-radial-bar-color="color-primary">75%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="radial-bar__bullet bg-contrast-higher margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 2 (<i class="js-radial-bar__value" data-radial-bar-color="color-contrast-higher">54%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="radial-bar__bullet bg-success margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 3 (<i class="js-radial-bar__value" data-radial-bar-color="color-success">41%</i>)</span>
          </li>

          <li class="flex items-center">
            <span class="radial-bar__bullet bg-accent margin-right-xxs" aria-hidden="true"></span>
            <span class="text-sm">Label 4 (<i class="js-radial-bar__value" data-radial-bar-color="color-accent">18%</i>)</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/includes/footer.php'; ?>