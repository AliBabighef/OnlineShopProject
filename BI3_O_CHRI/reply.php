<?php
ob_start();
session_start();
session_regenerate_id();
if (isset($_SESSION['userEcommerce'])) {
    include "../include/header.php";
    include "../include/navBar.php";
    include "../include/functions.php";
    if (isset($_GET['pageID']) && is_numeric($_GET['pageID']) && isset($_GET['commentID']) && is_numeric($_GET['commentID'])) {
        $columns = innerJoinData("*", $_GET["pageID"]);
        $mainsComments = getAllData("*", "comments", "ID", $_GET['commentID']);
?>
        <div class="replyComments">
            <div class="containner">
                <div class="btnLogOutreply">
                    <span class="IconLogOut"><i class="fa fa-arrow-left"></i></span>
                    <h3>replies</h3>
                </div>
                <div class="reply">
                    <div class="headerReply">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <div class="infoHeaderItem">
                            <span><?php
                                    $getColumnOb = new getColumn();
                                    $userID = $getColumnOb->columnFx("NamdID", "comments", "ID", $_GET["commentID"]);
                                    ?><a href="#"><?php
                                                    $userID = getAllData("*", "usersinfo", "ID", $userID);
                                                    echo $userID["NameStr"];
                                                    ?></a></span>
                            <span><?php echo $mainsComments["date"]; ?></span>
                        </div>
                    </div>
                    <p><?php echo $mainsComments["comment"]; ?></p>
                </div>
                <!-- start sub of mains comments  -->
                <?php
                $columns = innerJoinTable("*", $_GET["commentID"], $_GET["pageID"]);
                foreach ($columns as $reply) {
                    $getColumnOb = new getColumn();
                    $NameStr = $getColumnOb->columnFx("NameStr", "usersinfo", "ID", $reply["userID"]);
                ?>
                    <div class="subReply">
                        <div class="headerReply">
                            <span class="icon"><i class="fa fa-user"></i></span>
                            <div class="infoHeaderItem">
                                <span><a href="#"><?php echo $NameStr; ?></a></span>
                                <span><?php echo $reply["DateRep"]; ?></span>
                            </div>
                        </div>
                        <p><?php echo $reply["message"]; ?></p>
                    </div>
                <?php } ?>
                <!-- end sub of mains comments  -->
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $getColumnOb = new getColumn();
                    $userID = $getColumnOb->columnFx("ID", "usersinfo", "NameStr", $_SESSION['userEcommerce']);

                    $message = filter_var($_POST["reply"], FILTER_SANITIZE_STRING);
                    $cmtID = filter_var($_GET["commentID"], FILTER_SANITIZE_NUMBER_INT);
                    $productID = filter_var($_GET["pageID"], FILTER_SANITIZE_NUMBER_INT);

                    $statment = $con->prepare("INSERT INTO replies(`message`, `cmtID`, productID, userID, DateRep) VALUES(?,?,?,?,now())");
                    $statment->execute(array($message, $cmtID, $productID, $userID));
                    $count = $statment->rowCount();

                    echo "has been send";
                }
                ?>
                <!-- start form replies  -->
                <div class="commentsSystemCont">
                    <div class="comment">
                        <form action="<?php echo $_SERVER['PHP_SELF'] . "?pageID=" . $_GET['pageID'] . "&commentID=" . $_GET['commentID']; ?>" method="post">
                            <div class="nameProCon">
                                <input type="text" class="nameProduct" name="reply" placeholder="reply a comments" autocomplete="off" />
                                <button><i class="fa fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end form replies   -->
            </div>
        </div>
<?php
        include "../include/footer.php";
    } else {
        echo "page not found";
    }
}
ob_end_flush();
?>