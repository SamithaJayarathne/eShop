<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Watchlist | eShop</title>

        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />

        <link rel="icon" href="resourses/logo.svg" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php include "header.php";

                ?>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 border border-1 border-primary rounded mb-2">
                            <div class="row">

                                <div class="col-12">
                                    <label class="form-label fs-1 fw-bolder">Watchlist &hearts;</label>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <hr />
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="offset-lg-2 col-12 col-lg-6 mb-3">
                                            <input type="text" class="form-control" placeholder="Search in Watchlist..." />
                                        </div>
                                        <div class="col-12 col-lg-2 mb-3 d-grid">
                                            <button class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr />
                                </div>

                                <div class="col-11 col-lg-2 border-0 border-end border-1 border-dark">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Watchlist</li>
                                        </ol>
                                    </nav>
                                    <nav class="nav nav-pills flex-column">
                                        <a class="nav-link active" aria-current="page" href="#">My Watchlist</a>
                                        <a class="nav-link" href="#">My Cart</a>
                                        <a class="nav-link" href="#">Recents</a>
                                    </nav>
                                </div>

                                <?php
                                $watclist_rs = Database::search("SELECT * FROM `watchlist` WHERE 
                                `users_email`='" . $_SESSION["u"]["email"] . "'");
                                $watchlist_num = $watclist_rs->num_rows;

                                if ($watchlist_num == 0) {
                                ?>
                                    <!-- empty view -->
                                    <div class="col-12 col-lg-9">
                                        <div class="row">
                                            <div class="col-12 emptyView"></div>
                                            <div class="col-12 text-center">
                                                <label class="form-label fs-1 fw-bold">You have no items in your Watchlist yet.</label>
                                            </div>
                                            <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                                <a href="home.php" class="btn btn-warning fs-3 fw-bold">Start Shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- empty view -->
                                    <?php
                                } else {
                                    for ($x = 0; $x < $watchlist_num; $x++) {
                                        $watchlist_data = $watclist_rs->fetch_assoc();
                                        $pro_id = $watchlist_data["product_id"];



                                    ?>
                                        <!-- have products -->
                                        <div class="col-12 col-lg-9">
                                            <div class="row">

                                                <div class="card mb-3 mx-0 mx-lg-2 col-12">
                                                    <div class="row g-0">
                                                        <div class="col-md-4">
                                                            <?php
                                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='".$pro_id."'");
                                                            $img_num = $img_rs->num_rows;
                                                            if($img_num !=0){
                                                                $img_data = $img_rs->fetch_assoc();
                                                                ?>
                                                                <img src="<?php echo $img_data["img_path"]; ?>" class="img-fluid rounded-start" style="height: 200px;" />
                                                                <?php
                                                            }
                                                            ?>

                                                            
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="card-body">
                                                                <?php
                                                                $pro_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pro_id . "'");
                                                                $pro_num = $pro_rs->num_rows;
                                                                if ($pro_num !=0) {
                                                                    $pro_data = $pro_rs->fetch_assoc();
                                                                ?>

                                                                    <h5 class="card-title fs-2 fw-bold text-primary"><?php echo $pro_data["title"]; ?></h5>

                                                                    <?php
                                                                    $color = $pro_data["color_color_id"];
                                                                    $color_rs = Database::search("SELECT * FROM `color` WHERE `color_id`='" . $color . "'");
                                                                    $color_num = $color_rs->num_rows;
                                                                    if($color_num !=0){
                                                                        $color_data = $color_rs->fetch_assoc();
                                                                        
                                                                        ?>
                                                                        <span class="fs-5 fw-bold text-black-50">Colour : <?php echo $color_data["color_name"]; ?></span>
                                                                        <?php
                                                                    }
                                                                    ?>



                                                                    
                                                                    &nbsp;&nbsp; | &nbsp;&nbsp;

                                                                    <?php
                                                                    $condition = $pro_data["condition_condition_id"];
                                                                    $condition_rs = Database::search("SELECT * FROM `condition` WHERE `condition_id`='" . $condition . "'");
                                                                    $condition_num = $condition_rs->num_rows;
                                                                    if($color_num !=0){
                                                                        $condition_data = $condition_rs->fetch_assoc();
                                                                        
                                                                        ?>
                                                                         <span class="fs-5 fw-bold text-black-50">Condition : <?php echo $condition_data["condition_name"]; ?></span>
                                                                        <?php
                                                                    }
                                                                    ?>

                                                                   
                                                                    <br />
                                                                    <span class="fs-5 fw-bold text-black-50">Price :</span>&nbsp;&nbsp;
                                                                    <span class="fs-5 fw-bold text-black">Rs. <?php echo $pro_data["price"]; ?> .00</span>
                                                                    <br />
                                                                    <span class="fs-5 fw-bold text-black-50">Quantity :</span>&nbsp;&nbsp;
                                                                    <span class="fs-5 fw-bold text-black"><?php echo $pro_data["qty"]; ?> Items available</span>
                                                                    <br />
                                                                    <span class="fs-5 fw-bold text-black-50">Seller :</span>
                                                                    <br />
                                                                    <?php
                                                                    $user = $pro_data["users_email"];
                                                                    $user_rs = Database::search("SELECT * FROM `users` WHERE `email`='" . $user . "'");
                                                                    $user_num = $user_rs->num_rows;

                                                                    if($user_num !=0){
                                                                        $user_data = $user_rs->fetch_assoc();

                                                                        ?>
                                                                        <span class="fs-5 fw-bold text-black"><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></span>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 mt-5">
                                                            <div class="card-body d-lg-grid">
                                                                
                                                                <a href="<?php echo "singleProductView.php?id=". ($product_data["id"]); ?>" class="btn btn-outline-success mb-2">Buy Now</a>
                                                                <a href="#" class="btn btn-outline-warning mb-2">Add to Cart</a>
                                                                <a href="#" onclick="removeFromWatchlist(<?php echo $watchlist_data['id']; ?>);" class="btn btn-outline-danger">Remove</a>
                                                            </div>
                                                        </div>

                                                    <?php
                                                                }
                                                    ?>


                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- have products -->
                                <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

                <?php include "footer.php"; ?>

            </div>
        </div>

        <script src="bootstrap.bundle.js"></script>
        <script src="script.js"></script>
    </body>

    </html>
<?php

}

?>