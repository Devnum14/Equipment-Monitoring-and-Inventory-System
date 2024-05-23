<?php

if (!empty($_SESSION["name"])) {

} else {
    header('Location: ../../index');
    exit();
}

?>

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/all.css">
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-solid.css">
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-regular.css">
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.2/css/sharp-light.css">

<title>InSport UMDC</title>

<aside class="sidebar" id="sidebar" style="height: 94vh;">
    <div class="h-100">
        <div class="sidebar-logo">
            <div class="">
                <img src="../../assets/img/logo.png" style="width: 50px; border-radius: 100%;" alt="logo">
                <label for="" class="fw-bold text-white mx-2">InSport UMDC</label>
            </div>
            </div>
<!-- Sidebar Navigation -->
<ul class="sidebar-nav px-1 text-white">
    <li class="sidebar-item">
        <a href="dashboard" class="sidebar-link text-white">
            <i class="fa-solid fa-grid-2 fa-lg"></i>
            Dashboard
        </a>

        <li class="sidebar-item">
        <a href="equipmentlist" class="sidebar-link text-white">
            <i class="fa-sharp fa-solid fa-list"></i>
            Equipment List
        </a>
    </li>    
    </li>
    
    <li class="sidebar-item">
        <a href="equipments" class="sidebar-link text-white">
            <i class="fa-sharp fa-solid fa-money-bills-simple"></i>
            Borrow Section
        </a>
    </li>
    <li class="sidebar-item">
        <a href="borrowed" class="sidebar-link text-white">
            <i class="fa-sharp fa-solid fa-address-book"></i>
            Borrowed Equipment
        </a>
    </li>
    <li class="sidebar-item">
        <a href="history.php" class="sidebar-link text-white">
            <i class="fa-sharp fa-solid fa-address-book"></i>
            History
        </a>
    </li>
    <!-- New Sidebar Item --><hr style="color: white; border: 1px solid white; margin-left: 10px; margin-right: 10px;">
    <li class="sidebar-item">
        <a href="logout.php" class="sidebar-link text-white">
            <i class="fa-sharp fa-solid fa-arrow-right-from-bracket"></i>
            Logout
        </a>
    </li>
</ul>
</div>

</aside>