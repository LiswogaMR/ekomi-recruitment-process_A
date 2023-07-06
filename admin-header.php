<?php
    include('functions/connection.php');
    $date = date('Y');
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li <?php if ($currentPage === 'admin-users.php') echo 'class="active"'; ?>><a href="admin-users.php">Users</a></li>
            <li <?php if ($currentPage === 'admin-job-task.php') echo 'class="active"'; ?>><a href="admin-job-task.php">Task</a></li>
        </ul>
    </div>
</nav>
