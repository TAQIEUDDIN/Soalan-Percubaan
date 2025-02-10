<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electricity Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="container mt-5">

    <h2 class="text-center fw-bold">Electricity Calculator</h2>
    
    <form method="post" action="" class="mt-4">
        <div class="mb-3">
            <label for="voltage" class="form-label fw-bold">Voltage</label>
            <input type="number" step="0.01" class="form-control" id="voltage" name="voltage" required>
            <small class="text-muted">Volt (V)</small>
        </div>

        <div class="mb-3">
            <label for="current" class="form-label fw-bold">Current</label>
            <input type="number" step="0.01" class="form-control" id="current" name="current" required>
            <small class="text-muted">Ampere (A)</small>
        </div>

        <div class="mb-3">
            <label for="rate" class="form-label fw-bold">CURRENT RATE</label>
            <input type="number" step="0.01" class="form-control" id="rate" name="rate" required>
            <small class="text-muted">sen/kWh</small>
        </div>

        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $voltage = floatval($_POST["voltage"]);
        $current = floatval($_POST["current"]);
        $rate = floatval($_POST["rate"]);

        function calculateElectricity($voltage, $current, $rate) {
            $power = $voltage * $current / 1000; 
            $results = [];

            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = $power * $hour; 
                $total = $energy * ($rate / 100); 
                $results[] = [
                    'hour' => $hour,
                    'energy' => $energy,
                    'total' => $total
                ];
            }

            return ['power' => $power, 'rate' => $rate / 100, 'results' => $results];
        }

        $result = calculateElectricity($voltage, $current, $rate);
    }
    ?>

<?php if (isset($result)): ?>
    <div class="mt-4 p-3 border border-primary rounded bg-light">
        <p class="fw-bold text-primary">POWER : <?= number_format($result['power'], 5) ?> kW</p>
        <p class="fw-bold text-primary">RATE : RM <?= number_format($result['rate'], 3) ?></p>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Hour</th>
                <th>Energy (kWh)</th>
                <th>TOTAL (RM)</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter = 1; ?>
            <?php foreach ($result['results'] as $row): ?>
                <tr>
                    <td class="fw-bold"><?= $counter++ ?></td>
                    <td><?= $row['hour'] ?></td>
                    <td><?= number_format($row['energy'], 5) ?></td>
                    <td><?= number_format($row['total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>

