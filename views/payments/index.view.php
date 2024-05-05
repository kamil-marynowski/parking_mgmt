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
            <?php if (empty($data['parkingAreas'])): ?>
                <h1>No parking areas</h1>
            <?php else: ?>
                <form>
                    <div class="form-group">
                        <label class="form-label">Parking area</label>
                        <select id="parking-area-id" class="form-select">
                            <?php foreach ($data['parkingAreas'] as $parkingArea): ?>
                                <option value="<?= $parkingArea->getId() ?>"><?= $parkingArea->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Start time</label>
                        <input id="start-time" class="form-input" type="time" value="<?= $data['now']->format('H:i') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End time</label>
                        <input id="end-time" class="form-input" type="time" value="<?= $data['now']->format('H:i') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Day</label>
                        <input id="date" class="form-input" type="date"  value="<?= $data['now']->format('Y-m-d') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Currency</label>
                        <select id="currency" class="form-select">
                            <option value="USD" selected>USD $</option>
                            <option value="EUR">EUR €</option>
                            <option value="PLN">PLN zł</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button id="calculate-fee-btn" class="btn btn-success" type="button">Calculate fee</button>
                    </div>
                </form>
                <div>
                    <label>Parking fee</label>
                    <input id="parking-fee" class="form-input">
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script>
    const calculateFeeBtn = document.querySelector('#calculate-fee-btn');
    calculateFeeBtn.addEventListener('click', () => {
        const parkingAreaId = document.querySelector('#parking-area-id').value;
        const startTime     = document.querySelector('#start-time').value;
        const endTime       = document.querySelector('#end-time').value;
        const date          = document.querySelector('#date').value;
        const currency      = document.querySelector('#currency').value;

        const url = "<?= \Core\Config::get('app', 'base_uri') . '?route=/payments/calculate-fee' ?>";
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url, true);
        xhr.onreadystatechange = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) { //.DONE === 4
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    const parkingFee = response.parkingFee;

                    const parkingFeeInput = document.querySelector('#parking-fee');
                    parkingFeeInput.value = parkingFee;

                } else {
                    alert('An error occurred. Contact with administrator.');
                }
            }
        }

        const data = 'parking_area_id=' + parkingAreaId
            + '&start_time=' + startTime
            + '&end_time=' + endTime
            + '&date=' + date
            + '&currency=' + currency;

        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(data);
    });
</script>
<?php include \Core\App::getProjectRootPath() . '/views/partials/script.view.php' ?>
</body>
</html>