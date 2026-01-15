<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPTOP PRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        .card-laptop { transition: 0.3s; border-radius: 15px; overflow: hidden; }
        .card-laptop:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="<?= BASEURL; ?>/dashboard">LAPTOP PRO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="<?= BASEURL; ?>/dashboard">Home</a>
        </li>
        <li class="nav-item">
          <span class="nav-link text-white fw-bold">| Role: <?= $_SESSION['user']['role']; ?></span>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-danger btn-sm text-white ms-lg-2" href="<?= BASEURL; ?>/login/logout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">