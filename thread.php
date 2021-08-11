<?php include 'partials/_dbconnect.php'?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <title>WeDiscuss-Technology Forum</title>
</head>

<body>
    <?php
        $showAlert = false;
        $thread_ID = $_GET['question_ID'];
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $comment_content = $_POST['comment_content'];
            $comment_content = str_replace("<","&lt;",$comment_content);
            $comment_content = str_replace(">","&gt;",$comment_content);
            $sno = $_POST['sno'];
            $sql = "INSERT INTO `comments` (`comment_content`, `comment_thread_ID`, `comment_user_ID`) VALUES ('$comment_content', '$thread_ID','$sno')";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
        }
    ?>
    <?php include 'partials/_header.php' ?>
    <?php
        if($showAlert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been succesfully posted.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    ?>


    <?php
    $question_ID = $_GET['question_ID'];
    $sql = "SELECT * FROM `threads` WHERE thread_ID = $question_ID ";
    $result = mysqli_query($conn,$sql);
    $no_result = true;
    while($row = mysqli_fetch_assoc($result))
    {
        $no_result = false;
        $thread_title = $row['thread_title'];
        $thread_description = $row['thread_description'];
        $thread_userID = $row['thread_user_ID'];
        $sql3 = "SELECT * FROM `users` WHERE sno = $thread_userID";
        $result3 = mysqli_query($conn,$sql3);
        $row3 = mysqli_fetch_assoc($result3);
        $fname = $row3['FirstName'];
        $lname = $row3['LastName'];
        echo '<div class="container my-4">
        <div class="container my-4">
            <div class="p-3 mb-2 bg-light text-dark">
                <h1>'.$thread_title.'</h1>
                <p>'.$thread_description.'</p>
                <hr>
                <p>This is a peer to peer forum . No Spam / Advertising / Self-promote in the forums. Do not post
                    copyright-infringing material. Do not
                    post “offensive” posts, links or images. Do not cross post questions. Do not PM users asking for
                    help. Remain respectful of other members at all times</p>
                <p><b>Posted By:'.$fname.' '.$lname.'</p></b>
            </div>
            </div>
        </div>';
    }
    
?>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {

        echo '<div class="container">
            <form action="'. $_SERVER['REQUEST_URI']. '" method="post">
        <div class="mb-3">
            <label for="comment_content" class="form-label">Post Your Comment</label>
            <textarea class="form-control" name="comment_content" id="comment_content" cols="30" rows="10"></textarea>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
        </div>
        <button type="submit" class="btn btn-primary">Post</button>
        </form>
        </div>';
    }
    else
    {
        echo '<div class="container">
        <p class="lead">Loggin To Post Comment</p>
        </div>';
    }
    ?>

    <div class="container my-4">
        <h2>Discussions</h2>
        <div class="container">
            <?php 
            $comment_thread_ID = $_GET['question_ID'];
            $sql = "SELECT * FROM `comments` WHERE comment_thread_ID = $comment_thread_ID ";
            $result = mysqli_query($conn,$sql);
            $no_result = true;
            while($row = mysqli_fetch_assoc($result))
            {
                $no_result = false;
                $content = $row['comment_content'];
                $comment_userID = $row['comment_user_ID'];
                $comment_time = $row['comment_DATETIME'];
                $sql2 = "SELECT * FROM `users` WHERE sno = $comment_userID";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $fname = $row2['FirstName'];
                echo '<div class="d-flex my-4">
                <div class="flex-shrink-0">
                <img src="images/defaultuser.png" width="60px" alt="...">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3>'.$fname.'. Commented on '. $comment_time . '</h3>
                    <p>'. $content . '</p>
                </div>
            </div>';

            }
            if($no_result)
        {
            echo '
            <div class="container my-4">
        <div class="container my-4">
            <div class="p-3 mb-2 bg-light text-dark">
                <h3>No Response Found.</h3>
                <p>Be the first person to respond to this post</p>
            </div>
        </div>';
        }

            ?>
        </div>
    </div>
    </div>



    <?php include 'partials/_footer.php' ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>

</html>