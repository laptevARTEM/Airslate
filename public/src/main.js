$(window).on('load', function () {
	eventBinder();
});

function eventBinder()  {
	$('input').on('keydown', function () {
		$(this).removeClass('red');
	});

	$('.edit-addr-btn').off('click').on('click', function () {
		const $row = $(this).closest('tr'),
			addressId = $row.data('address-id');
		let newHtml = `
		    <tr class="edit-addr-form" data-address-id="${addressId}">
			    <td>
				    <input
				    	type="text"
				    	data-column="country"
				    	class="form-control"
				    	id="inputCountry"
				    	placeholder="Country"
				    	value="${$('.country', $row).text().trim()}"
				    >
			    </td>
			    <td>
				    <input
				    	type="text"
				    	data-column="city"
				    	class="form-control"
				    	id="inputCity"
				    	placeholder="City"
				    	value="${$('.city', $row).text().trim()}"
				    >
			    </td>
			    <td>
				    <input
				    	type="text"
				    	data-column="street"
				    	class="form-control"
				    	id="inputStreet"
				    	placeholder="Street"
				    	value="${$('.street', $row).text().trim()}"
				    >
			    </td>
			    <td>
				    <input
				    	type="text"
				    	data-column="house-number"
				    	class="form-control"
				    	id="inputHouseNumber"
				    	placeholder="House Number"
				    	value="${$('.house-number', $row).text().trim()}"
				    >
			    </td>
			    <td>
				    <input
				    	type="text"
				    	data-column="postal-code"
				    	class="form-control"
				    	id="inputPostalCode"
				    	placeholder="Postal Code"
				    	value="${$('.postal-code', $row).text().trim()}"
				    >
			    </td>
			    <td>
				    <input
				    	type="text"
				    	data-column="belongs-to"
				    	class="form-control"
				    	id="inputBelongsTo"
				    	placeholder="Belongs To"
				    	value="${$('.belongs-to', $row).text().trim()}"
				    >
			    </td>
			    <td>
				    <button type="button" class="update-addr-btn btn btn-success me-2">Save</button>
				    <button type="button" class="cancel-update-addr-btn btn btn-danger me-2">Cancel</button>
			    </td>
		    </tr>
	    `;
		$row.before(newHtml);
		$row.hide();

		eventBinder();
	});

	$('.delete-addr-btn').off('click').on('click', function () {
		const addressId = $(this).closest('tr').data('address-id'),
			$self = $(this);

		$.ajax({
			url: `${window.location.origin}/api/address/delete`,
			dataType: 'json',
			method: 'post',
			data: {
				addressId: addressId
			},
			success: function (data) {
				if (data.Status === 1) {
					let needRedirect = false;
					if ($self.hasClass('show-page')) {
						needRedirect = true;
					}

					$(`tr.address-row[data-address-id="${addressId}"]`).remove();

					if (needRedirect) {
						window.location.href = '/';
					}
				} else {
					alert('Something went wrong during update address. Please try again');
				}
			}
		});
	});

	$('.update-addr-btn').off('click').on('click', function () {
		const $row = $(this).closest('tr'),
			addressId = $row.data('address-id');
		collectUpdateData(addressId);
	});

	$('.show-addr-btn').off('click').on('click', function () {
		const link = $(this).data('link');
		window.location.href = link;
	});

	$('.cancel-update-addr-btn').off('click').on('click', function () {
		const $row = $(this).closest('tr'),
			addressId = $row.data('address-id');
		$row.remove();
		$(`tr[data-address-id="${addressId}"]`).show();
	});

	$('.save-addr-btn').off('click').on('click', function () {
		collectCreateFormData();
	});

	$('.cancel-addr-btn').off('click').on('click', function () {
		$('.new-addr-form').remove();
		$('.cancel-addr-btn').remove();
		$('.add-addr-btn').show();
	});

	$('.add-addr-btn').off('click').on('click', function () {
		const $table = $('.addresses-table-body');
		let newHtml = `
		    <tr class="new-addr-form">
			    <td>
				    <input type="text"
				    	data-column="country"
				    	class="form-control"
				    	id="inputCountry"
				    	placeholder="Country"
				    >
			    </td>
			    <td>
				    <input type="text" data-column="city" class="form-control" id="inputCity" placeholder="City">
			    </td>
			    <td>
				    <input type="text" data-column="street" class="form-control" id="inputStreet" placeholder="Street">
			    </td>
			    <td>
				    <input type="text"
						data-column="house-number"
						class="form-control"
						id="inputHouseNumber"
						placeholder="House Number"
					>
			    </td>
			    <td>
				    <input type="text"
						data-column="postal-code"
						class="form-control"
						id="inputPostalCode"
						placeholder="Postal Code"
					>
			    </td>
			    <td>
				    <input type="text"
						data-column="belongs-to"
						class="form-control"
						id="inputBelongsTo"
						placeholder="Belongs to"
					>
			    </td>
			    <td>
				    <button type="button" class="save-addr-btn btn btn-success me-2">Save</button>
			    </td>
		    </tr>
	    `;

		$(this).closest('tr').before(newHtml);
		$(this).hide().after(`
		    <button type="button" class="cancel-addr-btn btn btn-danger me-2">Cancel</button>
	    `);

		eventBinder();
	});
}

