<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<body>
<?php include 'sidebar.php'; ?>
<div id="main">
    <div class="container_of_content">
        <div class="description-box">
            <h3>MÔ TẢ</h3>

            <h4>Kích cỡ ống nội khí quản</h4>
            <p>Kích cỡ (hay đường kính [mm]) ống nội khí quản phù hợp giúp làm hạn chế sự tổn thương đường thở do ống nội khí quản gây ra, đảm bảo thông khí và tránh rò rỉ khí. Kích cỡ ống nội khí quản ở trẻ em thay đổi theo độ tuổi và được ước tính dựa vào các công thức sau:</p>
            <ul>
                <li>Kích cỡ ống nội khí quản không bóng chèn = (tuổi theo năm / 4) + 4</li>
                <li>Kích cỡ ống nội khí quản có bóng chèn = (tuổi theo năm / 4) + 3.5</li>
            </ul>
            <p>Theo kinh điển, ống nội khí quản có bóng chèn được ưu tiên cho trẻ > 8 tuổi và người lớn. Hiện nay, AHA khuyến cáo ưu tiên ống nội khí quản có bóng chèn (Cuff) cho mọi lứa tuổi.</p>

            <h4>Độ sâu của ống nội khí quản</h4>
            <ul>
                <li>Độ sâu được tính từ cung răng (răng cửa) hay khóe miệng.</li>
                <li>Độ sâu ống nội khí quản ước tính ở trẻ em (cm) = kích cỡ ống nội khí quản x 3.</li>
                <li>Ở người lớn, nam giới: 22 - 23 cm.</li>
                <li>Ở người lớn, nữ giới: 20 - 21 cm.</li>
                <li>Ở người lớn, trường hợp đặt nội khí quản qua đường mũi + thêm 3 đến 4 cm.</li>
            </ul>
        </div>

        <div class="calculation-box" id="formBox">
            <h2>Pediatric Endotracheal Tube (ETT) Size</h2>
            <form id="ettForm" onsubmit="calculateETT(); return false;">
                <label for="ageInput">Tuổi</label>
                <input type="number" id="ageInput" min="1" max="12" required placeholder="Nhập tuổi" />
                <small style="display: block; font-size: 10px; color: #6c757d; margin-top: -6px;">Input range: 1 - 12</small>
                <br />

                <button type="submit">Tính toán</button>
            </form>
        </div>

        <div class="result_container" id="resultBoxes" style="display: none;">
            <h2>ETT Size for a child of <span id="age"></span> years old</h2>
            <div class="box">
                <div class="box-header">Predicted Uncuffed Tube Size</div>
                <div class="box-content"><span id="ettWithoutCuff"></span></div>
            </div>
            <br />

            <div class="box">
                <div class="box-header">Predicted Cuffed Tube Size</div>
                <div class="box-content"><span id="ettWithCuff"></span></div>
            </div>
            <br />

            <div class="box">
                <div class="box-header">Predicted Depth Tube</div>
                <div class="box-content"><span id="ettDepth"></span></div>
            </div>
            <br />

            <button id="resetBtn" onclick="resetForm()">Nhập lại</button>
        </div>
    </div>
</div>
</body>
</html>
