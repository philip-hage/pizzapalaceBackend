<?php


class PizzaController extends Controller
{
    private $pizzaModel;

    public function __construct()
    {
        $this->pizzaModel = $this->model('PizzaModel');
    }

    public function index()
    {
        $data = [
            'title' => "Pizza Palace"
        ];
        $this->view('backend/index', $data);
    }


    //Customers

    public function customersOverview()
    {
        $customers = $this->pizzaModel->getCustomers();
        $countCustomers = count($this->pizzaModel->getCustomers());

        $data = [
            'customers' => $customers,
            'countCustomers' => $countCustomers,
        ];
        $this->view('backend/customer/customersOverview', $data);
    }

    public function createCustomer()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->pizzaModel->createCustomer($post);
            header("Location: " . URLROOT . "pizzacontroller/customersOverview");
        } else {
            $data = [
                'title' => 'Create customer'
            ];
            $this->view('backend/customer/customerCreate', $data);
        }
    }

    public function editCustomer($customerId = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $result = $this->pizzaModel->editCustomer($post);
            if (!$result) {
                echo "The update was successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/customersOverview/" . $customerId . "");
            } else {
                echo "The update was not successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/customersOverview/" . $customerId . "");
            }
        } else {
            $row = $this->pizzaModel->getSingleCustomer($customerId);
            $data = [
                'title' => '<h3>Update customer</h3>',
                'row' => $row
            ];
            $this->view("backend/customer/edit", $data);
        }
    }


    public function deleteCustomer($customerId)
    {
        $customerInfo = $this->pizzaModel->getCustomerById($customerId);

        if ($customerInfo) {
            $customerFirstName = $customerInfo[0];
            $customerLastName = $customerInfo[1];

            echo '<script>';
            echo 'if (confirm("Weet u zeker dat u ' . $customerFirstName . ' ' . $customerLastName . ' wilt verwijderen?")) {';
            echo '    window.location.href = "' . URLROOT . '/PizzaController/confirmDeleteCustomer/' . $customerId . '";';
            echo '} else {';
            echo '    window.location.href = "' . URLROOT . '/PizzaController/customersOverview/' . $customerId . '";';
            echo '}';
            echo '</script>';
        } else {
            echo 'Customer information not found.';
        }
    }

    public function confirmDeleteCustomer($customerId)
    {
        if ($this->pizzaModel->deleteCustomer($customerId)) {
            header('location: ' . URLROOT . '/PizzaController/customersOverview');
        } else {
            header('location: ' . URLROOT . '/PizzaController/customersOverview');
        }
    }


    //order

    public function ordersOverview()
    {
        $orders = $this->pizzaModel->getOrders();
        $countOrders = count($this->pizzaModel->getOrders());

        $data = [
            'orders' => $orders,
            'countOrders' => $countOrders
        ];
        $this->view('backend/order/ordersOverview', $data);
    }

    public function orderHasProducts($orderId)
    {
        $products = $this->pizzaModel->getProductByOrder($orderId);
        $countProducts = count($this->pizzaModel->getProductByOrder($orderId));

        $data = [
            'products' => $products,
            'countProducts' => $countProducts
        ];
        $this->view('backend/order/orderhasproducts', $data);
    }

    // Ingredient

    public function ingredientsOverview()
    {
        $ingredients = $this->pizzaModel->getIngredients();
        $countIngredients = count($this->pizzaModel->getIngredients());

        $data = [
            'ingredients' => $ingredients,
            'countIngredients' => $countIngredients
        ];
        $this->view('backend/ingredient/ingredientsOverview', $data);
    }

    public function createIngredient()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->pizzaModel->createIngredient($post);
            header("Location: " . URLROOT . "pizzacontroller/ingredientsOverview");
        } else {
            $data = [
                'title' => 'Create Ingredient'
            ];
            $this->view('backend/ingredient/ingredientCreate', $data);
        }
    }

    public function deleteIngredient($ingredientId)
    {
        echo '<script>';
        echo 'if (confirm("Weet u zeker dat u dit ingredient wilt verwijderen?")) {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/confirmDeleteIngredient/' . $ingredientId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/ingredientsOverview/' . $ingredientId . '";';
        echo '}';
        echo '</script>';
    }

    public function confirmDeleteIngredient($ingredientId)
    {
        if ($this->pizzaModel->deleteIngredient($ingredientId)) {
            header('location: ' . URLROOT . '/PizzaController/ingredientsOverview');
        } else {
            header('location: ' . URLROOT . '/PizzaController/ingredientsOverview');
        }
    }

    public function editIngredient($ingredientId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->pizzaModel->editIngredient($post);

            if (!$result) {
                echo "The update was successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/ingredientsOverview/" . $ingredientId . "");
            } else {
                echo "The update was not successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/ingredientsOverview/" . $ingredientId . "");
            }
        } else {
            $row = $this->pizzaModel->getIngredientById($ingredientId);

            $data = [
                'row' => $row
            ];
            $this->view('backend/ingredient/ingredientEdit', $data);
        }
    }


    //Employee

    public function employeesOverview()
    {
        $employees = $this->pizzaModel->getEmployees();
        $countEmployees = count($this->pizzaModel->getEmployees());

        $data = [
            'employees' => $employees,
            'countEmployees' => $countEmployees
        ];
        $this->view('backend/employee/employeesOverview', $data);
    }

    public function createEmployee()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->pizzaModel->createEmployee($post);
            header("Location: " . URLROOT . "pizzacontroller/employeesOverview");
        } else {
            $data = [
                'title' => 'Create Employee'
            ];
            $this->view('backend/employee/employeeCreate', $data);
        }
    }

    public function deleteEmployee($employeeId)
    {
        echo '<script>';
        echo 'if (confirm("Weet u zeker dat u deze persoon wilt verwijderen?")) {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/confirmDeleteEmployee/' . $employeeId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/employeesOverview/' . $employeeId . '";';
        echo '}';
        echo '</script>';
    }

    public function confirmDeleteEmployee($employeeId)
    {
        if ($this->pizzaModel->deleteEmployee($employeeId)) {
            header('location: ' . URLROOT . '/PizzaController/employeesOverview');
        } else {
            header('location: ' . URLROOT . '/PizzaController/employeesOverview');
        }
    }

    public function editEmployee($employeeId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->pizzaModel->editEmployee($post);

            if (!$result) {
                echo "The update was successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/employeesOverview/" . $employeeId . "");
            } else {
                echo "The update was not successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/employeesOverview/" . $employeeId . "");
            }
        } else {
            $row = $this->pizzaModel->getEmployeeById($employeeId);

            $data = [
                'row' => $row
            ];
            $this->view('backend/employee/employeeEdit', $data);
        }
    }

    // Stores

    public function storesOverview()
    {
        $stores = $this->pizzaModel->getStores();
        $countStores = count($this->pizzaModel->getStores());

        $data = [
            'stores' => $stores,
            'countStores' => $countStores
        ];
        $this->view('backend/store/storesOverview', $data);
    }

    public function createStore()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->pizzaModel->createStore($post);
            header("Location: " . URLROOT . "pizzacontroller/storesOverview");
        } else {
            $data = [
                'title' => 'Create Store'
            ];
            $this->view('backend/store/storeCreate', $data);
        }
    }

    public function deleteStore($storeId)
    {
        echo '<script>';
        echo 'if (confirm("Weet u zeker dat u deze store wilt verwijderen?")) {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/confirmDeleteStore/' . $storeId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/storesOverview/' . $storeId . '";';
        echo '}';
        echo '</script>';
    }

    public function confirmDeleteStore($storeId)
    {
        if ($this->pizzaModel->deleteStore($storeId)) {
            header('location: ' . URLROOT . '/PizzaController/storesOverview');
        } else {
            header('location: ' . URLROOT . '/PizzaController/storesOverview');
        }
    }

    public function editStore($storeId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->pizzaModel->editStore($post);

            if (!$result) {
                echo "The update was successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/storesOverview/" . $storeId . "");
            } else {
                echo "The update was not successful";
                header("Refresh: 3; url=" . URLROOT . "/pizzacontroller/storesOverview/" . $storeId . "");
            }
        } else {
            $row = $this->pizzaModel->getStoreById($storeId);

            $data = [
                'row' => $row
            ];
            $this->view('backend/store/storeEdit', $data);
        }
    }

    public function storeHasEmployees($storeId)
    {
        $store = $this->pizzaModel->getStoreById($storeId);
        $employees = $this->pizzaModel->getEmployeeByStore($storeId);
        $countEmployees = count($this->pizzaModel->getEmployeeByStore($storeId));

        $data = [
            'employees' => $employees,
            'store' => $store,
            'countEmployees' => $countEmployees
        ];
        $this->view('backend/store/storehasemployees', $data);
    }

    public function createStoreEmployee($storeId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->pizzaModel->createStore($post, $storeId);
            header("Location: " . URLROOT . "pizzacontroller/storeHasEmployees/" . $storeId);
        } else {
            $data = [
                'title' => 'Create Store',
                'id' => $storeId
            ];
            $this->view('backend/store/storesOverview', $data);
        }
    }

    public function storeHasVehicles($storeId)
    {
        $store = $this->pizzaModel->getStoreById($storeId);
        $vehicles = $this->pizzaModel->getVehicleByStore($storeId);

        $data = [
            'store' => $store,
            'vehicles' => $vehicles
        ];
        $this->view('backend/store/storehasvehicles', $data);
    }

    // vehicles

    public function vehiclesOverview()
    {
        $vehicles = $this->pizzaModel->getVehicles();
        $countVehicles = count($this->pizzaModel->getVehicles());


        $data = [
            'vehicles' => $vehicles,
            'countVehicles' => $countVehicles
        ];
        $this->view('backend/vehicles/vehiclesOverview', $data);
    }

    public function createVehicle()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->pizzaModel->createVehicle($post);
            header("Location: " . URLROOT . "pizzacontroller/vehiclesOverview");
        } else {
            $store = $this->pizzaModel->getStores();
            global $vehicleType;
            $data = [
                'title' => 'Create Vehicle',
                'store' => $store,
                'vehicleType' => $vehicleType
            ];
            $this->view('backend/vehicles/vehicleCreate', $data);
        }
    }

    // product

    public function productsOverview()
    {
        $products = $this->pizzaModel->getProducts();
        $countProducts = count($this->pizzaModel->getProducts());


        $data = [
            'products' => $products,
            'countProducts' => $countProducts
        ];
        $this->view('backend/products/productsOverview', $data);
    }

    public function createProduct()
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $this->pizzaModel->createProduct($post);
            header("Location: " . URLROOT . "pizzacontroller/productsOverview");
        } else {
            $customer = $this->pizzaModel->getCustomers();
            global $productType;
            $data = [
                'title' => 'Create Vehicle',
                'customer' => $customer,
                'productType' => $productType
            ];
            $this->view('backend/products/productCreate', $data);
        }
    }

    public function deleteProduct($productId)
    {
        echo '<script>';
        echo 'if (confirm("Weet u zeker dat u dit product wilt verwijderen?")) {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/confirmDeleteProduct/' . $productId . '";';
        echo '} else {';
        echo '    window.location.href = "' . URLROOT . '/PizzaController/productsOverview/' . $productId . '";';
        echo '}';
        echo '</script>';
    }

    public function confirmDeleteProduct($productId)
    {
        if ($this->pizzaModel->deleteProduct($productId)) {
            header('location: ' . URLROOT . '/PizzaController/productsOverview');
        } else {
            header('location: ' . URLROOT . '/PizzaController/productsOverview');
        }
    }

    public function productEdit($productId)
    {
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $result = $this->pizzaModel->editProduct($post);

            if (!$result) {
                echo "The update was successful";
                header("Refresh: 1; url=" . URLROOT . "/pizzacontroller/productsOverview/" . $productId . "");
            } else {
                echo "The update was not successful";
                header("Refresh: 1; url=" . URLROOT . "/pizzacontroller/productsOverview/" . $productId . "");
            }
        } else {
            global $productType;
            $row = $this->pizzaModel->getProductById($productId);
            $customer = $this->pizzaModel->getCustomers();

            $data = [
                'row' => $row,
                'customer' => $customer,
                'productType' => $productType,
                
            ];
            $this->view('backend/products/productEdit', $data);
        }
    }

    public function reviewOverview()
    {
        $reviews = $this->pizzaModel->getReviews();
        $countReviews = count($this->pizzaModel->getReviews());

        $data = [
            'reviews' => $reviews,
            'countReviews' => $countReviews
        ];
        $this->view('backend/reviews/reviewOverview', $data);
    }
}
