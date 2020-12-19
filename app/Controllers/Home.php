<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Home'
		];
		return view('pages/home', $data);
	}

	public function about()
	{
		$data = [
			'title' => 'About'
		];
		return view('pages/about', $data);
	}

	public function contact()
	{
		$data = [
			'title' => 'Contact',
			'alamat' => [
				[
					'tipe' => 'Rumah',
					'jalan' => 'Jl. Mawar 4 Blok C6/23 RT 04/10 Perum PMI 1 Wancimekar',
					'kota' => 'Karawang'
				],
				[
					'tipe' => 'Kampus',
					'jalan' => 'Jl. Ronggo Waluyo H.Ahmad No.223',
					'kota' => 'Karawang'
				]
			]
		];
		return view('pages/contact', $data);
	}

	//--------------------------------------------------------------------

}
