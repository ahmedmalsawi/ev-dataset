<nav class="navbar navbar-inverse navbar-dark navbar-expand-lg bg-dark">
    <div class="container">
        <a class="navbar-brand active " href="dashboard.php"><?php echo lang('Home'); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav"
            aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="categories.php"><?php echo lang('Categories'); ?></a>
                </li>
                <li class="nav-item btn-secondary active"><a class="nav-link " aria-current="page"
                        href="items.php"><?php echo lang('Items'); ?></a></li>
                <li class="nav-item btn-secondary"><a class="nav-link " aria-current="page"
                        href="members.php?do=Manage"><?php echo lang('members'); ?></a></li>
                <li class="nav-item btn-secondary"><a class="nav-link " aria-current="page"
                        href="comments.php?do=Manage">Comments</a></li>
                <li class="nav-item btn-secondary"><a class="nav-link " aria-current="page"
                        href="#"><?php echo lang('Statistics'); ?></a></li>
                <li class="nav-item btn-secondary"><a class="nav-link " aria-current="page"
                        href="#"><?php echo lang('Logs'); ?></a></li>
                <li class="nav-item btn-secondary"><a class="nav-link " aria-current="page"
                        href="calc.php?do=Manage">Calculate</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['username']; ?></a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../index.php">Visit Shop</a></li>
                        <li><a class="dropdown-item" href="members.php?do=Edit&userId=<?php echo $_SESSION['ID']; ?>"><?php echo lang('Edit Profile'); ?></a></li>
                        <li><a class="dropdown-item" href="#"><?php echo lang('Settings'); ?></a></li>
                        <li><a class="dropdown-item" href="logout.php"><?php echo lang('Logout');?></a></li>
                    </ul>
                    </li>
            </ul>
        </div>
    </div>
</nav>
