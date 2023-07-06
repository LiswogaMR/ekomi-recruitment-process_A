<?php

    require_once '../user.php';

    $dataDraw = (int) ($_POST['draw']);
    $dataStart = (int) ($_POST['start']);
    $dataLength = (int) ($_POST['length']);
    $dataSearch = $_POST['search']['value'];
    $orderColumn = (int) ($_POST['order'][0]['column']);
    $orderDirection = $_POST['order'][0]['dir'];
    $columnName = $_POST['columns'][$orderColumn]["name"];

    $data = array();

    $recordsTotal = 0;
    $r = 0;

    $users = $userModel->getAllUsers();
    
    // Apply search filter
    if (!empty($dataSearch)) {
        $filteredUsers = array_filter($users, function ($user) use ($dataSearch) {
            return strpos(strtolower($user['name']), strtolower($dataSearch)) !== false
                || strpos(strtolower($user['email']), strtolower($dataSearch)) !== false
                || strpos(strtolower($user['surname']), strtolower($dataSearch)) !== false
                || strpos(strtolower($user['contactNo']), strtolower($dataSearch)) !== false;
        });

        $users = array_values($filteredUsers);
    }

    //sorting we have to change for actions as we cannot sort using actions it provide javascript error
    if($columnName ='actions'){
        $columnName = 'name';
    }

    usort($users, function ($a, $b) use ($orderColumn, $orderDirection,$columnName) {
        $column = $orderColumn === 0 ? 'id' : $columnName;
        if ($orderDirection === 'asc') {
            return $a[$column] <=> $b[$column];
        } else {
            return $b[$column] <=> $a[$column];
        }
    });

    // Apply paging
    $users = array_slice($users, $dataStart, $dataLength);

    foreach ($users as $row) {
        $data['data'][$r]['rowID'] = $r;
        $data['data'][$r]['rec'] = $row['id'];
        $data['data'][$r]['id'] = $row['id'];
        $data['data'][$r]['name'] = $row['name'];
        $data['data'][$r]['email'] = $row['email'];
        $data['data'][$r]['surname'] = $row['surname'];
        $data['data'][$r]['contactNo'] = $row['contactNo'];
        $data['data'][$r]['actions'] = "<button class='btn btn-danger triggerActions' data-rec='$row[id]'>
                                            <span class='glyphicon glyphicon-trash' id='delete' title='delete' data-toggle='tooltip'></span>
                                        </button>
                                            &nbsp;&nbsp;
                                        <button class='btn btn-primary triggerEdit' data-rec='$row[id]' data-name='$row[name]'
                                            data-email='$row[email]' data-surname='$row[surname]' data-contactNo='$row[contactNo]'>
                                            <span class='glyphicon glyphicon-pencil' id='edit' title='edit' data-toggle='tooltip'></span>
                                        </button>
                                        ";
						

        ++$r;
    }

    $recordsTotal = count($users);

    if($recordsTotal == 0){
        $data['data'] = [];
    }

    $data['draw'] = $dataDraw;
    $data['recordsFiltered'] = $recordsTotal;
    $data['recordsTotal'] = $recordsTotal;
    // $data['selectedGrid'] = $selectedGrid;
    die(json_encode($data));


?>