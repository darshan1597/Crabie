<?php

    function isAdminLogin(){
        if(isset($_SESSION['admin-id'])){
		    return true;
	    }
        else{
	        return false;
        }
    }

?>