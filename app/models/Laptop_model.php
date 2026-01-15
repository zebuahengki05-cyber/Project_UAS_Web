<?php

class Laptop_model {
    private $table = 'laptop';
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllLaptop($limit, $start) {
        $this->db->query("SELECT * FROM " . $this->table . " LIMIT :start, :limit");
        $this->db->bind('start', (int)$start, PDO::PARAM_INT);
        $this->db->bind('limit', (int)$limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }

    public function countLaptop() {
        $this->db->query("SELECT COUNT(*) as total FROM " . $this->table);
        return $this->db->single()['total'];
    }

    public function uploadGambar() {
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        if($error === 4) return 'default.jpg';

        $ekstensiValid = ['jpg', 'jpeg', 'png'];
        $ekstensi = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        if(!in_array($ekstensi, $ekstensiValid)) return false;
        if($ukuranFile > 2000000) return false;

        $namaFileBaru = uniqid() . '.' . $ekstensi;
        // Path mengarah ke folder public/img/laptop
        move_uploaded_file($tmpName, 'img/laptop/' . $namaFileBaru);

        return $namaFileBaru;
    }

    public function tambahDataLaptop($data) {
        $gambar = $this->uploadGambar();
        if(!$gambar) return 0;

        $query = "INSERT INTO laptop (nama, brand, harga, stok, deskripsi, gambar) 
                  VALUES (:nama, :brand, :harga, :stok, :deskripsi, :gambar)";
        
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('brand', $data['brand']);
        $this->db->bind('h', (int)$data['harga']);
        $this->db->bind('stok', $data['stok']);
        $this->db->bind('deskripsi', $data['deskripsi']);
        $this->db->bind('gambar', $gambar);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function ubahDataLaptop($data) {
        $gambarLama = $data['gambarLama'];
        
        if($_FILES['gambar']['error'] === 4) {
            $gambar = $gambarLama;
        } else {
            $gambar = $this->uploadGambar();
        }

        $query = "UPDATE laptop SET nama=:n, brand=:b, harga=:h, stok=:s, deskripsi=:d, gambar=:g WHERE id=:id";
        
        $this->db->query($query);
        $this->db->bind('n', $data['nama']);
        $this->db->bind('b', $data['brand']);
        $this->db->bind('h', $data['harga']);
        $this->db->bind('s', $data['stok']);
        $this->db->bind('d', $data['deskripsi']);
        $this->db->bind('g', $gambar);
        $this->db->bind('id', $data['id']);

        $this->db->execute();
        return $this->db->rowCount();
    }

    public function searchLaptop($keyword) {
        $this->db->query("SELECT * FROM " . $this->table . " WHERE nama LIKE :k OR brand LIKE :k");
        $this->db->bind('k', "%$keyword%");
        return $this->db->resultSet();
    }

    public function hapusDataLaptop($id) {
        $this->db->query("DELETE FROM " . $this->table . " WHERE id = :id");
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}