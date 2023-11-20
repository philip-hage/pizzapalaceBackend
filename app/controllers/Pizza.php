<?php


class Pizza extends Controller
{
    private $pizzaModel;

    public function __construct()
    {
        $this->pizzaModel = $this->model('PizzaModel');
    }

    public function index()
    {
        $data = [
            'title' => 'Pizza Palace'
        ];
        $this->view('backend/index', $data);
    }
}
