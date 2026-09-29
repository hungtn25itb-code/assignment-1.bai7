<?php
include_once("../connect.php");

if (!isset($_GET['idTL'])) {
    die("Không có idTL.");
}

$idTL = (int)$_GET['idTL'];

$stmt = mysqli_prepare($connect, "SELECT * FROM theloai WHERE idTL = ?");
mysqli_stmt_bind_param($stmt, "i", $idTL);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$d = mysqli_fetch_assoc($result);

if (!$d) {
    die("Không tìm thấy thể loại.");
}

if (isset($_POST['Sua'])) {
    $theloai = trim($_POST['TenTL']);
    $thutu = (int)$_POST['ThuTu'];
    $an = (int)$_POST['AnHien'];
    $icon = $_POST['ten_anh'];

    if (!empty($_FILES['image']['name'])) {
        $icon = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../image/" . $icon);

        if (!empty($_POST['ten_anh'])) {
            $old = "../image/" . basename($_POST['ten_anh']);
            if (file_exists($old)) {
                unlink($old);
            }
        }
    }

    $stmt = mysqli_prepare($connect,
        "UPDATE theloai SET TenTL=?, ThuTu=?, AnHien=?, icon=? WHERE idTL=?"
    );
    mysqli_stmt_bind_param($stmt, "siisi", $theloai, $thutu, $an, $icon, $idTL);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Sửa thành công'); location.href='theloai.php';</script>";
        exit;
    } else {
        echo "Lỗi: " . mysqli_error($connect);
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="utf-8"><title>Sửa thể loại</title></head>
<body>
<h2>SỬA THỂ LOẠI</h2>
<form method="post" enctype="multipart/form-data">
<table>
<tr><td>Tên thể loại</td>
<td><input type="text" name="TenTL" value="<?php echo htmlspecialchars($d['TenTL']); ?>" required></td></tr>
<tr><td>Thứ tự</td>
<td><input type="number" name="ThuTu" value="<?php echo $d['ThuTu']; ?>" required></td></tr>
<tr><td>Ẩn hiện</td><td>
<select name="AnHien">
<option value="0" <?php if($d['AnHien']==0) echo "selected"; ?>>Ẩn</option>
<option value="1" <?php if($d['AnHien']==1) echo "selected"; ?>>Hiện</option>
</select>
</td></tr>
<tr><td>Icon hiện tại</td><td>
<?php if (!empty($d['icon'])) { ?>
<img src="../image/<?php echo htmlspecialchars($d['icon']); ?>" width="40" height="40">
<?php } ?>
</td></tr>
<tr><td>Chọn icon mới</td><td>
<input type="file" name="image">
<input type="hidden" name="ten_anh" value="<?php echo htmlspecialchars($d['icon']); ?>">
</td></tr>
<tr><td><input type="submit" name="Sua" value="Sửa"></td>
<td><input type="reset" value="Hủy"></td></tr>
</table>
</form>
<a href="theloai.php">Quay lại</a>
</body>
</html>
