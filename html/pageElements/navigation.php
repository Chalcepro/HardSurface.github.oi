       <!-- Navbar -->
       <nav class="navbar navbar-expand-lg navbar-dark bg-transparent" aria-label="Tenth navbar example">
            <div class="container-fluid fw-bold">
              <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarsExample08"
                aria-controls="navbarsExample08"\
                aria-expanded="false"
                aria-label="Toggle navigation"
              >
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse justify-content-lg-center" id="navbarsExample08">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link <?php if($page == 'home'){ echo "active";} ?>" aria-current="page" href="./home.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if($page == 'explore'){ echo "active";} ?>" href="./explore.php">Explore</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if($page == 'about'){ echo "active";} ?>" href="./about.php">About</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if($page == 'contact'){ echo "active";} ?>" href="./contact.php">Contacts</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php if($page == 'logout'){ echo "active";} ?>" href="./logout.php">Logout</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>