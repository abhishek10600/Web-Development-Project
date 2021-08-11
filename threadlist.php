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

    <?php include 'partials/_header.php' ?>
    <?php
        $cate_id = $_GET['catid'];
        $showAlert = false;
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $th_title = $_POST['qtitle'];
            $th_description = $_POST['qdescription'];
            $th_description = str_replace("<","&lt;", $th_description);
            $th_description = str_replace(">","&gt;", $th_description);
            $sno = $_POST['sno'];
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_description`, `thread_category_ID`, `thread_user_ID`, `thread_timedata`) VALUES ('$th_title', '$th_description', '$cate_id', '$sno', current_timestamp());";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;
        }
    ?>
    <?php
    if($showAlert)
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Wait for the community to respond.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }

    ?>
    <?php 
        $cid = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_ID = $cid ";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result))
        {
            $catname = $row['category_name'];
            $cat_description = $row['category_description'];
            echo '<div class="container my-4">
        <div class="container my-4">
            <div class="p-3 mb-2 bg-light text-dark">
                <h1>Welcome To '.$catname.'</h1>
                <p>'.$cat_description.'</p>
                <hr>
                <p>This is a peer to peer forum . No Spam / Advertising / Self-promote in the forums. Do not post
                    copyright-infringing material. Do not
                    post “offensive” posts, links or images. Do not cross post questions. Do not PM users asking for
                    help. Remain respectful of other members at all times</p>
                <button class="btn btn-primary">Learn more</button>
            </div>
        </div>';
        }
        ?>


    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
        echo '  <div class="container">
                <h1>Post Your Question</h1>
                <form action="'. $_SERVER["REQUEST_URI"] . '" method="post">
    <div class="mb-3">
        <label for="qtitle" class="form-label">Question Title</label>
        <input type="text" class="form-control" id="qtitle" name="qtitle" aria-describedby="emailHelp"
            placeholder="Enter Your Question Title">
    </div>
    <div class="mb-3">

        <label for="qdescription" class="form-label">Question Description</label>
        <textarea class="form-control" name="qdescription" id="qdescription" cols="100" rows="10"
            placeholder="Elaborate Your Question"></textarea>
            <input type="hidden" name="sno" value="'.$_SESSION["sno"]. '">

    </div>


    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>';
    }
    else
    {
    echo '<div class="container">
    <h1>Post Your Question</h1>
    <p class="lead">Please loggin to start a discussion</p>
</div>';
    }
    ?>


    <div class="container" id="questions">
        <h2 class="px-3">Browse Questions</h2>
        <?php
        $cid = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_category_ID = $cid";
        $result = mysqli_query($conn,$sql);
        $no_result = true;
        while($row = mysqli_fetch_assoc($result))
        {
            $no_result = false;
            $question_ID = $row['thread_ID'];
            $question_title = $row['thread_title'];
            $question_description = $row['thread_description'];
            $question_user_ID = $row['thread_user_ID'];
            $question_DATETIME = $row['thread_timedata'];
            $sql2 = "SELECT * FROM `users` WHERE sno = $question_user_ID ";
            $result2 = mysqli_query($conn,$sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $fname = $row2['FirstName'];
            $lname = $row2['LastName'];
                echo '
                <div class="d-flex my-4">
                    <div class="flex-shrink-0">
                    <img src="images/defaultuser.png" width="60px" alt="...">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p><b>'.$fname.' '.$lname. '. Commented on '.$question_DATETIME.'</b></p>
                        <h3><a href="thread.php?question_ID='. $question_ID .'">'. $question_title .'</a></h3>
                        <h4>' . $question_description .'</h4>
                    </div>
                </div>';
        }
            
        if($no_result)
        {
            echo '
            <div class="container my-4">
        <div class="container my-4">
            <div class="p-3 mb-2 bg-light text-dark">
                <h3>No Questions Found</h3>
                <p>Be the first person to post a question</p>
            </div>
        </div>';
        }
?>
    </div>





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