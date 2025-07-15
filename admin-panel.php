<?php

    include("dataBase.php");
    include("functions.php");

    if(!isAdminLogin()){
        header("Location: admin-login.php");
    }

    $error = '';
    $message = '';

    if(isset($_POST["add-product"])){
        $formData = array();    
        if(empty($_POST["itemName"])){
            $error .= '<li>item Name is Required</li>';
        }
        else{
            $formData['itemName'] = trim($_POST["itemName"]);
        }
    
        if(empty($_POST["itemCategory"])){
            $error .= '<li>Category is Required</li>';
        }
        else{
            $formData['itemCategory'] = trim($_POST["itemCategory"]);
        }

        if(empty($_POST["totalItems"])){
            $error .= '<li>No. of Items is Required</li>';
        }
        else{
            $formData['totalItems'] = trim($_POST["totalItems"]);
        }

        if(empty($_POST["amount"])){
            $error .= '<li>Amount is Required</li>';
        }
        else{
            $formData['amount'] = trim($_POST["amount"]);
        }

        if(isset($_FILES['itemImg'])){

            $imgName = $_FILES['itemImg']['name'];
            $imgType = $_FILES['itemImg']['type'];
            $tmpName = $_FILES['itemImg']['tmp_name'];
            $imageSize = $_FILES['itemImg']['size'];
            $extensions = ["jpeg", "png", "jpg"];
            if(move_uploaded_file($tmpName, "farmItemsUpload/".$imgName)){
                $formData['itemImg'] = $imgName;
            }
        }
        else{
            $error .= "<li>Upload Farm's ingredient Image</li>";
        }
    
        if($error == ''){
            $data = array(
                ':itemName'		=>	$formData['itemName']
            );
    
            $query = "
            SELECT item_name FROM farm_items 
            WHERE item_name = :itemName
            AND farmer_name = '".$_SESSION['userName']."'
            ";
            $statement = $connection->prepare($query);    
            $statement->execute($data);

            if($statement->rowCount() > 0){
                $error = '<li>Product Already Exists Please Edit That For Changes</li>';
            }
            else{
                $data = array(
                    ':itemCategory'		   =>   	$formData['itemCategory'],
                    ':userName'            =>       $_SESSION['userName'],
                    ':itemName'			   =>   	$formData['itemName'],
                    ':totalItems'		   =>   	$formData['totalItems'],
                    ':amount'		       =>   	$formData['amount'],
                    ':itemImg'	           =>	    $formData['itemImg'],
                    ':itemAddedOn'		   =>   	getDateTime($connection)
                );
        
                $query = "
                    INSERT INTO farm_items 
                    (item_cat, farmer_name, item_name, total_item, amount, item_pic, item_added_on) 
                    VALUES (:itemCategory, :userName, :itemName, :totalItems, :amount, :itemImg, :itemAddedOn)
                ";
                $statement = $connection->prepare($query);    
                $statement->execute($data);

                header('Location:farmerAdditems.php?msg=add');
            }
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Crabie</title>
  <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .admin-header {
            background-color: #111;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .admin-container {
            padding: 40px 5%;
        }
        .toggle-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 20px;
        }
        .toggle-btn {
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .toggle-btn.active, .toggle-btn:hover {
            background-color: #333;
        }
        .admin-section {
            display: none;
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }
        .admin-section.active {
            display: block;
        }
        .admin-section h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #1a1e23;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
        }
        .product-table th,
        .product-table td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        .product-table th {
            background-color: #eee;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .admin-btn {
            background-color: #000;
            color: #fff;
            padding: 10px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .admin-btn:hover {
            background-color: #333;
        }
        .center{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        ::-webkit-file-upload-button{
            color: white;
            background: #504f4fff;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            outline: none;
        }
        ::-webkit-file-upload-button:hover{
            background: #000000ff;
            cursor: pointer;
        }
    </style>
</head>
<body>

  <div class="admin-header">
    <h1>Admin Panel - Crabie</h1>
  </div>

  <div class="admin-container">

    <!-- Toggle Buttons -->
    <div class="toggle-buttons">
      <button class="toggle-btn active" onclick="toggleSection('product-list')">View Products</button>
      <button class="toggle-btn" onclick="toggleSection('add-product')">Add Product</button>
    </div>

    <!-- Product List -->
    <div class="admin-section active" id="product-list">
      <h2>All Products</h2>
      <table class="product-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Original Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Loop here from DB -->
          <tr>
            <td>1</td>
            <td><img src="images/jacket1.png" width="60"></td>
            <td>Light Blue Jacket</td>
            <td>₹1999</td>
            <td>₹1299</td>
            <td>
              <button class="admin-btn">Edit</button>
              <button class="admin-btn">Delete</button>
            </td>
          </tr>
          <!-- End loop -->
        </tbody>
      </table>
    </div>

    <!-- Add New Product -->
    <div class="admin-section" id="add-product" style="max-width: 600px; margin: 0 auto;">
        <h2 style="padding-left:50px;">Add New Product</h2>
        <form method="POST" enctype="multipart/form-data" style="padding:0 50px;">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" name="price" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" required>
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" name="category" required>
            </div>
            <div class="form-group">
                <label>How many colors?</label>
                <input type="text" name="category" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image1" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image2" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image3" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image4" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image5" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image6" >
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image7" >
            </div>
            <div class="center">
                <input type="submit" name="add-product" class="admin-btn center" value="Add Product">
            </div>
            
        </form>
    </div>
  </div>

  <script>
    function toggleSection(sectionId) {
      const sections = document.querySelectorAll('.admin-section');
      const buttons = document.querySelectorAll('.toggle-btn');

      sections.forEach(sec => sec.classList.remove('active'));
      buttons.forEach(btn => btn.classList.remove('active'));

      document.getElementById(sectionId).classList.add('active');
      event.target.classList.add('active');
    }
  </script>

</body>
</html>
