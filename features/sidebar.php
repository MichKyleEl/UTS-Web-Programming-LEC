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
                    <span>Registered Events</span>
                </a>
            </li>
        <?php endif; ?>

    </ul>
    <hr class="hr hr-blurry mb-3" />
    <div class="weather-widget" style="padding: 10px; text-align: center;">
        <h5>Current Weather</h5>
        <div id="weather" style="font-size: 14px;">
            <p>Loading...</p>
        </div>
    </div>

</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const city = 'Kota Tangerang'; // You can change the city
        const url = `https://wttr.in/${city}?format=%C+%t&lang=en`;

        fetch(url)
            .then(response => response.text())
            .then(data => {
                const weatherContainer = document.getElementById('weather');
                weatherContainer.innerHTML = `
                    <p>${city}</p>
                    <p>${data}</p>
                `;
            })
            .catch(() => {
                document.getElementById('weather').innerHTML = '<p>Unable to fetch weather data</p>';
            });
    });
</script>