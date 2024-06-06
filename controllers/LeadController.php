<?php

require_once 'models/DB.php';
require_once 'models/Lead.php';
require_once 'helpers/CSRF.php';
require_once 'helpers/Throttle.php';

class LeadController {
    private $validCities = ['Москва', 'Санкт-Петербург', 'Тула'];

    public function showForm() {
        include 'views/header.php';
        include 'views/lead_form.php';
        include 'views/footer.php';
    }

    public function submitForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!CSRF::validateToken($_POST['csrf_token'])) {
                die('Invalid CSRF token');
            }
    
            if (Throttle::isBlocked($_SERVER['REMOTE_ADDR'])) {
                $errorMessage = 'Отправка формы заблокирована из-за слишком большого количества попыток. Пожалуйста, повторите попытку позже.';
                include 'views/header.php';
                include 'views/lead_form.php';
                include 'views/footer.php';
                return;
            }
    
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['email']));
            $phone = htmlspecialchars(trim($_POST['phone']));
            $city = htmlspecialchars(trim($_POST['city']));
    
            if ($this->isValidName($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && $this->isValidPhone($phone) && in_array($city, $this->validCities)) {
                Lead::create($name, $email, $phone, $city);
                Throttle::recordSubmission($_SERVER['REMOTE_ADDR']);
                header('Location: index.php?action=list');
                exit();
            } else {
                $errorMessage = 'Invalid input';
                include 'views/header.php';
                include 'views/lead_form.php';
                include 'views/footer.php';
            }
        }
    }

    private function isValidName($name) {
        return preg_match('/^[a-zA-Zа-яА-Я\s]+$/u', $name);
    }

    private function isValidPhone($phone) {
        return preg_match('/^\+?\d{10,15}$/', $phone);
    }

    public function listLeads() {
        $city = isset($_GET['city']) ? htmlspecialchars($_GET['city']) : null;
        $leads = $city ? Lead::getByCity($city) : Lead::getAll();
    
        include 'views/header.php';
        include 'views/lead_list.php';
        include 'views/footer.php';
    }
    

    public function exportCSV() {
        $leads = Lead::getAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="leads.csv"');
    
        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF"); 

        $delimiter = ";"; 
    
        fputcsv($output, ['Name', 'Email', 'Phone', 'City'], $delimiter);
    
        foreach ($leads as $lead) {
            fputcsv($output, [$lead['name'], $lead['email'], $lead['phone'], $lead['city']], $delimiter);
        }
        fclose($output);
    }
      
}
?>
