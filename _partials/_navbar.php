    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li class="is-flex is-align-items-center"><img src="media\logo\dcnhs.png" alt="" width="30px"></li>
            <li class="is-align-content-center"><a href="index.php">Home</a></li>
            <li class="is-align-content-center"><a href="index.php">Referral</a></li>
            <li class="is-align-content-center"><a href="index.php">Conference</a></li>
            <li class="is-align-content-center"><a href="index.php">Intake</a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <li class="is-align-content-center"><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li class="is-align-content-center"><a href="login.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>