<?php include_once 'partials/connection.php'; ?>

<?php
$query = "select * from categories where cat_id = {$_GET['id']}";
$result = mysqli_query($conn, $query);
$row   = mysqli_fetch_assoc($result);

// make the action when user click on Save Button
if (isset($_POST['submit_edit_category'])) {

    // get image data
    $image_name = $_FILES['cat_image']['name'];
    $tmp_name   = $_FILES['cat_image']['tmp_name'];
    $path       = 'images/cat_images/';


    // move image to folder
    move_uploaded_file($tmp_name, $path . $image_name);

    if ($image_name) {
        $check_img = $path . $image_name;
    } else {
        $check_img = $row['cat_image'];
    }


    // Take Data From Web Form 
    $cat_name    = $_POST['cat_name'];


    $name_query = " SELECT * FROM categories WHERE cat_name = '$cat_name' ";
    $name_query_run = mysqli_query($conn, $name_query);
    if (mysqli_num_rows($name_query_run) > 0) {
        $repeated_name = "* Category name already taken, please try another one!";
    } else {
        $query = "UPDATE categories set cat_name      = '$cat_name' ,
                                        cat_image     = '$check_img' 
                  where cat_id = {$_GET['id']}";

        mysqli_query($conn, $query);
        header("location:manage_category.php");
    }
}
?>
<?php include_once 'partials/header_admin.php'; ?>
<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-header text-center"><strong>Create New Category</strong></div>
                        <div class="card-body card-block">
                            <form action="" method="post" enctype="multipart/form-data" class="">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Category Name</label>
                                        <input type="text" id="adminname" name="cat_name" placeholder="Category name" class="form-control" value="<?php echo $row['cat_name'] ?>">
                                        <small style="color: red;">
                                            <?php
                                            if (isset($repeated_name) && $repeated_name != "") {
                                                echo ($repeated_name);
                                                unset($repeated_name);
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="file-input" class=" form-control-label">Upload Image</label>
                                        <input type="file" id="file-input" name="cat_image" class="form-control-file">
                                    </div>
                                </div>
                                <!-- <div class="form-actions form-group">
                                                <button type="submit" name="submit" class="btn btn-success btn-sm">Create Category</button>
                                            </div> -->
                                <div>
                                    <button id="payment-button" type="submit" class="btn btn-lg btn-success btn-block" name="submit_edit_category">
                                        <span id="payment-button-amount">Edit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DATA TABLE-->

            <!-- END MAIN CONTENT-->
        </div>
    </div>
</div>
<!-- </div>
</div> -->

<?php
include_once 'partials/footer_admin.php';
?>