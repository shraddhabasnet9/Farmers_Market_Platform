<?php
    include("nav_old.php");
    include('conn.php');
    session_start();
    //$pid=$_SESSION['pid'];
    $uid=null;
    if($_SESSION['uid']){
        $uid=$_SESSION['uid'];

    // echo $_SESSION['uid'];
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>
    <style>
        .container .row{
            align-items: center;
            margin:14px 18px;
            padding: 39px 40px;
        }
    </style>
</head>
<body>
    <div class="container">
       
            <div class="row">
                <div class="col-lg-12 text-center border rounded bg-light my-5 ">
                    <h1>My Cart</h1>
                </div>
                <div class="col-lg-9">
                    <form action="manage_cart.php" method="POST">
                        <table class="table" border="1">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">SN</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Item Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            
                                <?php
                                    if(isset($_SESSION['cart']))
                                    {   
                                        $item=0;
                                        foreach($_SESSION['cart'] as $key => $value)
                                        {
                                            
                                            $item++;
                                            echo "<tr>
                                                <td>$item</td>
                                                <td>{$value['Item_Name']}</td>
                                                <td class='price'>{$value['Price']}</td>
                                                <td><input type='number' class='quantity' value='{$value['Quantity']}' min='1' max='10'>
                                                </td>
                                                <td>
                                                    <button name='Remove_Item' class='btn btn-sm btn-outline-danger'>REMOVE</button>
                                                    <input type='hidden' name='Item_Name' value='$value[Item_Name]'>
                                                </td>
                                            </tr>";
                                        }
                                        echo '
                                            <tr>
                                                <td colspan="4">
                                                    Total Item:</td>
                                                <td>'.$item.'</td>
                                                </tr>
                                                <tr>
                                                <td colspan="4">
                                                    Total Quantity:</td>
                                                <td id="quantity"></td>
                                                </tr>
                                                <tr>
                                                <td colspan="4">
                                                    Total Price:</td>
                                                <td id="price"></td>
                                                </tr>
                                        ';
                                    }
                                ?>
                            </tbody>
                        </table>   
                    </form>
                </div>
                <div class="col-lg-3">
                        <!--<div class="border bg-light rounded p-4">-->
                            <?php
                                if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0)
                                {
                                    $readuser='SELECT * FROM USER_LOGIN WHERE uid='.$uid.';';
                                    if($result=$conn->query($readuser)){
                                        if($result->num_rows>0){
                                            while($row=$result->fetch_assoc()){
                                                $name=$row['name'];
                                                $phone=$row['phone'];
                                            }
                                        }
                                    }
                                    
                            ?>
                            <form action="purchase.php" method="POST">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="Full_Name" class="form-control" required value='<?=$name?>' readonly>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="number" name="Phone_No" class="form-control" required value='<?=$phone?>' readonly>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="Address" class="form-control" required>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="Pay_Mode" value="COD" id="flexRadioDefault" checked>
                                    <label class="form-check-label" for="flexRadioDefault2">Cash on Delivery</label>
                                </div>
                                    <br>
                                    <button class="btn btn-primary btn-block" name="purchase">Make Purchase</button>
                            </form>

                            <?php
                             }
                            ?>
                        </div>
                </div>
            </div>
        <button class='btn btn-primary' id='printbtn'>Print</button>
    </div>
</body>
<script>
    let quantityEl=document.getElementById("quantity");
    let priceEl=document.getElementById("price");
    let priceElAll=document.querySelectorAll(".price");
    let quantityElAll=document.querySelectorAll(".quantity");
    quantityElAll.forEach((quantityEl,index)=>{
        quantityEl.addEventListener("change",function(){
            if(this.value<1){
                this.value=1;
            }
            updateCartTotal();
        });
    });

    function updateCartTotal(){
        let price=0;
        let quantity=0;
        let totalquantity=0;
        let totalprice=0;
        priceElAll.forEach((priceEl,index)=>{
            priceamount=priceEl.innerText;
            priceamount=priceamount.replace("Rs","");
            price=parseInt(priceamount);
            quantity=parseInt(quantityElAll[index].value);
            totalquantity=totalquantity+quantity;
            totalprice=totalprice+(price*quantity);
            console.log(totalprice);
        });
        quantityEl.innerText=totalquantity;
        priceEl.innerText=totalprice;
    }
    updateCartTotal();

    document.getElementById("printbtn").addEventListener("click",(e)=>{
        e.target.style.opacity="0";
        window.print();
        e.target.style.opacity="1";
    });
</script>
</html>
<?php
}else{
        header("Location:login.php");
    }
    ?>