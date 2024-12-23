<?php
// $product_shuffle = $product->getData();
shuffle($product_shuffle);

// request method post
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['top_sale_submit'])) {
        // call method addToCart
        $Cart->addToCart($_POST['user_id'], $_POST['item_id']);
    }
}
?>
<section id="top-sale">
    <div class="container py-5">
        <h4 class="font-roboto font-size-25"><b>Mua Online giá siêu rẻ</b></h4>
        <hr>
        <!-- owl carousel -->
        <div class="owl-carousel owl-theme">
            <?php foreach ($product_shuffle as $item) { ?>
                <div class="item py-2">
                    <div class="product font-roboto">
                        <a href="<?php printf('%s?item_id=%s', 'product.php',  $item['item_id']); ?>"><img src="<?php echo $item['item_image'] ?? "./assets/products/xiaomi_14t.png"; ?>" alt="product1" class="img-fluid"></a>
                        <div class="text-center">
                            <h6><?php echo  $item['item_name'] ?? "Unknown";  ?></h6>
                            <?php
                            $rating = mt_rand(8, 10) / 2;
                            $fullStars = floor($rating);
                            $emptyStars = 5 - ceil($rating);

                            echo '<div class="rating text-warning font-size-15">';
                            for ($i = 0; $i < $fullStars; $i++) {
                                echo '<span><i class="fas fa-star"></i></span>';
                            }

                            if ($rating - $fullStars >= 0.5) {
                                echo '<span><i class="fas fa-star-half-alt"></i></span>';
                            }

                            for ($i = 0; $i < $emptyStars; $i++) {
                                echo '<span><i class="far fa-star"></i></span>';
                            }
                            echo '</div>';
                            ?>


                            <div class="price py-2">
                                <span>
                                    <?php echo number_format($item['item_price'] ?? 0, 0, '', '.'); ?>&#8363;
                                </span>


                            </div>
                            <form method="post">
                                <input type="hidden" name="item_id" value="<?php echo $item['item_id'] ?? '1'; ?>">
                                <input type="hidden" name="user_id" value="<?php echo 1; ?>">
                                <?php
                                //!Hàm in_array() trong php dùng để kiểm tra giá trị nào đó có tồn tại trong mảng hay không.
                                //! Nếu như tồn tại thì nó sẽ trả về TRUE và ngược lại sẽ trả về FALSE 
                                if (in_array($item['item_id'], $Cart->getCartId($product->getData('cart')) ?? [])) {
                                    echo '<button type="submit" disabled class="btn btn-success font-size-15"><b>Đã có trong giỏ hàng</b></button>';
                                } else {
                                    echo '<button type="submit" name="top_sale_submit" class="btn btn-warning font-size-15"><b>Thêm vào giỏ hàng</b></button>';
                                }
                                ?>


                            </form>
                        </div>
                    </div>
                </div>
            <?php } // closing foreach function 
            ?>
        </div>
        <!-- !owl carousel -->
    </div>
</section>
<!-- !Top Sale -->
<style>
    .product {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* Đảm bảo nội dung được căn đều từ trên xuống */
        height: 100%;
        /* Đảm bảo tất cả thẻ có chiều cao bằng nhau */
        border: 1px solid #ddd;
        /* Đường viền cho mỗi thẻ */
        padding: 15px;
        box-sizing: border-box;
        /* Tính padding trong chiều cao và chiều rộng */
        border-radius: 5px;
        background-color: #fff;
    }

    .product img {
        max-width: 100%;
        /* Đảm bảo hình ảnh không vượt quá kích thước thẻ */
        height: auto;
        margin-bottom: 15px;
    }

    .product h6 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        white-space: nowrap;
        /* Không cho phép xuống dòng */
        overflow: hidden;
        /* Ẩn nội dung thừa */
        text-overflow: ellipsis;
        /* Hiển thị dấu "..." nếu vượt quá */
    }

    .product .text-center {
        margin-top: auto;
        /* Đẩy nút xuống cuối cùng */
    }

    .price {
        font-size: 18px;
        color: #e60023;
        /* Màu giá */
        margin-bottom: 10px;
    }
</style>