<?php
$servername = "localhost:3308";
$username = "root";
$password = "";
$dbname = "college_web_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['study_material']) && $role === 'faculty') {
    // Handle file upload
    $target_dir = "uploads/study_materials/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["study_material"]["name"]);
    $subject_name = $_POST['subject_name'];
    $uploaded_by = $user_id;

    // Get file extension
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["study_material"]["tmp_name"], $target_file)) {
        // Insert record into study_material table
        $sql = "INSERT INTO study_material (subject_name, file_path, uploaded_at, uploaded_by)
                VALUES ('$subject_name', '$target_file', NOW(), $uploaded_by)";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert success'>Study material uploaded successfully.</div>";
        } else {
            echo "<div class='alert error'>Error: " . $sql . "<br>" . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert error'>Sorry, there was an error uploading your file.</div>";
    }
}
?>

<style>
    .material-form {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    .material-form input[type="text"],
    .material-form textarea {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-family: 'Roboto', sans-serif;
        margin: 10px 0 20px;
        transition: border 0.3s ease;
    }
    .material-form input[type="file"] {
        width: 100%;
        padding: 12px;
        margin: 10px 0 20px;
    }
    .material-form input[type="text"]:focus,
    .material-form textarea:focus {
        border-color: var(--accent-color);
        outline: none;
    }
    .material-form textarea {
        resize: vertical;
    }
    .material-form button {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .material-form button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    .materials-list {
        list-style-type: none;
        padding: 0;
    }
    .materials-list li {
        background-color: white;
        border-left: 4px solid var(--accent-color);
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    .material-meta {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
        font-size: 0.9rem;
        color: #777;
    }
    .material-content {
        margin-bottom: 15px;
        line-height: 1.6;
    }
    .material-description {
        color: #555;
        margin: 10px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
        line-height: 1.5;
    }
    .download-btn {
        display: inline-block;
        background-color: var(--accent-color);
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .download-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }
    .file-icon {
        margin-right: 5px;
    }
    .section-title {
        color: var(--primary-color);
        margin: 30px 0 20px;
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: var(--accent-color);
    }
    .alert {
        padding: 12px 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-weight: 500;
    }
    .success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
    .error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    .empty-state {
        text-align: center;
        padding: 30px;
        color: #777;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    .subject-badge {
        display: inline-block;
        background-color: var(--primary-color);
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    .filter-section {
        background-color: white;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    .filter-section select {
        padding: 8px 12px;
        border-radius: 4px;
        border: 1px solid #ddd;
        margin-right: 10px;
    }
    .filter-section button {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<h2 class="section-title">Study Material</h2>

<?php if ($role === 'faculty'): ?>
    <div class="material-form">
        <h3 class="section-title">Upload Study Material</h3>
        <form method="POST" enctype="multipart/form-data">
            <label for="subject-name"><strong>Subject Name:</strong></label><br>
            <input type="text" id="subject-name" name="subject_name" required placeholder="e.g., Mathematics, Physics, Computer Science, etc."><br>
            <label for="study-material"><strong>Upload File:</strong></label><br>
            <input type="file" id="study-material" name="study_material" required><br>
            <small style="color: #777;">Supported file types: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP</small><br><br>
            <button type="submit">Upload Material</button>
        </form>
    </div>

    <h3 class="section-title">Your Uploaded Materials</h3>
    <?php
    $sql = "SELECT sm.id, sm.subject_name, sm.file_path, sm.uploaded_at
            FROM study_material sm
            WHERE sm.uploaded_by = $user_id
            ORDER BY sm.uploaded_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <ul class="materials-list">
            <?php while ($row = $result->fetch_assoc()):
                $file_extension = strtolower(pathinfo($row['file_path'], PATHINFO_EXTENSION));
                $file_icon = '';

                // Determine file type icon
                if (in_array($file_extension, ['pdf'])) {
                    $file_icon = '📄'; // PDF
                } elseif (in_array($file_extension, ['doc', 'docx'])) {
                    $file_icon = '📝'; // Word
                } elseif (in_array($file_extension, ['ppt', 'pptx'])) {
                    $file_icon = '📊'; // PowerPoint
                } elseif (in_array($file_extension, ['xls', 'xlsx'])) {
                    $file_icon = '📈'; // Excel
                } elseif (in_array($file_extension, ['zip', 'rar'])) {
                    $file_icon = '📦'; // Archive
                } else {
                    $file_icon = '📎'; // Other
                }
            ?>
                <li>
                    <span class="subject-badge"><?php echo htmlspecialchars($row['subject_name']); ?></span>
                    <div class="material-meta">
                        <div>
                            <strong>Uploaded:</strong> <?php echo htmlspecialchars($row['uploaded_at']); ?>
                        </div>
                        <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="download-btn" target="_blank">
                            <span class="file-icon"><?php echo $file_icon; ?></span> Download
                        </a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="empty-state">
            <p>You haven't uploaded any study materials yet.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if ($role === 'students' || $role === 'crs'): ?>
    <div class="filter-section">
        <form method="GET" style="display: flex; align-items: center;">
            <label for="subject-filter" style="margin-right: 10px;"><strong>Filter by Subject:</strong></label>
            <select id="subject-filter" name="subject">
                <option value="">All Subjects</option>
                <?php
                $sql_subjects = "SELECT DISTINCT subject_name FROM study_material ORDER BY subject_name";
                $result_subjects = $conn->query($sql_subjects);
                while ($subject = $result_subjects->fetch_assoc()) {
                    $selected = (isset($_GET['subject']) && $_GET['subject'] == $subject['subject_name']) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($subject['subject_name']) . "' $selected>" .
                         htmlspecialchars($subject['subject_name']) . "</option>";
                }
                ?>
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>

    <h3 class="section-title">Available Study Materials</h3>
    <?php
    $subject_filter = isset($_GET['subject']) && !empty($_GET['subject']) ?
        "WHERE subject_name = '" . $conn->real_escape_string($_GET['subject']) . "'" : "";

    $sql = "SELECT sm.id, sm.subject_name, sm.file_path, sm.uploaded_at, f.name as faculty_name
            FROM study_material sm
            LEFT JOIN faculty f ON sm.uploaded_by = f.id
            $subject_filter
            ORDER BY sm.uploaded_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <ul class="materials-list">
            <?php while ($row = $result->fetch_assoc()):
                $file_extension = strtolower(pathinfo($row['file_path'], PATHINFO_EXTENSION));
                $file_icon = '';

                // Determine file type icon
                if (in_array($file_extension, ['pdf'])) {
                    $file_icon = '📄'; // PDF
                } elseif (in_array($file_extension, ['doc', 'docx'])) {
                    $file_icon = '📝'; // Word
                } elseif (in_array($file_extension, ['ppt', 'pptx'])) {
                    $file_icon = '📊'; // PowerPoint
                } elseif (in_array($file_extension, ['xls', 'xlsx'])) {
                    $file_icon = '📈'; // Excel
                } elseif (in_array($file_extension, ['zip', 'rar'])) {
                    $file_icon = '📦'; // Archive
                } else {
                    $file_icon = '📎'; // Other
                }
            ?>
                <li>
                    <span class="subject-badge"><?php echo htmlspecialchars($row['subject_name']); ?></span>
                    <div class="material-meta">
                        <div>
                            <strong>Uploaded by:</strong> <?php echo htmlspecialchars($row['faculty_name']); ?><br>
                            <strong>Date:</strong> <?php echo htmlspecialchars($row['uploaded_at']); ?>
                        </div>
                        <a href="<?php echo htmlspecialchars($row['file_path']); ?>" class="download-btn" target="_blank">
                            <span class="file-icon"><?php echo $file_icon; ?></span> Download
                        </a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="empty-state">
            <p>No study materials available<?php echo isset($_GET['subject']) && !empty($_GET['subject']) ? ' for ' . htmlspecialchars($_GET['subject']) : ''; ?>.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $conn->close(); ?>
