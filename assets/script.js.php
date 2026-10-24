<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */ ?>
<script type="text/javascript">
 $(document).ready(function() {
    $('input.validate').characterCounter();
  });

 $(document).on("input", ".validate", function() {
    this.value = this.value.replace(/\D/g,'');
});

    /*   
       WebFont.load({
        google: {
          families: ['Material+Icons']
      }
  });

      (function() {
          if (sessionStorage.fonts) {
            console.log("Fonts installed.");
            document.documentElement.classList.add('wf-active');
        } else {
            console.log("No fonts installed.");
        }
    })();


    WebFontConfig = {
  active: function() {
    sessionStorage.fonts = true;
}
} */
</script>