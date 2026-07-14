<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Paket as PaketModel;

class Home extends BaseController
{
   
    public function index()
   {
    $paket = new PaketModel();
    $paket = $paket->findAll();
    $data = [
        'title' => 'Pencucian Qenza',
        'paket' => $paket
    ];
    return view('home/index', $data);
   }

   public function tracking()
   {
       $id = $this->request->getGet('id');
       
       if ($id) {
           return redirect()->to(site_url("faktur/tracking/$id"));
       }

       return view('home/tracking');
   }
}