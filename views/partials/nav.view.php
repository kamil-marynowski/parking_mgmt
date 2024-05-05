<nav id="left-nav">
    <div class="nav-tile">
        <h2>Menu</h2>
    </div>
    <div class="nav-tile">
        <a class="nav-link" href="<?= \Core\Config::get('app', 'base_uri') ?>"
           title="Dashboard"
        >
            Dashboard
        </a>
    </div>
    <div class="nav-tile">
        <a class="nav-link" href="<?= \Core\Config::get('app', 'base_uri') . '?route=/admin/parking-areas' ?>"
           title="Parking areas management"
        >
            Parking areas
        </a>
    </div>
    <div class="nav-tile">
        <a class="nav-link" href="<?= \Core\Config::get('app', 'base_uri') . '?route=/payments' ?>"
           title="Payments"
        >
            Payments
        </a>
    </div>
</nav>
