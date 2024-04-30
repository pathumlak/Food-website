<?php
include 'connection.php';

$sql = "SELECT name, COUNT(*) as count FROM orders GROUP BY name";
$result = $conn->query($sql);

$labels = [];
$values = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $labels[] = $row['name'];
        $values[] = $row['count'];
    }
}

echo json_encode(['labels' => $labels, 'values' => $values]);

$conn->close();
?>
