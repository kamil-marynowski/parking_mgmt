<!Doctype html>
<html lang="en">
    <head>
        <?php include \Core\App::getProjectRootPath() . '/views/partials/head.view.php' ?>
        <title>Parking areas management</title>
    </head>
    <body>
        <div id="container">
            <?php include \Core\App::getProjectRootPath() . '/views/partials/nav.view.php' ?>
            <div id="right-container">
            <?php include \Core\App::getProjectRootPath() . '/views/partials/top_bar.view.php' ?>
                <main id="content">
                    <div>
                        <button class="btn btn-success open-modal" data-modal-id="#create-parking-modal">
                            Create parking area
                        </button>
                    </div>
                    <h2 id="parking-areas-table-header">Parking areas</h2>
                    <div class="table-wrapper">
                        <table id="parking-areas-table" class="fl-table" aria-labelledby="parking-areas-table-header">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Weekdays hourly rate (USD)</th>
                                    <th>Weekend hourly rate (USD)</th>
                                    <th>Discount percentage</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($data['parkingAreas'])): ?>
                                    <tr id="no-parking-areas-row">
                                        <td class="text-center" colspan="6">No parking areas</td>
                                    </tr>
                                <?php endif; ?>
                                <?php foreach ($data['parkingAreas'] as $parkingArea): ?>
                                    <tr class="parking-area-row" data-parking-id="<?= $parkingArea->getId() ?>">
                                        <td class="id-col">
                                            <?= $parkingArea->getId() ?>
                                        </td>
                                        <td class="name-col">
                                            <?= $parkingArea->getName() ?>
                                        </td>
                                        <td class="weekdays-hourly-rate-col">
                                            <?= $parkingArea->getWeekdaysHourlyRate() ?>
                                        </td>
                                        <td class="weekend-hourly-rate-col">
                                            <?= $parkingArea->getWeekendHourlyRate() ?>
                                        </td>
                                        <td class="discount-percentage-col">
                                            <?= $parkingArea->getDiscountPercentage() ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning open-modal edit-parking-btn"
                                                    data-modal-id="#edit-parking-modal"
                                                    data-parking-id="<?= $parkingArea->getId() ?>"
                                            >
                                                Edit
                                            </button>
                                            <button class="btn btn-danger open-modal delete-parking-btn"
                                                    data-modal-id="#delete-parking-modal"
                                                    data-parking-id="<?= $parkingArea->getId() ?>"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
        <?php include \Core\App::getProjectRootPath() . '/views/admin/parking_areas/partials/modals/create_modal.view.php' ?>
        <?php include \Core\App::getProjectRootPath() . '/views/admin/parking_areas/partials/modals/edit_modal.view.php' ?>
        <?php include \Core\App::getProjectRootPath() . '/views/admin/parking_areas/partials/modals/delete_modal.view.php' ?>
        <script src="<?= \Core\Config::get('app', 'public_path') . '/js/modal.js' ?>"></script>
        <script>
            function clearErrors()
            {
                const errorBoxes = document.querySelectorAll('.error');
                for (const errorBox of errorBoxes) {
                    errorBox.classList.remove('show');
                }
            }

            function clearFormData(formId)
            {
                const form = document.querySelector(formId);

                const inputs = form.querySelectorAll('input');
                for (const input of inputs) {
                    input.value = '';
                }
            }

            function onClickEditBtn(editParkingBtn)
            {
                clearErrors();

                const id = editParkingBtn.dataset.parkingId;

                updateParkingAreaBtn.dataset.parkingId = id;

                const url = "http://localhost/parking_mgmt/public/index.php/?route=/get-parking-area&id=" + id;
                const xhr = new XMLHttpRequest();
                xhr.open('GET', url, true);

                xhr.onreadystatechange = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) { //.DONE === 4
                        if (xhr.status === 200) {
                            const response = JSON.parse(xhr.responseText);

                            const name = document.querySelector('#edit-name');
                            const weekdaysHourlyRate = document.querySelector('#edit-weekdays-hourly-rate');
                            const weekendHourlyRate = document.querySelector('#edit-weekend-hourly-rate');
                            const discountPercentage = document.querySelector('#edit-discount-percentage');

                            name.value = response.name;
                            weekdaysHourlyRate.value = response.weekdaysHourlyRate;
                            weekendHourlyRate.value = response.weekendHourlyRate;
                            discountPercentage.value = response.discountPercentage;

                            showModal(editParkingBtn.dataset.modalId);
                        } else {
                            alert('An error occurred. Contact with administrator.');
                        }
                    }
                }

                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send();
            }

            function onClickDeleteBtn(deleteParkingBtn)
            {
                deleteParkingConfirmBtn.dataset.parkingId = deleteParkingBtn.dataset.parkingId;
                showModal(deleteParkingBtn.dataset.modalId);
            }

            const submitFormBtns = document.querySelectorAll('.submit-form-btn');
            for (const submitFormBtn of submitFormBtns) {
                submitFormBtn.addEventListener('click', (e) => {
                    e.preventDefault();

                    clearErrors();

                    const name = document.querySelector('#name').value;
                    const weekdaysHourlyRate = document.querySelector('#weekdays-hourly-rate').value;
                    const weekendHourlyRate = document.querySelector('#weekend-hourly-rate').value;
                    const discountPercentage = document.querySelector('#discount-percentage').value;

                    const url = "<?= \Core\URL::to('/admin/parking-areas/create')?>";
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', url, true);
                    xhr.onreadystatechange = () => {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            const response = JSON.parse(xhr.responseText);
                            if (xhr.status === 200) {

                                const noParkingAreasRow = document.querySelector('#no-parking-areas-row');
                                if (noParkingAreasRow) {
                                    noParkingAreasRow.remove();
                                }

                                hideModal('#create-parking-modal');
                                clearFormData('#creating-parking-area-form');

                                const tableBody = document.querySelector('#parking-areas-table tbody');

                                const newRow = document.createElement('tr');
                                newRow.classList.add('parking-area-row')
                                newRow.dataset.parkingId = response.id;

                                const idCol = document.createElement('td');
                                idCol.classList.add('id-col');
                                idCol.innerHTML = response.id;

                                const nameCol = document.createElement('td');
                                nameCol.classList.add('name-col');
                                nameCol.innerHTML = response.name;

                                const weekdaysHourlyRateCol = document.createElement('td');
                                weekdaysHourlyRateCol.classList.add('weekdays-hourly-rate-col');
                                weekdaysHourlyRateCol.innerHTML = response.weekdaysHourlyRate;

                                const weekendHourlyRateCol = document.createElement('td');
                                weekendHourlyRateCol.classList.add('weekend-hourly-rate-col');
                                weekendHourlyRateCol.innerHTML = response.weekendHourlyRate;

                                const discountPercentageCol = document.createElement('td');
                                discountPercentageCol.classList.add('discount-percentage-col');
                                discountPercentageCol.innerHTML = response.discountPercentage;

                                const actionCol = document.createElement('td');
                                const editBtn = document.createElement('button');
                                editBtn.classList.add('btn', 'btn-warning', 'open-modal', 'edit-parking-btn');
                                editBtn.innerHTML = 'Edit';
                                editBtn.dataset.modalId = '#edit-parking-modal';
                                editBtn.dataset.parkingId = response.id;
                                editBtn.addEventListener('click', () => {
                                    onClickEditBtn(editBtn);
                                })

                                const deleteBtn = document.createElement('button');
                                deleteBtn.classList.add('btn', 'btn-danger', 'open-modal', 'delete-parking-btn');
                                deleteBtn.innerHTML = 'Delete';
                                deleteBtn.dataset.modalId = '#delete-parking-modal';
                                deleteBtn.dataset.parkingId = response.id;
                                deleteBtn.addEventListener('click', () => {
                                    onClickDeleteBtn(deleteBtn);
                                });

                                actionCol.append(editBtn, deleteBtn);

                                newRow.append(idCol, nameCol, weekdaysHourlyRateCol, weekendHourlyRateCol, discountPercentageCol, actionCol);
                                tableBody.append(newRow);
                                alert(response.msg);
                            } else if (xhr.status === 422) {
                                alert(response.msg);

                                const errors = response.errors;
                                for (const [key, value] of Object.entries(errors)) {
                                    const errorBox = document.querySelector('#create-parking-error-' + key);
                                    errorBox.innerHTML = value;
                                    errorBox.classList.add('show');
                                }
                            } else {
                                alert('An error occurred. Contact with administrator.');
                            }
                        }
                    }

                    const data = 'name=' + name
                        + '&weekdaysHourlyRate=' + weekdaysHourlyRate
                        + '&weekendHourlyRate=' + weekendHourlyRate
                        + '&discountPercentage=' + discountPercentage;

                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.send(data);
                });
            }

            const updateParkingAreaBtn = document.querySelector('#update-parking-area-btn');
            const editParkingBtns = document.querySelectorAll('.edit-parking-btn');
            for (const editParkingBtn of editParkingBtns) {
                editParkingBtn.addEventListener('click', () => {
                    onClickEditBtn(editParkingBtn);
                });
            }

            updateParkingAreaBtn.addEventListener('click', () => {
                const id = updateParkingAreaBtn.dataset.parkingId;
                const name = document.querySelector('#edit-name').value;
                const weekdaysHourlyRate = document.querySelector('#edit-weekdays-hourly-rate').value;
                const weekendHourlyRate = document.querySelector('#edit-weekend-hourly-rate').value;
                const discountPercentage = document.querySelector('#edit-discount-percentage').value;

                const url = "<?= \Core\URL::to('/admin/parking-areas/update') ?>";
                const xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);

                xhr.onreadystatechange = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) { //.DONE === 4
                        const response = JSON.parse(xhr.responseText);
                        if (xhr.status === 200) {
                            const updatedParkingAreaRow = document.querySelectorAll(".parking-area-row[data-parking-id='" + id + "']")[0];

                            updatedParkingAreaRow.querySelector('.name-col').innerHTML = name;
                            updatedParkingAreaRow.querySelector('.weekdays-hourly-rate-col').innerHTML = weekdaysHourlyRate;
                            updatedParkingAreaRow.querySelector('.weekend-hourly-rate-col').innerHTML = weekendHourlyRate;
                            updatedParkingAreaRow.querySelector('.discount-percentage-col').innerHTML = discountPercentage;

                            hideModal('#edit-parking-modal');
                        } else if (xhr.status === 422) {
                            alert(response.msg);

                            const errors = response.errors;
                            for (const [key, value] of Object.entries(errors)) {
                                const errorBox = document.querySelector('#edit-parking-error-' + key);
                                errorBox.innerHTML = value;
                                errorBox.classList.add('show');
                            }
                        } else {
                            alert(response.msg);
                        }
                    }
                }

                const data = 'id=' + id
                    + '&name=' + name
                    + '&weekdaysHourlyRate=' + weekdaysHourlyRate
                    + '&weekendHourlyRate=' + weekendHourlyRate
                    + '&discountPercentage=' + discountPercentage;

                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send(data);
            });


            const deleteParkingConfirmBtn = document.querySelector('#delete-parking-confirm-btn');
            const deleteParkingBtns = document.querySelectorAll('.delete-parking-btn');
            for (const deleteParkingBtn of deleteParkingBtns) {
                deleteParkingBtn.addEventListener('click', () => {
                    onClickDeleteBtn(deleteParkingBtn);
                });
            }


            deleteParkingConfirmBtn.addEventListener('click', () => {
                const id = deleteParkingConfirmBtn.dataset.parkingId;
                const url = "<?= \Core\Config::get('app', 'base_uri') . '?route=/admin/parking-areas/delete' ?>";
                const xhr = new XMLHttpRequest();
                xhr.open('POST', url, true);

                xhr.onreadystatechange = () => {
                    if (xhr.readyState === XMLHttpRequest.DONE) { //.DONE === 4
                        const response = JSON.parse(xhr.responseText);
                        if (xhr.status === 200) {
                            const deletedParkingAreaRow = document.querySelectorAll(".parking-area-row[data-parking-id='" + id + "']");
                            deletedParkingAreaRow[0].remove();

                            alert(response.msg);
                        } else {
                            alert('An error occurred. Contact with administrator.')
                        }

                        hideModal('#delete-parking-modal');
                    }
                }


                const data = 'id=' + id;
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.send(data);
            });
        </script>
        <?php include \Core\App::getProjectRootPath() . '/views/partials/script.view.php' ?>
    </body>
</html>