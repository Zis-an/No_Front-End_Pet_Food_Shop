<?php
      session_start();
      unset($_SESSION['user']);
      return isset($_SESSION['user']) && empty($_SESSION['user']);
?>