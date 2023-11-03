<?php
class LandingpageController extends Controller
{

  public function index()
  {
    $data = [
      'title' => "Pizza Palace"
    ];
    $this->view('landingpages/index', $data);
  }
}