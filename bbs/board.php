<?php

include("../utils/constants.php");
include("../utils/connect.php");
include("../utils/general.php");

if (!isset($_GET['board_ID']))
    exit('Illegal call to this page.');

$board_ID = $_GET['board_ID'];
$board_ID = addslashes($board_ID);
$user_ID = $_SESSION['user_ID'];

$permission = GetPermission($user_ID, $board_ID);

$query = "SELECT board_name FROM board WHERE board_ID = $board_ID";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

if ($result = mysqli_fetch_array($result))
    $board_name = $result['board_name'];
else
    exit("No board found for BID=$board_ID.");


function ShowPosts($board_ID, $user_ID, $permission)
{
    include('../utils/connect.php');
    $query = "SELECT * FROM post WHERE board_ID = '$board_ID' ORDER BY last_update DESC";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $control = '';
    while ($row = mysqli_fetch_array($result))
    {
        $post_ID = $row['post_ID'];
        $post_name = $row['post_name'];
        $author_ID = $row['user_ID'];
        $post_link = "<a href='post.php?post_ID=$post_ID'>$post_name</a>";
        if (($permission >= PERM_MODERATOR) or ($user_ID == $author_ID))
            $control = "<button style=\"float:right\" class=\"btn btn-sm btn-danger\" onClick=\"ConfirmDelete($post_ID, '$post_name')\">Delete</button>";
        echo <<< EOT
		<p><h5>
			$post_link
			$control
		</h5></p>
EOT;
    }
}

function ShowPostInput($board_ID, $permission)
{
    include('../utils/connect.php');
    $query = "SELECT board_name FROM board WHERE board_ID = $board_ID";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    if ($result = mysqli_fetch_array($result))
        $board_name = $result['board_name'];
    else
        exit("No board found for BID=$board_ID.");

    if ($permission >= PERM_USER)
        echo <<< EOT
		<form method="GET" action="add_post_view.php" >
		    <input type="hidden" name="board_name" value=$board_name>
		    <input type="hidden" name="board_ID" value=$board_ID> 
			<input class="btn btn-primary" type="submit" name="submit" value="New Post" />
		</form>
EOT;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>kisec bbs - board</title>
    <link href="../css/style.css" rel="stylesheet" />
</head>
<body>
<header class="masthead">
    <div class="container">
        <div class="masthead-logo">
            kisec bbs
        </div>
        <nav class="masthead-nav">
            <a href="../bbs/home.php">Home</a>
            <?php ShowUserManagement($_SESSION['default_permission']); ?>
            <a href="../user/user_info.php"><?php ShowUser(); ?></a>
            <a href="../logout.php">Log out</a>
        </nav>
    </div>
</header>

<div class="container markdown-body">
    <h1 class="page-title">Board - <?php echo($board_name); ?></h1>
    <?php ShowPosts($board_ID, $user_ID, $permission); ?>
    <?php ShowPostInput($board_ID, $permission); ?>
    <footer class="footer">
        Designed by Kisec
    </footer>
</div>
</body>
</html>

<script>
    function ConfirmDelete(post_ID, post_name)
    {
        if (confirm("Do you really want to delete post '" + post_name + "'?"))
            window.location.href = "del_post.php?post_ID=" + post_ID;
    }

    function InputCheck()
    {
        title = document.getElementById("title");
        content = document.getElementById("content");
        if (!title.value)
        {
            alert("Post title should not be empty.");
            title.focus();
            return false;
        }
        if (!content.value)
        {
            alert("Content should not be empty.");
            content.focus();
            return false;
        }
        return true;
    }
</script>
