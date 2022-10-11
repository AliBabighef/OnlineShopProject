<?php
include "../include/connectDB.php";
?>
<!-- start nav bar  -->
<div class="navBarContainner">
    <div class="containner">
        <div class="navBar">
            <div class="logo">
                <span class="icon"><i class="fa fa-store"></i></span>
                <a href="home.php">
                    <h3><span class="fram_color_orange">bi3</span> o <span class="fram_color_orange">chri</span> maroc</h3>
                </a>
            </div>
            <div class="setting">
                <!-- start  -->
                <div class="nav" data-storage="Dashboard">
                    <h3>dashboard</h3>
                </div>
                <div class="nav" data-storage="Categories">
                    <h3>categories</h3>
                </div>
                <div class="nav" data-storage="Log">
                    <h3>log</h3>
                </div>
                <!-- end  -->
            </div>

        </div>
    </div>
</div>
<!-- end nav bar  -->
<!-- start navBarContainnerRes page -->
<div class="navBarFram">
    <div class="containner">
        <div class="navBarContainnerRes">
            <div class="iconMenu"><i class="fa fa-bars"></i></div>
            <div class="sectionPage close">
                <div class="headerRes">
                    <span class="logOutPage"><i class="fa fa-arrow-left"></i></span>
                    <h3><span class="fram_color_orange">bi3</span> o <span class="fram_color_orange">chri</span> maroc</h3>
                </div>
                <div class="profile">
                    <div class="userIconRes">
                        <span><i class="fa fa-user"></i></span>
                        <span></span>
                    </div>
                    <h3> <?php if (isset($_SESSION['userEcommerce'])) {
                                echo $_SESSION['userEcommerce'];
                            } ?></h3>
                    <?php
                    if (isset($_SESSION['userEcommerce'])) {
                        echo '<a href="../include/logOut.php">logOut</a>';
                    } else {
                        echo '<a href="logIn.php">register</a>';
                    }
                    ?>
                </div>
                <!-- start categories  -->
                <div class="parentCate">
                    <div class="categories">
                        <h3>categories</h3>
                        <i class="fa fa-greater-than"></i>
                    </div>
                    <ul>
                        <li><i class="fa fa-home"></i><a href="home.php">home</a></li>
                        <?php
                        $statment = $con->prepare("SELECT * FROM category");
                        $statment->execute();
                        $categories = $statment->fetchAll();
                        foreach ($categories as $cate) { ?>

                            <li><a href="<?php echo "home.php?category=" . $cate["ID"]; ?>"><?php echo $cate["cate_name"]; ?></a></li>

                        <?php } ?>
                    </ul>
                </div>
                <hr>
                <!-- end categories  -->
                <!-- start filter -->
                <div class="parentCities">
                    <div class="cities">
                        <h3>cities</h3>
                        <i class="fa fa-greater-than"></i>
                    </div>
                    <ul>
                        <?php
                        $statment = $con->prepare("SELECT * FROM product");
                        $statment->execute();
                        $cities = $statment->fetchAll();
                        foreach ($cities  as $city) { ?>

                            <li><a href="<?php echo "home.php?locationID=" . $city["ID"] ?>"><?php echo $city["productCity"]; ?></a></li>

                        <?php } ?>
                    </ul>
                </div>
                <hr>
                <!-- end filter -->
                <!-- start contuct us-->
                <div class="categories">
                    <h3>categories</h3>
                    <i class="fa fa-arrow-right"></i>
                </div>
                <hr>
                <!-- end contuct us-->
            </div>
        </div>
    </div>
</div>
<!-- end navBarContainnerRes page -->
<div class="subNavBar">
    <div class="containner">
        <div class="ul">
            <ul class="Dashboard" data-storage="Dashboard">
                <li>test</li>
            </ul>
            <ul class="Categories" data-storage="Categories">
                <!-- start  -->
                <?php
                $statment = $con->prepare("SELECT * from category");
                $statment->execute();
                $categories = $statment->fetchAll();
                foreach ($categories as $cate) { ?>
                    <li><a href="<?php echo "home.php?" . "category=" . $cate["ID"]; ?>"><?php echo $cate["cate_name"]; ?></a></li>
                <?php }
                ?>
                <li>show more ...</li>
            </ul>
            <ul class="Log" data-storage="Log">
                <li><a href="logIn.php">signIn</a></li>
                <li><a href="logIn.php">signUp</a></li>
                <?php if (isset($_SESSION['userEcommerce'])) { ?><li><a href="../include/logOut.php">
                            logOut</a></li><?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="fram-clearBoth"></div>