<?php
ob_start();
session_start();
session_regenerate_id();
include "../include/header.php";
include "../include/navBar.php";
include "../include/functions.php";
if (isset($_GET["category"])) {
    $do = $_GET["category"];
?>
    <div class="home_page">
        <div class="containner">
            <!-- start sub show item  -->
            <h3 class="CutomHeader "><?php $column = getAllData("*", "category", "ID", $do);
                                        echo $column["cate_name"]; ?></h3>
            <div class="containnerProduct">
                <?php
                $statment = $con->prepare("SELECT *, product.ID as showID from product
                INNER JOIN category ON category.ID = product.CateProduct
                WHERE product.CateProduct = ?");
                $statment->execute(array($_GET["category"]));
                $data = $statment->fetchAll();
                foreach ($data as $dt) {
                    $toArray = explode(",", $dt["productImg"]);
                ?>
                    <div class="product">
                        <div class="headerProduct">
                            <!-- <span class="iconImg"><i class="fa fa-user"></i></span> -->
                            <span class="iconImg"><img src="<?php echo '../upload\\' . $toArray[0]; ?>" /></span>
                            <span class="price"><?php echo $dt["productPrice"] . "$"; ?></span>
                        </div>
                        <div class="infoProduct">
                            <div class="ChildInfoProduct">
                                <span class="nameProduct"><a href="#"><?php echo $dt["productName"]; ?></a></span>
                                <span class="dateProduct"><span><?php echo $dt["dateProduct"]; ?></span> min ago</span>
                            </div>
                            <p class="decriptionOfProduct"><?php echo $dt["productDescription"]; ?></p>
                        </div>
                        <div class="overLow"><a href="<?php echo 'showItem.php?pageID=' . $dt["showID"]; ?>">show more...</a></div>
                    </div>
                <?php } ?>
            </div>
            <!-- start sub show item  -->
        </div>
    </div>
<?php
} else if (isset($_GET["locationID"])) { ?>
    <!-- start location  -->
    <div class="home_page">
        <div class="containner">
            <!-- start sub show item  -->

            <div class="containnerProduct">
                <?php
                $statment = $con->prepare("SELECT * from product
                WHERE product.ID = ?");
                $statment->execute(array($_GET["locationID"]));
                $data = $statment->fetchAll();
                foreach ($data as $dt) {
                    $toArray = explode(",", $dt["productImg"]);
                ?>
                    <div class="product">
                        <div class="headerProduct">
                            <!-- <span class="iconImg"><i class="fa fa-user"></i></span> -->
                            <span class="iconImg"><img src="<?php echo '../upload\\' . $toArray[0]; ?>" /></span>
                            <span class="price"><?php echo $dt["productPrice"] . "$"; ?></span>
                        </div>
                        <div class="infoProduct">
                            <div class="ChildInfoProduct">
                                <span class="nameProduct"><a href="#"><?php echo $dt["productName"]; ?></a></span>
                                <span class="dateProduct"><span><?php echo $dt["dateProduct"]; ?></span> min ago</span>
                            </div>
                            <p class="decriptionOfProduct"><?php echo $dt["productDescription"]; ?></p>
                        </div>
                        <div class="overLow"><a href="<?php echo 'showItem.php?pageID=' . $dt["ID"]; ?>">show more...</a></div>
                    </div>
                <?php } ?>
            </div>
            <!-- start sub show item  -->
        </div>
    </div>
    <!-- end location  -->
<?php } else { ?>

    <div class="home_page">
        <div class="containner">
            <div class="subNavBar">
                <div class="search">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <button class="iconSearch"><i class="fa fa-search"></i></button>
                        <input type="text" name="shearchHome" placeholder="search a you're product" />
                    </form>
                </div>
            </div>
            <div class="containnerProduct">
                <!-- start show product  -->
                <?php
                $getAllAppDataOb = new getAllAppData();
                $data = $getAllAppDataOb->allFx("product");
                foreach ($data as $dt) {
                    $toArray = explode(",", $dt["productImg"]);
                ?>
                    <div class="product">
                        <div class="headerProduct">
                            <!-- <span class="iconImg"><i class="fa fa-user"></i></span> -->
                            <span class="iconImg"><img src="<?php echo '../upload\\' . $toArray[0]; ?>" /></span>
                            <span class="price"><?php echo $dt["productPrice"] . "$"; ?></span>
                        </div>
                        <div class="infoProduct">
                            <div class="ChildInfoProduct">
                                <span class="nameProduct"><a href="#"><?php echo $dt["productName"]; ?></a></span>
                                <span class="dateProduct"><span><?php echo timeAgo($dt["dateProduct"]); ?>
                            </div>
                            <p class="decriptionOfProduct"><?php echo $dt["productDescription"]; ?></p>
                        </div>
                        <div class="overLow"><a href="<?php echo 'showItem.php?pageID=' . $dt["ID"]; ?>">show more...</a></div>
                    </div>
                <?php } ?>
                <!-- end show product  -->
            </div>
        </div>
    </div>
<?php
}
include "../include/footer.php";
ob_end_flush();
?>