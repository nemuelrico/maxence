<?php
// Include necessary files (e.g., for session or database connection)
session_start();  // Start a session if you need to track the logged-in user
include('../bootstrap_admin/php/db.php');
 // Adjust the path if necessary
// Optionally, include your header and footer files for a clean structure
// include('header.php'); // Use this to include common header across pages
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MAXENCE CLOTHING HOMEPAGE</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="#!">Maxence Clothing</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        
                        <!-- About with dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="aboutDropdown" href="#" role="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">About</a>
                            <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                                <li><a class="dropdown-item" href="#!">Size Chart</a></li>
                                <li><a class="dropdown-item" href="#!">How to Order</a></li>
                                <li><a class="dropdown-item" href="#!">FAQ's</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Contact us</a></li>
                            </ul>
                        </li>

                        <!-- Shop dropdown (unchanged) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" 
                            data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>
                    </ul>

                    <form class="d-flex align-items-center">
                        <!-- Cart button -->
                        <button class="btn btn-outline-dark me-2" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                        </button>
                    
                        <!-- User/Login button -->
                        <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#authModal">
                            <i class="bi-person"></i>
                        </button>
                    </form>
                </div>
            </div>
            <!-- Login/Register Modal -->
            <div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-4">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="authModalLabel">Login or Register</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Register</button>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Login Form -->
                                <div class="tab-pane fade show active" id="login" role="tabpanel">
                                    <form method="POST" action="login.php">
                                        <div class="mb-3">
                                            <label for="loginEmail" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="loginPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                                    </form>
                                </div>

                                <!-- Register Form -->
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form method="POST" action="php/register.php" onsubmit="return validateRegisterForm()">
                                        <div class="mb-3">
                                            <label for="registerName" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="registerName" name="fullname" placeholder="Full Name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registerUsername" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="registerUsername" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registerEmail" class="form-label">Email address</label>
                                            <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Enter email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registerPassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registerContact" class="form-label">Contact Number</label>
                                            <input type="tel" class="form-control" id="registerContact" name="contact" placeholder="e.g. 09XXXXXXXXX" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registerBirthdate" class="form-label">Birthdate</label>
                                            <input type="date" class="form-control" id="registerBirthdate" name="birthdate" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registerAddress" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="registerAddress" name="address" placeholder="Street, Barangay, City" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="registerZip" class="form-label">Zip / Postal Code</label>
                                            <input type="text" class="form-control" id="registerZip" name="zip" placeholder="e.g. 1000" required>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100" name="register">Register</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
  
        </nav>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Shop in style</h1>
                    <p class="lead fw-normal text-white-50 mb-0">With Maxence Clothing</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                // Example query to fetch product details from the database, including sale price
                $sql = "SELECT * FROM products"; // Make sure your table has a sale_price column
                $stmt = $conn->query($sql);
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                foreach ($products as $product):
                    $regular_price = $product['price'];
                    $sale_price = isset($product['sale_price']) ? $product['sale_price'] : null;
                    ?>
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Sale badge -->
                            <?php if ($sale_price): ?>
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <?php endif; ?>
                            <!-- Product image-->
                            <img class="card-img-top" src="uploads/<?php echo $product['image']; ?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $product['name']; ?></h5>
                                    <!-- Product price-->
                                    <?php if ($sale_price): ?>
                                        <span class="text-muted text-decoration-line-through">$<?php echo number_format($regular_price, 2); ?></span>
                                        $<?php echo number_format($sale_price, 2); ?>
                                    <?php else: ?>
                                        $<?php echo number_format($regular_price, 2); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

            <!-- Modal HTML (Place this at the bottom of your HTML file) -->
            <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="loginModalLabel">Login or Register</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="loginForm">
                                <!-- Login Form -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary" id="showRegister">Don't have an account? Register here.</button>
                                </div>
                            </form>

                            <!-- Register Form (Initially hidden) -->
                            <form id="registerForm" style="display:none;">
                                <div class="mb-3">
                                    <label for="newUsername" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="newUsername" required>
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="newPassword" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Maxence 2025</p></div>
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Maxence 2025</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="bootstrap_homepage/js/formValidation.js"></script>
    </body>
</html>
