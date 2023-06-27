<html>
<head>
    <title>Html-Qrcode Demo</title>
<body>
    <div id="qr-reader" style="width:500px"></div>
    <div id="qr-reader-results"></div>
    <input type="text" name="" id="text">
</body>
<script src="camera.js"></script>
<script>

    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                console.log(lastResult);
                document.getElementById('text').value = lastResult
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    });
    

    $(document).ready(function(){
        $('div button#html5-qrcode-button-camera-permission').click(()=>{
        })
    });
</script>
</head>
</html>