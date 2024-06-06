<form method="GET" action="index.php">
    <input type="hidden" name="action" value="list">
    <label>Город: 
        <select name="city" onchange="this.form.submit()">
            <option value="">Все города</option>
            <option value="Москва" <?php echo (isset($_GET['city']) && $_GET['city'] == 'Москва') ? 'selected' : ''; ?>>Москва</option>
            <option value="Санкт-Петербург" <?php echo (isset($_GET['city']) && $_GET['city'] == 'Санкт-Петербург') ? 'selected' : ''; ?>>Санкт-Петербург</option>
            <option value="Тула" <?php echo (isset($_GET['city']) && $_GET['city'] == 'Тула') ? 'selected' : ''; ?>>Тула</option>
        </select>
    </label>
</form>

<form method="GET" action="index.php">
    <input type="hidden" name="action" value="export">
    <button type="submit">Экспорт в CSV</button>
</form>

<table>
    <thead>
        <tr>
            <th>ФИО</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Город</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($leads as $lead): ?>
        <tr>
            <td><?php echo htmlspecialchars($lead['name']); ?></td>
            <td><?php echo htmlspecialchars($lead['email']); ?></td>
            <td><?php echo htmlspecialchars($lead['phone']); ?></td>
            <td><?php echo htmlspecialchars($lead['city']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
