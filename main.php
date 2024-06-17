<?php include "config.php" ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}else{
    echo "No Link found";
    exit();
}
$selecting = $connection->prepare("SELECT * FROM urls WHERE id='$id'");
$selecting->execute();

$data = $selecting->fetch(PDO::FETCH_OBJ);
if ($data) {
    $clicks = $data->clicks + 1;
    $update = $connection->prepare("UPDATE urls SET clicks = :ck WHERE id = :i");
    $stats = [
        ":ck" => $clicks,
        ":i" => $id,
    ];
    $update->execute($stats);
    header("Location: " . $data->links);
    exit();
} else {
    echo "Link not found.";
}
?>