<div class="list-group">
    <a href="{{route('dashboard')}}" class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Dashboard</div>
        <i class="icon-user"></i></a>
    <a href="{{route('dashboard.billing')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Billing information</div>
        <i class="icon-credit-card"></i></a>
    <a href="{{route('my-subscriptions.index')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>My Subscriptions</div>
        <i class="icon-money-check"></i></a>
    <a href="{{route('licensed.videos')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Licensed Videos</div>
        <i class="icon-video"></i></a>
    <a href="{{route('dashboard.orders')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>My Transactions</div>
        <i class="icon-money"></i></a>
    <a href="{{route('dashboard.profile')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Profile</div>
        <i class="icon-user"></i></a>
    <a href="{{route('dashboard.password')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Password</div>
        <i class="icon-key"></i>
    </a>
    <a href="{{route('dashboard.brand-colors')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Brand Colors</div>
        <i class="icon-picture"></i>
    </a>
    <a href="{{route('operate-locations.index')}}"
       class="list-group-item list-group-item-action d-flex justify-content-between">
        <div>Operate Locations</div>
        <i class="icon-location"></i>
    </a>
    <a class="list-group-item list-group-item-action d-flex justify-content-between" href="#"
       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
        {{ __('Logout') }} <i class="icon-line2-logout"></i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

