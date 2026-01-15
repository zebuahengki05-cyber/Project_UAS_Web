<?php
class Login extends Controller {
    public function index() {
        $this->view('login/index');
    }

    public function process() {
        // Ambil input dan hapus spasi yang tidak sengaja terketik
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $user = $this->model('User_model')->getUserByUsername($username);

        if ($user) {
            // LOGIC SEDERHANA: Cek apakah password di input SAMA PERSIS dengan di DB
            if ($password == $user['password']) {
                $_SESSION['user'] = $user;
                header('Location: ' . BASEURL . '/dashboard');
                exit;
            } else {
                echo "Password salah! Input: [$password], Di DB: [" . $user['password'] . "]";
            }
        } else {
            echo "Username tidak ditemukan!";
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/login');
        exit;
    }
}