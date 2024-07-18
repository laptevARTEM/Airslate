<!doctype html>
<html lang="en">
<?php include_once 'head.php' ?>
    <body>
        <div class="addresses-table-block container">
            <table class="addresses-table table">
                <thead>
                <tr>
                    <th scope="col">Country</th>
                    <th scope="col">City</th>
                    <th scope="col">Street</th>
                    <th scope="col">House Number</th>
                    <th scope="col">Postal Code</th>
                    <th scope="col">Belongs to</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody class="addresses-table-body">
                    <tr class="address-row" data-address-id="<?= $address['ADDRESSID'] ?>">
                        <td class="country">
                            <?= $address['COUNTRY'] ?>
                        </td>
                        <td class="city">
                            <?= $address['CITY'] ?>
                        </td>
                        <td class="street">
                            <?= $address['STREET'] ?>
                        </td>
                        <td class="house-number">
                            <?= $address['HOUSENUMBER'] ?>
                        </td>
                        <td class="postal-code">
                            <?= $address['POSTALCODE'] ?>
                        </td>
                        <td class="belongs-to">
                            <?= $address['LABEL'] ?>
                        </td>
                        <td class="buttons">
                            <button type="button" class="edit-addr-btn btn btn-outline-primary me-2">Edit</button>
                            <button type="button" class="show-page delete-addr-btn btn btn-danger me-2">Delete</button>
                        </td>
                    </tr>
                <tr class="add-address-row">
                    <td class="add-address-block text-center" colspan="7">
                        <a class="link-offset-2" href="/">< Back To Main Page</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>