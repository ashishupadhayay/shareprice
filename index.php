<?php
require __DIR__ . '/vendor/autoload.php';

$data = array();
$client = new \Google_Client();
$client->setApplicationName('SharePrice');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig('../github-shareprice.json');
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1sYdcwPHCIwVaLpsavlrjp-5Y0itwZ2dqfYTMj1sf3D0';
$response = $service->spreadsheets_values->get($spreadsheetId, 'A2:E6');
$values = $response->getValues();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Share Price via Google Sheets</title>
    <link href="css/style.min.css" rel="stylesheet">
</head>
<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <?php foreach($values as $k=>$v):?>
                <div class="col-lg-4 offset-lg-4 text-center">
                    <div class="card bg-secondary border-secondary mb-5">
                        <div class="card-body p-5">
                            <p>
                                <?php if($v[2] > 0):?>
                                <i class="bi bi-graph-up-arrow"></i> 
                                <?php endif;?>
                                <?php if($v[2] < 0):?>
                                <i class="bi bi-graph-down-arrow"></i> 
                                <?php endif;?>
                                <?php echo $v[0];?>
                            </p>
                            <h3 class="mt-5">
                                $<?php echo $v[1];?> 
                            </h3>
                            <p class="mt-3">
                                <?php if($v[2] > 0):?>
                                <span class="badge bg-success">
                                    <i class="bi bi-arrow-up-circle-fill"></i> <?php echo $v[2];?>%
                                </span>
                                <?php endif;?>
                                <?php if($v[2] < 0):?>
                                <span class="badge bg-danger">
                                    <i class="bi bi-arrow-down-circle-fill"></i> <?php echo $v[2];?>%
                                </span>
                                <?php endif;?>
                            </p>
                            <p class="text-small mt-3">
                                52W High: <strong>$<?php echo $v[3];?></strong><br />
                                52W Low: <strong>$<?php echo $v[4];?></strong>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</body>
</html>