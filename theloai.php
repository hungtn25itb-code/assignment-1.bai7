<?php
include_once("../connect.php");

$sql = "SELECT * FROM theloai ORDER BY ThuTu ASC";
$results = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="utf-8">
<title>Quản lý thể loại</title>
<style>
body { font-family: Arial; }
table { border-collapse: collapse; margin: 30px auto; width: 700px; }
th, td { border: 1px solid #333; padding: 8px; text-align: center; }
th { background: #eee; }
a { text-decoration: none; margin: 0 4px; }
</style>
</head>
<body>
<table>
<tr>
    <th>Tên thể loại</th>
    <th>Thứ tự</th>
    <th>Ẩn/Hiện</th>
    <th>Biểu tượng</th>
    <th colspan="2"><a href="theloai_them.php">Thêm</a></th>
</tr>

<?php while ($rows = mysqli_fetch_assoc($results)) { ?>
<tr>
    <td><?php echo htmlspecialchars($rows['TenTL']); ?></td>
    <td><?php echo $rows['ThuTu']; ?></td>
    <td><?php echo ($rows['AnHien'] == 1) ? "Hiện" : "Ẩn"; ?></td>
    <td>
        <?php if (!empty($rows['icon'])) { ?>
            <img src="../image/<?php echo htmlspecialchars($rows['icon']); ?>"
                 width="40" height="40" alt="">
        <?php } ?>
    </td>
    <td>
        <a href="theloai_sua.php?idTL=<?php echo $rows['idTL']; ?>">Sửa</a>
    </td>
    <td>
        <a href="theloai_xoa.php?idTL=<?php echo $rows['idTL']; ?>"
           onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</a>
    </td>
</tr>
<?php } ?>

</table>
</body>
</html>
<?php mysqli_close($connect); ?>
