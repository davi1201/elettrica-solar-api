<?php

namespace App\Http\Controllers;

use App\Infrastructure\Services\AddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    private $address_service;

    public function __construct(AddressService $addressService)
    {
        $this->address_service = $addressService;
    }
    public function getAddressExternal(Request $request)
    {
        $response = $this->address_service->getAddresByZipCode($request->get('cep'));

        return new JsonResponse($response);
    }
}
