
    <?php 
        if(isset($js) && !empty($js))
        {
            foreach($js as $js_val)
            {
            	$jss = HTTP_HOST."admin/assets/js/".$js_val;
                echo '<script src="'.$jss.'">';
                echo "\n";
            }
        }

    ?>
<script>

 $(document).ready(function(){
       var successBox = $('.flash.success');
       var errorBox = $('.flash.error');
   // fade $alertBox out after 1 second (1000 ms)
   successBox.delay(3000).fadeOut('slow');
   errorBox.delay(3000).fadeOut('slow');
});
</script>
</body>

</html>