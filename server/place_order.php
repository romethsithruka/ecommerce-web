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

    // 2 get products from cart

    // 3 store information in fo in database



    // 4 store each singke item in order_item database



    // 5 remove evething from create



    // 6  inform user wherether everething is fine or thereis problem





  }



?>