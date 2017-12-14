<?php

namespace Itb;

class MainController
{
    private $twig;

    public function __construct(\twig\Environment $twig)
    {
        $this->twig = $twig;
    }

    public function setUsernameAction($name)
    {
        $_SESSION['username'] = $name;
    }

    public function showUsernameAction()
    {
        if(isset($_SESSION['username']))
        {
            print 'username = ' . $_SESSION['username'];
        }

        else
        {
            print 'missing SESSION value: ' .  'username';
        }
    }

    public function processLoginAction($username, $password)
    {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        if($this->validCredentials($username, $password_hashed))
        {
            $_SESSION['username'] = $username;

            $username = $this->usernameFromSession();

            $this->indexAction();
        }

        else
        {
            $template = 'loginError.html.twig';

            $argsArray =
                [
                    'pageTitle' => 'Bad Login',
                    'heading' => 'Login error',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }
    }

    public function validCredentials($u, $p)
    {
        if('admin' == $u && password_verify('admin', $p))
        {
            $_SESSION['username'] = $u;

            return true;
        }

        else if('staff' == $u && password_verify('staff', $p))
        {
            $_SESSION['username'] = $u;

            return true;
        }

        else if('visitor' == $u && password_verify('visitor', $p))
        {
            $_SESSION['username'] = $u;

            return true;
        }

        else
        {
            return false;
        }
    }

    public function isLoggedIn()
    {
        if(isset($_SESSION['username']))
        {
            return true;
        }

        else
        {
            return false;
        }
    }

    public function usernameFromSession()
    {
        if(isset($_SESSION['username']))
        {
            return $_SESSION['username'];
        }

        else
        {
            return '';
        }
    }

    public function processLogoutAction()
    {
        $this->endSessionAction();

        //  Goes to the index page
        header("Location:/");
    }

    public function logoutAction()
    {
        $this->killSession();

        $this->indexAction();
    }

    public function endSessionAction()
    {
        $this->killSession();
    }

    public function killSession()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies'))
        {
            $params = session_get_cookie_params();

            setcookie(	session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
    }

    public function indexAction()
    {
        $template = 'home.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Project Home Page',
                'heading' => ' Welcome to the Biffy Clyro Fan page:',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function aboutAction()
    {
        $template = 'about.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'About the Band',
                'heading' => 'Who is Biffy Clyro?',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function galleryAction()
    {
        $template = 'gallery.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Gallery',
                'heading' => 'Pictures of the members and some of their albums',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function musicAction()
    {
        $template = 'music.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Music',
                'heading' => 'Music the band has released',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function socialAction()
    {
        $template = 'social.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Social Links ',
                'heading' => 'The social media of the Band & the members',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function merchandiseAction()
    {
        $template = 'merchandise.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Merchandise',
                'heading' => 'The bands merchandise',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function accountCreationAction()
    {
        $template = 'accountCreation.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Sign up',
                'heading' => 'Sign up to an Account',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function createUserAccountAction($name, $emailAddress, $passWord, $emailNotified)
    {
        $template = 'createUserAccountConfirm.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'name' => $name,
                'emailAddress' => $emailAddress,
                'passWord' => $passWord,
                'emailNotified' => $emailNotified,

                'pageTitle' => 'Confirm',
                'heading' => 'Confirmation of Account Details',
            ];

        $visitorRepository = new VisitorRepository();

        $visitorRepository->insertIntoVisitor($name, $emailAddress, $passWord, $emailNotified);

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function logInAction()
    {
        $template = 'login.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Sign in to account',
                'heading' => 'Account overview',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function loggedInAction() //    Shows the logged in list of all databases (depeneding on users)
    {
        $username = $this->usernameFromSession();

        if($username != '')    //  Everyone logged in can visit
        {
            $template = 'successfullLogIn.html.twig';

            $argsArray =
                [
                    'username' => $username,

                    'pageTitle' => 'Database overview',
                    'heading' => 'Database overview',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function successfullyCreatedAction()
    {
        $template = 'successfullyCreated.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Account created',
                'heading' => 'Account overview',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function siteMapAction()
    {
        $template = 'siteMap.html.twig';

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'pageTitle' => 'Site Map',
                'heading' => 'Site Map view',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function showProductsAction()
    {
        $username = $this->usernameFromSession();

        if($username != '')    //  Everyone logged in can visit
        {
            $template = 'showProducts.html.twig';

            $productRepository = new ProductsRepository();

            $products = $productRepository->getAllFromProducts();

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'products' => $products,
                    'pageTitle' => 'Product overview',
                    'heading' => 'Products overview',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }
    public function showProductsAction2()
    {
        $template = 'showProducts.html.twig';

        $productRepository = new ProductsRepository();

        $products = $productRepository->getAllFromProducts();

        $argsArray =
            [
                'products' => $products,
                'pageTitle' => 'Product overview',
                'heading' => 'Products overview',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }
    public function productShowAction($id)
    {
        $template = 'productShow.html.twig';

        $productRepository = new ProductsRepository();

        $product = $productRepository->getOneFromProducts($id);

        $argsArray =
            [
                'username' => $this->usernameFromSession(),

                'product' => $product,
                'pageTitle' => 'Product ',
                'heading' => 'Overview of Product',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function productShowAction2($id)
    {
        $template = 'productShow.html.twig';

        $productRepository = new ProductsRepository();

        $product = $productRepository->getOneFromProducts($id);

        $argsArray =
            [
                'product' => $product,
                'pageTitle' => 'Product ',
                'heading' => 'Overview of Product',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function editProductAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'editProduct.html.twig';

            $productRepository = new ProductsRepository();

            $product = $productRepository->getOneFromProducts($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'product' => $product,
                    'pageTitle' => 'Product Edited',
                    'heading' => 'Overview of edit',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    //  Function to Update with edits
    public function productUpdateAction($id, $description, $price, $image)
    {
        $productRepository = new ProductsRepository();

        $id = $productRepository->updateProducts($id, $description, $price, $image);

        //  Calls another function for the page and Updated info
        $this->confirmProductsUpdate($id, $description, $price, $image);
    }

    public function confirmProductsUpdate($id, $image, $description, $price)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmProductUpdateData.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'id' => $id,
                    'image' => $image,
                    'description' => $description,
                    'price' => $price,

                    'pageTitle' => 'Product Updated',
                    'heading' => 'Confirmation of Update',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function createProductAction()
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'createProduct.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'Product Created',
                    'heading' => 'Overview of Creation',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function productCreateAction($image, $description, $price)
    {
        $productRepository = new ProductsRepository();

        $id = $productRepository->insertIntoProducts($image, $description, $price);

        $this->confirmProductsCreation($id);  //  Calls another function for the page and Updated info
    }

    public function confirmProductsCreation($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmProductCreation.html.twig';

            $ProductRepository = new ProductsRepository();

            $product = $ProductRepository->getOneFromProducts($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'product' => $product,
                    'pageTitle' => 'Product Creation',
                    'heading' => 'Confirmation',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function deleteProductAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'deleteProduct.html.twig';

            $productRepository = new ProductsRepository();

            $product = $productRepository->getOneFromProducts($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'products' => $product,
                    'pageTitle' => 'Product Deletion',
                    'heading' => 'Confirmation',
                ];

            $this->confirmProductsDeletion($id); //  Calls another function for the page and deletes info

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function confirmProductsDeletion($id)
    {
        $productRepository = new ProductsRepository();

        $productRepository->deleteOneFromProducts($id);
    }

    public function productDeleteAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmProductDelete.html.twig';

            $productRepository = new ProductsRepository();

            $productRepository->deleteOneFromProducts($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'Product Deleted',
                    'heading' => 'Confirmation of Delete',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function showVisitorAction()
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'showVisitors.html.twig';

            $visitorRepository = new VisitorRepository();

            $Visitor = $visitorRepository->getAllFromVisitor();

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'visitor' => $Visitor,
                    'pageTitle' => 'Visitor overview',
                    'heading' => 'Visitor to site',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function visitorShowAction($id)
    {
        $template = 'visitorShow.html.twig';

        $visitorRepository = new VisitorRepository();

        $visitor = $visitorRepository->getOneFromVisitor($id);

        $argsArray =
            [
                'visitor' => $visitor,
                'pageTitle' => 'Visitor ',
                'heading' => 'Overview of Visitor',
            ];

        $html = $this->twig->render($template, $argsArray);
        print $html;
    }

    public function editVisitorAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'editVisitor.html.twig';

            $visitorRepository = new VisitorRepository();

            $visitor = $visitorRepository->getOneFromVisitor($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'visitor' => $visitor,
                    'pageTitle' => 'Visitor Edited',
                    'heading' => 'Overview of edit',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    //  Function to Update with edits
    public function visitorUpdateAction($id, $aName, $aEmail, $aPassword, $emailNotify)
    {
        $visitorRepository = new VisitorRepository();

        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        $id = $visitorRepository->updateVisitor($id, $aName, $aEmail, $password_hashed, $emailNotify);

        //  Calls another function for the page and Updated info
        $this->confirmVisitorUpdate($id, $aName, $aEmail, $aPassword, $emailNotify);
    }

    public function confirmVisitorUpdate($id, $aName, $aEmail, $aPassword, $emailNotify)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmVisitorUpdateData.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'id' => $id,
                    'aName' => $aName,
                    'aEmail' => $aEmail,
                    'aPassword' => $aPassword,
                    'emailNotify' => $emailNotify,

                    'pageTitle' => 'Visitor Updated',
                    'heading' => 'Confirmation of Update',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function createVisitorAction()
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'createVisitor.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'Visitor edited',
                    'heading' => 'Overview of edit',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function visitorCreateAction($aName, $aEmail, $aPassword, $getsEmails)
    {
        $visitorRepository = new VisitorRepository();

        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        $id = $visitorRepository->insertIntoVisitor($aName, $aEmail, $password_hashed, $getsEmails);

        $this->confirmVisitorCreation($id, $aName, $aEmail, $aPassword, $getsEmails); //  Calls another function for the page and Updated info
    }

    public function confirmVisitorCreation($id, $aName, $aEmail, $aPassword, $getsEmails)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmVisitorCreation.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'id' => $id,
                    'aName' => $aName,
                    'aEmail' => $aEmail,
                    'aPassword' => $aPassword,
                    'getsEmails'=> $getsEmails,


                    'pageTitle' => 'Visitor Creation',
                    'heading' => 'Confirmation',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function deleteVisitorAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'deleteVisitor.html.twig';

            $visitorRepository = new VisitorRepository();

            $visitor = $visitorRepository->getOneFromVisitor($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'visitor' => $visitor,
                    'pageTitle' => 'Visitor Deletion',
                    'heading' => 'Confirmation',
                ];

            $this->confirmVisitorDeletion($id); //  Calls another function for the page and deletes info

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function confirmVisitorDeletion($id)
    {
        $visitorRepository = new VisitorRepository();

        $visitorRepository->deleteOneFromVisitor($id);
    }

    public function visitorDeleteAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmVisitorDelete.html.twig';

            $visitorRepository = new VisitorRepository();

            $visitorRepository->deleteOneFromVisitor($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'Visitor Deleted',
                    'heading' => 'Confirmation of Delete',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function showStaffAction()
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'showStaff.html.twig';

            $staffRepository = new StaffRepository();

            $staff = $staffRepository->getAllFromStaff();

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'staff' => $staff,
                    'pageTitle' => 'Staff overview',
                    'heading' => 'Staff members',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function editStaffAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'editStaff.html.twig';

            $staffRepository = new StaffRepository();

            $staff = $staffRepository->getOneFromStaff($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'staff' => $staff,
                    'pageTitle' => 'Visitor Edited',
                    'heading' => 'Overview of edit',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    //  Function to Update with edits
    public function staffUpdateAction($id, $aName, $aPassword)
    {
        $staffRepository = new StaffRepository();

        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        $id = $staffRepository->updateStaff($id, $aName, $password_hashed);

        //  Calls another function for the page and Updated info
        $this->confirmStaffUpdate($id, $aName, $aPassword);
    }

    public function confirmStaffUpdate($id, $aName, $aPassword)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmStaffUpdateDatas.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'id' => $id,
                    'aName' => $aName,
                    'aPassword' => $aPassword,

                    'pageTitle' => 'Staff Updated',
                    'heading' => 'Confirmation of Update',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function createStaffAction()
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'createStaff.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'Staff edited',
                    'heading' => 'Overview of edit',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function staffCreateAction($aName, $aPassword)
    {
        $staffRepository = new StaffRepository();

        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        $id = $staffRepository->insertIntoStaff($aName,$password_hashed);

        $this->confirmStaffCreation($id, $aName, $aPassword); //  Calls another function for the page and Updated info
    }

    public function confirmStaffCreation($id, $aName, $aPassword)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmStaffCreation.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'id' => $id,
                    'aName' => $aName,
                    'aPassword' => $aPassword,

                    'pageTitle' => 'Staff Creation',
                    'heading' => 'Confirmation',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function deleteStaffAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'deleteStaff.html.twig';

            $staffRepository = new StaffRepository();

            $staff = $staffRepository->getOneFromStaff($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'staff' => $staff,
                    'pageTitle' => 'Staff Deletion',
                    'heading' => 'Confirmation',
                ];

            $this->confirmStaffDeletion($id);  //  Calls another function for the page and deletes info

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function confirmStaffDeletion($id)
    {
        $staffRepository = new StaffRepository();

        $staffRepository->deleteOneFromStaff($id);
    }

    public function staffDeleteAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' || $username == 'staff')    //  Will become from (admin or staff) table
        {
            $template = 'confirmStaffDelete.html.twig';

            $staffRepository = new StaffRepository();

            $staffRepository->deleteOneFromStaff($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'Staff Deleted',
                    'heading' => 'Confirmation of Delete',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function showAdminAction()
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin')    //  Will become from admin table
        {
            $template = 'showAdmin.html.twig';

            $adminRepository = new AdminRepository();

            $admin = $adminRepository->getAllFromAdmin();

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'admin' => $admin,
                    'pageTitle' => 'Admin overview',
                    'heading' => 'Admin members',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function editAdminAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin')    //  Will become from admin table
        {
            $template = 'editAdmin.html.twig';

            $adminRepository = new AdminRepository();

            $admin = $adminRepository->getOneFromAdmin($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'admin' => $admin,
                    'pageTitle' => 'Admin Edited',
                    'heading' => 'Overview of edit',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    //  Function to Update with edits
    public function adminUpdateAction($id, $aName, $aPassword)
    {
        $adminRepository = new AdminRepository();

        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        $id = $adminRepository->updateAdmin($id, $aName, $password_hashed);

        //  Calls another function for the page and Updated info
        $this->confirmAdminUpdate($id, $aName, $aPassword);
    }

    public function confirmAdminUpdate($id, $aName, $aPassword)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin' )    //  Will become from admin table
        {
            $template = 'confirmAdminUpdateDatas.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'id' => $id,
                    'aName' => $aName,
                    'aPassword' => $aPassword,

                    'pageTitle' => 'Admin Updated',
                    'heading' => 'Confirmation of Update',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function createAdminAction()
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin')    //  Will become from admin table
        {
            $template = 'createAdmin.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'AdminCreated',
                    'heading' => 'Overview of Creation',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function adminCreateAction($aName, $aPassword)
    {
        $adminRepository = new AdminRepository();

        $password_hashed = password_hash($aPassword, PASSWORD_DEFAULT);

        $id = $adminRepository->insertIntoAdmin($aName,$password_hashed);

        $this->confirmAdminCreation($id, $aName, $aPassword); //  Calls another function for the page and Updated info
    }

    public function confirmAdminCreation($id, $aName, $aPassword)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin')    //  Will become from admi table
        {
            $template = 'confirmAdminCreation.html.twig';

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'id' => $id,
                    'aName' => $aName,
                    'aPassword' => $aPassword,

                    'pageTitle' => 'Admin Creation',
                    'heading' => 'Confirmation',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function deleteAdminAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin')    //  Will become from admin table
        {
            $template = 'deleteAdmin.html.twig';

            $adminRepository = new AdminRepository();

            $admin = $adminRepository->getOneFromAdmin($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'admin' => $admin,
                    'pageTitle' => 'Admin Deletion',
                    'heading' => 'Confirmation',
                ];

            $this->confirmAdminDeletion($id);  //  Calls another function for the page and deletes info

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }

    public function confirmAdminDeletion($id)
    {
        $adminRepository = new AdminRepository();

        $adminRepository->deleteFromAdmin($id);
    }

    public function AdminDeleteAction($id)
    {
        $username = $this->usernameFromSession();

        if ($username == 'admin')    //  Will become from admin  table
        {
            $template = 'confirmAdminDelete.html.twig';

            $adminRepository = new AdminRepository();

            $adminRepository->deleteFromAdmin($id);

            $argsArray =
                [
                    'username' => $this->usernameFromSession(),

                    'pageTitle' => 'Admin Deleted',
                    'heading' => 'Confirmation of Delete',
                ];

            $html = $this->twig->render($template, $argsArray);
            print $html;
        }

        else
        {
            $this->indexAction();
        }
    }
}