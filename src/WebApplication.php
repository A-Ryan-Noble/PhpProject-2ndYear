<?php
namespace Itb;

class WebApplication
{
    const PATH_TO_TEMPLATES = __DIR__ . '/../views';

    private $mainController;

    public function __construct()
    {
        $twig = new \Twig\Environment(new \Twig_Loader_Filesystem(self::PATH_TO_TEMPLATES));

        $this->mainController = new MainController($twig);
    }

    public function run()
    {
        $action = filter_input(INPUT_GET, 'action');

        if(empty($action))
        {
            $action = filter_input(INPUT_POST, 'action');
        }

        switch ($action)
        {
            case 'about':
                // Go to the about page
                $this->mainController->aboutAction();
                break;

            case 'gallery':
                // Go to the gallery page
                $this->mainController->galleryAction();
                break;

            case 'music':
                // Go to the music page
                $this->mainController->musicAction();
                break;

            case 'social':
                // Go to the social page
                $this->mainController->socialAction();
                break;

            case 'merchandise':
                // Go to the merchandise page
                $this->mainController->merchandiseAction();
                break;

            case 'successfullyCreated':
                // Go to the successfully created page
                $this->mainController->successfullyCreatedAction();
                break;

            case 'siteMap':
                // Go to the siteMap page
                $this->mainController->siteMapAction();
                break;

            case'login':
                $this->mainController->logInAction();
                break;

            case 'loggedIn':
                // Go to the admin login page
                $this->mainController->loggedInAction();
                break;

            case 'accountCreation':
                // Go to the account creation page
                $this->mainController->accountCreationAction();
                break;

            case 'createUserAccount':
                $firstName = filter_input(INPUT_POST, 'firstName',FILTER_SANITIZE_STRING);
                $lastName = filter_input(INPUT_POST, 'lastName',FILTER_SANITIZE_STRING);
                $emailAddress = filter_input(INPUT_POST, 'emailAddress',FILTER_SANITIZE_STRING);
                $passWord = filter_input(INPUT_POST, 'passWord',FILTER_SANITIZE_STRING);
                $emailNotified = filter_input(INPUT_POST, 'emailNotified',FILTER_SANITIZE_STRING);

                //  Combines the two user inputted names into one with a space in between
                $name = $firstName . ' ' . $lastName;

                /// Go to the create user page
                $this->mainController->createUserAccountAction($name, $emailAddress, $passWord, $emailNotified);
                break;

            case 'showProducts':
                // Go to the show products page
                $this->mainController->showProductsAction();
                break;

            case 'showProducts2':
                // Go to the show products page
                $this->mainController->showProductsAction2();
                break;

            case 'productShow':
                $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
                // Go to the show product page
                $this->mainController->productShowAction($id);
                break;

            case 'editProduct':
                $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the edit product page
                $this->mainController->editProductAction($id);
                break;

            case 'productUpdate':
                $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
                $image =  filter_input(INPUT_POST, 'image',FILTER_SANITIZE_STRING);
                $description = filter_input(INPUT_POST, 'description',FILTER_SANITIZE_STRING);
                $price = filter_input(INPUT_POST, 'price',FILTER_SANITIZE_NUMBER_FLOAT);

                // Go to the product update page
                $this->mainController->productUpdateAction($id, $image, $description, $price);
                break;

            case 'createProduct':
                // Go to the create product page
                $this->mainController->createProductAction();
                break;

            case 'productCreate':
                $image = filter_input(INPUT_POST,'productImage',FILTER_SANITIZE_STRING);
                $description = filter_input(INPUT_POST,'productDescription',FILTER_SANITIZE_STRING);
                $price = filter_input(INPUT_POST,'productPrice',FILTER_SANITIZE_NUMBER_FLOAT);

                // Go to the product create page
                $this->mainController->productCreateAction($image, $description, $price);
                break;

            case 'deleteProduct':
                $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the delete product page
                $this->mainController->deleteProductAction($id);
                break;

            case 'productDelete':
                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the product delete page
                $this->mainController->productDeleteAction($id);
                break;

            case 'showVisitor':
                // Go to the show visitor page
                $this->mainController->showVisitorAction();
                break;

            case 'visitorShow':
                $id = filter_input(INPUT_GET, 'id',FILTER_SANITIZE_NUMBER_INT);
                // Go to the visitor show page
                $this->mainController->visitorShowAction($id);
                break;

            case 'editVisitor':
                $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the edit visitor page
                $this->mainController->editVisitorAction($id);
                break;

            case 'visitorUpdate':
                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);
                $aName = filter_input(INPUT_POST, 'aName',FILTER_SANITIZE_STRING);
                $aEmail = filter_input(INPUT_POST, 'aEmail',FILTER_SANITIZE_STRING);
                $aPassword = filter_input(INPUT_POST, 'aPassword',FILTER_SANITIZE_STRING);
                $emailNotify = filter_input(INPUT_POST, 'emailNotify',FILTER_SANITIZE_STRING);

                // Go to the visitor update page
                $this->mainController->visitorUpdateAction($id, $aName, $aEmail, $aPassword, $emailNotify);
                break;

            case 'createVisitor':
                // Go to the create visitor page
                $this->mainController->createVisitorAction();
                break;

            case 'visitorCreate':
                $aName = filter_input(INPUT_POST, 'aName',FILTER_SANITIZE_STRING);
                $aEmail = filter_input(INPUT_POST, 'aEmail',FILTER_SANITIZE_STRING);
                $aPassword = filter_input(INPUT_POST, 'aPassword',FILTER_SANITIZE_STRING);
                $emailNotify = filter_input(INPUT_POST, 'emailNotify',FILTER_SANITIZE_STRING);

                /// Go to the visitor create page
                $this->mainController->visitorCreateAction($aName, $aEmail, $aPassword ,$emailNotify);
                break;

            case 'deleteVisitor':
                $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the delete visitor page
                $this->mainController->deleteVisitorAction($id);
                break;

            case 'visitorDelete':
                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the visitor delete page
                $this->mainController->visitorDeleteAction($id);
                break;

            case 'showStaff':
                // show the Staff page
                $this->mainController->showStaffAction();
                break;

            case 'editStaff':
                $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

                //  Show the edit Staff page
                $this->mainController->editStaffAction($id);
                break;

            case 'staffUpdate':
                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);
                $aName = filter_input(INPUT_POST, 'aName',FILTER_SANITIZE_STRING);
                $aPassword = filter_input(INPUT_POST, 'aPassword',FILTER_SANITIZE_STRING);

