<?php
include('session.php');
include('dbcon.php');
header('Content-Type: application/json');

$user_id = $_SESSION['id'];
$type = $_POST['type'] ?? '';
$item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
$emoji = $_POST['emoji'] ?? '';
$action = $_POST['action'] ?? '';

if (!$user_id || !$type || !$item_id || !$emoji || !in_array($type, ['post','reply']) || !in_array($action, ['add','remove'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

if ($action === 'add') {
    // Insert ignore duplicate
    $stmt = $conn->prepare("INSERT IGNORE INTO discussion_reaction (user_id, type, item_id, emoji) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssis', $user_id, $type, $item_id, $emoji);
    $stmt->execute();
} else if ($action === 'remove') {
    $stmt = $conn->prepare("DELETE FROM discussion_reaction WHERE user_id = ? AND type = ? AND item_id = ? AND emoji = ?");
    $stmt->bind_param('ssis', $user_id, $type, $item_id, $emoji);
    $stmt->execute();
}

// Get updated reaction counts for this item
$counts = [];
$user_reacted = [];
$res = $conn->query("SELECT emoji, COUNT(*) as cnt FROM discussion_reaction WHERE type='$type' AND item_id='$item_id' GROUP BY emoji");
while ($row = $res->fetch_assoc()) {
    $counts[$row['emoji']] = (int)$row['cnt'];
}
$res2 = $conn->query("SELECT emoji FROM discussion_reaction WHERE type='$type' AND item_id='$item_id' AND user_id='$user_id'");
while ($row = $res2->fetch_assoc()) {
    $user_reacted[] = $row['emoji'];
}

// Return all emojis used, their counts, and which the user has reacted with
$reactions = [];
foreach ($counts as $emj => $cnt) {
    $reactions[$emj] = [
        'count' => $cnt,
        'reacted' => in_array($emj, $user_reacted)
    ];
}
echo json_encode(['status' => 'success', 'reactions' => $reactions]); 