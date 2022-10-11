<?php
ob_start();
session_start();
session_regenerate_id();
include "../include/header.php";
if (isset($_SESSION['userEcommerce'])) {
    include "../include/navBar.php";
    include "../include/functions.php";
    if (isset($_GET['pageID']) && is_numeric($_GET['pageID'])) {
        $checkColomnOb = new checkColomn();
        $count = $checkColomnOb->checkRowCount("ID", "product", "ID", $_GET['pageID']);
        if ($count > 0) {
            $statment = $con->prepare("SELECT * from usersinfo 
        INNER join product
        ON product.NameID = usersinfo.ID
        WHERE product.ID = ?;");
            $statment->execute(array($_GET['pageID']));
            $all = $statment->fetch();

            $toArrayImg = explode(",", $all['productImg']);
?>

            <div class="showItem">
                <div class="containner">
                    <?php
                    // $errors = array();
                    // if($_SERVER['REQUEST_METHOD'] == "POST"){
                    //     $comments = FILTER_VAR($_POST['comments'], FILTER_SANITIZE_STRING);
                    //     if($comments == null || $comments == ""){
                    //         $errors[] = "<div class='problem'>feild (comment) cant be empty</div>";
                    //     }
                    //     if(!empty($errors)){foreach($errors as $errore){echo $errore;}}else{
                    //         $statment = $con->prepare("SELECT ID from usersinfo WHERE NameStr = ?");
                    //         $statment->execute(array($_SESSION['userEcommerce']));
                    //         $columnId = $statment->fetchColumn();

                    //         $statment = $con->prepare("INSERT INTO comments(comment, `date`, `namdID`, cateID) VALUES(?,now(),?,?)");
                    //         $statment->execute(array($comments, $columnId, $_GET['pageID']));
                    //         $count = $statment->rowCount();

                    //     }
                    // }

                    ?>
                    <h3>item information</h3>
                    <?php
                    if (isset($_GET['viewmore']) && is_string($_GET['viewmore'])) { ?>
                        <div class="containnerImgSlider">
                            <div class="containnerBtn">
                                <span class="leftBtn"><i class="fa fa-arrow-left"></i></span>
                                <div class="placeImg">
                                    <input type="hidden" value="<?php echo $all['productImg'];  ?>" />
                                    <img src="" />
                                </div>
                                <span class="rightBtn"><i class="fa fa-arrow-right"></i></span>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="item">
                            <h4>about item</h4>
                            <div class="itemCon">
                                <div class="leftContainner">
                                    <!-- start name product  -->
                                    <div class="nameProCon">
                                        <span>name</span>
                                        <div class="user"><a href="#"><?php echo $all['productName']; ?></a></div>

                                    </div>
                                    <!-- end name product  -->
                                    <!-- start description product  -->
                                    <div class="nameProCon">
                                        <span>description</span>
                                        <input type="text" class="nameProduct" name="desOfProduct" placeholder="<?php echo $all['productDescription']; ?>" autocomplete="off" disabled />
                                    </div>
                                    <!-- end description  product  -->
                                    <!-- start price product  -->
                                    <div class="nameProCon">
                                        <span>price</span>
                                        <input type="text" name="priceOfProduct" class="pricePro" placeholder="<?php echo $all['productPrice'] . "$"; ?>" autocomplete="off" disabled />
                                    </div>
                                    <!-- start city product  -->
                                    <div class="nameProCon">
                                        <span>city</span>
                                        <input type="text" name="cityOfProduct" placeholder="<?php echo $all['productCity']; ?>" autocomplete="off" disabled />
                                    </div>
                                    <!-- end city  product  -->
                                    <!-- start date -->
                                    <div class="nameProCon">
                                        <span>date</span>
                                        <input type="text" name="date" placeholder="<?php echo $all['dateProduct'] ?>" autocomplete="off" disabled />

                                    </div>
                                    <!-- end date  -->
                                    <!-- start category  -->
                                    <div class="nameProCon">
                                        <span>category</span>
                                        <input type="text" name="category" placeholder="<?php
                                                                                        $getColumnOb = new getColumn();
                                                                                        $getClm = $getColumnOb->columnFx("cate_name", "category", "ID", $all['CateProduct']);
                                                                                        echo $getClm;
                                                                                        ?>" autocomplete="off" disabled />

                                    </div>
                                    <!-- end category -->
                                    <!-- start user  -->
                                    <div class="nameProCon">
                                        <span>user</span>
                                        <div class="user"><a href="#"><?php echo $all['NameStr']; ?></a></div>

                                    </div>
                                    <!-- end user -->
                                    <!-- start number of image -->
                                    <div class="nameProCon">
                                        <span>num of img</span>
                                        <div class="user"><?php echo count($toArrayImg) . ' images'; ?></div>

                                    </div>
                                    <!-- start number of image-->
                                    <!-- start counter of comments -->
                                    <div class="nameProCon">
                                        <span>comments</span>
                                        <div class="user"><a href="<?php echo "comments.php?pageID=" . $_GET['pageID']; ?>"><?php echo "show " . getCountColumn('ID', 'comments', 'cateID', $_GET['pageID']) . " comments"; ?></a></div>

                                    </div>
                                    <!-- start counter of comments -->

                                </div>
                                <div class="rightContainner">
                                    <div class="contImg">
                                        <img src="<?php echo '../upload\\' .  $toArrayImg[0]; ?>" />
                                        <!-- <span class="price">0$</span> -->
                                        <div class="overLow"><a href="<?php echo "?pageID=" . $_GET['pageID'] . "&viewmore=image" ?>"><?php echo "+ " . (count($toArrayImg) - 1) . " images"; ?></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            </div>

<?php
                    }
                } else {

                    echo "page not found";
                }
            } else {

                echo "page not found";
            }
?>
<?php
    include "../include/footer.php";
}
ob_end_flush();
?>