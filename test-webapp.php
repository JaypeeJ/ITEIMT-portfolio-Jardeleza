<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "birthday_wishnote";

$conn = new mysqli($servername, $username, $password, $dbname);

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName   = trim($_POST['FirstName'] ?? '');
    $lastName    = trim($_POST['LastName'] ?? '');
    $govPosition = trim($_POST['GovPosition'] ?? '');
    $location    = trim($_POST['Location'] ?? '');

    // INTENTIONAL FLAW DEMONSTRATION:
    // The Location field is captured from POST, but intentionally omitted in the SQL string and bind_param.
    $stmt = $conn->prepare("INSERT INTO main_corrupt_politicians (FirstName, LastName, GovPosition) VALUES (?, ?, ?)");

    if ($stmt) {
        $stmt->bind_param("sss", $firstName, $lastName, $govPosition);
        if ($stmt->execute()) {
            $message = "Success! The wish note has been sent.";
            $messageType = "success";
        } else {
            $message = "Error executing query: " . $stmt->error;
            $messageType = "error";
        }
        $stmt->close();
    } else {
        $message = "Failed to prepare database statement.";
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kara David's Wish Note</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f6f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .card { background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); width: 100%; max-width: 480px; }
        h2 { color: #1e3a8a; margin-bottom: 20px; text-align: center; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; font-weight: 600; text-align: center; }
        .alert-success { background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .alert-error { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 6px; font-weight: 600; color: #334155; }
        input[type="text"] { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 14px; }
        input[type="text"]:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2); }
        .btn-submit { width: 100%; padding: 12px; background-color: #2563eb; color: #ffffff; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        .btn-submit:hover { background-color: #1d4ed8; }
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; z-index: 1000; }
        .modal-content { background: #fff; padding: 25px; border-radius: 8px; width: 90%; max-width: 400px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .modal-content h3 { margin-bottom: 15px; color: #1e3a8a; }
        .modal-detail { margin-bottom: 8px; font-size: 14px; color: #475569; }
        .modal-detail strong { color: #1e293b; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-cancel { background-color: #64748b; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
        .btn-cancel:hover { background-color: #475569; }
        .btn-confirm { background-color: #16a34a; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; }
        .btn-confirm:hover { background-color: #15803d; }
    </style>
</head>
<body>

<div class="card">
    <h2>Kara David's Wish Note</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form id="wishnoteForm" method="POST" action="">
        <div class="form-group">
            <label for="FirstName">Target's First Name *</label>
            <input type="text" id="FirstName" name="FirstName" maxlength="30" required>
        </div>
        <div class="form-group">
            <label for="LastName">Target's Last Name *</label>
            <input type="text" id="LastName" name="LastName" maxlength="30" required>
        </div>
        <div class="form-group">
            <label for="GovPosition">Target's Government Position *</label>
            <input type="text" id="GovPosition" name="GovPosition" maxlength="20" required>
        </div>
        <div class="form-group">
            <label for="Location">Target's Location</label>
            <input type="text" id="Location" name="Location" maxlength="40">
        </div>
        <button type="submit" class="btn-submit">Send Wish Note</button>
    </form>
</div>

<div class="modal-overlay" id="verifyModal">
    <div class="modal-content">
        <h3>Verify Target Data</h3>
        <div class="modal-detail"><strong>First Name:</strong> <span id="modalFirstName"></span></div>
        <div class="modal-detail"><strong>Last Name:</strong> <span id="modalLastName"></span></div>
        <div class="modal-detail"><strong>Position:</strong> <span id="modalGovPosition"></span></div>
        <div class="modal-detail"><strong>Location:</strong> <span id="modalLocation"></span></div>
        <div class="modal-actions">
            <button class="btn-cancel" id="btnCancel">Cancel</button>
            <button class="btn-confirm" id="btnConfirm">Confirm & Send</button>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('wishnoteForm');
    const modal = document.getElementById('verifyModal');
    const btnCancel = document.getElementById('btnCancel');
    const btnConfirm = document.getElementById('btnConfirm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('modalFirstName').textContent = document.getElementById('FirstName').value;
        document.getElementById('modalLastName').textContent = document.getElementById('LastName').value;
        document.getElementById('modalGovPosition').textContent = document.getElementById('GovPosition').value;
        document.getElementById('modalLocation').textContent = document.getElementById('Location').value || '(None)';
        modal.style.display = 'flex';
    });

    btnCancel.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    btnConfirm.addEventListener('click', function() {
        modal.style.display = 'none';
        form.submit();
    });
</script>

</body>
</html>