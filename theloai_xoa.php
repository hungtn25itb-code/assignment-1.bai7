<?php
include_once("../connect.php");

if (!isset($_GET['idTL'])) {
    die("Không có idTL.");
}

$idTL = (int)$_GET['idTL'];

$stmt = mysqli_prepare($connect, "DELETE FROM theloai WHERE idTL = ?");
mysqli_stmt_bind_param($stmt, "i", $idTL);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Xóa thành công'); location.href='theloai.php';</script>";
} else {
    echo "Lỗi: " . mysqli_error($connect);
}
?>
