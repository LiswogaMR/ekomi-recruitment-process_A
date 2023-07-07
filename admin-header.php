<?php

    include('functions/connection.php');
    $date = date('Y');
    $currentPage = basename($_SERVER['PHP_SELF']);
    session_start();

    // Get user's IP address
    $userIP = $_SERVER['REMOTE_ADDR'];

    // Send a request to the IP Geolocation API
    $apiUrl = "https://ipgeolocationapi.com/api/{$userIP}";
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Extract the location data
    $city = $data['geo']['city'];
    $country = $data['geo']['country_name'];

    // Construct the weather API URL with the user's location
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&APPID=2265b043141cf33671d01a1d6bb1e00a";
    $response = file_get_contents($apiUrl);
    $weatherData = json_decode($response, true);

    // Access the weather information
    $temperature = $weatherData['main']['temp'];
    $description = $weatherData['weather'][0]['description'];

    // Print the weather information
    // echo "Current Temperature: " . $temperature . "°C";
    // echo "Weather Description: " . $description;
    
    $permission_group_id = $_SESSION['permission_group_id'];
   if($permission_group_id == '2' ){ ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li <?php if ($currentPage === 'employee-users.php') echo 'class="active"'; ?>><a href="employee-users.php">Users</a></li>
                <li <?php if ($currentPage === 'employee-job-task.php') echo 'class="active"'; ?>><a href="employee-job-task.php">Task</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle glyphicon glyphicon-menu" data-toggle="dropdown" href="#">
                    Profile
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div style="background-color:5CB85C; colour:#FFF; margin: 10px; text-align:center;">
                                <?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?>
                            </div>
                        </li>
                        <li><a href="changePassword.php?email=<?php echo $_SESSION['email']; ?>"><span class="glyphicon glyphicon-edit"></span>&nbsp;Change password</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

   <?php }else{?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li <?php if ($currentPage === 'admin-users.php') echo 'class="active"'; ?>><a href="admin-users.php">Users</a></li>
                <li <?php if ($currentPage === 'admin-job-task.php') echo 'class="active"'; ?>><a href="admin-job-task.php">Task</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle glyphicon glyphicon-menu" data-toggle="dropdown" href="#">
                    Profile
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div style="background-color:5CB85C; colour:#FFF; margin: 10px; text-align:center;">
                                <?php echo $_SESSION['name'] . ' ' . $_SESSION['surname']; ?>
                            </div>
                        </li>
                        <li><a href="changePassword.php?email=<?php echo $_SESSION['email']; ?>"><span class="glyphicon glyphicon-edit"></span>&nbsp;Change password</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>