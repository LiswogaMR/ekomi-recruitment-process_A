<?php

    include('functions/connection.php');
    include('functions/session_data.php');

    $date = date('Y');
    $currentPage = basename($_SERVER['PHP_SELF']);

    // Get user's IP address
    $userIP = $_SERVER['REMOTE_ADDR'];

    $address = 'Cape town';
    $apiKey = '2265b043141cf33671d01a1d6bb1e00a';  

    // Construct the API URL
    $url = "https://api.openweathermap.org/data/2.5/weather?address=$address&appid=$apiKey";

    // Make the API request
    $response = file_get_contents($url);

    // Check if the request was successful
    if ($response !== false) {
        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the data was decoded successfully
        if ($data !== null && $data['cod'] === 200) {
            // Extract the relevant weather information
            $temperature = $data['main']['temp'];
            $description = $data['weather'][0]['description'];

            echo "Temperature: " . $temperature . "<br>";
            echo "Description: " . $description . "<br>";
        } else {
            // echo "Unable to retrieve weather information.";
        }
    } else {
        // echo "Unable to connect to the weather API.";
    }
    
    $permission_group_id = $_SESSION['user']['permission_group_id'];
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
                                <?php echo $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?>
                            </div>
                        </li>
                        <li><a href="changePassword.php?email=<?php echo $_SESSION['user']['email']; ?>"><span class="glyphicon glyphicon-edit"></span>&nbsp;Change password</a></li>
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
                                <?php echo $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?>
                            </div>
                        </li>
                        <li><a href="changePassword.php?email=<?php echo $_SESSION['user']['email']; ?>"><span class="glyphicon glyphicon-edit"></span>&nbsp;Change password</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>