function collectUpdateData(addressId) {
	const validationData = collectValidData('edit-addr-form'),
		notValidColumns = validationData['notValidColumns'],
		addressData = validationData['addressData'];
	addressData.addressId = addressId;

	if (notValidColumns.length > 0) {
		notValidColumns.forEach((column) => {
			$(`.edit-addr-form input[data-column="${column}"]`).addClass('red');
		});
		alert('Red columns are not valid or empty, please check, and fill again');
	} else {
		$.ajax({
			url: '/api/address/update',
			dataType: 'json',
			method: 'post',
			data: addressData,
			success: function (data) {
				if (data.Status === 1) {
					const $row = $(`.address-row[data-address-id="${data.UpdatedAddress.addressId}"]`);
					$('.country', $row).text(data.UpdatedAddress['country']);
					$('.city', $row).text(data.UpdatedAddress['city']);
					$('.belongs-to', $row).text(data.UpdatedAddress['belongs-to']);
					$('.house-number', $row).text(data.UpdatedAddress['house-number']);
					$('.postal-code', $row).text(data.UpdatedAddress['postal-code']);
					$('.street', $row).text(data.UpdatedAddress['street']);

					$(`.edit-addr-form[data-address-id="${data.UpdatedAddress.addressId}"]`).remove();
					$row.show();
				} else {
					alert('Something went wrong during update address. Please try again');
				}
			}
		});
	}

	eventBinder();
}

function collectValidData(className) {
	const onlyStingsColumns = ['country', 'city', 'street', 'belongs-to'],
		onlyNumericColumns = ['postal-code'],
		combinedColumns = ['house-number'],
		$inputs = $(`.${className} input`),
		addressData = {},
		notValidColumns = [];

	$inputs.each((key, input) => {
		const val = $(input).val(),
			column = $(input).data('column');
		if (onlyStingsColumns.includes(column)) {
			if (escapeString(val)) {
				addressData[column] = val;
			} else {
				notValidColumns.push(column);
			}
		} else if (onlyNumericColumns.includes(column)) {
			if (escapeNumeric(val)) {
				addressData[column] = val;
			} else {
				notValidColumns.push(column);
			}
		} else if (combinedColumns.includes(column)) {
			if (escapeCombined(val)) {
				addressData[column] = val;
			} else {
				notValidColumns.push(column);
			}
		}
	});

	return {
		addressData: addressData,
		notValidColumns: notValidColumns
	};
}

function collectCreateFormData() {
	const validationData = collectValidData('new-addr-form'),
		notValidColumns = validationData['notValidColumns'],
		addressData = validationData['addressData'];

	if (notValidColumns.length > 0) {
		notValidColumns.forEach((column) => {
			$(`.new-addr-form input[data-column="${column}"]`).addClass('red');
		});
		alert('Red columns are not valid or empty, please check, and fill again');
	} else {
		$.ajax({
			url: '/api/address/create',
			dataType: 'json',
			method: 'post',
			data: addressData,
			success: function (data) {
				if (data.Status === 1) {
					const lastAddrId = parseInt($('.address-row').last().data('address-id'), 10);
					let html = `
						<tr class="address-row" data-address-id="${lastAddrId + 1}">
							<td class="country">
								${data.NewAddress['country']}
							</td>
							<td class="city">
								${data.NewAddress['city']}
							</td>
							<td class="street">
								${data.NewAddress['street']}
							</td>
							<td class="house-number">
								${data.NewAddress['house-number']}
							</td>
							<td clss="postal-code">
								${data.NewAddress['postal-code']}
							</td>
							<td class="belongs-to">
								${data.NewAddress['belongs-to']}
							</td>
							<td class="buttons">
                                <button type="link"
                                	class="show-addr-btn btn btn-info me-2"
                                	data-link="/address/show/${lastAddrId + 1}"
                                >
                                	Show
                                </button>
								<button type="button" class="edit-addr-btn btn btn-outline-primary me-2">Edit</button>
								<button type="button" class="delete-addr-btn btn btn-danger me-2">Delete</button>
							</td>
						</tr>
					`;
					$('.new-addr-form').before(html);
					$('.new-addr-form').remove();
					$('.cancel-addr-btn').remove();
					$('.add-addr-btn').show();
				} else {
					alert('Something went wrong during create address. Please try again');
				}
			}
		});
	}

	eventBinder();
}

function escapeString(str) {
	const regex = new RegExp("^[a-zA-Z]+$");
	return regex.test(str);
}

function escapeNumeric(str) {
	const regex = new RegExp("^\\d+$");
	return regex.test(str);
}

function escapeCombined(str) {
	const regex = new RegExp("^[a-zA-Z0-9]+$");
	return regex.test(str);
}

