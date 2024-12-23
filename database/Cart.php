<?php

// php cart class
class Cart
{
    public $db = null;

    public function __construct(DBController $db)
    {

        
        if (!isset($db->con)) return null;
        $this->db = $db;
    }

    // insert into cart table
    public  function insertIntoCart($params = null, $table = "cart"){
        if ($this->db->con != null){
            if ($params != null){
                // "Insert into cart(user_id) values (0)"
                // get table columns
                //!array_keys:lấy ra toàn bộ KEY trong mảng, hoặc lấy ra các KEY có giá trị được truyền vào
                 //!implode:dùng để nối các phần tử mảng thành một chuỗi kết quả. 
                $columns = implode(',', array_keys($params));

                $values = implode(',' , array_values($params));

                // create sql query
                $query_string = sprintf("INSERT INTO %s(%s) VALUES(%s)", $table, $columns, $values);

                // execute query
                $result = $this->db->con->query($query_string);
                return $result;
            }
        }
    }

    // to get user_id and item_id and insert into cart table
    public  function addToCart($userid, $itemid){
        //!isset: Kiểm tra một biến nào đó đã được khởi tạo hay chưa. Nếu đã tồn tại, isset sẽ trả về giá trị true. 
        //!Hàm empty: Kiểm tra một biến nào đó đã được khởi tạo và có dữ liệu hay chưa.
        if (isset($userid) && isset($itemid)){
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid
            );

            // insert data into cart
            $result = $this->insertIntoCart($params);
            if ($result){
                // Reload Page
                //!header:dieu huong trang
                header("Location: " . $_SERVER['PHP_SELF']);
            }
            return $result;
        }
    }
        // delete cart item using cart item id
        public function deleteCart($item_id = null, $table = 'cart'){
            if($item_id != null){
                $result = $this->db->con->query("DELETE FROM {$table} WHERE item_id={$item_id}");
                if($result){
                    header("Location:" . $_SERVER['PHP_SELF']);
                }
                return $result;
            }
        }

        // Clear all items from the cart
        public function clearCart($table = 'cart'){
            $result = $this->db->con->query("DELETE FROM {$table}");
            if($result){
                header("Location:" . $_SERVER['PHP_SELF']);
            }
            return $result;
        }
        
        // delete cart item using Wishlist item id
        public function deleteWishlist($item_id = null, $table = 'wishlist'){
            if($item_id != null){
                $result = $this->db->con->query("DELETE FROM {$table} WHERE item_id={$item_id}");
                if($result){
                    header("Location:" . $_SERVER['PHP_SELF']);
                }
                return $result;
            }
        }
       // calculate sub total
       public function getSum($arr){
        if(isset($arr)){
            $sum = 0;
            foreach ($arr as $item){
                //!floatval() là hàm để chuyển đổi một chuỗi thành một số dấu phẩy động. được trích xuất từ ​​tham số đầu và
                $sum += floatval($item[0]);
            }
            return number_format($sum, 0, '', '.');
        }
        return '0';
    }
   // get item_it of shopping cart list
   public function getCartId($cartArray = null, $key = "item_id"){
    if ($cartArray != null){
        $cart_id = array_map(function ($value) use($key){
            return $value[$key];
        }, $cartArray);
        return $cart_id;
    }
}
  // Save for later
  public function saveForLater($item_id = null, $saveTable = "wishlist", $fromTable = "cart"){
    if ($item_id != null){
        $query = "INSERT INTO {$saveTable} SELECT * FROM {$fromTable} WHERE item_id={$item_id};";
        $query .= "DELETE FROM {$fromTable} WHERE item_id={$item_id};";

        // execute multiple query
        $result = $this->db->con->multi_query($query);

        if($result){
            header("Location:" . $_SERVER['PHP_SELF']);
        }
        return $result;
    }
}

   


}