<?php /* header('Cache-Control: public, max-age=31536000, immutable'); */ ?>
<script type="text/javascript">


      $(function(){ 
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                  acc[i].onclick = function () {
                        this.classList.toggle("active");
                        this.nextElementSibling.classList.toggle("show");
                  }
            }});


      $(function(){ 
            $('input[type="text"]').change(function(){
                  this.value = this.value.replace(/\s+/g, " ").trim();

            });
      });




</script>

