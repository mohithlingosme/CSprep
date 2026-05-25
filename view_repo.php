<!DOCTYPE html>
<html>
<head>
    <title>CS & Law Repo</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <nav>
        <button onclick="filter('Law')">Law</button>
        <button onclick="filter('Business')">Business</button>
    </nav>

    <div class="container">
        <?php foreach ($provisions as $row): ?>
            <div class="card" id="card-<?php echo $row['id']; ?>">
                <h2><?php echo $row['statute_name']; ?> - <?php echo $row['section_number']; ?></h2>
                <div class="content">
                    <p><strong>Bare Provision:</strong> <?php echo $row['statutory_text']; ?></p>
                    <button onclick="toggleDetails(<?php echo $row['id']; ?>)">View Full Matrix</button>
                    <div class="hidden-details" id="details-<?php echo $row['id']; ?>">
                        <p><strong>Judicial Interpretation:</strong> <?php echo $row['landmark_cases']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        function toggleDetails(id) {
            document.getElementById('details-' + id).classList.toggle('hidden-details');
        }
    </script>
</body>
</html>