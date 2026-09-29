<?php
include_once("../connect.php");

if (isset($_POST['Them'])) {
    $theloai = trim($_POST['TenTL']);
    $thutu = (int)$_POST['ThuTu'];
    $an = (int)$_POST['AnHien'];
    $icon = "";

    if (!empty($_FILES['image']['name'])) {
        $icon = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../image/" . $icon);
    }

    $stmt = mysqli_prepare($connect,
        "INSERT INTO theloai (TenTL, ThuTu, AnHien, icon) VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "siis", $theloai, $thutu, $an, $icon);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Thêm thành công'); location.href='theloai.php';</script>";
        exit;
    } else {
        echo "Lỗi: " . mysqli_error($connect);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="utf-8"><title>Thêm thể loại</title></head>
<body>
<h2>THÊM THỂ LOẠI</h2>
<form method="post" enctype="multipart/form-data">
<table>
<tr><td>Tên thể loại</td><td><input type="text" name="TenTL" required></td></tr>
<tr><td>Thứ tự</td><td><input type="number" name="ThuTu" required></td></tr>
<tr><td>Ẩn hiện</td><td>
<select name="AnHien">
<option value="0">Ẩn</option>
<option value="1">Hiện</option>
</select>
</td></tr>
<tr><td>Icon</td><td><input type="file" name="image"></td></tr>
<tr><td><input type="submit" name="Them" value="Thêm"></td>
<td><input type="reset" value="Hủy"></td></tr>
</table>
</form>
<a href="theloai.php">Quay lại</a>
</body>
</html>
