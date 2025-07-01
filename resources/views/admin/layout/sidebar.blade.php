<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a class="has-arrow ai-icon" href="{{ url('dashboard') }}" aria-expanded="false">
                    <i class="flaticon-dashboard-1"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-app-store"></i>
                    <span class="nav-text">Manage Staff</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ url('staff') }}">All Staff</a></li>
                    <li><a href="{{ url('default-access') }}">Default Access</a></li>
                </ul>
            </li>
            {{-- <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-settings-6"></i>
                    <span class="nav-text">Extended Horoscope<span class="badge badge-danger badge-xs ms-1">NEW</span></span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="content.html">Find Moon Sign</a></li>
                    <li><a href="content-add.html"> Find Sun Sign</a></li>
                    <li><a href="menu.html">Find ascendant</a></li>
                    <li><a href="email-template.html">Current Sade Sati</a></li>
                    <li><a href="add-email.html">Extended Kundli Details</a></li>
                    <li><a href="blog.html">Shad Bala</a></li>
                    <li><a href="add-email.html">Sade Sati Table</a></li>
                    <li><a href="add-blog.html">Friendship Table</a></li>
                    <li><a href="blog-category.html">KP-Houses</a></li>
                    <li><a href="blog-category.html">KP-Planets</a></li>
                    <li><a href="blog-category.html">Gem Suggestion</a></li>
                    <li><a href="blog-category.html">Numero Table</a></li>
                    <li><a href="blog-category.html">Rudraksh Suggestion</a></li>
                    <li><a href="blog-category.html">Varshapal Details</a></li>
                    <li><a href="blog-category.html">Varshapal Month Chart</a></li>
                    <li><a href="blog-category.html">Varshapal Year Chart</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-statistics"></i>
                    <span class="nav-text">Horoscope (Kundali)</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="chart-flot.html">Planet Details</a></li>
                    <li><a href="chart-morris.html">Ascendant Report</a></li>
                    <li><a href="chart-chartjs.html">Planet Report</a></li>
                    <li><a href="chart-chartist.html">Personal Characteristics</a></li>
                    <li><a href="chart-sparkline.html">Divisional Charts</a></li>
                    <li><a href="chart-peity.html">Chart Image</a></li>
                    <li><a href="chart-peity.html">Ashtakvarga</a></li>
                    <li><a href="chart-peity.html">Binnashtakvarga</a></li>
                    <li><a href="chart-peity.html">Western Planets</a></li>
                </ul>
            </li>
            <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-exchange"></i>
                    <span class="nav-text">Matching</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="ui-accordion.html">North Match</a></li>
                    <li><a href="ui-alert.html">North Match with Astro details</a></li>
                    <li><a href="ui-badge.html">South Match</a></li>
                    <li><a href="ui-button.html">South Match with Astro details Copy</a></li>
                    <li><a href="ui-modal.html">Aggregate Match</a></li>
                    <li><a href="ui-button-group.html">Rajju Vedha Match</a></li>
                    <li><a href="ui-list-group.html">Papasamaya Match</a></li>
                    <li><a href="ui-media-object.html">Nakshatra Match</a></li>
                    <li><a href="ui-card.html">Western Match</a></li>
                    <li><a href="ui-carousel.html">Bulk North Match</a></li>
                    <li><a href="ui-dropdown.html">Bulk South Match</a></li>
                    <li><a href="ui-popover.html">Bulk West Match</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-plugin"></i>
                    <span class="nav-text">Panchang</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="uc-select2.html">Panchang</a></li>
                    <li><a href="uc-nestable.html">Monthly Panchang</a></li>
                    <li><a href="uc-noui-slider.html">Choghadiya Muhurta</a></li>
                    <li><a href="uc-sweetalert.html">Hora Muhurta</a></li>
                    <li><a href="uc-toastr.html">Moon Calendar</a></li>
                    <li><a href="map-jqvmap.html">Moon Phase</a></li>
                    <li><a href="uc-lightgallery.html">Moon Rise</a></li>
                    <li><a href="uc-lightgallery.html">Moon Set</a></li>
                    <li><a href="uc-lightgallery.html">Solar Noon</a></li>
                    <li><a href="uc-lightgallery.html">Sun Rise</a></li>
                    <li><a href="uc-lightgallery.html">Sun Set</a></li>
                    <li><a href="uc-lightgallery.html">Retrogrades</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-form"></i>
                    <span class="nav-text">Predictions (daily, weekly, etc)</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="form-element.html">Daily Sun</a></li>
                    <li><a href="form-wizard.html">Daily Nakshatra</a></li>
                    <li><a href="form-ckeditor.html">Daily Moon</a></li>
                    <li><a href="form-pickers.html">Weekly Moon</a></li>
                    <li><a href="form-validation-jquery.html">Weekly Sun</a></li>
                    <li><a href="form-validation-jquery.html">yearly</a></li>
                    <li><a href="form-validation-jquery.html">BioRhythm</a></li>
                    <li><a href="form-validation-jquery.html">Day Number</a></li>
                    <li><a href="form-validation-jquery.html">Numerology</a></li>
                </ul>
            </li> --}}
        </ul>
    </div>
</div>