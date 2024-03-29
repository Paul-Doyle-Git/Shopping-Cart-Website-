<?php require_once '../../config.php'; ?>
<?php
use BookWorms\Model\Product;
use BookWorms\Model\Image;

if (!$request->is_logged_in()) {
  $request->redirect("/views/auth/login-form.php");
}
$role = $request->session()->get("role");
if ($role !== "admin") {
  $request->redirect("/actions/logout.php");
}
?>
<?php
try {
    $rules = [
        'id' => 'present|integer|min:1'
    ];
    $request->validate($rules);
    if (!$request->is_valid()) {
        throw new Exception("Illegal request");
    }
    $id = $request->input('id');
    $product = Product::findById($id);
    if ($product === null) {
        throw new Exception("Illegal request parameter");
        }
    }
    catch (Exception $ex) {
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");

    $request->redirect("/admin/home.php");
    }

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Book Worms - Edit Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="assets/css/mystyle.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
             <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </head>
  <body>
   

      <?php require 'include/navbar.php'; ?>
      <?php require 'include/flash.php'; ?>
      <main role="main">
      <div class="cart breathe">
          
      <div class="row">
          <div class="col table-responsive">
          <h1>Edit Product</h1>
            <form method="post" 
                  action="<?= APP_URL .'actions/product-update.php' ?>"
                  enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?= $product->id ?>" />  

                <label for="brand" class="mt-2">Brand</label>
                <div class="form-field">
                    <input type="text" name="brand" id="brand" value="<?= old('brand', $product->brand) ?>" />
                    <span class="error"><?= error('brand') ?></span>
                </div>

                <label for="model" class="mt-2">Model</label>
                <div class="form-field">
                    <input type="text" name="model" id="model" value="<?= old('model', $product->model) ?>" />
                    <span class="error"><?= error('model') ?></span>
                </div>

                <label for="price" class="mt-2">Price(€)</label>
                <div class="form-field">
                    <input type="text" name="price" id="price" value="<?= old('price', $product->price) ?>" />
                    <span class="error"><?= error('price') ?></span>
                </div>

                <label for="description" class="mt-2">Description</label>
                <div class="form-field">
                    <textarea name="description" id="description"  cols="147" rows="5"><?= old('description', $product->description) ?></textarea>
                    <span class="error"><?= error('description') ?></span>
                </div>

                <div>
                <label for="category">Category</label>
                <select class="form-control" name="category" id="category">
                  <option value="guitar" <?= chosen("category", "guitar") ? "selected" : "" ?>>Guitar</option>
                  <option value="bass" <?= chosen("category", "bass") ? "selected" : "" ?>>Bass</option>
                  <option value="drums" <?= chosen("category", "drums") ? "selected" : "" ?>>Drums</option>
                </select>
                <span class="error"><?= error("category") ?></span>
              </div>

           
                <div class="form-group">
                    <label for="image_id" class="mt-2">Product Image(Main):</label>
                    <?php
                    $image = Image::findById($product->image_id);
                    if ($image !== null){
                    ?>
                    <img src="<?= APP_URL . "/actions/". $image->filename ?>" width="150px" />
                    <?php
                    }
                    ?>
                    <input type="file" name="image_id" id="image_id" value="<?= $image->filename ?>"/>
                    <span class="error"><?= error('image_id') ?></span>
                </div>


                <div class="form-field">
                    <label for="image_id2" class="mt-2">Product Image2:</label>
                    <?php
                    $image2 = Image::findById($product->image_id2);
                    if ($image2 !== null){
                    ?>
                    <img src="<?= APP_URL . "/actions/" . $image2->filename ?>" width="150px" />
                    <?php
                    }
                    ?>
                    <input type="file" name="image_id2" id="image_id2" value="<?= $image2->filename ?>"/>
                    <span class="error"><?= error('image_id2') ?></span>
                </div>


                <div class="form-field">
                    <label for="image_id3" class="mt-2">Product Image3:</label>
                    <?php
                    $image3 = Image::findById($product->image_id3);
                    if ($image3 !== null){
                    ?>
                    <img src="<?= APP_URL . "/actions/" . $image3->filename ?>" width="150px" />
                    <?php
                    }
                    ?>
                    <input type="file" name="image_id3" id="image_id3" value="<?= $image3->filename ?>/>
                    <span class="error"><?= error('image_id3') ?></span>
                </div>
              
                <div class="form-field">
                    <label for="image_id4" class="mt-2">Product Image4:</label>
                    <?php
                    $image4 = Image::findById($product->image_id4);
                    if ($image4 !== null){
                    ?>
                    <img src="<?= APP_URL . "/actions/" . $image4->filename ?>" width="150px" />
                    <?php
                    }
                    ?>
                    <input type="file" name="image_id4" id="image_id4" value="<?= $image4->filename ?>/>
                    <span class="error"><?= error('image_id4') ?></span>
                </div>
               

                
               <div class="margin"></div>
                <label></label>
                <button type="submit" class="btn btn-primary">Store</button>
                <a class="btn btn-danger" href="<?= APP_URL ?>/views/admin/home.php">Cancel</a>
             
        
            </form>
            </div>
        </div>
       

      </main>
      <?php require 'include/footer_stick.php'; ?>
    </div>
    <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
