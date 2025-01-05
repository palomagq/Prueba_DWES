<?php
// Importar conexión a la base de datos
require_once '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener todos los artículos de la base de datos
$sql = "SELECT * FROM items";
$stmt = $pdo->query($sql);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT name FROM users where id = ?";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute([$_SESSION['user_id']]);
$users = $stmt2->fetch(PDO::FETCH_ASSOC);
//var_dump($users);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>ShopNow</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="../css/index_client.css" rel="stylesheet" />

		<!-- Bootstrap icons-->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <!-- Core theme CSS (includes Bootstrap)-->
    </head>
    <body data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="50">
        <input id="user_id" value="<?= htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8') ?>" type="hidden">
        <!-- Navigation-->
		<nav class="navbar py-3 py-lg-0 navbar-light bg-light navbar-expand-lg" id="navbar-example2">
			 <div class="container d-flex">
				 <a class="navbar-brand" href="#!">ShopNow</a>
				 <div class="d-flex flex-row order-lg-last align-items-center">
				 
					 <button type="button" class="navbar-toggler order-last collapsed" data-bs-toggle="collapse" data-bs-target="#navbar" aria-expanded="false" aria-controls="navbar">
						 <span class="navbar-toggler-icon"></span>
					 </button>
					 <ul onclick="getCart()"  class="navbar-nav me-3 me-lg-0 d-flex flex-row align-items-center">
						 <li class="dropdown search-dropdown nav-item py-lg-3">						 
							 <a  href="javascript:void(0)" class="btn btn-outline-dark flex-center" type="button" >
								<i class="fas fa-shopping-cart me-1"></i> Carrito <span class="badge bg-dark text-white ms-1 rounded-pill" id="count_product">0</span>
							 </a>
						 </li>
					 </ul>
				 </div>

				 <div id="navbar" class="navbar-collapse collapse">

					 <ul class="navbar-nav me-auto mb-4 mb-lg-0 ms-lg-5">
						 <li class="nav-item">
						  <a class="nav-link" href="#articulo"><i class="fas fa-shopping-basket"></i> Artículos</a>
						</li>
					 </ul>
				 </div>
                 
			 </div>
             <div class="profile">
                <?php if (isset($users['name'])): ?>
                    <span><?= htmlspecialchars($users['name'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php else: ?>
                    <span>Nombre no disponible</span>
                <?php endif; ?>            
            </div>
		 </nav>

        <!-- Header-->
       <!-- <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">IT Academy Shop</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Get up to 50% off Today Only!</p>
                </div>
            </div>
        </header>-->
		<!-- Section-->
		<section class="pt-5" id="articulo">
			<h2 class="text-center"><i class="fas fa-shopping-basket pe-3"></i>Artículos</h2>
			<div class="container px-4 px-lg-5 mt-5">
				<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= $item['name'] ?></h5>
                                    <p class="card-text"><?= $item['price']?>€</p>
                                    <button id="buttonAddCart" class="btn btn-outline-dark" onclick="addItemCart(<?= $item['id'] ?>)">Agregar al Carrito</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
	   
				</div>
			</div>

            
		</section>

        <div class="modal" id="cartModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Carro de la Compra</h2>
                    <button class="close-btn" id="closeEditModalClient">&times;</button>
                </div>
                <table class="table" id="tableCart">
					<thead>
						<tr>
						  <th scope="col">Producto</th>
						  <th scope="col">Precio</th>
						  <th scope="col">Cantidad</th>
						  <th scope="col">Total</th>
						</tr>
					  </thead>
					  <tbody id="cart_list">
						<tr>
						  
						</tr>
					  </tbody>
				  </table>
				  <div class="text-center fs-3">
					Total: <span id="total_price"></span>
				  </div>
                  <div style="align-self: center;">
                    <button id="buttonCheckout" class="btn btn-outline-dark" onclick="checkout()">Checkout</button>
                  </div>
            </div>
        </div>
	
        <!-- Footer-->
        <footer class="py-3 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy;  2025</p></div>
        </footer>

	
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- Core theme JS-->
        <script src="../js/index_client.js"></script>

    </body>
</html>
