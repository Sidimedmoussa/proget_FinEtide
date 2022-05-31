
<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button> 
           
            <a href="admin.php" class="navbar-brand"><img src="images/logo.png" alt="logo"></a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav nav ">
                <li><a href="admin.php" >ACCEUIL</a></li>
                <li><a href="client.php" >CLIENT</a></li>
                <li><a href="voiture.php?action=allvoiture">VOITURE</a></li>
                <li><a href="contract.php?action=allcontract">CONTRACTS</a></li>
                <li><a href="factures.php">FACCTURES</a></li>
            </ul>
            <ul class="navbar-nav nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" ><?php echo $_SESSION["nom"];?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="editprofile.php?id=<?php echo $_SESSION["id"];?>">Editer Profile</a></li>
                    <li><a href="#">Language</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>