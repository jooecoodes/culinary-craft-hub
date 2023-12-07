<?php
include '../db_conn.php';
session_start();
$userCategory = (isset($_SESSION['usercategory'])) ? $_SESSION['usercategory'] : "category is not set";
// initiate empty array for users
$userCategoryToSelect = "user";
$users = array();
// selects all users
$stmt    = $conn->prepare("SELECT * FROM user WHERE usercategory = ?");
$stmt->bind_param("s", $userCategoryToSelect);
$stmt->execute();

// check result
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    array_push($users, $row);
}

// close conn
$conn->close();

if(isset($_POST['dataIndex'])) {
    $dataIndex = $_POST['dataIndex'];
    $data = $users[$dataIndex];
    echo json_encode($data);
} else if (isset($_SESSION['userId']) && $userCategory == 'admin') {
    $userId = $_SESSION['userId'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="chart.js" defer></script>
        <script src="admin.js" defer></script>
        <link rel="stylesheet" href="../../styles/admin.css">
        <title>Document</title>
    </head>

    <body>
        <canvas id="chart-canvas"></canvas>
        <table id="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Date of Registration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // loop through users
                $index = 0;
                foreach ($users as $user) {


                ?>

                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['userprofile'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td> <?= $user['useremail'] ?></td>
                        <td><?= $user['fname'] ?></td>
                        <td><?= $user['lname'] ?></td>
                        <td><?= $user['gender'] ?></td>
                        <td><?= $user['dateregistration'] ?></td>
                        <td><button class="edit-btn" data-index="<?= $index ?>" data-userid="<?= $user['id'] ?>">Edit</button></td>
                    </tr>
                <?php $index++;
                } ?>
            </tbody>
        </table>
        <div id="modal" style="display: none;">
            Hello Test
        </div>
    
       <div class="content-form-wrapper">
        <form id="content-form">
                <label for="videoField">Add the video</label>
                <input type="file" name="video-content-form" accept="video/*" id="videoField">
                <label for="question-article">Add question, separate with /n/n, followed by 4 choices separate with /q/q with answer /a/a in every end</label>
                <textarea name="questionField" id="question-article" cols="30" rows="10"></textarea>
                <label for="contentField">Add /n/n for the end of the paragraph</label>
                <textarea name="content-article" id="contentField" cols="30" rows="10"></textarea>
                <label for="categoryField">Add the category</label>
                <input type="text" name="category" id="categoryField">
                <input type="submit" value="Submit" name="submit-btn-content-form">
            </form>
       </div>

       
        <button id="logoutBttn">Log out</button>
        
    </body>

    </html>

<?php

} else {
    echo "You're not an admin or not registered";
}

?>