<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el total desde el carrito
$importeTotal = isset($_GET['total']) ? floatval($_GET['total']) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pasarela de pago</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/paipay.css">
     <!-- Link de FontAwesome para el ícono de casita -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
      <!-- Botón en la esquina superior derecha en forma de casita -->
    <div style="position: fixed; top: 20px; right: 20px;">
        <a href="index.php" style="text-decoration: none; color: white;">
            <i class="fas fa-home" style="font-size: 30px; color: #fff; background-color: #000000; padding: 10px; border-radius: 50%;"></i>
        </a>
    </div>
    <div class="py-4 container">
        <div class="alert alert-info">
            Hola, Estimado Cliente
            <b>El monto a pagar es de s/. <?php echo number_format($importeTotal, 2, ","); ?></b>
        </div>
        <div class="text-center p-3">
            <div id="paypal-botton-container" class="col-xl-6 col-lg-6 col-md-8 col-12"></div>
            <br>
            <div id="qr-code-container" class="col-xl-6 col-lg-6 col-md-8 col-12"></div>
            <br>
            <button id="confirm-qr-payment" class="btn btn-success" onclick="confirmarPagoQR()">Confirmar Pago QR</button>
        </div>
    </div>

    <script src="https://sandbox.paypal.com/sdk/js?client-id=ATtChGHNp-io5JRXmXuA_rBLUOapn0wL_5GifywOI_vZOMraTsBoJuc75XCevqTGiGkqTQVDC4l2dwqt"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script>
        var Total = <?php echo number_format($importeTotal, 2, '.', ''); ?>;
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'gold',
                shape: 'pill',
                label: 'paypal',
                height: 38,
                disableMaxWidth: true
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: Total
                        }
                    }]
                });
            },
            oncancel: function(data_cancel) {
                console.log(data_cancel);
            },
            onApprove: function(data, actions) {
                actions.order.capture().then(function(detalle_compra) {
                    if (detalle_compra.status === 'COMPLETED') {
                        location.href = "completado.php";
                    }
                });
            }
        }).render('#paypal-botton-container');

        // Generar el código QR para el pago por QR
        $(document).ready(function() {
            var paymentLink = "<?php echo 'https://sandbox.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' . urlencode('sb-kvcks33280111@business.example.com') . '&item_name=Pago%20QR&amount=' . number_format($importeTotal, 2, '.', '') . '&currency_code=USD&invoice=' . uniqid(); ?>";
            $('#qr-code-container').qrcode({
                width: 128,
                height: 128,
                text: paymentLink
                
            });
        });

        // Función para confirmar el pago por QR y redirigir a completado.php
        function confirmarPagoQR() {
            alert("Gracias por confirmar su pago. Se procederá a validar la transacción.");
            window.location.href = "completado.php";
        }
    </script>
</body>
</html>
