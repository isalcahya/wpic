<style type="text/css">
  .loading {
    background-image: url( <?php echo get_image_directory() . '/md-loading.svg'?> );
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
  }
</style>
<?php
$host = 'app.sandbox';
if ( $is_production ) {
  $host = 'app';
}
$source = "https://{$host}.midtrans.com/snap/snap.js";
?>
<html>
  <body style="height: 100vh;" class="loading">
    <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
    <script src="<?php echo $source; ?>" data-client-key="<?php echo $client_key; ?>"></script>
    <script type="text/javascript" defer>
      window.onload = function(){
        setTimeout(function(){
          document.body.classList.remove("loading");
          // SnapToken acquired from previous step
          snap.pay('<?php echo $snap_token; ?>', {
            // Optional
            onSuccess: function(result){
              window.location = '/wp-user/tagihan-spp/';
            },
            // Optional
            onPending: function(result){
              window.location = '/wp-user/tagihan-spp/';
            },
            // Optional
            onError: function(result){
              window.location = '/wp-user/tagihan-spp/';
            }
          });
        }, 3000)
      };
    </script>
  </body>
</html>