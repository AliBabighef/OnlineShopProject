<?php
ob_start();
session_start();
session_regenerate_id();

include "../include/header.php";
include "../include/navBar.php";
require "../include/functions.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["signUp"])) {
        // start filter 
        $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
        $E_mail = filter_var($_POST['E_mail'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $ecytPassWord = SHA1($password);
        $confirmPassword = filter_var($_POST['confirmPassword'], FILTER_SANITIZE_STRING);

        $errore = array();


        //  start filter input when lenght of that is less than 2 
        if (strlen($user) < 3) {

            $errore[] = "this feild(user) must be greater than " . 2 .  " characters";
        }

        if (strlen($E_mail) < 12) {

            $errore[] = "this feild(e_mail) must be greater than " . 11 .  " characters";
        }

        if (strlen($password) < 3) {

            $errore[] = "this feild(password) must be greater than " . 2 .  " characters";
        }

        if ($password !== $confirmPassword) {

            $errore[] = "feild(password) is not match with feild(confirm password)";
        }
        //  start filter input when lenght of that is less than 2 

        //  start filter iput that empty 
        if ($user == NULL || $user == '') {

            $errore[] = "this feild(user) can't be empty";
        }

        if ($E_mail  == NULL || $E_mail == '') {

            $errore[] = "this feild(E_mail) can't be empty";
        }

        if ($password == NULL || $password == '') {

            $errore[] = "this feild(password) can't be empty";
        }

        // end filter 
        // start show error of signUp 
        if (!empty($errore)) {

            foreach ($errore as $err) {
                # code...
                echo "<div class='fram-problem'>" . $err . "</div>";
            }
        } else

            $insertAppData = new insertAppData($user, $E_mail, $ecytPassWord, 1);
    }
}


// ens page signUp 
// start page signIn 
if (isset($_POST["signIn"])) {

    // start filter 
    $user = filter_var($_POST['user'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $ecytPassWord = SHA1($password);

    $errore = array();


    //  start filter input when lenght of that is less than 2 
    if (strlen($user) < 3) {

        $errore[] = "this feild(user) must be greater than " . 2 .  " characters";
    }


    if (strlen($password) < 3) {

        $errore[] = "this feild(password) must be greater than " . 2 .  " characters";
    }


    //  start filter input when lenght of that is less than 2 

    //  start filter iput that empty 
    if ($user == NULL || $user == '') {

        $errore[] = "this feild(user) can't be empty";
    }


    if ($password == NULL || $password == '') {

        $errore[] = "this feild(password) can't be empty";
    }

    // end filter 
    // start show error of signIn
    if (empty($errore)) {

        $stmt = $con->prepare("SELECT NameStr, `PassWord` FROM `usersinfo` WHERE NameStr = ? AND `PassWord` = ?");
        $stmt->execute(array($user, $ecytPassWord));
        $data = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {

            $_SESSION['userEcommerce'] = $user;
            header("location: home.php");
            exit();
        } else {

            echo  "<div class='fram-problem'>" . "incorect user or password" . "</div>";
        }
    } else {

        foreach ($errore as $err) {
            # code...
            echo "<div class='fram-problem'>" . $err . "</div>";
        }
    }
    // end show error of signIn

}
// end page signIn


?>
<div class="logInPage">
    <div class="containner">
        <h1 class="title"><span class="signIn active">signIn</span><strong>|</strong><span class="signUp">signUp</span></h1>
        <div class="divcontiannerForm">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="formSignIn">
                <input type="text" name="user" placeholder="type you're user or email" />
                <input type="password" name="password" placeholder="type a password" />
                <button name="signIn" class="iconSearch"><i class="fa fa-paper-plane"></i></button>
            </form>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="formSignUp fram-hide">
                <input type="text" name="user" placeholder="type you're user" />
                <input type="text" name="E_mail" placeholder="type you're email" />
                <input type="password" name="password" placeholder="type a password" />
                <input type="password" name="confirmPassword" placeholder="confirm a password" />
                <button name="signUp" class="iconSearch"><i class="fa fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>
<?php
include "../include/footer.php";
ob_end_flush();
?>