<?php
 
    session_start();
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light bg-blue">
    <div class="container-fluid anc">
        <a class="navbar-brand" href="index.php">WeDiscuss</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Top Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    $sql = "SELECT * FROM `categories` LIMIT 3";
                    $result = mysqli_query($conn,$sql);
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $catename = $row['category_name'];
                        $cateid = $row['category_ID'];
                        echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$cateid.'">'.$catename.'</a></li>';
                    }

                    echo '</ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>';
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
            {
                echo '<form class="d-flex" method="get" action="search.php" >
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success bot" type="submit">Search</button>
                
                <a href="partials/_logout.php" class="btn btn-outline-success mx-2 bot" type="submit">Logout</a>
                </form>
                <p class = "text-light px-4 mb-0">Welcome '.$_SESSION['fname'].'</p>';

            }
            else
            {
                    echo '<form class="d-flex method="get" action="search.php">
                    <input class="form-control me-2" name = "search" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success bot" type="submit">Search</button></form>
                    <div class="login_signup_button">
                    <button class="btn btn-outline-success bot" type="submit" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button class="btn btn-outline-success bot" type="submit" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
            }

            echo '</div>
        </div>
    </div>
</nav>';
include '_loginModal.php';
include '_signupModal.php';
if(isset($_GET['signupSuccess']) && $_GET['signupSuccess']=="true")
{
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>You have been signeup successfully!</strong> You can now login.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}

?>