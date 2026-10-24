<h2><?= $page_title ?></h2>
<p>Complete all fields below.</p>
<?php if ($error !== ''): ?>
    <p class="error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<form method="post" class="student-form">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8') ?>">
    <label for="student_number">Student Number</label>
    <input type="text" id="student_number" name="student_number" maxlength="30" value="<?= htmlspecialchars($student_number, ENT_QUOTES, 'UTF-8') ?>" required>
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name" maxlength="80" value="<?= htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8') ?>" required>
    <label for="last_name">Last Name</label>
    <input type="text" id="last_name" name="last_name" maxlength="80" value="<?= htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8') ?>" required>
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" maxlength="120" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" required>
    <label for="course">Course</label>
    <input type="text" id="course" name="course" maxlength="120" value="<?= htmlspecialchars($course, ENT_QUOTES, 'UTF-8') ?>" required>
    <label for="year_level">Year Level</label>
    <select id="year_level" name="year_level" required>
        <option value="">Select year level</option>
        <?php for ($year = 1; $year <= 6; $year++): ?>
            <option value="<?= $year ?>" <?= (string) $year_level === (string) $year ? 'selected' : '' ?>>Year <?= $year ?></option>
        <?php endfor; ?>
    </select>
    <div class="form-buttons">
        <button type="submit"><?= $button_text ?></button>
        <a href="index.php">Cancel</a>
    </div>
</form>
