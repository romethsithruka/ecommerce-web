<?php



session_start();
include('connection.php');


  if(isset($_POST['place_order'])  ){


    //1 get usser info and store in database
    $name  = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $city  = $_POST['city'];
    $address  = $_POST['address'];
    $order_cost =$_SESSION['total'];
    $order_status = "on_hold";

    $user_id = 1;

    $order_date = date('y-m-d H:i:s');
    
    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date)
                    VALUES (?,?,?,?,?,?,?); ");

    $stmt->bind_param('isiisss',$order_cost, $order_status,$user_id, $phone,$city,$address,$order_date);

    $stmt->execute();
 // 2 store information in fo in database
    $order_id = $stmt->insert_id;

    echo $order_id;

    // 3 get products from cart

    foreach ($_SESSION['cart'] as $key => $product) {

    $product_id = $product['product_id'];
    $product_name = $product['product_name'];
    $product_image = $product['product_image'];
    $product_price = $product['product_price'];
    $product_quantity = $product['product_quantity'];
// 4 store each singke item in order_item database
    $stmt1 = $conn->prepare("INSERT INTO order_items 
        (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt1->bind_param("iissiiis", 
        $order_id, 
        $product_id, 
        $product_name, 
        $product_image, 
        $product_price, 
        $product_quantity, 
        $user_id, 
        $order_date
    );

    $stmt1->execute();
}

   



    



    // 5 remove evething from crrt ->delay until payment is done
    // unset($_SESSION['cart']);



    // 6  inform user wherether everething is fine or thereis problem
    header('location: ../payment.php?order_status=order placed successfully');




  }



?>