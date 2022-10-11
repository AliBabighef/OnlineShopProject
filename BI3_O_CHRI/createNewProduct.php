<?php
ob_start();
session_start();
session_regenerate_id();
if (isset($_SESSION['userEcommerce'])) {
    include "../include/header.php";
    include "../include/navBar.php";
    include "../include/functions.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nameOfProduct = filter_var($_POST['nameOfProduct'], FILTER_SANITIZE_STRING);
        $desOfProduct = filter_var($_POST['desOfProduct'], FILTER_SANITIZE_STRING);
        $priceOfProduct = filter_var($_POST['priceOfProduct'], FILTER_SANITIZE_STRING);
        $cityOfProduct = filter_var($_POST['cityOfProduct'], FILTER_SANITIZE_STRING);
        $imgProSrc = $_FILES['imgProSrc'];
        $statusPro = $_POST['statusPro'];
        $category = $_POST['category'];

        $imgName = $imgProSrc['name'];
        $imgSize = $imgProSrc['size'];
        $imgErrore = $imgProSrc['error'];
        $imgTem = $imgProSrc['tmp_name'];
        $imgType = $imgProSrc['type'];

        $myAllImgForUpload = array();

        $errors = array();

        $allowsExtend = array("jpg", "png", "jpeg", "gif");


        for ($i = 0; $i < count($imgName); $i++) {
            # code...

            if ($imgErrore[$i] !== 4) {

                $myExtend = strtolower(end(explode(".", $imgName[$i])));
                if (!in_array($myExtend, $allowsExtend)) {

                    $errors[] = "</div class='fram-problem'>" . "the extend(" . $myExtend . ") not accept it" . "</div>";
                } else {

                    $rand = rand(0, 1000000000000);
                    $myImgAfterChange = $rand . "_" . $imgName[$i];
                    $myAllImgForUpload[] =  $myImgAfterChange;
                    move_uploaded_file($imgTem[$i], "../upload\\" . $myImgAfterChange);
                }
            } else {

                $errors[] = "</div class='fram-probleme'>" . "you can not send an image empty or null" . "</div>";
            }
        }
        if (empty($errors)) {
            $imgByStr = implode(",", $myAllImgForUpload);
            $columnOb = new getColumn();
            $columnId = $columnOb->columnFx("id", "usersinfo", "NameStr", $_SESSION['userEcommerce']);

            $statment = $con->prepare("INSERT INTO `product` (`productName`, `productDescription`, 
            `productPrice`, `productCity`, `productImg`, `statusProduct`, `CateProduct`, `NameID`, dateProduct) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, now())");
            $statment->execute(array($nameOfProduct, $desOfProduct, $priceOfProduct, $cityOfProduct, $imgByStr, $statusPro, $category, $columnId));
            $count = $statment->rowCount();
        } else {
            foreach ($errors as $er) {
                echo $er;
            }
        }
    }
?>
    <div class="newProduct">
        <div class="containner">
            <h3>Create New product</h3>
            <div class="newProductCont">
                <h4>Create a New Item</h4>
                <div class="parentElements">
                    <!-- start left  -->
                    <div class="leftElements">
                        <!-- start form  -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <!-- start name product  -->
                            <div class="nameProCon">
                                <input type="text" class="nameOfProduct" name="nameOfProduct" placeholder="type you're product name" autocomplete="off" required />
                                <span>name</span>
                            </div>
                            <!-- end name product  -->
                            <!-- start description product  -->
                            <div class="nameProCon">
                                <input type="text" class="nameProduct" name="desOfProduct" placeholder="type you're description about that product name" autocomplete="off" required />
                                <span>description</span>
                            </div>
                            <!-- end description  product  -->
                            <!-- start price product  -->
                            <div class="nameProCon">
                                <input type="text" name="priceOfProduct" class="pricePro" placeholder="type you're price about that product name" autocomplete="off" required />
                                <span>price</span>
                            </div>
                            <!-- start city product  -->
                            <div class="nameProCon">
                                <input type="text" name="cityOfProduct" placeholder="type you're city" autocomplete="off" required />
                                <span>city</span>
                            </div>
                            <!-- end city  product  -->

                            <!-- start uplaod image of product  -->
                            <div class="nameProCon">
                                <input type="file" name="imgProSrc[]" multiple="multiple" />
                                <span>upload</span>
                            </div>
                            <!-- end uplaod image of product  -->
                            <!-- start status product  -->
                            <div class="nameProCon">
                                <select name="statusPro">
                                    <option value="0">***</option>
                                    <option value="1">New</option>
                                    <option value="2">like new</option>
                                    <option value="3">old</option>
                                </select>
                                <span>status</span>
                            </div>
                            <!-- end status  product  -->
                            <!-- start city categories  -->
                            <div class="nameProCon">
                                <select name="category">
                                    <option value="0">***</option>
                                    <?php
                                    $categoryOB = new getAllAppData;
                                    $columns = $categoryOB->allFx("category");
                                    foreach ($columns as $column) { ?>
                                        <option value="<?php echo $column["ID"]; ?>"><?php echo $column["cate_name"]; ?></option>
                                    <?php } ?>
                                </select>
                                <span>status</span>
                            </div>
                            <!-- end city  categories  -->

                            <!-- start button send  -->
                            <div class="nameProCon">
                                <input type="submit" name="files" value="send" />
                            </div>
                            <!-- end button send  -->
                        </form>
                        <!-- end form  -->
                    </div>
                    <!-- end left  -->
                    <!-- start  right  -->
                    <div class="rightElements">
                        <div class="contImg">
                            <i class="fa fa-user"></i>
                            <span class="price">0$</span>
                        </div>
                        <div class="contentImg">
                            <h5>name ad</h5>
                            <p>description</p>
                        </div>
                    </div>
                    <!-- end  right  -->
                </div>
            </div>
        </div>
    </div>
<?php
    include "../include/footer.php";
} else {
    header("location: logIn.php");
    exit();
}
ob_end_flush();
?>