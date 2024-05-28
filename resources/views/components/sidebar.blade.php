<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">Inventory <i class="fa-solid fa-shop" style="color: #718098;"></i></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}"><i class="fa-solid fa-shop" style="color: #718098;"></i></a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ request()->is('home') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-table-columns"></i> <span>Homepage</span>
                </a>
            </li>
            <li class="{{ request()->is('transaction') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('transactions.index') }}">
                    <i class="fas fa-money-bill"></i> <span>Transactions</span>
                </a>
            </li>
            <li class="{{ request()->is('product') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('product.index') }}">
                    <i class="fas fa-boxes-stacked"></i> <span>Inventory</span>
                </a>
            </li>
            @if (Auth::user()->role == 'owner')
                <li class="{{ request()->is('history*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('history.index') }}">
                        <i class="fas fa-book"></i> <span>History</span>
                    </a>
                </li>
                <li class="{{ request()->is('users*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('user.index') }}">
                        <i class="fas fa-user"></i> <span>Users</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>
