<?php

require_once __DIR__.'/../vendor/autoload.php';

//  Each table to be set up

use Itb\ProductsRepository;

$productRepository = new ProductsRepository();

$productRepository->dropProductsTable();

$productRepository->createProductsTable();

$productRepository->deleteAllFromProducts();

// Every Product added to its database: (description , price)
$productRepository->insertIntoProducts('images/carnival_T-Shirt.jpg','Carnival T-Shirt',23.99);
$productRepository->insertIntoProducts('images/doll_T-Shirt.jpg','Doll T-Shirt',19.99);
$productRepository->insertIntoProducts('images/official_Biffytartan_Key_Ring.jpg','Key Ring',19.99);
$productRepository->insertIntoProducts('images/late_Guests_T-Shirt .jpg','Late Guest T-Shirt',23.99);
$productRepository->insertIntoProducts('images/faces_Tour_T-Shirt.jpg','Faces Tour T-Shirt',23.99);
$productRepository->insertIntoProducts('images/mon_The_Biff_Tye_Dye_T-Shirt.jpg','Mon The Biff Tye Dye T-Shirt',29.99);

/* ------------------------------------------------------------------------------------------------------------------------------------------------- */

use Itb\StaffRepository;

$staffRepository = new StaffRepository();

$staffRepository->dropStaffTable();

$staffRepository->createStaffTable();

$staffRepository->deleteAllFromStaff();

$password_hashed = password_hash("staff", PASSWORD_DEFAULT);
$password_hashed2 = password_hash("staff2", PASSWORD_DEFAULT);


// Every Staff added to its database: (aName, department)
$staffRepository->insertIntoStaff('Staff',$password_hashed);
$staffRepository->insertIntoStaff('Staff2',$password_hashed2);
/* ------------------------------------------------------------------------------------------------------------------------------------------------- */

use Itb\AdminRepository;

$adminRepository = new AdminRepository();

$adminRepository ->dropAdminTable();

$adminRepository->createAdminTable();

$adminRepository->deleteAllFromAdmin();

$password_hashed = password_hash("admin", PASSWORD_DEFAULT);
$password_hashed2 = password_hash("admin2", PASSWORD_DEFAULT);

// Every admin added to its database: (name, password)
$adminRepository->insertIntoAdmin('Admin',$password_hashed);
$adminRepository->insertIntoAdmin('Admin2',$password_hashed2);

/* ------------------------------------------------------------------------------------------------------------------------------------------------- */

use Itb\VisitorRepository;

$visitorRepository = new VisitorRepository();

$visitorRepository ->dropVisitorTable();

$visitorRepository ->createVisitorTable();

$visitorRepository ->deleteAllFromVisitor();

$password_hashed = password_hash("visitor", PASSWORD_DEFAULT);
$password_hashed2 = password_hash("visitor2", PASSWORD_DEFAULT);

// Every visitor added to its database: (name, email, password, )
$visitorRepository ->insertIntoVisitor('Visitor','email@email.com',$password_hashed,'Yes');
$visitorRepository ->insertIntoVisitor('Visitor2','emails@emails.com',$password_hashed2,'No');

/* ------------------------------------------------------------------------------------------------------------------------------------------------- */
