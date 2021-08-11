<?php
    $showError = "false";
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        include '_dbconnect.php';

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $user_email = $_POST['userEmail'];
        $pass = $_POST['signupPassword'];
        $cpass = $_POST['signupcPassword'];

        $sqlexist = "SELECT * FROM `users` WHERE email = '$user_email' ";
        $result = mysqli_query($conn,$sqlexist);
        $numrows = mysqli_num_rows($result);
        if($numrows>0)
        {
            $showError = "User with this email already exists!";
        }
        else
        {
            if($pass==$cpass)
            {
                $hash = password_hash($pass,PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`FirstName`, `LastName`, `email`, `password`, `users_DATETIME`) VALUES ('$fname', '$lname', '$user_email', '$hash', current_timestamp())";
                $result = mysqli_query($conn,$sql);
                if($result)
                {
                    $showAlert = true;
                    header("Location: /forum/index.php?signupSuccess=true");
                    exit();
                }
            }
            else
            {
                $showError = "Passowrds Do not match";
                
            }
        }
        header("Location: /forum/index.php?signupsuccess=false&error=$showError");
    }




?>