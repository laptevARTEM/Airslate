<?php

include_once __DIR__ . '/../Models/Address.php';

class AddressController
{
    public $conn;
    public function __construct($db)
    {
        $this->conn = $db->getConnect();
    }

    public function show(int $addressId)
    {

        $params = $this->validate(['addressId' => $addressId]);

        if (empty($params)) {
            include_once __DIR__ . '/../../views/home.php';

            return;
        }

        $addressObj = new Address($params['addressId']);
        $address = $addressObj->show($this->conn);

        include_once __DIR__ . '/../../views/show.php';
    }

    public function create(array $params)
    {
        $params = $this->validate($params);

        if (empty($params)) {
            echo json_encode([
                'Status' => 0,
                'Error' => 'NotWalidParams'
            ]);
        }

        $address = new Address(
            $params['addressId'] ?? 0,
            $params['belongs-to'],
            $params['street'],
            $params['house-number'],
            $params['postal-code'],
            $params['city'],
            $params['country']
        );

        $data = $address->create($this->conn);

        echo json_encode($data);
    }

    public function update(array $params)
    {
        $params = $this->validate($params);

        if (empty($params)) {
            echo json_encode([
                'Status' => 0,
                'Error' => 'NotWalidParams'
            ]);
        }

        $address = new Address(
            $params['addressId'],
            $params['belongs-to'],
            $params['street'],
            $params['house-number'],
            $params['postal-code'],
            $params['city'],
            $params['country']
        );
        $data = $address->update($this->conn);

        echo json_encode($data);
    }

    public function delete(array $params)
    {
        $params = $this->validate($params);

        if (empty($params)) {
            echo json_encode([
                'Status' => 0,
                'Error' => 'NotWalidParams'
            ]);
        }

        $addressObj = new Address($params['addressId']);
        $data = $addressObj->delete($this->conn);

        echo json_encode($data);
    }

    private function validate(array $params) :array
    {
        $allowedParamKeys = [
            'addressId',
            'belongs-to',
            'street',
            'house-number',
            'postal-code',
            'city',
            'country'
        ];

        $allowedParams = [];

        foreach ($params as $paramKey => $paramVal) {
            if (in_array($paramKey, $allowedParamKeys)) {
                if ($paramKey === 'addressId') {
                    $allowedParams[$paramKey] = filter_var($paramVal, FILTER_SANITIZE_NUMBER_INT);
                } else {
                    $allowedParams[$paramKey] = htmlspecialchars(strip_tags($paramVal,ENT_QUOTES));
                }
            }
        }

        return $allowedParams;
    }
}
