<?php

    require_once '../tasks.php';

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

    $task = $taskModel->getAllTask();
    
    // Apply search filter
    if (!empty($dataSearch)) {
        $filteredUsers = array_filter($task, function ($task) use ($dataSearch) {
            return strpos(strtolower($task['title']), strtolower($dataSearch)) !== false
                || strpos(strtolower($task['description']), strtolower($dataSearch)) !== false
                || strpos(strtolower($task['status']), strtolower($dataSearch)) !== false
                || strpos(strtolower($task['date_created']), strtolower($dataSearch)) !== false;
        });

        $task = array_values($filteredUsers);
    }

    //sorting we have to change for actions as we cannot sort using actions it provide javascript error
    if($columnName ='actions'){
        $columnName = 'title';
    }

    usort($task, function ($a, $b) use ($orderColumn, $orderDirection,$columnName) {
        $column = $orderColumn === 0 ? 'id' : $columnName;
        if ($orderDirection === 'asc') {
            return $a[$column] <=> $b[$column];
        } else {
            return $b[$column] <=> $a[$column];
        }
    });

    // Apply paging
    $task = array_slice($task, $dataStart, $dataLength);

    foreach ($task as $row) {
        $data['data'][$r]['rowID'] = $r;
        $data['data'][$r]['rec'] = $row['id'];
        $data['data'][$r]['id'] = $row['id'];
        $data['data'][$r]['title'] = $row['title'];
        $data['data'][$r]['description'] = $row['description'];
        $data['data'][$r]['status'] = $row['status'];
        $data['data'][$r]['date_created'] = $row['date_created'];
        $data['data'][$r]['date_updated'] = $row['date_updated'];
        $data['data'][$r]['actions'] = "<button class='btn btn-danger triggerActions' data-rec='$row[id]'>
                                            <span class='glyphicon glyphicon-trash' id='delete' title='delete task' data-toggle='tooltip'></span>
                                        </button>
                                            &nbsp;&nbsp;
                                        <button class='btn btn-primary triggerEdit' data-rec='$row[id]' data-title='$row[title]'
                                            data-description='$row[description]' data-status='$row[status]' data-date_created='$row[date_created]'>
                                            <span class='glyphicon glyphicon-check' id='complete' title='complete task' data-toggle='tooltip'></span>
                                        </button>
                                        ";
						

        ++$r;
    }

    $recordsTotal = count($task);

    if($recordsTotal == 0){
        $data['data'] = [];
    }

    $data['draw'] = $dataDraw;
    $data['recordsFiltered'] = $recordsTotal;
    $data['recordsTotal'] = $recordsTotal;
    // $data['selectedGrid'] = $selectedGrid;
    die(json_encode($data));


?>