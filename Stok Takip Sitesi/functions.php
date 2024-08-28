<?php
function executeQuery($conn, $query, $params = [], $types = "") {
    $stmt = $conn->prepare($query);
    if ($stmt) {
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    } else {
        throw new Exception("Database query failed: " . $conn->error);
    }
}
?>
