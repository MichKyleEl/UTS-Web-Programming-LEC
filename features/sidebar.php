<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- If role is admin -->
        <?php if ($role === "admin"): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($urlname === 'admin.php') ? '' : 'collapsed'; ?>" href="admin.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- If role is user -->
        <?php if ($role === "user"): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($urlname === 'index.php') ? '' : 'collapsed'; ?>" href="index.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>
        <?php endif; ?>

        <li class="nav-heading">Pages</li>

        <!-- If role is admin -->
        <?php if ($role === "admin"): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($urlname === 'adminevent.php') ? '' : 'collapsed'; ?>" href="adminevent.php">
                <i class="bi bi-calendar-event"></i>
                <span>Event</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($urlname === 'listofregistrant.php') ? '' : 'collapsed'; ?>" href="listofregistrant.php">
                <i class="bi bi-people"></i>
                <span>List of Registrant</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($urlname === 'usermanagement.php') ? '' : 'collapsed'; ?>" href="usermanagement.php">
                <i class="bi bi-person-lines-fill"></i>
                <span>User Management</span>
            </a>
        </li>
        <?php endif; ?>

        <!-- If role is user -->
        <?php if ($role === "user"): ?>
        <li class="nav-item">
            <a class="nav-link <?php echo ($urlname === 'event.php') ? '' : 'collapsed'; ?>" href="event.php">
                <i class="bi bi-calendar-event"></i>
                <span>Event</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo ($urlname === 'eventregistration.php') ? '' : 'collapsed'; ?>" href="eventregistration.php">
                <i class="bi bi-pencil-square"></i>
                <span>Event Registration</span>
            </a>
        </li>
        <?php endif; ?>

    </ul>
</aside>
