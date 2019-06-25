<?php
define('SERVERNAME', 'Server');
define('PASSWORD', 'Password');
define('USER', 'User');
define('DBNAME', 'Database');

// Set a user for testing
$_SERVER["REMOTE_USER"] = "User";
if (!$_SERVER["REMOTE_USER"]) {

    http_response_code(401);
    exit("User not authorized");
}

$dbconn = mysqli_connect(SERVERNAME, USER, PASSWORD, DBNAME);
if ($dbconn->connect_errno) {
    die('No access to database' . $dbconn->connect_error);
}

$stmt = $dbconn->prepare("SELECT login FROM admin_users WHERE login = ?");
$stmt->bind_param('s', $_SERVER["REMOTE_USER"]);
$stmt->execute();
$stmt->bind_result($userResult);
$stmt->fetch();
if (!$userResult) {

    http_response_code(403);
    exit("Not authorized");
}
$stmt->close();

$success = true;
if ($_POST["action"]) {
    // Update user matching this ID
    if ($_POST["action"] == "update") {
        $stmt = $dbconn->prepare(
            "UPDATE user_data SET name = ?, title = ?, login = ? WHERE id = ?"
        );
        $stmt->bind_param(
            'sssi',
            $_POST["name"],
            $_POST["title"],
            $_POST["login"],
            $_POST["id"]
        );
        $success = $stmt->execute();
        if (!$success) {
            print_r($stmt->error_list);
            die();
        }
        $searchId = $_POST["id"];
    } else if ($_POST["action"] == "add") {
        $stmt = $dbconn->prepare(
            "INSERT INTO user_data (name, login, title) VALUES (?, ?, ?);"
        );
        $stmt->bind_param(
            'sss',
            $_POST["name"],
            $_POST["login"],
            $_POST["title"]
        );
        $success = $stmt->execute();
        if (!$success) {
            print_r($stmt->error_list);
            die();
        }
        $searchId = $stmt->insert_id;
    } else {
        die("Unexpected action: " . $_POST["action"]);
    }
    $stmt->close();

    $stmt = $dbconn->prepare("SELECT id, name, title, login FROM user_data WHERE id = ?");
    $stmt->bind_param('i', $searchId);
    $stmt->execute();
    $stmt->bind_result($id, $name, $title, $login);
    $stmt->fetch();
    $stmt->close();
}

if ($_GET["username"]) {
    // Fetch user information matching the supplied username

    $username = $_GET["username"];
    $stmt = $dbconn->prepare("SELECT id, name, title, login FROM user_data WHERE login = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($id, $name, $title, $login);
    $stmt->fetch();
    $stmt->close();
}
?>
<html>

<head>
</head>

<body>
    <form>
        <input type="text" name="username" value="<?php echo $_GET["username"]; ?>" />
        <input type="submit" value="Search" />
    </form>
    <?php
    if ($id) {
        ?>
        <ul>
            <li><?php echo $id; ?></li>
            <li><?php echo $name; ?></li>
            <li><?php echo $title; ?></li>
            <li><?php echo $login; ?></li>
        </ul>
    <?php
} else if ($username) {
    ?>
        <p>
            No user found matching <?php echo $username; ?>.
        </p>
    <?php
}
if (!$success) {
    ?>
        <p>
            MySQL Error!
        </p>
    <?php
}
?>
    <form method="post">
        <?php
        if ($id) {
            ?>
            <b>Update User</b>
            <input type="hidden" name="action" value="update" />
        <?php
    } else {
        ?>
            <b>Add User</b>
            <input type="hidden" name="action" value="add" />
        <?php
    }
    ?>

        <p>Name:
            <input type="text" name="name" size="25" maxlength="80" value="<?php echo $name; ?>" />
        </p>

        <p>Login:
            <input type="text" name="login" size="15" maxlength="8" value="<?php echo $login; ?>" />
        </p>

        <p>Title:
            <input type="text" name="title" size="25" maxlength="80" value="<?php echo $title; ?>" />
        </p>

        <p>
            <input type="submit" name="add" value="<?php echo $id ? "Update User" : "Add User" ?>" />
        </p>

        <input type="hidden" name="id" value="<?php echo $id; ?>" />

    </form>
</body>

</html>