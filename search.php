<?php include 'partials/_dbconnect.php'    ?>

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
<style>
#maincontainer {
    min-height: 100vh;
}

.container {
    min-height: 50vh;
}
</style>



<body>
    <?php include 'partials/_header.php' ?>


    <?php $search = $_GET['search'];
    echo '<div class="container my-4" id="maincontainer">
        <h1>Browse Results For <em>"'.$search.'"</em></h1>
        <div class="row my-4">';
    ?>
    <?php


$sql = "SELECT * FROM `threads` WHERE MATCH (thread_title,thread_description) against ('$search') ";
$result = mysqli_query($conn,$sql);
$numrows = mysqli_num_rows($result);
if($numrows>0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $thread_title = $row['thread_title'];
        $thread_description = $row['thread_description'];
        $thread_ID = $row['thread_ID'];
        $url = "thread.php?question_ID=".$thread_ID;
            echo '<div class="results">
                <h4><a class="text-dark" href="'.$url.'">'.$thread_title.'</a></h4>
                <p>'.$thread_description.'</p>
            </div>';
    }
}
else
{
    echo '<div class=" py-3 mb-2 bg-light text-dark container">
        <h3>No Results Found</h3>
        <h5>Suggestions:</h5>
        <ul>
        <li>Spell the keywords correctly</li>
        <li>Check valid queries</li>
        </ul>
    </div>';
}
        
        
   
       
        
       
        echo '</div>
        
        
        
    </div>';
?>
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