<?php CSRF::setToken(); ?>
<form method="POST" action="index.php?action=submit">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    
    <?php if (isset($errorMessage)): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    
    <label>ФИО: <input type="text" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"placeholder="Имя" required></label><br>
    <label>Email: <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"placeholder="gmail@gmail.com" required></label><br>
    <label>Телефон: <input type="text" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"placeholder="+78008008080" required></label><br>
    <label>Город: 
        <select name="city" required>
            <option value="Москва" <?php echo (isset($_POST['city']) && $_POST['city'] == 'Москва') ? 'selected' : ''; ?>>Москва</option>
            <option value="Санкт-Петербург" <?php echo (isset($_POST['city']) && $_POST['city'] == 'Санкт-Петербург') ? 'selected' : ''; ?>>Санкт-Петербург</option>
            <option value="Тула" <?php echo (isset($_POST['city']) && $_POST['city'] == 'Тула') ? 'selected' : ''; ?>>Тула</option>
        </select>
    </label><br>
    <button type="submit">Отправить</button>
</form>
