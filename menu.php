<style>
    @font-face{
        font-family: NotoSansLao;
        src: url(fonts/NotoSansLaoUI-Regular.ttf);
    }

    nav{
        font-family: NotoSansLao;
        background: rgba(0, 0, 0, 0.7);
    }
    .dropdown:hover>.dropdown-menu{
        display: block;
    }
    .nav-link:hover{
        background: rgba(0, 0, 0, 0.7);
        border-radius: 6px;
    }

</style>

<nav class="navbar navbar-expand-md navbar-dark sticky-top">
    <!-- Brand -->
    <a class="navbar-brand" href="#"><i>HR <span style="color: gold">Management</span></i></a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> ໜ້າຫຼັກ</a>
            </li>

            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    <i class="fas fa-database"></i> ຈັດການຂໍ້ມູນ
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="emp-manage.php">ຈັດການຂໍ້ມູນພະນັກງານ</a>
                    <a class="dropdown-item" href="#">ຈັດການຂໍ້ມູນພະແນກ</a>
                    <a class="dropdown-item" href="#">ຈັດການຂໍ້ມູນຂັ້ນເງິນເດືອນ</a>
                </div>
            </li>

            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    <i class="fas fa-file-alt"></i> ລາຍງານ
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="emp-report.php">ລາຍງານຂໍ້ມູນພະນັກງານ</a>
                    <a class="dropdown-item" href="#">ລາຍງານຂໍ້ມູນພະແນກ</a>
                    <a class="dropdown-item" href="#">ລາຍງານຂໍ້ມູນຂັ້ນເງິນເດືອນ</a>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-phone-volume"></i> ຕິດຕໍ່ພວກເຮົາ</a>
            </li>
        </ul>
        <!--ໃຫ້ລາຍການເມນູໄປຕິດທາງດ້ານຂວາ-->
        <ul class="navbar-nav ml-auto">
            <!-- Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    <i class="fas fa-user"></i> <?= @$_SESSION['username'] ?> ຜູ້ໃຊ້ລະບົບ
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="register-form.php">ລົງທະບຽນ</a>
                    <a class="dropdown-item" href="profile.php">ໂປຣໄຟລ໌</a>
                    <?php
                    if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
                        echo '<a class="dropdown-item" href="login-form.php">ເຂົ້າໃຊ້ລະບົບ</a>';
                    } else {
                        echo ' <a class="dropdown-item" href="logout.php">ອອກລະບົບ</a>';
                    }
                    ?>


                </div>
            </li>
        </ul>

    </div>
</nav>