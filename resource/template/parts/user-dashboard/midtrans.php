<html>
  <body>
    <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-1yQTBnMF78t4l6oG"></script>
    <script type="text/javascript" defer>
      window.onload = function(){
        setTimeout(function(){
          // SnapToken acquired from previous step
          snap.pay('<?php echo $snap_token; ?>', {
            // Optional
            onSuccess: function(result){
             console.log( JSON.stringify(result, null, 2) );
            },
            // Optional
            onPending: function(result){
              console.log( JSON.stringify(result, null, 2) );
            },
            // Optional
            onError: function(result){
              console.log( JSON.stringify(result, null, 2) );
            }
          });
        }, 3000)
      };
    </script>
  </body>
</html>