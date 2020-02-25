<?php

require_once('lib/autoload.php');

/**
 * 管理画面のコントローラー起動
 */
use Mine\Admin\Controller\Admin;

if ( is_admin() ) {
	new Admin();
}