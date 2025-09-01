<?php 
    // Initialize variables
    $product_name = "";
    $product_name_error = "";
    $product_price = "";
    $product_price_error = "";
    $product_category = "";
    $product_category_error = "";
    $product_stock_number= "";
    $product_stock_number_error = "";
    $product_expiration_date= "";
    $product_expiration_date_error = "";
    $product_status= "";
    $product_status_error = "";

    $has_error = false;

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        // validation for product name
        $product_name = trim(htmlspecialchars($_POST["product_name"] ?? ""));
        if(empty($product_name)) {
            $product_name_error = "Product Name is Required";
            $has_error = true;
        }

        // validation for product category
        $product_category = trim(htmlspecialchars($_POST["category"] ?? ""));
        if(empty($product_category)) {
            $product_category_error = "Product Category is Required";
            $has_error = true;
        }

        // validation for product price
        $product_price = trim($_POST["price"] ?? "");
        if(empty($product_price)) {
            $product_price_error = "Product Price is Required";
            $has_error = true;
        } else if (!is_numeric($product_price)){
            $product_price_error = "Product Price must be a Number";
            $has_error = true;
        } else {
            $product_price = number_format($product_price, 2, '.', '');
        }

        // validation for product stock
        $product_stock_number = trim($_POST["stock_quantity"] ?? "");
        if(empty($product_stock_number)) {
            $product_stock_number_error = "Product Stock is Required";
            $has_error = true;
        } else if (!is_numeric($product_stock_number)){
            $product_stock_number_error = "Product Stock must be a Number";
            $has_error = true;
        } else if ($product_stock_number <= 0){
            $product_stock_number_error = "Product Stock must be Greater than 0";
            $has_error = true;
        } else {
            $product_stock_number = intval($product_stock_number);
        }

        // validation for product expiration date
        $product_expiration_date = trim($_POST["expiration_date"] ?? "");
        if(empty($product_expiration_date)) {
            $product_expiration_date_error = "Product Expiration Date is Required";
            $has_error = true;
        } else if (strtotime($product_expiration_date) < strtotime(date("Y-m-d"))) {
            $product_expiration_date_error = "Product Expiration Date must be Current or Future Date";
            $has_error = true;
        }

        // validation for product status
        if (!isset($_POST["status"]) || empty($_POST["status"])) {
            $product_status_error = "Product Status is Required";
            $has_error = true;
        } else {
            $product_status = $_POST["status"];
        }

        // Redirect only if no errors
        if(!$has_error) {
            header("Location: viewProduct.php");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
</head>
<body>
    <form method="post">

        <label>Product Name</label><br>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>"><br>
        <p style="color: red; margin: 0;"><?php echo $product_name_error; ?></p><br>

        <label>Category</label>
        <select name="category">
            <option value="">-- Select Category --</option>
            <option value="Category A" <?php if($product_category=="Category A") echo "selected"; ?>>Category A</option>
            <option value="Category B" <?php if($product_category=="Category B") echo "selected"; ?>>Category B</option>
            <option value="Category C" <?php if($product_category=="Category C") echo "selected"; ?>>Category C</option>
            <option value="Category D" <?php if($product_category=="Category D") echo "selected"; ?>>Category D</option>
        </select><br>
        <p style="color: red; margin: 0;"><?php echo $product_category_error; ?></p> <br>

        <label>Price (&#8369;): </label>
        <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($product_price); ?>"><br>
        <p style="color: red; margin: 0;"><?php echo $product_price_error; ?></p><br>

        <label>Stock Quantity: </label>
        <input type="number" name="stock_quantity" min="0" value="<?php echo htmlspecialchars($product_stock_number); ?>"><br>
        <p style="color: red; margin: 0;"><?php echo $product_stock_number_error; ?></p><br>

        <label>Expiration Date: </label>
        <input type="date" name="expiration_date" value="<?php echo htmlspecialchars($product_expiration_date); ?>"><br>
        <p style="color: red; margin: 0;"><?php echo $product_expiration_date_error; ?></p><br>

        <label>Status: </label><br>
        <input type="radio" name="status" value="active" <?php if($product_status=="active") echo "checked"; ?>> Active<br>
        <input type="radio" name="status" value="inactive" <?php if($product_status=="inactive") echo "checked"; ?>> Inactive<br>
        <p style="color: red; margin: 0;"><?php echo $product_status_error; ?></p><br>

        <input type="submit" value="Save Product">
    </form>
</body>
</html>
