<?php
include 'boilerplate.php';
echo "loginSubmit =" . $_POST['loginSubmit'] . "<br>"; 


if(isset($_POST['loginSubmit'])) {

    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];
    
    echo "mailuid =" . $mailuid . "<br>";
    echo "password =" . $password . "<br>";
    
    if(empty($password)){
    echo 'This line is printed, because the $password is empty.';
    }
echo "empty($mailuid) = " . empty($mailuid);
echo "empty($password) = " . empty($password);

    if (empty($mailuid) || empty($password)) {
        echo "yyy";
        header('Location: indexlogin.php?error=emptyfields');
        echo "zzz";
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE uidUsers = ? OR emailUsers = ?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: indexlogin.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $pwdCheck = password_verify($password, $row['pwdUsers']);
                if ($pwdCheck == false) {
                    header("Location: indexlogin.php?error=wrongpwd");
                    exit();
                } else if ($pwdCheck == true) {
                    session_start();  /*these are names of the columns in our database Users table*/
                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];

                    header("Location: introPage.php?login=success");
                    exit();

                } else {
                    header("Location: indexlogin.php?error=wrongpwd");
                    exit();

                }
            }else {
                    header("Location: indexlogin.php?error=nouser");
                    exit();
            }
        }
    }


}else{
        header("Location:indexlogin.php");
        exit();
}/*end if(isset($_POST['login_submit']*/
