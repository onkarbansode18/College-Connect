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

if ($_SERVER["REQUEST_METHOD"] == "POST") {     
    if (isset($_POST['action']) && $_POST['action'] == 'submit_query' && $role === 'students') {         
        $query = $_POST['query'];          
        $sql = "INSERT INTO queries (student_id, query) VALUES ($user_id, '$query')";         
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert success'>Query submitted successfully.</div>";
        } else {
            echo "<div class='alert error'>Error submitting query: " . $conn->error . "</div>";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'respond_query' && ($role === 'crs' || $role === 'faculty')) {         
        $query_id = $_POST['query_id'];         
        $response = $_POST['response'];          
        $sql = "UPDATE queries SET response = '$response' WHERE id = $query_id";         
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert success'>Response submitted successfully.</div>";
        } else {
            echo "<div class='alert error'>Error submitting response: " . $conn->error . "</div>";
        }
    } 
}  
?>  

<style>
    .query-form, .query-item {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .query-form textarea {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-family: 'Roboto', sans-serif;
        margin: 10px 0 20px;
        resize: vertical;
        transition: border 0.3s ease;
    }
    
    .query-form textarea:focus {
        border-color: var(--accent-color);
        outline: none;
    }
    
    .query-form button, .response-form button {
        background-color: var(--accent-color);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .query-form button:hover, .response-form button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    
    .queries-list {
        list-style-type: none;
        padding: 0;
    }
    
    .queries-list li {
        background-color: white;
        border-left: 4px solid var(--accent-color);
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }
    
    .query-content, .response-content {
        margin-bottom: 15px;
        line-height: 1.6;
        padding: 10px;
        background-color: #f9f9f9;
        border-radius: 5px;
    }
    
    .query-meta {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid #eee;
        font-size: 0.9rem;
        color: #777;
    }
    
    .response-form {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }
    
    .response-form textarea {
        width: 100%;
        padding: 12px;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin: 10px 0 15px;
        resize: vertical;
    }
    
    .response-form textarea:focus {
        border-color: var(--accent-color);
        outline: none;
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
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-answered {
        background-color: #d4edda;
        color: #155724;
    }
    
    .student-info {
        font-weight: 500;
        color: var(--primary-color);
        margin-bottom: 10px;
    }
</style>

<h2 class="section-title">Queries</h2>  

<?php if ($role === 'students'): ?>
    <div class="query-form">
        <h3 class="section-title">Submit a Query</h3>
        <form method="POST">
            <label for="query-text"><strong>Your Question:</strong></label><br>
            <textarea id="query-text" name="query" rows="4" required placeholder="Type your question here..."></textarea><br>
            <input type="hidden" name="action" value="submit_query">
            <button type="submit">Submit Query</button>
        </form>
    </div>
    
    <h3 class="section-title">Your Queries</h3>
    <?php
    $sql = "SELECT q.id, q.query, q.response, q.created_at
            FROM queries q
            WHERE q.student_id = $user_id
            ORDER BY q.id DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0): ?>
        <ul class="queries-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <div class="query-content">
                        <strong>Question:</strong><br>
                        <?php echo nl2br(htmlspecialchars($row['query'])); ?>
                    </div>
                    
                    <?php if (!empty($row['response'])): ?>
                        <div class="response-content">
                            <strong>Response:</strong><br>
                            <?php echo nl2br(htmlspecialchars($row['response'])); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="query-meta">
                        <div>
                            <strong>Submitted:</strong> <?php echo htmlspecialchars($row['created_at']); ?>
                        </div>
                        <div>
                            <?php if (!empty($row['response'])): ?>
                                <span class="status-badge status-answered">Answered</span>
                            <?php else: ?>
                                <span class="status-badge status-pending">Pending</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="empty-state">
            <p>You haven't submitted any queries yet. Use the form above to ask a question.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>  

<?php if ($role === 'crs' || $role === 'faculty'): ?>
    <h3 class="section-title">Pending Queries</h3>
    <?php
    $sql = "SELECT q.id, s.name AS student_name, q.query, q.response, q.created_at
            FROM queries q
            JOIN students s ON q.student_id = s.id
            WHERE q.response IS NULL
            ORDER BY q.id DESC";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0): ?>
        <ul class="queries-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <div class="student-info">
                        <strong>From:</strong> <?php echo htmlspecialchars($row['student_name']); ?>
                        <span style="float: right; color: #777; font-size: 0.9rem;">
                            <strong>Date:</strong> <?php echo htmlspecialchars($row['created_at']); ?>
                        </span>
                    </div>
                    
                    <div class="query-content">
                        <strong>Question:</strong><br>
                        <?php echo nl2br(htmlspecialchars($row['query'])); ?>
                    </div>
                    
                    <div class="response-form">
                        <form method="POST">
                            <label for="response-text-<?php echo $row['id']; ?>"><strong>Your Response:</strong></label><br>
                            <textarea id="response-text-<?php echo $row['id']; ?>" name="response" rows="4" required placeholder="Type your response here..."><?php echo htmlspecialchars($row['response'] ?? ''); ?></textarea><br>
                            <input type="hidden" name="action" value="respond_query">
                            <input type="hidden" name="query_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Submit Response</button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="empty-state">
            <p>No pending queries to respond to.</p>
        </div>
    <?php endif; ?>
    
    <h3 class="section-title">Answered Queries</h3>
    <?php
    $sql = "SELECT q.id, s.name AS student_name, q.query, q.response, q.created_at
            FROM queries q
            JOIN students s ON q.student_id = s.id
            WHERE q.response IS NOT NULL
            ORDER BY q.id DESC
            LIMIT 10";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0): ?>
        <ul class="queries-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <div class="student-info">
                        <strong>From:</strong> <?php echo htmlspecialchars($row['student_name']); ?>
                        <span style="float: right; color: #777; font-size: 0.9rem;">
                            <strong>Date:</strong> <?php echo htmlspecialchars($row['created_at']); ?>
                        </span>
                    </div>
                    
                    <div class="query-content">
                        <strong>Question:</strong><br>
                        <?php echo nl2br(htmlspecialchars($row['query'])); ?>
                    </div>
                    
                    <div class="response-content">
                        <strong>Your Response:</strong><br>
                        <?php echo nl2br(htmlspecialchars($row['response'])); ?>
                    </div>
                    
                    <div class="response-form">
                        <form method="POST">
                            <label for="response-text-<?php echo $row['id']; ?>"><strong>Update Response:</strong></label><br>
                            <textarea id="response-text-<?php echo $row['id']; ?>" name="response" rows="4" required><?php echo htmlspecialchars($row['response']); ?></textarea><br>
                            <input type="hidden" name="action" value="respond_query">
                            <input type="hidden" name="query_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Update Response</button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <div class="empty-state">
            <p>No answered queries to display.</p>
        </div>
    <?php endif; ?>
<?php endif; ?>  

<?php $conn->close(); ?>