                // Show the staff update page
                $this->mainController->staffUpdateAction($id, $aName, $aPassword);
                break;

            case 'createStaff':
                // Show the create staff page
                $this->mainController->createStaffAction();
                break;

            case 'staffCreate':
                $aName = filter_input(INPUT_POST, 'aName',FILTER_SANITIZE_STRING);
                $aPassword = filter_input(INPUT_POST, 'aPassword',FILTER_SANITIZE_STRING);

                // Go to the staff create page
                $this->mainController->staffCreateAction($aName, $aPassword);
                break;

            case 'deleteStaff':
                $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the delete staff page
                $this->mainController->deleteStaffAction($id);
                break;

            case 'staffDelete':
                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the staff delete page
                $this->mainController->staffDeleteAction($id);
                break;

            case 'showAdmin':
                // show the Admin page
                $this->mainController->showAdminAction();
                break;

            case 'editAdmin':
                $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

                //  Show the edit Staff page
                $this->mainController->editAdminAction($id);
                break;

            case 'adminUpdate':
                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);
                $aName = filter_input(INPUT_POST, 'aName',FILTER_SANITIZE_STRING);
                $aPassword = filter_input(INPUT_POST, 'aPassword',FILTER_SANITIZE_STRING);

                // Show the staff update page
                $this->mainController->adminUpdateAction($id, $aName, $aPassword);
                break;

            case 'createAdmin':
                // Show the create staff page
                $this->mainController->createStaffAction();
                break;

            case 'adminCreate':
                $aName = filter_input(INPUT_POST, 'aName',FILTER_SANITIZE_STRING);
                $aPassword = filter_input(INPUT_POST, 'aPassword',FILTER_SANITIZE_STRING);

                // Go to the staff create page
                $this->mainController->adminCreateAction($aName, $aPassword);
                break;

            case 'deleteAdmin':
                $id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the delete staff page
                $this->mainController->deleteAdminAction($id);
                break;

            case 'adminDelete':
                $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);

                // Go to the staff delete page
                $this->mainController->adminDeleteAction($id);
                break;
            case'refreshDatabases':
                include_once __DIR__ . '/../setup/setup_database.php';

                //  Will go back to the admin logged in page after reloaded
                header("Location:/index.php?action=adminLoggedIn");
                break;

            case 'createAccount':
                $aName = filter_input(INPUT_POST, 'aName',FILTER_SANITIZE_STRING);
                $aPassword = filter_input(INPUT_POST, 'aPassword',FILTER_SANITIZE_STRING);

                // Go to the staff create page
                $this->mainController->staffCreateAction($aName, $aPassword);
                break;

            case 'processLogin':
                $username = filter_input(INPUT_POST, 'username',FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password',FILTER_SANITIZE_STRING);

                //  Tries to login passed on inputs
                $this->mainController->processLoginAction($username, $password);
                break;

            case 'processLogout':
                //  Will logout and go to home page
                $this->mainController->processLogoutAction();
                break;

            case 'index':
            default:
                $this->mainController->indexAction();
        }
    }
}
