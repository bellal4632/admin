<?php require "inc/head.php"; ?>
<?php
require "inc/adminauth.php";
?>

<title>Admin - Add User</title>
</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- !-- Sidebar -->
        <?php require "inc/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require "inc/topbar.php"; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->

                    <h1 class="h3 text-gray-800">Add User</h1>
                    <hr>

                    
<?php

// Set up database connection

require "inc/config.php";
require "inc/adminauth.php";


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $name = $_POST['fname'] . ' ' . $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $active = $_POST['active'];
    $role = $_POST['role'];

    $address = $_POST['address'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    

    // Validate form data
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($phone) || empty($address) || empty($city) || empty($zip) || empty($country) || empty($state) || empty($active) || empty($role)) {
        echo '<div class="alert alert-danger" role="alert">Please fill in all fields.</div>';
    } elseif ($password != $confirm_password) {
        echo '<div class="alert alert-danger" role="alert">Passwords do not match.</div>';
    } else {

        // Check if email and username are unique
        $email_query = "SELECT * FROM users WHERE email='$email'";
        $username_query = "SELECT * FROM users WHERE username='$username'";
        $phone_query = "SELECT * FROM users WHERE phone='$phone'";
        $email_result = mysqli_query($conn, $email_query);
        $username_result = mysqli_query($conn, $username_query);
        $phone_result = mysqli_query($conn, $phone_query);

        if (mysqli_num_rows($email_result) > 0) {
            echo '<div class="alert alert-danger" role="alert">Email already exists.</div>';
        } elseif (mysqli_num_rows($username_result) > 0) {
            echo '<div class="alert alert-danger" role="alert">Username already exists.</div>';
        } elseif (mysqli_num_rows($phone_result) > 0) {
            echo '<div class="alert alert-danger" role="alert">Phone Number already exists.</div>';
        }else {

            // Store uploaded image with temporary name
            $target_dir = "a.assets/pro_image/";
            $temp_name = uniqid() .  ".png";
            $target_file = $target_dir . $temp_name;
            $image_upload_success = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            // Insert form data into database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users VALUES (null, '$name', '$username', '$email', '$hashed_password', '$phone', '$temp_name', '$role', '$active', '$address', '$city', '$zip', '$country', '$state', null)";

            if ($image_upload_success && mysqli_query($conn, $sql)) {
                echo '<div class="alert alert-success" role="alert">New record created successfully.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . mysqli_error($conn) . '</div>';
            }
        }
    }

    
}

?>

                    <h4 class="mb-2">Personal Details</h4>

                    <form method="post" enctype="multipart/form-data">


                        <div class="form-group row">
                            <div class="col-sm-4  mb-sm-0">
                                <label>Email</label>
                                <input type="text" class="form-control" placeholder="Enter Users Unique Email Address" aria-describedby="emailHelp" name="email">
                                <small id="emailHelp" class="form-text text-muted px-2">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="col-sm-4  mb-sm-0">
                                <label>Username</label>
                                <input type="text" class="form-control" placeholder="Enter Users Unique Username" name="username">
                            </div>
                            <div class="col-sm-4  mb-sm-0">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" placeholder="Enter Users Phone Number" name="phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6  mb-sm-0">
                                <label>First Name</label>
                                <input type="text" class="form-control" placeholder="Enter Users First Name" name="fname">
                            </div>
                            <div class="col-sm-6  mb-sm-0">
                                <label>Last Name</label>
                                <input type="text" class="form-control" placeholder="Enter Users Last Name" name="lname">
                            </div>

                        </div>


                        <div class="form-group row">
                            <div class="col-sm-8  mb-sm-0">
                                <label>Address</label>
                                <input type="text" class="form-control" placeholder="Enter Users Address" name="address">
                            </div>
                            <div class="col-sm-4  mb-sm-0">
                                <label>City</label>
                                <input type="text" class="form-control" placeholder="Enter Users City" name="city">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3 mb-sm-0">
                                <label>ZIP Code</label>
                                <input type="text" class="form-control" placeholder="Enter Users Zip Code" name="zip">
                            </div>


                            <div class="col-sm-4  mb-sm-0">
                                <label>Country</label>
                                <input type="text" class="form-control" placeholder="Enter Users Country" name="country">
                            </div>
                            <div class="col-sm-5 mb-sm-0">
                                <label>State</label>
                                <input type="text" class="form-control" placeholder="Enter Users State" name="state">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-4  mb-sm-0">
                                <label>Active Status</label>
                                <select class="form-control" name="active">
                                    <option selected>Select Users Status</option>
                                    <option value="1">Pending</option>
                                    <option value="3">Approve</option>
                                </select>
                            </div>
                            <div class="col-sm-4  mb-sm-0">
                                <label>Role</label>
                                <select class="form-control" name="role">
                                    <option selected>Select Users Role</option>
                                    <option value="1">Publisher</option>
                                    <option value="2">Moderator</option>
                                    <option value="3">Admin</option>
                                </select>
                            </div>
                            <div class="col-sm-4  mb-sm-0">
                                <label>Profile Photo</label>
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6  mb-sm-0">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Enter Users password" name="password">
                            </div>
                            <div class="col-sm-6  mb-sm-0">
                                <label>Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Confirm Users Password" name="confirm_password">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Add User</button>
                    </form>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- Footer -->
            <?php require "inc/footer.php"; ?>

</body>

</html>