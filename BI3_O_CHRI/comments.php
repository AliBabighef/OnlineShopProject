<?php
ob_start();
session_start();
session_regenerate_id();
if (isset($_SESSION['userEcommerce'])) {
    include "../include/header.php";
    include "../include/navBar.php";
    include "../include/functions.php";
    if (isset($_GET['pageID']) && is_numeric($_GET['pageID'])) {

        $statment = $con->prepare("SELECT * , comments.ID as commentID from comments 
        INNER JOIN usersinfo ON comments.namdID = usersinfo.ID
        INNER JOIN product ON comments.cateID = product.ID
        WHERE cateID = ?");
        $statment->execute(array($_GET["pageID"]));
        $data = $statment->fetchAll();
?>
        <div class="containner">
            <div class="showComments">
                <?php
                $errors = array();
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $comments = FILTER_VAR($_POST['comments'], FILTER_SANITIZE_STRING);
                    if ($comments == null || $comments == "") {
                        $errors[] = "<div class='problem'>feild (comment) cant be empty</div>";
                    }
                    if (!empty($errors)) {
                        foreach ($errors as $errore) {
                            echo $errore;
                        }
                    } else {
                        // $statment = $con->prepare("SELECT ID from usersinfo WHERE NameStr = ?");
                        // $statment->execute(array($_SESSION['userEcommerce']));
                        // $columnId = $statment->fetchColumn();
                        $columnIdOb = new getColumn();
                        $columnId = $columnIdOb->columnFx("ID", "usersinfo", "NameStr", $_SESSION['userEcommerce']);

                        $statment = $con->prepare("INSERT INTO comments(comment, `date`, `namdID`, cateID) VALUES(?,now(),?,?)");
                        $statment->execute(array($comments, $columnId, $_GET['pageID']));
                        $count = $statment->rowCount();
                    }
                }
                ?>
                <div class="btnLogOutCommentsSystem">
                    <span class="IconLogOut"><i class="fa fa-arrow-left"></i></span>
                    <h3>comments</h3>
                </div>
                <!-- start header of item  -->
                <?php
                $statment = $con->prepare("SELECT COUNT(cateID) from comments 
                INNER JOIN usersinfo ON comments.namdID = usersinfo.ID
                INNER JOIN product ON comments.cateID = product.ID
                WHERE cateID = ?");
                $statment->execute(array($_GET["pageID"]));
                $count = $statment->fetchColumn();

                if ($count == 0) {
                    $getColumnOb = new getColumn();
                    $columnImg = $getColumnOb->columnFx("productImg", "product", "ID", $_GET['pageID']);
                    // echo 0;
                    $statment = $con->prepare("SELECT * from usersinfo 
                    INNER join product
                    ON product.NameID = usersinfo.ID
                    WHERE product.ID = ?;");
                    $statment->execute(array($_GET['pageID']));
                    $columns = $statment->fetch();

                ?>
                    <input type="hidden" value="<?php echo $columnImg; ?>" class="imgSrcBystr" />
                <?php

                } else {
                    // $columns = innerJoinData("*", $_GET["pageID"]);

                    $statment = $con->prepare("SELECT * from product
                    INNER JOIN usersinfo ON product.NameID = usersinfo.ID
                    WHERE product.ID = ?");
                    $statment->execute(array($_GET['pageID']));
                    $columns = $statment->fetch();
                }
                ?>
                <div class="parentHeaderItem">
                    <div class="headerItem">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <div class="infoHeaderItem">
                            <span><a href="#"><?php echo $columns['NameStr']; ?></a><?php
                                                                                    $getColumnOb = new getColumn();
                                                                                    $columnName = $getColumnOb->columnFx("NameStr", "usersinfo", "ID", $columns['NameID']);
                                                                                    ?></a></span>
                            <span><?php echo $columns['dateProduct']; ?></span>
                        </div>
                    </div>
                    <p><?php echo $columns['productDescription']; ?></p>
                </div>
                <!-- end header of item  -->

                <!-- start info item  -->
                <div class="parentitemInfoContainner">
                    <div class="itemInfoContainner">
                        <div class="sliderImgCon">
                            <span class="lft"><i class="fa fa-arrow-left"></i></span>
                            <span class="rgt"><i class="fa fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
                <hr />
                <?php

                $statment = $con->prepare("SELECT  COUNT(comments.ID) as commentID from comments 
                INNER JOIN usersinfo ON comments.namdID = usersinfo.ID
                INNER JOIN product ON comments.cateID = product.ID
                WHERE cateID = ?");
                $statment->execute(array($_GET["pageID"]));
                $msg = $statment->fetchColumn();

                if ($msg < 1) {
                    echo "<h5 class='fram-No-comment'>no comment</h5>";
                    echo "<p class='fram-No-content'>be fisrt to comment</p>";
                }
                ?>

                <!-- end info item  -->
                <?php foreach ($data as $data) { ?>
                    <!-- start comment  -->
                    <div class="comments">
                        <input type="hidden" value="<?php echo $data['productImg']; ?>" class="imgSrcBystr" />
                        <div class="parent">
                            <div class="profileCmt">
                                <span><i class="fa fa-user"></i></span>
                                <span><?php echo $data['NameStr']; ?></span>
                                <p class="date"><?php echo $data['date']; ?></p>
                            </div>
                        </div>
                        <p class="cmt"><?php echo $data['comment']; ?></p>
                        <div class="settinfCmt">

                            <span><a href="<?php echo "reply.php?pageID=" . $_GET["pageID"] . "&commentID=" . $data['commentID']; ?>">reply</a></span>
                            <span><a href="<?php echo "reply.php?pageID=" . $_GET["pageID"] . "&commentID=" . $data['commentID'];
                                            ?>">show <b><?php echo replyCount($data['commentID']); ?>
                                    </b> relies</a></span>
                        </div>
                    </div>
                    <!-- end comment  -->
                <?php } ?>
                <hr />
                <!-- start form comment  -->
                <div class="commentsSystemContPartOne">
                    <div class="comment">
                        <form action="<?php echo $_SERVER['PHP_SELF'] . "?pageID=" . $_GET['pageID']; ?>" method="post">
                            <div class="nameProCon">
                                <input type="text" class="nameProduct" name="comments" placeholder="type you're comment" autocomplete="off" />
                                <button><i class="fa fa-paper-plane"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end form comment  -->
            </div>
        </div>
<?php
        include "../include/footer.php";
    }
}
ob_end_flush();
?>