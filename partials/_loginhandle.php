<?php

    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        include '_dbconnect.php';
        $user_login_email = $_POST['loginEmail'];
        $user_login_password = $_POST['loginPassword'];
        
        $sql = "SELECT * FROM `users` WHERE email = '$user_login_email' ";
        $result = mysqli_query($conn,$sql);
        $numRows = mysqli_num_rows($result);
        if($numRows == 1)
        {
            $row = mysqli_fetch_assoc($result);
            if(password_verify($user_login_password,$row['password']))
            {
                session_start();
                $_SESSION['loggedin']=true;
                $_SESSION['useremail']=$user_login_email;
                $_SESSION['sno'] = $row[sno];
                $_SESSION['fname'] = $row['FirstName'];
            }
            header("Location: /forum/index.php");
        }
        header("Location: /forum/index.php");
    }



?>