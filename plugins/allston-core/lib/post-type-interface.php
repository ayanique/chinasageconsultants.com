<?php

namespace AllstonCore\Lib;

/**
 * interface PostTypeInterface
 * @package AllstonCore\Lib;
 */
interface PostTypeInterface {
	/**
	 * @return string
	 */
	public function getBase();
	
	/**
	 * Registers custom post type with WordPress
	 */
	public function register();
}