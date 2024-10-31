<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();


if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as read!');
        } else {
            alert('error', 'Operation Failed!');
        }
    } else {
        $q = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read!');
        } else {
            alert('error', 'Operation Failed!');
        }
    }
}

if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);

    if ($frm_data['del'] == 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $q)) {
            alert('success', 'All data deleted!');
        } else {
            alert('error', 'Operation Failed!');
        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data deleted!');
        } else {
            alert('error', 'Operation Failed!');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">


    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4 h-font">USER QUERIES</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                                <i class="bi bi-check-all"></i> Mark all read</a>
                            <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                                <i class="bi bi-trash"></i> Delete all</a>
                        </div>


                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;" >
                            <table class="table table-hover border">
                                <thead class="sticky-top">
                                    <tr class="bg-dark text-light">
                                        <th scope="col" class="t-font ">#</th>
                                        <th scope="col" class="t-font ">Name</th>
                                        <th scope="col" class="t-font ">Email</th>
                                        <th scope="col" class="t-font " width="20%">Subject</th>
                                        <th scope="col" class="t-font " width="30%">Message</th>
                                        <th scope="col" class="t-font ">Date</th>
                                        <th scope="col" class="t-font ">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $q = "SELECT * FROM `user_queries` ORDER BY `sr_no` DESC";
                                $data = mysqli_query($con, $q);
                                $i = 1;

                                while ($row = mysqli_fetch_assoc($data)) {
                                    $seen = '';
                                    if ($row['seen'] != 1) {
                                        $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary'>Mark as read</a>";
                                    }
                                    $seen .= "<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger ms-2'>Delete</a>";
                                    echo <<<query
                                            <tr>
                                                <td class="mb-4">$i</td>
                                                <td class="mb-4">$row[name]</td>
                                                <td class="mb-4">$row[email]</td>
                                                <td class="mb-4">$row[subject]</td>
                                                <td class="mb-4">$row[message]</td>
                                                <td class="mb-4">$row[date]</td>
                                                <td class="mb-4">$seen</td>
                                            </tr>
                                            query;
                                    $i++;
                                }
                                ?>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="row" id="pms-data">
                        </div>

                    </div>
                </div>




            </div>
        </div>
    </div>


    <?php require('inc/script.php'); ?>

</body>

</html>