@if (Auth::user()->is_admin)
    <div class="fancy-title topmargin title-border">
        <h4>Admin</h4>
    </div>

    <div class="list-group">
        {{--        Subscriptions--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!!
Request::route()->getName() == 'admin.orders' ||
Request::route()->getName() == 'admin-canceled-subscription' ? 'active' : '' !!}">
                Subscriptions
            </div>
            <div class="admin-dd-content {!!
Request::route()->getName() == 'admin.orders' ||
Request::route()->getName() == 'admin-canceled-subscription' ? 'active' : '' !!}">
                <a href="/admin/subscriptions"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Subscriptions</div>
                    <i class="icon-money"></i></a>

                <a href="/admin/subscriptions/canceled"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Canceled Subscriptions</div>
                    <i class="icon-money"></i></a>
            </div>
        </div>
        {{--        Transactions--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!!
Request::route()->getName() == 'upcoming-transactions' ||
Request::route()->getName() == 'failed-transactions' ? 'active' : '' !!}">
                Transactions
            </div>
            <div class="admin-dd-content {!!
Request::route()->getName() == 'upcoming-transactions' ||
Request::route()->getName() == 'failed-transactions' ? 'active' : '' !!}">
                <a href="/admin/upcoming-transactions"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Upcoming transactions</div>
                    <i class="icon-money-bill-wave"></i></a>

                <a href="/admin/failed-transactions"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Failed transactions</div>
                    <i class="icon-file-invoice"></i></a>
            </div>
        </div>
        {{--        Coupons--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!!
Request::route()->getName() == 'admin.coupons' ||
Request::route()->getName() == 'admin.coupons.additional' ? 'active' : '' !!}">Coupons
            </div>
            <div class="admin-dd-content {!!
Request::route()->getName() == 'admin.coupons' ||
Request::route()->getName() == 'admin.coupons.additional' ? 'active' : '' !!}">
                <a href="/admin/coupons" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Coupons</div>
                    <i class="icon-money-check-alt"></i></a>

                <a href="/admin/additional-coupons"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Additional Videos Coupons</div>
                    <i class="icon-money-check-alt"></i></a>
            </div>
        </div>
        {{--        Vodeos and gallery--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!!
Request::route()->getName() == 'admin.gallery' ||
Request::route()->getName() == 'admin.templates' ? 'active' : '' !!}">
                Video edit management
            </div>
            <div class="admin-dd-content {!!
Request::route()->getName() == 'admin.gallery' ||
Request::route()->getName() == 'admin.templates' ? 'active' : '' !!}">
                <a href="/admin/gallery" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Gallery</div>
                    <i class="icon-cog"></i></a>
                <a href="/admin/templates" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Templates</div>
                    <i class="icon-th-large"></i></a>
            </div>
        </div>
        {{--        Partnership--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!!
Request::route()->getName() == 'admin.sales-rep.index' ||
Request::route()->getName() == 'admin.partner-company.index' ||
Request::route()->getName() == 'admin.leads.index' ? 'active' : '' !!}">
                Partnership
            </div>
            <div class="admin-dd-content {!!
Request::route()->getName() == 'admin.sales-rep.index' ||
Request::route()->getName() == 'admin.partner-company.index' ||
Request::route()->getName() == 'admin.leads.index' ? 'active' : '' !!}">
                <a href="/admin/sales-rep"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Sales Rep</div>
                    <i class="icon-book2"></i></a>
                <a href="/admin/partner-company"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Partner Companies</div>
                    <i class="icon-book2"></i></a>
                <a href="/admin/leads" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Leads</div>
                    <i class="icon-book2"></i></a>
            </div>
        </div>
        {{--        Exports--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!! Request::route()->getName() == 'export' ? 'active' : '' !!}">
                Exports
            </div>
            <div class="admin-dd-content {!! Request::route()->getName() == 'export' ? 'active' : '' !!}">
                <a href="{{route('export')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Export</div>
                    <i class="icon-file-export"></i></a>
            </div>
        </div>
        {{--        Tax management--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!! Request::route()->getName() == 'tax-rate.index' ? 'active' : '' !!}">
                Tax management
            </div>
            <div class="admin-dd-content {!! Request::route()->getName() == 'tax-rate.index' ? 'active' : '' !!}">
                <a href="{{route('tax-rate.index')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Tax Rates</div>
                    <i class="icon-taxi"></i></a>
            </div>
        </div>
        {{--        Accounts--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!!
Request::route()->getName() == 'admin.video-orders' ||
Request::route()->getName() == 'admin.accounts'
 ? 'active' : '' !!}">Accounts
            </div>
            <div class="admin-dd-content {!!
Request::route()->getName() == 'admin.video-orders' ||
Request::route()->getName() == 'admin.accounts'
 ? 'active' : '' !!}">
                <a href="{{route('admin.video-orders')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Video orders</div>
                    <i class="icon-folder"></i></a>
                <a href="/admin/accounts" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Accounts</div>
                    <i class="icon-users"></i></a>
            </div>
        </div>
        {{--        Other--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!! Request::route()->getName() == 'support-pages.index' ? 'active' : '' !!}">
                Other
            </div>
            <div class="admin-dd-content {!! Request::route()->getName() == 'support-pages.index' ? 'active' : '' !!}">
                <a href="{{route('support-pages.index')}}"
                   class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Support Pages</div>
                    <i class="icon-support"></i></a>
            </div>
        </div>
        {{--        Dev--}}
        <div class="admin-dd-wrapper">
            <div class="admin-dd-title {!! Request::route()->getName() == 'admin.logs' ? 'active' : '' !!}">
                Development
            </div>
            <div class="admin-dd-content {!! Request::route()->getName() == 'admin.logs' ? 'active' : '' !!}">
                <a href="/admin/logs" class="list-group-item list-group-item-action d-flex justify-content-between">
                    <div>Logs</div>
                    <i class="icon-book2"></i></a>
            </div>
        </div>

    </div>
@endif

@section('css_admin_additional')
    <style>
        .admin-dd-title {
            padding: 0.75rem 1.25rem;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            text-align: center;
            cursor: pointer;
        }

        .admin-dd-title.active {
            background-color: #dfdddd;
        }

        .admin-dd-content {
            display: none;
        }

        .admin-dd-content.active {
            display: flex;
            flex-direction: column;
        }
    </style>
@endsection

@section('js_admin_additional')
    <script>
        $('.admin-dd-title').click(function () {
            $('.admin-dd-content').removeClass('active')
            $('.admin-dd-title').removeClass('active')
            $(this).siblings('.admin-dd-content').addClass('active')
            $(this).addClass('active')
        })
    </script>
@endsection
