<?php

class Dashboard extends Controller {
    public function index($page = 1) {
        if(!isset($_SESSION['user'])) header('Location: ' . BASEURL . '/login');

        $limit = 6;
        $page = (int)$page;
        if($page <= 0) $page = 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;
        
        $data['laptop'] = $this->model('Laptop_model')->getAllLaptop($limit, $start);
        $total = $this->model('Laptop_model')->countLaptop();
        $data['pages'] = ceil($total / $limit);
        $data['curr_page'] = $page;

        $this->view('templates/header');
        $this->view('dashboard/index', $data);
        $this->view('templates/footer');
    }

    public function cari() {
        $keyword = $_POST['keyword'] ?? '';
        $data['laptop'] = $this->model('Laptop_model')->searchLaptop($keyword);
        $data['pages'] = 1;
        $data['curr_page'] = 1;

        $this->view('templates/header');
        $this->view('dashboard/index', $data);
        $this->view('templates/footer');
    }

    public function tambah() {
        if($_SESSION['user']['role'] != 'admin') header('Location: ' . BASEURL . '/dashboard');
        
        if($this->model('Laptop_model')->tambahDataLaptop($_POST) > 0) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }

    public function ubah() {
        if($_SESSION['user']['role'] != 'admin') header('Location: ' . BASEURL . '/dashboard');

        if($this->model('Laptop_model')->ubahDataLaptop($_POST) > 0) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        } else {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }

    public function hapus($id) {
        if($_SESSION['user']['role'] != 'admin') header('Location: ' . BASEURL . '/dashboard');

        if($this->model('Laptop_model')->hapusDataLaptop($id) > 0) {
            header('Location: ' . BASEURL . '/dashboard');
            exit;
        }
    }
}