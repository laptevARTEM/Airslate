<?php

class Address
{
    private int $COL_ADDRESSID;
    private string $COL_LABEL;
    private string $COL_STREET;
    private string $COL_HOUSENUMBER;
    private string $COL_POSTALCODE;
    private string $COL_CITY;
    private string $COL_COUNTRY;

    public function __construct(
        $addressId   = 0,
        $label       = '',
        $street      = '',
        $houseNumber = '',
        $postalCode  = '',
        $city        = '',
        $country     = ''
    )
    {
        $this->COL_ADDRESSID   = $addressId;
        $this->COL_LABEL       = $label;
        $this->COL_STREET      = $street;
        $this->COL_HOUSENUMBER = $houseNumber;
        $this->COL_POSTALCODE  = $postalCode;
        $this->COL_CITY        = $city;
        $this->COL_COUNTRY     = $country;
    }

    public function show($conn) :array
    {
        $address = [];
        $sql = "SELECT * FROM ADDRESS WHERE ADDRESSID = {$this->COL_ADDRESSID};";
        $res = $conn->query($sql);

        return $res->fetch_assoc();
    }

    public function getAll($conn) :array
    {
        $addresses = [];
        $sql = "SELECT * FROM ADDRESS";

        $allAddresses = $conn->query($sql);

        while ($address = $allAddresses->fetch_assoc()) {
            $addresses[] = $address;
        }

        return $addresses;
    }

    public function create($conn) :array
    {
        $res = [
            'Status' => 0
        ];

        $query = "INSERT INTO ADDRESS (
            LABEL,
            STREET,
            HOUSENUMBER,
            POSTALCODE,
            CITY,
            COUNTRY
        ) VALUES (
            '{$this->COL_LABEL}',
            '{$this->COL_STREET}',
            '{$this->COL_HOUSENUMBER}',
            '{$this->COL_POSTALCODE}',
            '{$this->COL_CITY}',
            '{$this->COL_COUNTRY}'
        );
        ";

        $resMarker = $conn->query($query);

        if (!empty($resMarker)) {
            $res['Status'] = 1;
            $res['NewAddress'] = [
                'country'      => $this->COL_COUNTRY,
                'city'         => $this->COL_CITY,
                'street'       => $this->COL_STREET,
                'house-number' => $this->COL_HOUSENUMBER,
                'postal-code'  => $this->COL_POSTALCODE,
                'belongs-to'   => $this->COL_LABEL
            ];
        }

        return $res;
    }

    public function update($conn) :array
    {
        $res = [
            'Status' => 0
        ];

        $query = "
            UPDATE ADDRESS SET
                COUNTRY     = '{$this->COL_COUNTRY}',
                CITY        = '{$this->COL_CITY}',
                STREET      = '{$this->COL_STREET}',
                HOUSENUMBER = '{$this->COL_HOUSENUMBER}',
                POSTALCODE  = '{$this->COL_POSTALCODE}',
                LABEL       = '{$this->COL_LABEL}'
            WHERE
                ADDRESSID   = {$this->COL_ADDRESSID};
        ";

        $resMarker = $conn->query($query);

        if (!empty($resMarker)) {
            $res['Status'] = 1;
            $res['UpdatedAddress'] = [
                'addressId'    => $this->COL_ADDRESSID,
                'country'      => $this->COL_COUNTRY,
                'city'         => $this->COL_CITY,
                'street'       => $this->COL_STREET,
                'house-number' => $this->COL_HOUSENUMBER,
                'postal-code'  => $this->COL_POSTALCODE,
                'belongs-to'   => $this->COL_LABEL
            ];
        }

        return $res;
    }

    public function delete($conn) :array
    {
        $res = [
            'Status' => 0
        ];

        $query = "
            DELETE FROM ADDRESS WHERE ADDRESSID = '{$this->COL_ADDRESSID}';
        ";

        $resMarker = $conn->query($query);

        if (!empty($resMarker)) {
            $res['Status'] = 1;
        }

        return $res;
    }
}
