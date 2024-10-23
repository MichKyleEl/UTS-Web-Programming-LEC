<?php
$pagename = "Dashboard";
$urlname = "admin.php";
require 'database/config.php'; // config for database connection
require 'authentication.php'; // authentication to manage sessions, etc.
require 'features/navbar.php';
require 'features/sidebar.php';

// Fetch counts from the database
try {
    // Count total admins
    $stmt_admin = $pdo->prepare("SELECT COUNT(*) AS admin_count FROM tb_user WHERE role = 'admin'");
    $stmt_admin->execute();
    $admin_count = $stmt_admin->fetch(PDO::FETCH_ASSOC)['admin_count'];

    // Count total users
    $stmt_user = $pdo->prepare("SELECT COUNT(*) AS user_count FROM tb_user WHERE role = 'user'");
    $stmt_user->execute();
    $user_count = $stmt_user->fetch(PDO::FETCH_ASSOC)['user_count'];

    // Count total registrants (users who have registered for at least one event)
    $stmt_registrant = $pdo->prepare("SELECT COUNT(DISTINCT user_id) AS registrant_count FROM tb_registration");
    $stmt_registrant->execute();
    $registrant_count = $stmt_registrant->fetch(PDO::FETCH_ASSOC)['registrant_count'];

    // Count total available events (events that are open)
    $stmt_event = $pdo->prepare("SELECT COUNT(*) AS event_count FROM tb_event WHERE event_status = 'open'");
    $stmt_event->execute();
    $event_count = $stmt_event->fetch(PDO::FETCH_ASSOC)['event_count'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    // Prepare query to get event names and number of registrants
    $stmt = $pdo->prepare("
        SELECT 
            e.event_name, 
            COUNT(r.registration_id) AS registrant_count 
        FROM tb_event e 
        LEFT JOIN tb_registration r ON e.event_id = r.event_id 
        GROUP BY e.event_id
    ");
    $stmt->execute();
    $event_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare data for the chart
    $chart_data = [];
    foreach ($event_data as $event) {
        $chart_data[] = [
            'value' => (int)$event['registrant_count'],
            'name' => $event['event_name']
        ];
    }

    // Encode the data for passing into JavaScript
    $chart_data_json = json_encode($chart_data);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try {
    $stmt = $pdo->prepare("SELECT * FROM tb_event");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

?>

<!-- main -->
<main id="main" class="main">
    <?php
    require 'features/pagetitle.php';
    ?>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <!-- Admin count -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Admin</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $admin_count; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User count -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">User</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $user_count; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registrant count -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Registrant</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-lines-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $registrant_count; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Available Event count -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Available Event</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?php echo $event_count; ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">

                    <div class="card-body pb-0">
                        <h5 class="card-title">Number of Registrants/Event</h5>

                        <div class="card-body pb-0">

                            <div id="trafficChart" style="min-height: 400px" class="echart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const chartData = <?php echo $chart_data_json; ?>; // PHP data passed to JS

                                    echarts
                                        .init(document.querySelector("#trafficChart"))
                                        .setOption({
                                            tooltip: {
                                                trigger: "item",
                                            },
                                            legend: {
                                                top: "5%",
                                                left: "center",
                                            },
                                            series: [{
                                                name: "Registrants",
                                                type: "pie",
                                                radius: ["40%", "70%"],
                                                avoidLabelOverlap: false,
                                                label: {
                                                    show: false,
                                                    position: "center",
                                                },
                                                emphasis: {
                                                    label: {
                                                        show: true,
                                                        fontSize: "18",
                                                        fontWeight: "bold",
                                                    },
                                                },
                                                labelLine: {
                                                    show: false,
                                                },
                                                data: chartData, // Using dynamic data
                                            }, ],
                                        });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card top-selling overflow-auto">

                    <div class="card-body pb-0">
                        <h5 class="card-title">Available Event</h5>
                        <!-- table -->
                        <style>
                            /* Adjust column widths */
                            .banner-column,
                            .image-column {
                                width: 100px;
                                /* Adjust the width of the banner column */
                                padding: 0px;
                            }


                            .max-participants-column {
                                width: 150px;
                                /* Adjust the width of the max participants column */
                                text-align: center;
                                /* Center the text */
                            }
                        </style>

                        <table class="table table-border">
                            <thead>
                                <tr>
                                    <th scope="col" class="banner-column">Banner</th>
                                    <th scope="col" class="image-column">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Location</th>
                                    <th scope="col" class="max-participants-column">Max Participants</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event) : ?>
                                    <tr>
                                        <!-- Banner -->
                                        <td class="banner-column">

                                            <img src="uploads/<?php echo htmlspecialchars($event['event_banner']); ?>" alt="Event Banner" class="banner-image" />

                                        </td>

                                        <td class="image-column">

                                            <img src="uploads/<?php echo htmlspecialchars($event['event_image']); ?>" alt="Event Image" class="event-image" />

                                        </td>

                                        <!-- Name -->
                                        <td>
                                            <a href="#" class="text-primary fw-bold">
                                                <?php echo htmlspecialchars($event['event_name']); ?>
                                            </a>
                                        </td>

                                        <!-- Date -->
                                        <td><?php echo htmlspecialchars($event['event_date']); ?></td>

                                        <!-- Time -->
                                        <td><?php echo htmlspecialchars($event['event_time']); ?></td>

                                        <!-- Location -->
                                        <td><?php echo htmlspecialchars($event['event_location']); ?></td>

                                        <!-- Max Participants -->
                                        <td class="max-participants-column"><?php echo htmlspecialchars($event['max_participants']); ?></td>

                                        <!-- Status -->
                                        <td><?php echo ucfirst(htmlspecialchars($event['event_status'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="col-lg-12">
                    <table id="table1" class="display table-striped table" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
    </section>

</main>
<!-- end main -->


<?php
require 'features/footer.php';
?>