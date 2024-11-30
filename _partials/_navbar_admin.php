<!-- Navigation Bar -->
<nav>
    <ul class="columns">
        <div class="column is-flex">
            <li class="is-flex is-align-items-center ml-5"><img src="..\media\logo\dcnhs.png" alt="" width="30px"></li>
            <li><a href="">System Administration</a></li>
            <li class="is-flex is-align-content-center"><a href="../index.php">Home</a></li>
        </div>
        <div class="column is-flex">
        </div>
        <div class="column is-flex">
            <?php if (isset($_SESSION['username']) && $_SESSION['is_admin']): ?>
                <li class="is-flex is-align-content-center" style="position: relative;">
                    <a href="#" id="notification-icon" class="mx-0 is-flex is-align-content-center">
                        <?php
                        // Include the database connection file
                        include("../db_connection.php");

                        // Fetch the number of pending bookings and referrals
                        $pendingBookings = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE status = 'pending' AND notification_status = 'unread' AND status NOT IN ('finished', 'on process')")->fetch_assoc()['count'];
                        $pendingReferrals = $conn->query("SELECT COUNT(*) as count FROM referrals WHERE status = 'pending' AND notification_status = 'unread'")->fetch_assoc()['count'];
                        $upcomingBookings = $conn->query("SELECT COUNT(*) as count FROM bookings WHERE schedule BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 DAY) AND status NOT IN ('finished', 'on process')")->fetch_assoc()['count'];
                        $totalNotifications = $pendingBookings + $pendingReferrals + $upcomingBookings;
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="20px">
                            <path d="<?php echo $totalNotifications > 0 ? 'M19 17V11.8C18.5 11.9 18 12 17.5 12H17V18H7V11C7 8.2 9.2 6 12 6C12.1 4.7 12.7 3.6 13.5 2.7C13.2 2.3 12.6 2 12 2C10.9 2 10 2.9 10 4V4.3C7 5.2 5 7.9 5 11V17L3 19V20H21V19L19 17M10 21C10 22.1 10.9 23 12 23S14 22.1 14 21H10M21 6.5C21 8.4 19.4 10 17.5 10S14 8.4 14 6.5 15.6 3 17.5 3 21 4.6 21 6.5' : 'M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21' ?>" />
                        </svg>
                        <?php if ($totalNotifications > 0): ?>
                            <span class="notification-badge"><?php echo $totalNotifications; ?></span>
                        <?php endif; ?>
                    </a>
                    <div id="notification-popover"
                        style="display: none; position: absolute; top: 40px; right: 0; background: white; border: 1px solid #ccc; padding: 10px; z-index: 1000;">
                        <ul>
                            <?php if ($pendingBookings > 0): ?>
                                <li style="width: 300px;" class="button is-white">
                                    <a href="bookings.php" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                                        Pending Bookings: <?php echo $pendingBookings; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($pendingReferrals > 0): ?>
                                <li style="width: 300px;" class="button is-white">
                                    <a href="referrals.php" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                                        Pending Referrals: <?php echo $pendingReferrals; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($upcomingBookings > 0): ?>
                                <li style="width: 300px;" class="button is-white">
                                    <a href="bookings.php" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                                        Upcoming Bookings: <?php echo $upcomingBookings; ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if ($pendingBookings == 0 && $pendingReferrals == 0 && $upcomingBookings == 0): ?>
                                <li style="width: 300px;">No pending notifications</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['username'])): ?>
                <?php if ($_SESSION['is_admin']): ?>
                    <li class="is-flex is-align-content-center"><a href="../admin/referrals.php">Admin</a></li>
                <?php endif; ?>
                <li class="is-flex is-align-content-center"><a href="../logout.php">Logout</a></li>
            <?php else: ?>
                <li class="is-flex is-align-content-center"><a href="../login.php">Login</a></li>
            <?php endif; ?>
        </div>
    </ul>
</nav>

<script>
    document.getElementById('notification-icon').addEventListener('click', function (event) {
        event.preventDefault();
        var popover = document.getElementById('notification-popover');
        if (popover.style.display === 'none') {
            popover.style.display = 'block';
        } else {
            popover.style.display = 'none';
        }
    });
</script>