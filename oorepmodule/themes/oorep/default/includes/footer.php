<?php
if (!empty($this->data['htmlinject']['htmlContentPost'])) {
    foreach ($this->data['htmlinject']['htmlContentPost'] as $c) {
        echo $c;
    }
}
?>
	    </div><!-- #content -->
            <div class="row justify-content-center">
            <div class="col-md-6 text-center" style="padding-top:30px;" id="footer">
                <hr />
		<!--
		<img src="/<?php echo $this->data['baseurlpath']; ?>resources/icons/ssplogo-fish-small.png" alt="Small fish logo" style="float: right" />		
		-->    
                Copyright &copy; 2020-2021 <a href="https://pspace.org/a/">Andreas Bauer</a>. All rights reserved.

                <br style="clear: right" />
            </div>
            </div><!-- #footer -->
        </div><!-- #wrap -->
    </body>
</html>
